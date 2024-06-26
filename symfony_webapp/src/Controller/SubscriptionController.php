<?php

namespace App\Controller;

use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscription', name: 'app_subscription')]
    public function index(SubscriptionRepository $subscriptionRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('app_login');
        }

        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }

    #[Route('/subscription/select/{id}', name: 'subscription_select')]
    public function select(int $id, SubscriptionRepository $subscriptionRepository, EntityManagerInterface $entityManager): Response
    {
        $subscription = $subscriptionRepository->find($id);
    
        if (!$subscription) {
            throw $this->createNotFoundException('Subscription not found');
        }
    
        $user = $this->getUser();
        if ($user) {
            // Set the new subscription for the user
            $user->setSubscription($subscription);
    
            // Reset the PDF limit of the user's subscription to its base value
            $user->getSubscription()->setPdfLimit($subscription->getBasePdfLimit());
    
            $entityManager->persist($user);
            $entityManager->flush();
        } else {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à cette fonctionnalité.');
            return $this->redirectToRoute('app_login');
        }
    
        return $this->redirectToRoute('app_subscription');
    }
}
