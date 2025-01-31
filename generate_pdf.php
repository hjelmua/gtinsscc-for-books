<?php
require_once __DIR__ . '/vendor/autoload.php'; // Load Composer libraries

// Retrieve form data
$article_number = $_POST['article_number'];
$shipment_barcode = $_POST['shipment_barcode'];
$description = $_POST['description'];
$date = $_POST['date'];
$customer_order = $_POST['customer_order'];
$batch = $_POST['batch'];
$quantity = $_POST['quantity'];
$notes = $_POST['notes'];

// Construct the product barcode correctly
$product_barcode = "020" . $article_number . "37" . $quantity;

// Construct the shipment barcode
//$shipment_barcode = "00" . $shipment_barcode;
// Generate SSCC based on user input
function calculateSSCCCheckDigit($baseNumber) {
    $sum = 0;
    $multiplier = 3;
    for ($i = strlen($baseNumber) - 1; $i >= 0; $i--) {
        $sum += $baseNumber[$i] * $multiplier;
        $multiplier = ($multiplier == 3) ? 1 : 3;
    }
    $modulo = $sum % 10;
    return ($modulo === 0) ? 0 : (10 - $modulo);
}

$shipment_date = $_POST['shipment_date'];
$parcel_number = $_POST['parcel_number'];
$sscc_prefix = "1234567890";
$sscc_base = "00" . $sscc_prefix . $shipment_date . $parcel_number;
$check_digit = calculateSSCCCheckDigit($sscc_base);
$shipment_barcode = $sscc_base . $check_digit;


// Create new PDF instance with 103 x 219 mm format
$pdf = new TCPDF('P', 'mm', array(103, 219), true, 'UTF-8', false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// ---- PRODUCT INFO ----
$pdf->Cell(0, 7, "Artikelnummer:", 0, 1);
$pdf->Cell(0, 7, $article_number, 0, 1);

$pdf->Cell(0, 7, "Beskrivning:", 0, 1);
$pdf->Cell(0, 7, $description, 0, 1);
$pdf->Ln(2);
$pdf->Cell(0, 7, "Datum:", 0, 1);
$pdf->Cell(0, 7, $date, 0, 1);
$pdf->Ln(2);
$pdf->Cell(0, 7, "Kundordernr:", 0, 1);
$pdf->Cell(0, 7, $customer_order, 0, 1);

$pdf->Cell(0, 7, "SSCC:", 0, 1);
$pdf->Cell(0, 7, $shipment_barcode, 0, 1);
$pdf->Ln(2);
$pdf->Cell(0, 7, "Antal:", 0, 1);
$pdf->Cell(0, 7, $quantity, 0, 1);
$pdf->Ln(5);
$pdf->Cell(50, 7, "Batch: $batch", 0, 0);
$pdf->Cell(50, 7, "Övrigt: $notes", 0, 1);
$pdf->Ln(2);

// ---- MOVE BARCODE TO BOTTOM ----
//$pdf->SetXY(10, 130);
$pdf->SetXY(5, 130);
$pdf->write1DBarcode($product_barcode, 'C128', '', '', 93, 20, 0.65, ['A' => 'A', 'B' => 'B', 'C' => 'C'], 'N');
$pdf->Ln(2);
$pdf->SetXY(10, 152);
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(90, 5, "(02)" . $article_number . "(37)" . $quantity, 0, 1, 'C');

$pdf->SetXY(5, 160);
$pdf->write1DBarcode($shipment_barcode, 'C128', '', '', 93, 20, 0.65, ['A' => 'A', 'B' => 'B', 'C' => 'C'], 'N');
$pdf->Ln(2);
$pdf->SetXY(10, 182);
$pdf->Cell(80, 5, "(00)" . substr($shipment_barcode, 2), 0, 1, 'C');

// ---- OUTPUT PDF ----
//$pdf->Output("Label_$article_number.pdf", 'D'); // Force download
$output_dir = __DIR__ . '/generated_labels/';
$random_number = rand(1000, 9999);
//$file_path = $output_dir . "Label_$article_number.pdf";
$file_path = $output_dir . "Label_" . $article_number . "_" . $random_number . ".pdf";
//$pdf->Output($file_path, 'F'); // Force download
$pdf->Output($file_path, 'F');

// Force download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
readfile($file_path);
exit; // Force download

?>
