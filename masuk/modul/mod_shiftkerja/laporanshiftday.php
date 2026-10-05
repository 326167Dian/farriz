<?php
include "../../../configurasi/koneksi.php";
require('../../assets/pdf/fpdf.php');
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";

//ambil header
$ah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader ");
$rh = mysqli_fetch_array($ah);

$id = $_GET['idshift'];

$dtshift = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM waktukerja WHERE id_shift='$id'");
$rshift = mysqli_fetch_array($dtshift);

//$shift = ($rshift['shift']=='pagi')?'1':'2';
$shift = $rshift['shift'];
$tgl_trkasir = $rshift['tanggal'];

$dt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_penjualan FROM trkasir
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir'");
$r1 = mysqli_fetch_array($dt);

$dnum = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir'");

$rnum = mysqli_num_rows($dnum);
$rrnum = mysqli_fetch_array($dnum);


$dt2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_tunai FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir' AND id_carabayar='1'");
$r2 = mysqli_fetch_array($dt2);

$dt3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_transfer FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir' AND id_carabayar='2'");
$r3 = mysqli_fetch_array($dt3);

$dt4 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_trkasir) as ttl_tempo FROM trkasir 
WHERE shift='$shift' AND tgl_trkasir='$tgl_trkasir' AND id_carabayar='3'");
$r4 = mysqli_fetch_array($dt4);


$tgl_awal = date('Y-m-d');
$jumlahdetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir where tgl_trkasir ='$tgl_awal' order by id_trkasir desc ");
$countdetail = mysqli_num_rows($jumlahdetail);

$ukuran1 = 14.7; //setingan kertas
$ukuran2 = 5.4; //garis akhir tabel

$tambahukuran = $countdetail * 0.4;
$tinggikertas = $ukuran1 + $tambahukuran;
$posisigaris = $ukuran2 + $tambahukuran;




//$pdf = new FPDF("P","cm","A4");
$pdf = new FPDF("P", "cm", array($tinggikertas, 7.5));
$pdf->SetMargins(-0.3, -0.8, 0);
$pdf->AliasNbPages();
$pdf->AddPage();

//$pdf->Image('../../images/mmd.jpg',1,1.5,5,2);
//HEADER 1
$pdf->Line(0, 2.7, 8, 2.7); //horisontal bawah

$pdf->Line(0, 6.5, 8, 6.5); //judul tabel atas



$pdf->ln(1.3);
$pdf->SetFont('Arial', '', 9);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 0.4, $rh['satu'], 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 0.4, $rh['dua'], 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 0.4, $rh['tiga'], 0, 1, 'C');
$pdf->Cell(0, 0.3, $rh['empat'], 0, 1, 'C');
$pdf->Cell(0, 0.3, $rh['lima'], 0, 1, 'C');
$pdf->Cell(0, 0.3, $rh['enam'], 0, 1, 'C');
$pdf->Cell(0, 0.5, $rh['tujuh'], 0, 1, 'C');

$pdf->ln(0.1);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Tanggal', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(1, 0, tgl_indo($tgl_trkasir), 0, 0, 'L');

//KIRI 1
$pdf->ln(0.4);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Total Penjualan', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(1, 0, format_rupiah($r1['ttl_penjualan']), 0, 0, 'L');

//KIRI 2
$pdf->ln(0.4);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Tunai', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1, 0, format_rupiah($r2['ttl_tunai']), 0, 0, 'L');


//KIRI 3
$pdf->ln(0.4);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Transfer', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1, 0, format_rupiah($r3['ttl_transfer']), 0, 0, 'L');

//KIRI 4
$pdf->ln(0.4);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Tempo', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1, 0, format_rupiah($r4['ttl_tempo']), 0, 0, 'L');

//KIRI 5
$pdf->ln(0.4);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Jumlah Transaksi', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1, 0, $rnum, 0, 0, 'L');

//KIRI 6
$pdf->ln(0.4);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Petugas Buka', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1, 0, ($rnum == 0) ? "" : $rshift['petugasbuka'], 0, 0, 'L');

//KIRI 7
$pdf->ln(0.4);
$pdf->SetX(0.6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 0, 'Petugas Tutup', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1, 0, ($rnum == 0) ? "" : $rshift['petugastutup'], 0, 0, 'L');

$pdf->ln(0.6);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 0.3, $rh['delapan'], 0, 1, 'C');
$pdf->Cell(0, 0.3, $rh['sembilan'], 0, 1, 'C');
$pdf->Cell(0, 0.3, $rh['sepuluh'], 0, 1, 'C');
// $pdf->Cell(0,0.3,"Kasir : ".$r1['petugas'],0,1,'C');

$pdf->Output("struk_wallpaper", "I");
