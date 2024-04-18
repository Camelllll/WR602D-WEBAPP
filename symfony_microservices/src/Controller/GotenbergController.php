<?php
namespace App\Controller;

use App\Service\GotenbergService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GotenbergController extends AbstractController
{
    private $gotenbergService;

    public function __construct(GotenbergService $gotenbergService)
    {
        $this->gotenbergService = $gotenbergService;
    }

    #[Route("/generate-pdf", name: "generate_pdf", methods: ["POST"])]

    /**
     * @Route("/generate-pdf", name="generate_pdf", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */

    public function generatePdf(Request $request): Response
    {
        $htmlContent = $request->getContent();

        $pdfContent = $this->gotenbergService->generatePdf($htmlContent);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="generated.pdf"',
        ]);
    }
}
?>