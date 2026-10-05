<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{

include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_thumb.php";
include "../../../configurasi/library.php";

$module=$_GET['module'];
$act=$_GET['act'];


$kd_barang = $_POST['kd_barang'];
$tgl = $_POST['tgl'];
$nm_kbarang = $_POST['nm_kbarang'];
$stok_barangawal = $_POST['stok_barangawal'];
$selisih_tx = $_POST['selisih_tx'];
$stok_baru = $_POST['stok_baru'];
$ket = $_POST['ket'];

// Input admin
if ($module=='koreksistok' AND $act=='input_koreksi'){

    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO koreksi_stok(kd_barang,
										 tgl,
										 nm_kbarang,
										 stok_barangawal,
										 selisih_tx,
										 stok_baru,
										 ket)			
								 VALUES('$_POST[kd_barang]',
								        '$_POST[tgl]',
										'$_POST[nm_kbarang]',
										'$_POST[stok_barangawal]',
										'$_POST[selisih_tx]',
										'$_POST[stok_baru]',
										'$_POST[ket]')");
//cek stok


    $cekstok=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang
		WHERE kd_barang='$kd_barang'");

    $rst=mysqli_fetch_array($cekstok);


    $stok_barang = $rst['stok_barang'];


    $stokakhir = $stok_barang + $stok_baru;

    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE kd_barang = '$kd_barang'");

    //mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stok_baru' WHERE kd_barang = '$kd_barang'");

	echo "<script type='text/javascript'>alert('Data berhasil dikoreksi !');window.location='../../media_admin.php?module=".$module."'</script>";
	header('location:../../media_admin.php?module='.$module);

}
else{}




}
?>
