<?php
namespace App\Tests\Entity;

use App\Entity\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    public function testGettersAndSetters(): void
    {
        $subscription = new Subscription();

        $subscription->setTitle('title');
        $this->assertEquals('title', $subscription->getTitle());

        $subscription->setDescription('description');
        $this->assertEquals('description', $subscription->getDescription());

        $subscription->setPrice('price');
        $this->assertEquals('price', $subscription->getPrice());

        $subscription->setMedia('media');
        $this->assertEquals('media', $subscription->getMedia());

        $subscription->setPdfLimit(10);
        $this->assertEquals(10, $subscription->getPdfLimit());
    }
}
?>