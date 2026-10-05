<?php
include "../../../configurasi/koneksi.php";
require('../../assets/pdf/rpdf.php');
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";

$kd=$_GET['kd_trkasir'];
$tampil = mysqli_query($GLOBALS['___mysqli_ston'],"select * from trkasir where kd_trkasir='$kd'");
$lihat = mysqli_fetch_array($tampil);
$panjang = terbilang($lihat['ttl_trkasir']);
$text1 = substr($panjang, 0,50);
$text2 = substr($panjang, 50,100);
$text3 = strlen($panjang);

//ambil header
$ah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader ");
$rh = mysqli_fetch_array($ah);

$pdf=new RPDF("L", "cm", [6.9,21]);
$pdf->SetMargins(0.8, 0.5, 0.5);
$pdf->AddPage();

//$pdf->TextWithRotation(10,10,$kd,45,0);
//$pdf->SetFontSize(30);
//$pdf->TextWithDirection(10,5,'world-1!','L');
//$pdf->TextWithDirection(10,5,'world-2!','U');
//$pdf->TextWithDirection(10,5,'world-3!','R');
//$pdf->TextWithDirection(10,5,'world-4!','D');


$pdf->SetFont('Arial','B', 10);
$pdf->TextWithDirection(1.5,4.9,$rh['satu'],'U');
$pdf->SetFont('Arial','', 8);
$pdf->TextWithDirection(2,4.2,$rh['dua'],'U');
$pdf->TextWithDirection(2.5,3.6,$rh['tiga'],'U');
$pdf->TextWithDirection(3.1,4,$rh['tujuh'],'U');


$pdf->SetLineWidth(0.1);
$pdf->Line(0.8, 0.3, 0.8, 5); //vertikal atas
$pdf->Line(4, 0.3, 4, 5); //vertikal tengah
$pdf->Line(20, 0.3, 20, 5); //vertikal akhir
$pdf->Line(0.8, 0.3, 20, 0.3); //Horizontal Atas
$pdf->Line(0.8, 5, 20, 5); //Horizontal Bawah

$pdf->ln(0.1);
$pdf->SetFont('Arial','', 12);
$pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
$pdf->Cell(4.2, 0.5,'No Transaksi', 0, 0, 'L');
$pdf->Cell(0.1, 0.5,':', 0, 0, 'C');
$pdf->Cell(3, 0.5,$kd, 0, 1, 'L');
$pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
$pdf->Cell(4.2, 0.5,'Telah Terima dari', 0, 0, 'L');
$pdf->Cell(0.1, 0.5,':', 0, 0, 'C');
$pdf->Cell(3, 0.5,$lihat['nm_pelanggan'], 0, 1, 'L');
if ($text3<51)
{
    $pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
    $pdf->Cell(4.2, 0.5,'Uang Sejumlah', 0, 0, 'L');
    $pdf->Cell(0.1, 0.5,':', 0, 0, 'C');
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(11, 0.5,$text1.' Rupiah', 0, 1, 'L',1);
}
else{
    $pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
    $pdf->Cell(4.2, 0.5,'Uang Sejumlah', 0, 0, 'L');
    $pdf->Cell(0.1, 0.5,':', 0, 0, 'C');
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(11, 0.5,$text1, 0, 1, 'L',1);
    $pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
    $pdf->Cell(4.2, 0.5,'', 0, 0, 'L');
    $pdf->Cell(0.1, 0.5,'', 0, 0, 'C');
    $pdf->SetFillColor(220, 220, 220);
    $pdf->Cell(11, 0.5,$text2.' Rupiah', 0, 1, 'L',1);
}
$pdf->ln(0.1);
$pdf->SetFont('Arial','', 12);
$pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
$pdf->Cell(4.2, 0.5,'Untuk Pembayaran', 0, 0, 'L');
$pdf->Cell(0.1,0.5,':',0,0,'C');
$pdf->Cell(11,0.5,'Pembelian obat - obatan',0,'L');


$pdf->ln(0.5);
$pdf->SetFont('Arial','', 12);
$pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
$pdf->Cell(7, 0.5,'', 0, 0, 'L');
$pdf->Cell(7, 0.5,'Bogor, '.tgl_indo($lihat['tgl_trkasir']), 0, 1, 'C');

$pdf->ln(1);
$pdf->SetFont('Arial','', 12);
$pdf->Cell(3.5, 0.5,'', 0, 0, 'R');
$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('Arial','', 20);
$pdf->Cell(7, 0.5,'Rp. '.format_rupiah($lihat['ttl_trkasir']).',-', 0, 0, 'L',1);
$pdf->SetFont('Arial','', 12);
$pdf->Cell(7, 0.5,$lihat['petugas'], 0, 1, 'C');

$pdf->Output();
?>