<?php

namespace App\Controller;

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfExportController extends AbstractController
{
    #[Route('/items/pdf', name: 'items_export_pdf')]
    public function exportToPdf(ItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findAll();
        $datetime = date('d-m-Y');

        // Configure Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);

        // Render HTML using Twig
        $html = $this->renderView('pdf/items.html.twig', [
            'items' => $items,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Return PDF as response
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="inventaris_' . $datetime . '.pdf"',
            ]
        );
    }
}