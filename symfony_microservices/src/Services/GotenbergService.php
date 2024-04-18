<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GotenbergService
{
    private $client;
    private $gotenbergUrl;

    public function __construct(HttpClientInterface $client, string $gotenbergUrl)
    {
        $this->client = $client;
        $this->gotenbergUrl = $gotenbergUrl;
    }

    public function generatePdf(string $html): string
    {
        $response = $this->client->request('POST', $this->gotenbergUrl . '/convert/html', [
            'headers' => [
                'Content-Type' => 'text/html',
            ],
            'body' => $html,
        ]);

        return $response->getContent();
    }
}

?>