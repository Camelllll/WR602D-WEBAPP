<?php 

// src/DataFixtures/SubscriptionFixtures.php
namespace App\DataFixtures;

use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $subscriptions = [
            [
                'title' => 'Basic',
                'description' => 'Accès limité à la génération de PDF avec 5 PDFs par mois.',
                'pdfLimit' => 5,
                'price' => 5.99,
                'media' => 'https://i.pinimg.com/originals/dc/a1/fa/dca1fab25e6921ae7b92c86f19ca3c8f.jpg',
            ],
            [
                'title' => 'Premium',
                'description' => 'Accès limité à la génération de PDF avec 20 PDFs par mois.',
                'pdfLimit' => 20,
                'price' => 9.99,
                'media' => 'https://img.freepik.com/vecteurs-premium/modele-logo-premium-golden-luxury_807399-20.jpg',
            ],
            [
                'title' => 'Ultra',
                'description' => 'Accès illimité à toutes les fonctionnalités avec un support prioritaire.',
                'pdfLimit' => 100,
                'price' => 19.99,
                'media' => 'https://logowik.com/content/uploads/images/ultra-electronics5885.jpg',
            ],
        ];

        foreach ($subscriptions as $subscriptionData) {
            $subscription = new Subscription();
            $subscription->setTitle($subscriptionData['title']);
            $subscription->setDescription($subscriptionData['description']);
            $subscription->setPdfLimit($subscriptionData['pdfLimit']);
            $subscription->setPrice($subscriptionData['price']);
            $subscription->setMedia($subscriptionData['media']);
            
            $manager->persist($subscription);
        }

        $manager->flush();
    }
}
