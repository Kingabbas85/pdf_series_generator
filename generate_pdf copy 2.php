<?php
include_once('database/database.php');
include_once('includes/helpers.php');
include_once("packages/fpdf/fpdf.php");
require __DIR__ . '/packages/vendor/autoload.php';

use Smalot\PdfParser\Parser;

// Function to convert hex color to RGB
function hexToRgb($hex) {
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    return array($r, $g, $b);
}

// Handle the PDF upload and form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdfFile = $_FILES['pdf_file']['tmp_name'];
    $outputFile = 'updated_pdf_series.pdf';

    // Create a new instance of the PDF parser
    $parser = new Parser();

    // Parse the uploaded PDF file
    $pdf = $parser->parseFile($pdfFile);

    // Extract text from the PDF for reference (optional)
    $text = $pdf->getText();

    // Create a new FPDF instance to write to the existing PDF's pages
    $pdfWriter = new FPDF();

    // Get the total number of pages from the parsed PDF
    $pages = $pdf->getPages();
    $totalPages = count($pages);

    // Iterate through each page of the original PDF
    foreach ($pages as $pageNo => $page) {
        $pdfWriter->AddPage();
        $pdfWriter->SetFont('Arial', '', 12);

        // Copy the text content from the parsed page (this doesn't copy the exact structure/formatting)
        $pdfWriter->MultiCell(0, 10, $page->getText());

        // Process each series text for this page
        foreach ($_POST['series_text'] as $index => $seriesText) {
            $startNumber = (int)$_POST['start_number'][$index];
            $pageRange = explode('-', $_POST['page_range'][$index]);
            $colorHex = $_POST['text_color'][$index];
            $position = explode(',', $_POST['position'][$index]);

            $x = (float)$position[0];
            $y = (float)$position[1];
            list($r, $g, $b) = hexToRgb($colorHex);

            // Check if the current page is within the specified range
            if ($pageNo + 1 >= (int)$pageRange[0] && $pageNo + 1 <= (int)$pageRange[1]) {
                // Set text color and font for series number
                $pdfWriter->SetTextColor($r, $g, $b);
                $pdfWriter->SetFont('Arial', 'B', 12);

                // Set position for series text
                $pdfWriter->SetXY($x, $y);

                // Write the series number
                $seriesNumber = $seriesText . ' ' . $startNumber++;
                $pdfWriter->Write(0, $seriesNumber);
            }
        }
    }

    // Output the new PDF with modifications
    $pdfWriter->Output('F', $outputFile);

    // Offer a download to the user
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($outputFile) . '"');
    readfile($outputFile);

    // Clean up
    unlink($outputFile);
    exit;
}
?>
