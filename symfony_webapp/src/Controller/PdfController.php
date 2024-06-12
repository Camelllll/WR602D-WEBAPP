<?php

namespace App\Controller;

use App\Entity\PdfHistory;
use App\Form\PdfType;
use App\HttpClient\PdfServiceHttpClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Component\Routing\Annotation\Route;
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
        // Empêcher l'accès à cette page si l'utilisateur n'est pas connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $form = $this->createForm(PdfType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subscription = $user->getSubscription();
            $pdf = $form->getData();
            $file = $form->get('file')->getData();

            if ($pdf['url']) {
                $response = $this->pdfServiceHttpClient->post(
                    'pdf/generate/url',
                    ['body' => ['url' => $pdf['url']]]
                );
            } elseif ($file) {
                $body = new FormDataPart(['html' => fopen($file->getPathname(), 'r')]);
                $response = $this->pdfServiceHttpClient->post(
                    'pdf/generate/html',
                    [
                        'headers' => ['Content-Type' => 'multipart/form-data'],
                        'body' => $body->bodyToIterable(),
                    ]
                );
            } else {
                throw new \Exception('Invalid form data');
            }

            if ($subscription) {
                $pdfLimit = $subscription->getPdfLimit();
                if ($pdfLimit > 0) {
                    $subscription->setPdfLimit($pdfLimit - 1);
                    $this->entityManager->persist($subscription);
                    $this->entityManager->flush();
                }
            }

            // Enregistrer les informations sur le PDF généré dans PdfHistory
            $pdfHistory = new PdfHistory();
            $pdfHistory->setUser($user);
            $pdfHistory->setFileName($pdf['title'] . '.pdf');
            $pdfHistory->setGeneratedAt(new \DateTime());

            $this->entityManager->persist($pdfHistory);
            $this->entityManager->flush();

            return new Response($response, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="%s"', $pdf['title'] . '.pdf'),
            ]);
        }

        return $this->render('pdf/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/account', name: 'user_account')]
    public function account(): Response
    {
        $user = $this->getUser();
        $pdfHistories = $user->getPdfHistories();

        return $this->render('account/account.html.twig', [
            'pdfHistories' => $pdfHistories,
        ]);
    }

    #[Route('/pdf/delete/{id}', name: 'delete_pdf')]
    public function deletePdf($id): Response
    {
        // Récupérez le PDF
        $pdf = $this->entityManager->getRepository(PdfHistory::class)->find($id);    
        if (!$pdf) {
            throw $this->createNotFoundException('PDF non trouvé avec l\'ID : ' . $id);
        }
    
        // Supprimez le PDF
        $this->entityManager->remove($pdf);
        $this->entityManager->flush();
    
        return $this->redirectToRoute('account');
    }
}
