<?php

// src/Controller/SubscriptionController.php

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
            // Reset PDF limits for all subscriptions
            $subscriptions = $subscriptionRepository->findAll();
            foreach ($subscriptions as $sub) {
                if ($sub !== $subscription) {
                    $sub->setPdfLimit($sub->getPdfLimit()); // This assumes getPdfLimit() returns the base value
                    $entityManager->persist($sub);
                }
            }

            // Set the new subscription for the user
            $user->setSubscription($subscription);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_subscription');
    }
}
