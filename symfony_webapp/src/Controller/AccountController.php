<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function index(): Response
    {
        $user = $this->getUser();
        $subscription = $user->getSubscription();

        return $this->render('account/index.html.twig', [
            'subscription' => $subscription,
            'user' => $user,
        ]);
    }
}
