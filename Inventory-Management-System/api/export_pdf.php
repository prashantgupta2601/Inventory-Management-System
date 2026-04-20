<?php
require_once '../../config.php';
require_once 'ForecastingUtil.php';
require_once '../lib/fpdf.php';

// Auth check
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Extend FPDF to create custom Header and Footer
class InventoryPDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->SetTextColor(78, 115, 223); // Primary theme color
        $this->Cell(0, 10, 'Inventory System - Professional Report', 0, 1, 'C');
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Exported on: ' . date('Y-m-d H:i:s'), 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Initialize PDF
$pdf = new InventoryPDF('L', 'mm', 'A4'); // Landscape for more columns
$pdf->AliasNbPages();
$pdf->AddPage();

// Set Table Header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(78, 115, 223);
$pdf->SetTextColor(255);

// Column Widths
$w = array(30, 60, 40, 20, 30, 40, 30); // Total 250mm
$header = array('ID', 'Name', 'Category', 'Qty', 'Price', 'Forecast', 'Trend');

for($i=0; $i<count($header); $i++)
    $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
$pdf->Ln();

// Set Table Content
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0);
$pdf->SetFillColor(248, 249, 252);

// Fetch data
$stmt = $conn->prepare("SELECT * FROM inventory ORDER BY name ASC");
$stmt->execute();
$result = $stmt->get_result();

$fill = false;
while ($row = $result->fetch_assoc()) {
    $sales_history = json_decode($row['sales_history'] ?? '[]', true);
    $monthly_sales = json_decode($row['monthly_sales'] ?? '[]', true);
    
    // AI insights
    $data = !empty($monthly_sales) ? $monthly_sales : $sales_history;
    $insights = ForecastingUtil::holtLinearForecast($data);
    
    $pdf->Cell($w[0], 6, $row['id'], 'LR', 0, 'L', $fill);
    $pdf->Cell($w[1], 6, substr($row['name'], 0, 35), 'LR', 0, 'L', $fill);
    $pdf->Cell($w[2], 6, substr($row['category'], 0, 20), 'LR', 0, 'L', $fill);
    $pdf->Cell($w[3], 6, $row['quantity'], 'LR', 0, 'C', $fill);
    $pdf->Cell($w[4], 6, '$' . number_format($row['price'], 2), 'LR', 0, 'R', $fill);
    $pdf->Cell($w[5], 6, $insights['forecast'], 'LR', 0, 'C', $fill);
    $pdf->Cell($w[6], 6, $insights['trend_percentage'] . '%', 'LR', 0, 'C', $fill);
    $pdf->Ln();
    $fill = !$fill;
}

// Closing line
$pdf->Cell(array_sum($w), 0, '', 'T');

// Output PDF
$pdf->Output('D', 'inventory_report_' . date('Y-m-d') . '.pdf');
exit;
