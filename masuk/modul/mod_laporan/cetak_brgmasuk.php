<?php
session_start();
include "../../../configurasi/koneksi.php";
require('../../assets/pdf/fpdf.php');
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(1,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();

$tgl_awal = $_POST['tgl_awal'];
$tgl_akhir = $_POST['tgl_akhir'];

$pdf->SetFont('Arial','B',10);
$pdf->Cell(25.5,0.7,"LAPORAN DATA BARANG MASUK",0,10,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(5.5,0.5,"Tanggal Cetak : ".date('d-m-Y h:i:s'),0,0,'L');
$pdf->Cell(5,0.5,"Dicetak Oleh : ".$_SESSION['namalengkap'],0,1,'L');
$pdf->Cell(5.5,0.5,"Periode : ".tgl_indo($tgl_awal)." - ".tgl_indo($tgl_akhir),0,0,'L');
$pdf->Line(1,2.7,28.5,2.7); //horisontal bawah

$pdf->ln(1.5);

//bagian header

$header=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trbmasuk 
WHERE trbmasuk.tgl_trbmasuk BETWEEN '$tgl_awal' AND '$tgl_akhir'");

$no1=1;
while($r1=mysqli_fetch_array($header)){

$kd_trbmasuk = $r1['kd_trbmasuk'];
$tgl_trbmasuk = $r1['tgl_trbmasuk'];
$nm_supplier = $r1['nm_supplier'];
$tlp_supplier = $r1['tlp_supplier'];
$ttl_trbmasuk = $r1['ttl_trbmasuk'];
$ket_trbmasuk = $r1['ket_trbmasuk'];

//KIRI 1
$pdf->SetX(1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(3,0,'Kode Transaksi',0,0,'L');
$pdf->Cell(0.5,0,':',0,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(1,0,$kd_trbmasuk,0,0,'L');

//KANAN 1
$pdf->SetX(10);
$pdf->SetFont('Arial','',9);
$pdf->Cell(3,0,'Supplier',0,0,'L');
$pdf->Cell(0.3,0,':',0,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(1,0,$nm_supplier,0,0,'L');

$pdf->ln(0.5);

//KIRI 2
$pdf->SetX(1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(3,0,'Tanggal Transaksi',0,0,'L');
$pdf->Cell(0.5,0,':',0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(1,0,tgl_indo($tgl_trbmasuk),0,0,'L');

//KANAN 2
$pdf->SetX(10);
$pdf->SetFont('Arial','',9);
$pdf->Cell(3,0,'Telepon',0,0,'L');
$pdf->Cell(0.3,0,':',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(1,0,$tlp_supplier,0,0,'L');

$pdf->ln(0.5);

//KIRI 3
$pdf->SetX(1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(3,0,'Keterangan',0,0,'L');
$pdf->Cell(0.5,0,':',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(1,0,$ket_trbmasuk,0,0,'L');

$pdf->ln(0.5);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(1, 0.7, 'NO', 1, 0, 'C');
$pdf->Cell(4, 0.7, 'Kode Barang', 1, 0, 'L');
$pdf->Cell(8.5, 0.7, 'Nama Barang', 1, 0, 'L');
$pdf->Cell(2, 0.7, 'Qty/Stok', 1, 0, 'R');
$pdf->Cell(2, 0.7, 'No Batch', 1, 0, 'C');
$pdf->Cell(2, 0.7, 'Exp Date', 1, 0, 'C');
$pdf->Cell(2, 0.7, 'Satuan', 1, 0, 'C');
$pdf->Cell(3, 0.7, 'Harga Satuan', 1, 0, 'R');
$pdf->Cell(3, 0.7, 'Total', 1, 1, 'R');
$pdf->SetFont('Arial','',8);

//detail barang
$detailbrg=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trbmasuk_detail WHERE trbmasuk_detail.kd_trbmasuk ='$kd_trbmasuk' ORDER BY trbmasuk_detail.nmbrg_dtrbmasuk ASC");
$no2=1;
while($lihat=mysqli_fetch_array($detailbrg)){

	$pdf->Cell(1, 0.5, $no2 , 1, 0, 'C');
	$pdf->Cell(4, 0.5, $lihat['kd_barang'],1, 0, 'L');
	$pdf->Cell(8.5, 0.5, $lihat['nmbrg_dtrbmasuk'], 1, 0,'L');
	$pdf->Cell(2, 0.5, format_rupiah($lihat['qty_dtrbmasuk']), 1, 0,'R');
	$pdf->Cell(2, 0.5, $lihat['no_batch'], 1, 0,'R');
	$pdf->Cell(2, 0.5, $lihat['exp_date'], 1, 0,'R');
	$pdf->Cell(2, 0.5, $lihat['sat_dtrbmasuk'], 1, 0,'C');
	$pdf->Cell(3, 0.5, format_rupiah($lihat['hrgsat_dtrbmasuk']), 1, 0,'R');
	$pdf->Cell(3, 0.5, format_rupiah($lihat['hrgttl_dtrbmasuk']), 1, 1,'R');

	$no2++;
}
//grand total
$pdf->SetFont('Arial','B',8);
$pdf->Cell(24.5, 0.7, 'Total', 1, 0, 'R');
$pdf->Cell(3, 0.7, format_rupiah($r1['ttl_trbmasuk']), 1, 1, 'R');
$pdf->ln(0.7);

}






$pdf->Output("Data-Barang-Masuk.pdf","I");

?>

