<?php
session_start();
include "../../../configurasi/koneksi.php";
require('../../assets/pdf/fpdf.php');
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";

$kdorders = $_GET['id'];

$query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM orders WHERE kd_trbmasuk = '$kdorders'");
$res = mysqli_fetch_array($query);

//ambil header
$ah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader ");
$rh = mysqli_fetch_array($ah);

$pdf = new FPDF("P", "cm", "A4");

$pdf->SetMargins(1, 1, 1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 0.4, $rh['satu'], 0, 1, 'C');

$pdf->ln(1);
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 0.5, $rh['dua'], 0, 1, 'C');
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(0, 0.5, $rh['tiga'], 0, 1, 'C');
// $pdf->Cell(0, 0.5, $rh['empat'], 0, 1, 'C');
$pdf->Cell(0, 0.5, $rh['lima'], 0, 1, 'C');
$pdf->Cell(0, 0.5, $rh['enam'], 0, 1, 'C');
$pdf->Cell(0, 0.5, $rh['tujuh'], 0, 1, 'C');
// $pdf->SetMargins(1, 1, 1);
// $pdf->AliasNbPages();
// $pdf->AddPage();
// $pdf->Image('../../images/header-logo.jpg', 0, 0);

// $pdf->Line(1, 2.6, 0, 2.6); //horisontal bawah
// $pdf->SetFont('Arial', 'B', 10);
// $pdf->Cell(27, 0.7, "Surat Nomor ", 0, 10, 'L');
// $pdf->Cell(27, 0.7, $kdorders, 0, 10, 'L');
// $pdf->SetFont('Arial', '', 9);
// $pdf->Cell(5.5, 0.5, "Tanggal Cetak : " . date('d-m-Y h:i:s'), 0, 0, 'L');
// $pdf->Cell(5, 0.5, "Dicetak Oleh : " . $_SESSION['namalengkap'], 0, 1, 'L');

$pdf->SetLineWidth(0.1);
$pdf->Line(1, 6, 20, 6); //horisontal bawah

$pdf->ln(1.5);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(19, 0, 'SURAT PESANAN', 0, 0, 'C');

$pdf->ln(1.5);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(5, 0, 'Surat Nomor', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(5, 0, $kdorders, 0, 0, 'L');

$pdf->ln(0.5);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(5, 0, 'Kepada', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(5, 0, $res['nm_supplier'], 0, 0, 'L');

$pdf->ln(0.5);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(5, 0, 'Tanggal', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(5, 0, tgl_indo($res['tgl_trbmasuk']), 0, 0, 'L');

$pdf->SetLineWidth(0);
$pdf->ln(0.8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(1, 0.7, 'No.', 1, 0, 'C');
$pdf->Cell(10, 0.7, 'Nama Obat', 1, 0, 'C');
$pdf->Cell(8, 0.7, 'Jumlah', 1, 0, 'C');
// $pdf->ln(0.7);
// $pdf->SetFont('Arial', '', 10);

$no = 1;
$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT *
FROM ordersdetail
WHERE kd_trbmasuk = '$kdorders'");

while ($lihat = mysqli_fetch_array($query1)) {
    $qty = ($lihat['qtygrosir_dtrbmasuk'] == 0) ? $lihat['qty_dtrbmasuk'] : $lihat['qtygrosir_dtrbmasuk'];
    $satuan = ($lihat['satgrosir_dtrbmasuk'] == "") ? $lihat['sat_dtrbmasuk'] : $lihat['satgrosir_dtrbmasuk'];

    $pdf->ln(0.7);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(1, 0.7, $no, 1, 0, 'C');
    $pdf->Cell(10, 0.7, $lihat['nmbrg_dtrbmasuk'], 1, 0, 'L');
    $pdf->Cell(8, 0.7, $qty . " " . $satuan, 1, 0, 'C');
    $no++;
}

$pdf->ln(2.8);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(19, 0, 'Bekasi, ' . tgl_indo(date("Y-m-d")), 0, 0, 'R');

$pdf->ln(2.5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(19, 0, $rh['empat'], 0, 0, 'R');

$pdf->ln(0.4);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(19, 0, $rh['lima'], 0, 0, 'R');
$pdf->Output("order.pdf", "I");
