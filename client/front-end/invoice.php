<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['UserId'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Include FPDF library
require('fpdf/fpdf.php');

// Create a new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 16);

// User details
$userName = $_SESSION['Firstname'];

// Invoice title
$pdf->Cell(0, 10, 'Invoice for ' . $userName, 0, 1, 'C');
$pdf->Ln(10); // Add some space

// Table header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Book Title', 1, 0, 'C');
$pdf->Cell(40, 10, 'Price', 1, 0, 'C');
$pdf->Cell(30, 10, 'Quantity', 1, 0, 'C');
$pdf->Cell(40, 10, 'Total', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
// Display cart items
foreach ($_SESSION['cart'] as $cartItem) {
    $pdf->Cell(60, 10, $cartItem['BookTitle'], 1, 0, 'C');
    $pdf->Cell(40, 10, 'CAD ' . $cartItem['Price'], 1, 0, 'C');
    $pdf->Cell(30, 10, $cartItem['Quantity'], 1, 0, 'C');
    $total = $cartItem['Price'] * $cartItem['Quantity'];
    $pdf->Cell(40, 10, 'CAD ' . $total, 1, 1, 'C');
}

$pdf->Ln(10); // Add some space

// Calculate total price
$totalPrice = array_reduce($_SESSION['cart'], function ($acc, $item) {
    return $acc + ($item['Price'] * $item['Quantity']);
}, 0);

// Total amount
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(130, 10, 'Total:', 1, 0, 'R');
$pdf->Cell(40, 10, 'CAD ' . $totalPrice, 1, 1, 'C');

// Output PDF
$pdf->Output('invoice.pdf', 'D');
?>
