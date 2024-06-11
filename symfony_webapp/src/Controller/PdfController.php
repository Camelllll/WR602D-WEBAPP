<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\PdfType;
use App\HttpClient\PdfServiceHttpClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/pdf')]
class PdfController extends AbstractController
{
    private PdfServiceHttpClient $pdfServiceHttpClient;
    private EntityManagerInterface $entityManager;

    public function __construct(PdfServiceHttpClient $pdfServiceHttpClient, EntityManagerInterface $entityManager)
    {
        $this->pdfServiceHttpClient = $pdfServiceHttpClient;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'pdf_index')]
    public function index(): Response
    {
        return $this->render('pdf/index.html.twig', [
            'controller_name' => 'PdfController',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/create', name: 'pdf_create')]
    public function create(Request $request): Response
    {
        // Récupérer l'utilisateur connecté
        /** @var UserInterface $user */
        $user = $this->getUser();

        $form = $this->createForm(PdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'abonnement de l'utilisateur
            $subscription = $user->getSubscription();

            $pdf = $form->getData();
            $file = $form->get('file')->getData();

            if ($pdf['url']) {
                // Générer le PDF à partir de l'URL
                $response = $this->pdfServiceHttpClient->post(
                    'pdf/generate/url',
                    [
                        'body' => [
                            'url' => $pdf['url'],
                        ],
                    ]
                );
            } elseif ($file) {
                // Générer le PDF à partir du fichier HTML
                $body = new FormDataPart([
                    'html' => fopen($file->getPathname(), 'r'),
                ]);
                $response = $this->pdfServiceHttpClient->post(
                    'pdf/generate/html',
                    [
                        'headers' => [
                            'Content-Type' => 'multipart/form-data',
                        ],
                        'body' => $body->bodyToIterable(),
                    ]
                );
            } else {
                throw new \Exception('Invalid form data');
            }

            // Déduire 1 du nombre de PDF restant dans l'abonnement de l'utilisateur
            if ($subscription) {
                $pdfLimit = $subscription->getPdfLimit();
                if ($pdfLimit > 0) {
                    $subscription->setPdfLimit($pdfLimit - 1);

                    // Utilisation de l'EntityManager pour enregistrer les modifications
                    $this->entityManager->persist($subscription);
                    $this->entityManager->flush();
                }
            }


            return new Response($response, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="%s"', $pdf['title'].'.pdf'),
            ]);
        }

        return $this->render('pdf/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}