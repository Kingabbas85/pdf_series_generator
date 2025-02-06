<?php
include_once('database/database.php');
include_once('includes/helpers.php');
include_once("packages/fpdf/fpdf.php");
require __DIR__ . '/packages/vendor/autoload.php';
    
    
use setasign\Fpdi\Fpdi;

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
    $outputFile = 'generated_pdf_series.pdf';

    // Create a new instance of FPDI
    $pdf = new Fpdi();

    // Load the uploaded PDF
    $pageCount = $pdf->setSourceFile($pdfFile);

    // Iterate through the pages
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $pdf->AddPage();
        $templateId = $pdf->importPage($pageNo);
        $pdf->useTemplate($templateId);

        // Process each series row
        foreach ($_POST['series_text'] as $index => $seriesText) {
            $startNumber = (int)$_POST['start_number'][$index];
            $pageRange = explode('-', $_POST['page_range'][$index]);
            $colorHex = $_POST['text_color'][$index];
            $position = explode(',', $_POST['position'][$index]);

            $x = (float)$position[0];
            $y = (float)$position[1];
            list($r, $g, $b) = hexToRgb($colorHex);

            // Check if the current page is within the specified range
            if ($pageNo >= (int)$pageRange[0] && $pageNo <= (int)$pageRange[1]) {
                $pdf->SetTextColor($r, $g, $b);
                $pdf->SetFont('Arial', 'B', 12);
                $pdf->SetXY($x, $y);

                // Write the series number
                $seriesNumber = $seriesText . ' ' . $startNumber++;
                $pdf->Write(0, $seriesNumber);
            }
        }
    }

    // Output the new PDF
    $pdf->Output('F', $outputFile);

    // Offer a download to the user
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $outputFile . '"');
    readfile($outputFile);

    // Clean up
    unlink($outputFile);
    exit;
}
    ?>
    
?>