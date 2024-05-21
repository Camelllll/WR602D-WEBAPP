<?php 

namespace App\Tests\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GotenbergTest extends WebTestCase
{
    public function testGeneratePdf(): void
    {
        $client = static::createClient();

        $htmlContent = '<h1>Hello, world!</h1>';

        $gotenbergService = $this->createMock(GotenbergService::class);
        $gotenbergService->method('generatePdf')->willReturn('PDF_CONTENT');

        $client->getContainer()->set(GotenbergService::class, $gotenbergService);

        $client->request('POST', '/generate-pdf', [], [], [], $htmlContent);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertEquals('application/pdf', $client->getResponse()->headers->get('Content-Type'));
        $this->assertEquals('attachment; filename="generated.pdf"', $client->getResponse()->headers->get('Content-Disposition'));
        $this->assertEquals('PDF_CONTENT', $client->getResponse()->getContent());
    }
}