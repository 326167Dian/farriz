<?php
session_start();
include "../../../configurasi/koneksi.php";
require('../../assets/pdf/fpdf.php');
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";


$tgl_awal = $_POST['tgl_awal'];
$tgl_akhir = $_POST['tgl_akhir'];
$shift = $_POST['shift'];
$shift2 = ($shift=='1')?"PAGI":"SORE";"MALAM";

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(1,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,0.7,"STOK OPNAME ".$shift2,0,10,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(5.5,0.5,"Tanggal Cetak : ".date('d-m-Y h:i:s'),0,0,'L');
$pdf->Cell(5,0.5,"Dicetak Oleh : ".$_SESSION['namalengkap'],0,1,'L');
$pdf->Cell(5.5,0.5,"Periode : ".tgl_indo($tgl_awal)." - ".tgl_indo($tgl_akhir),0,0,'L');
$pdf->Line(1,2.7,27,2.7); //horisontal bawah
$pdf->ln(0.5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(1, 0.7, 'NO', 1, 0, 'C');
$pdf->Cell(2.5, 0.7, 'Kode Barang', 1, 0, 'L');
$pdf->Cell(8.0, 0.7, 'Nama Barang', 1, 0, 'L');
$pdf->Cell(1.5, 0.7, 'Rak', 1, 0, 'L');
$pdf->Cell(1.5, 0.7, 'Terjual', 1, 0, 'R');
$pdf->Cell(1.5, 0.7, 'stok', 1, 0, 'R');
$pdf->Cell(2, 0.7, 'Satuan', 1, 0, 'C');
$pdf->Cell(3, 0.7, 'Qty Fisik', 1, 0, 'C');
$pdf->Cell(3, 0.7, 'Waktu', 1, 0, 'C');
$pdf->Cell(3, 0.7, 'ACC Manager', 1, 1, 'C');
$pdf->SetFont('Arial','',8);
$no=1;


$query=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT 
trkasir_detail.kd_barang,
trkasir_detail.id_dtrkasir,
trkasir_detail.kd_trkasir,
trkasir.kd_trkasir,
trkasir.tgl_trkasir
FROM trkasir_detail 
JOIN trkasir ON trkasir_detail.kd_trkasir = trkasir.kd_trkasir
WHERE trkasir.tgl_trkasir BETWEEN '$tgl_awal' AND '$tgl_akhir' AND shift = '$shift'
GROUP BY trkasir_detail.kd_barang");



while($lihat=mysqli_fetch_array($query)){

$query2=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT 
trkasir_detail.kd_barang,
trkasir_detail.id_dtrkasir,
trkasir_detail.kd_trkasir,
trkasir_detail.kd_barang,
barang.stok_barang,
barang.jenisobat,
SUM(trkasir_detail.qty_dtrkasir) as ttlqty,
SUM(trkasir_detail.hrgttl_dtrkasir) as ttlhrg,
trkasir.kd_trkasir,
trkasir.tgl_trkasir
FROM trkasir_detail 
JOIN trkasir ON trkasir_detail.kd_trkasir = trkasir.kd_trkasir
join barang on barang.kd_barang = trkasir_detail.kd_barang
WHERE trkasir_detail.kd_barang='$lihat[kd_barang]'
AND trkasir.tgl_trkasir BETWEEN '$tgl_awal' AND '$tgl_akhir' AND shift = '$shift'
ORDER BY trkasir_detail.nmbrg_dtrkasir ASC");

$r2=mysqli_fetch_array($query2);
$ttlqty = $r2['ttlqty'];
$ttlhrg = $r2['ttlhrg'];
$stok = $r2['stok_barang'];

$query3=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail 
WHERE id_dtrkasir='$lihat[id_dtrkasir]'");
$r3=mysqli_fetch_array($query3);
$kd_barang = $r3['kd_barang'];
$nmbrg_dtrkasir = $r3['nmbrg_dtrkasir'];
$sat_dtrkasir = $r3['sat_dtrkasir'];

	$pdf->Cell(1, 0.6, $no , 1, 0, 'C');
	$pdf->Cell(2.5, 0.6, $kd_barang,1, 0, 'L');
	$pdf->Cell(8.0, 0.6, $nmbrg_dtrkasir, 1, 0,'L');
	$pdf->Cell(1.5, 0.6, $r2['jenisobat'], 1, 0,'L');
	$pdf->Cell(1.5, 0.6, $ttlqty, 1, 0,'R');
	$pdf->Cell(1.5, 0.6, $stok, 1, 0,'R');
	$pdf->Cell(2, 0.6, $sat_dtrkasir, 1, 0,'C');
	$pdf->Cell(3, 0.6, '', 1, 0,'R');
	$pdf->Cell(3, 0.6,'' , 1, 0,'R');
	$pdf->Cell(3, 0.6, '', 1, 1,'C');
	$no++;
}


/*
$total= "SELECT id_trkasir, kd_trkasir,id_carabayar, SUM(ttl_trkasir)as ttlskrg1                                                              
                                        FROM trkasir WHERE tgl_trkasir between '$tgl_awal' and '$tgl_akhir'" ;
$tunai = "SELECT id_trkasir, kd_trkasir, id_carabayar, SUM(ttl_trkasir)as ttlskrg2                                                              
                                        FROM trkasir WHERE tgl_trkasir BETWEEN '$tgl_awal' AND '$tgl_akhir' AND id_carabayar='1'" ;
$transfer = "SELECT id_trkasir, kd_trkasir, id_carabayar, SUM(ttl_trkasir)as ttlskrg3                                                              
                                        FROM trkasir WHERE tgl_trkasir BETWEEN '$tgl_awal' and '$tgl_akhir' AND id_carabayar='2'" ;
$tempo = "SELECT id_trkasir, kd_trkasir, id_carabayar, SUM(ttl_trkasir)as ttlskrg4                                                              
                                        FROM trkasir WHERE tgl_trkasir BETWEEN '$tgl_awal' and '$tgl_akhir' AND id_carabayar='3'" ;

$query2=mysqli_query($GLOBALS["___mysqli_ston"], $total);
$query3=mysqli_query($GLOBALS["___mysqli_ston"], $tunai);
$query4=mysqli_query($GLOBALS["___mysqli_ston"], $transfer);
$query5=mysqli_query($GLOBALS["___mysqli_ston"], $tempo);

$r2=mysqli_fetch_array($query2);
$ttlskrg = $r2['ttlskrg1'];
$ttlskrg2 = format_rupiah($ttlskrg);

$r3=mysqli_fetch_array($query3);
$ttltunai = $r3['ttlskrg2'];
$ttltunai2 = format_rupiah($ttltunai);

$r4=mysqli_fetch_array($query4);
$ttltransfer = $r4['ttlskrg3'];
$ttltransfer2 = format_rupiah($ttltransfer);

$r5=mysqli_fetch_array($query5);
$ttltempo = $r5['ttlskrg4'];
$ttltempo2 = format_rupiah($ttltempo);

/*
$koneksi = $GLOBALS["___mysqli_ston"];
$query = "SELECT
SUM(a.hrgttl_dtrkasir) as gttl
FROM trkasir_detail AS a 
left join trkasir as b 
on a.kd_trkasir = b.kd_trkasir
where b.tgl_trkasir BETWEEN  '$tgl_awal' AND '$tgl_akhir'";
$result = $koneksi -> query($query);
$row = $result -> fetch_array();
/*$query4=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(hrgttl_dtrkasir) AS gttl FROM trkasir_detail WHERE tgl_trkasir BETWEEN '$tgl_awal' AND '$tgl_akhir'");
$query5=mysqli_fetch_assoc($query4);
var_dump($query5); die();*/



$pdf->Output("Stok_Opname_Harian.pdf","I");

?>

