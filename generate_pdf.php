<?php
include_once('includes/helpers.php');
require __DIR__ . '/packages/vendor/autoload.php';

use ZendPdf\PdfDocument;
use ZendPdf\Font;
use ZendPdf\Color\Rgb as ColorRgb;

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
    // pre_r($_POST);
    // die();
    $pdfFile = $_FILES['pdf_file']['tmp_name'];
    $outputFile = 'generated_pdf_series.pdf';

    // Load the uploaded PDF
    $pdf = PdfDocument::load($pdfFile);
    $pageCount = count($pdf->pages);

    // Iterate through the pages
    for ($pageNo = 0; $pageNo < $pageCount; $pageNo++) {
        $page = $pdf->pages[$pageNo];

        // Process each series row
        foreach ($_POST['series_text'] as $index => $seriesText) {
            // Check if this is the first page; only then get the initial start number from the form
            if ($pageNo === 0 && !isset($startNumbers[$index])) {
                // Initialize $startNumbers array to track the current number for each series across pages
                $startNumbers[$index] = (int)$_POST['start_number'][$index];
            }

            $pageRange = explode('-', $_POST['page_range'][$index]);  // Page range for the series
            $colorHex = $_POST['text_color'][$index];  // Text color in HEX
            $position = explode(',', $_POST['position'][$index]);  // Position for the text (x, y)

            $x = $position[0];
            $y = $position[1];
            list($r, $g, $b) = hexToRgb($colorHex);

            // Check if the current page is within the specified range
            if ($pageNo + 1 >= (int)$pageRange[0] && $pageNo + 1 <= (int)$pageRange[1]) {
                // Set font and color
                $page->setFont(Font::fontWithName(Font::FONT_HELVETICA), 17);
                $page->setFillColor(new ColorRgb($r / 255, $g / 255, $b / 255));

                // Write the series number using the current value from $startNumbers array
                $seriesNumber = $seriesText . '' . $startNumbers[$index];

                 // Get the height of the current page
                 $pageWidth = $page->getWidth();
                 $pageHeight = $page->getHeight();
                
                // Adjust the y-coordinate to place the text based on the top-left origin
                $adjustedY = $pageHeight - $y;
                $adjustedX = $pageWidth - $x;

                // Correctly use $x and adjustedY for positioning
                $page->drawText($seriesNumber, $adjustedX, $adjustedY);
                
                // Increment the start number after writing it for this page
                $startNumbers[$index]++;
            }
        }
    }

    // Save the new PDF
    $pdf->save($outputFile);

    // Offer a download to the user
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $outputFile . '"');
    readfile($outputFile);

    // Clean up
    unlink($outputFile);
    exit;
    header('location: index');
}
?>
