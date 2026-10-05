<?php
session_start();
include "../../../configurasi/koneksi.php";
require('../../assets/pdf/fpdf.php');
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";

$kdorders = $_GET['id'];

$query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM orders WHERE kd_trbmasuk = '$kdorders'");
$res = mysqli_fetch_array($query);
$alamat = $db->query("select * from supplier where id_supplier='$res[id_supplier]' ");
$alt = $alamat->fetch_array();
//ambil header
$ah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader ");
$rh = mysqli_fetch_array($ah);

$pdf = new FPDF("P", "cm", "A4");

$pdf->SetMargins(1, 0, 1);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Image('../../images/logo_yasfi.png',1,0.7,2,2.5,'');
$pdf->ln(1);
$pdf->SetFont('helvetica', 'B', 24);
$pdf->SetTextColor(139, 0, 0);
$pdf->Cell(3.5, 0.4,'' , 0, 0, 'C');
$pdf->Cell(14, 0.4, $rh['satu'], 0, 1, 'C');

$pdf->ln(0.3);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(3.5, 0.4,'' , 0, 0, 'C');
$pdf->Cell(14, 0.5,'No. SIPA : KS.08/1119/DPMPTSP/Apt/2023', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(3.5, 0.4,'' , 0, 0, 'C');
$pdf->Cell(14, 0.5,'Jl. Ujung Harapan Kav. Assalam III No 19A RT.002 RW.015 ', 0, 1, 'C');
$pdf->Cell(3.5, 0.4,'' , 0, 0, 'C');
$pdf->Cell(15, 0.5,'', 0, 1, 'C');

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

$pdf->SetLineWidth(0.15);
$pdf->Line(0.5, 3.3, 20.5, 3.3); //horisontal bawah

$pdf->ln(0.7);
$pdf->SetX(1);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(20.5, 0, 'SURAT PESANAN OBAT MENGANDUNG PREKURSOR FARMASI', 0, 0, 'C');

$pre = substr($kdorders,4,12);
$pdf->ln(0.4);
$pdf->SetFont('Arial', '', 10);
$pdf->SetX(1);
$pdf->Cell(20.5, 0, 'Nomor SP : PRE-'.$pre, 0, 0, 'C');



$pdf->ln(0.7);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(14, 0, 'Yang bertandatangan di bawah ini :', 0, 0, 'L');


$pdf->ln(0.5);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Nama', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0, 'apt. Heru Khoerudin, S.Si.', 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Jabatan', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0,'Apoteker Penaggung Jawab' , 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'No. SIPA', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0,'KS.08/1119/DPMPTSP/Apt/2023' , 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Alamat', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0,'Perum Telaga Mas' , 0, 1, 'L');
$pdf->Cell(3, 0.8,'' , 0, 0, 'L');
$pdf->Cell(10, 0.8,'Jl. Telaga Elok K5/48 Harapan Baru Bekasi Utara' , 0, 1, 'L');

$pdf->ln(0.2);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(14, 0, 'Mengajukan pesanan Obat Jadi Prekursor Farmasi kepada :', 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Kepada', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0, $res['nm_supplier'], 0, 0, 'L');

$text1 = substr($alt['alamat_supplier'], 0,62);
$text2 = substr($alt['alamat_supplier'], 62,124);
$text3 = strlen($alt['alamat_supplier']);

if($text3 > 62) {
    $pdf->ln(0.4);
    $pdf->SetX(1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(2.5, 0, 'Alamat', 0, 0, 'L');
    $pdf->Cell(0.5, 0, ':', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 0, $text1, 0, 0, 'L');

    $pdf->ln(0.4);
    $pdf->SetX(1);
    $pdf->Cell(2.5, 0, '', 0, 0, 'L');
    $pdf->Cell(0.5, 0, '', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 0, $text2, 0, 0, 'L');
}
else {
    $pdf->ln(0.4);
    $pdf->SetX(1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(2.5, 0, 'Alamat', 0, 0, 'L');
    $pdf->Cell(0.5, 0, ':', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(10, 0, $text1, 0, 0, 'L');
}

$pdf->SetLineWidth(0);
$pdf->ln(0.8);
$current_y = $pdf->GetY(10);
$current_x = $pdf->GetX(1);
$cell_width=1;
$cell_height=1;

$pdf->SetX(1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell($cell_width,1.2,'No',1,'C');
$current_x =$cell_width + $current_x;
$pdf-> SetXY($current_x,$current_y);
$pdf->MultiCell(6.5, 0.6, 'Nama Obat Mengandung Prekursor Farmasi', 1, 'C');
$current_x = (6.5 + $current_x);
$pdf-> SetXY($current_x,$current_y);
$pdf->MultiCell(4, 0.6, 'Zat Aktif Prekursor Farmasi / isi Kemasan', 1, 'C');
$current_x = (4 + $current_x);
$pdf-> SetXY($current_x,$current_y);
$pdf->MultiCell(3.5, 0.6, 'Bentuk dan Kekuatan', 1, 'C');
$current_x = (3.5 + $current_x);
$pdf-> SetXY($current_x,$current_y);
$pdf->MultiCell(1.2, 1.2, 'Sat', 1, 'C');
$current_x = (1.2 + $current_x);
$pdf-> SetXY($current_x,$current_y);
$pdf->MultiCell(1, 1.2, 'Jml', 1, 'C');
$current_x = (1 + $current_x);
$pdf-> SetXY($current_x,$current_y);
$pdf->MultiCell(1.7, 1.2, 'Ket', 1, 'C');


$no = 1;
$query1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT *
FROM ordersdetail join barang
on (ordersdetail.kd_barang=barang.kd_barang)
WHERE kd_trbmasuk = '$kdorders'");



while ($lihat = mysqli_fetch_array($query1)) {
    $qty = ($lihat['qtygrosir_dtrbmasuk'] == "") ? $lihat['qty_dtrbmasuk'] : $lihat['qtygrosir_dtrbmasuk'];
    $satuan = ($lihat['satgrosir_dtrbmasuk'] == "") ? $lihat['sat_dtrbmasuk'] : $lihat['satgrosir_dtrbmasuk'];
    $zat = substr($lihat['ket_barang'],0,30);
    $kekuatan = substr($lihat['ket_barang'],-11,10);
    //atur pindah baris nama barang
    $text4 = substr($lihat['nmbrg_dtrbmasuk'],0,46);
    $text5 = substr($lihat['nmbrg_dtrbmasuk'],46,92);
    $text6 = strlen($lihat['nmbrg_dtrbmasuk']);
    //atur pindah baris zat aktif
    $text7 = substr($lihat['ket_barang'],0,25);
    $text8 = substr($lihat['ket_barang'],25,50);
    $text9 = strlen($lihat['ket_barang']);
    //atur pindah baris bentuk dan kekuatan
    $text10 = substr($lihat['dosis'],0,23);
    $text11 = substr($lihat['dosis'],23,46);
    $text12 = strlen($lihat['dosis']);

    if($text6<47 && $text9<26 && $text12<24) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(1, 0.7, $no, 1, 0, 'C');
        $pdf->Cell(6.5, 0.7, $text4, 1, 0, 'L');
        $pdf->Cell(4, 0.7, $text7, 1, 0, 'L');
        $pdf->Cell(3.5, 0.7, $text10, 1, 0, 'C');
        $pdf->Cell(1.2, 0.7, $satuan, 1, 0, 'C');
        $pdf->Cell(1, 0.7, $qty, 1, 0, 'C');
        $pdf->Cell(1.7, 0.7, terbilang($qty), 1, 1, 'C');
    }
    else {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(1, 0.7, $no, 1, 0, 'C');
        $pdf->Cell(6.5, 0.7, $text4, 1, 0, 'L');
        $pdf->Cell(4, 0.7, $text7, 1, 0, 'L');
        $pdf->Cell(3.5, 0.7, $text10, 1, 0, 'C');
        $pdf->Cell(1.2, 0.7, $satuan, 1, 0, 'C');
        $pdf->Cell(1, 0.7, $qty, 1, 0, 'C');
        $pdf->Cell(1.7, 0.7, terbilang($qty), 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(1, 0.7,'', 1, 0, 'C');
        $pdf->Cell(6.5, 0.7, $text5, 1, 0, 'L');
        $pdf->Cell(4, 0.7, $text8, 1, 0, 'L');
        $pdf->Cell(3.5, 0.7, $text11, 1, 0, 'C');
        $pdf->Cell(1.2, 0.7, $satuan, 1, 0, 'C');
        $pdf->Cell(1, 0.7, $qty, 1, 0, 'C');
        $pdf->Cell(1.7, 0.7, terbilang($qty), 1, 1, 'C');
    }
    $no++;
}

$pdf->ln(0.7);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(14, 0, 'Obat Jadi Prekursor Farmasi tersebut akan digunakan untuk :', 0, 0, 'L');

$pdf->ln(0.5);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Nama', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0, 'Apotek Yasfi', 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Alamat', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0,'Jl. Ujung Harapan Kav. Assalam III No. 19A RT. 002 RW. 015' , 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('', '', 10);
$pdf->Cell(2.5, 0, '', 0, 0, 'L');
$pdf->Cell(0.5, 0, '', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0,'Kel. Bahagia Kec. Babelan Kab. Bekasi' , 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Telp/Email', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0,'021-89258401 / apotekyasfi@gmail.com' , 0, 0, 'L');

$pdf->ln(0.4);
$pdf->SetX(1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(2.5, 0, 'Surat Izin', 0, 0, 'L');
$pdf->Cell(0.5, 0, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0,'12022300077910001' , 0, 1, 'L');

$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 0, '', 0, 0, 'R');
$pdf->Cell(9, 0, 'Bekasi, ' . tgl_indo(date("Y-m-d")), 0, 1, 'C');

$pdf->ln(0.4);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0, '', 0, 0, 'R');
$pdf->Cell(9, 0, 'Apoteker Pemesan,', 0, 0, 'C');

$pdf->ln(1.5);
$pdf->SetFont('Arial', 'BU', 10);
$pdf->Cell(10, 0, '', 0, 0, 'R');
$pdf->Cell(9, 0,'apt. Heru Khoerudin, S.Si.',0, 0, 'C');

$pdf->ln(0.4);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(10, 0, '', 0, 0, 'R');
$pdf->Cell(9, 0,'SIPA : KS.08/1119/DPMPTSP/Apt/2023', 0, 0, 'C');
$pdf->Output("order-prekursor_".$res['tgl_trbmasuk'], "I");
