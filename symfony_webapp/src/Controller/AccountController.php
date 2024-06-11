<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // Récupérer le repository de l'entité PdfHistory
        $pdfHistoryRepository = $em->getRepository('App\Entity\PdfHistory');
        
        // Récupérer l'historique des PDFs pour l'utilisateur actuel
        $pdfs = $pdfHistoryRepository->findBy(['user' => $user]);

        return $this->render('account/index.html.twig', [
            'pdfs' => $pdfs,
        ]);
    }
}