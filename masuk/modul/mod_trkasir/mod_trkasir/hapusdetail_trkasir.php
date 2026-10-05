<?php 
include "../../../configurasi/koneksi.php";

$id_dtrkasir  = $_POST['id_dtrkasir'];

//ambil data
$ambildata=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_dtrkasir, id_barang, qty_dtrkasir FROM trkasir_detail 
WHERE id_dtrkasir='$id_dtrkasir'");
$r=mysqli_fetch_array($ambildata);

$id_barang = $r['id_barang'];
$qty_dtrkasir = $r['qty_dtrkasir'];

//update stok

$cekstok=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang 
WHERE id_barang='$id_barang'");
$rst=mysqli_fetch_array($cekstok);

$stok_barang = $rst['stok_barang'];
$stokakhir = $stok_barang + $qty_dtrkasir;

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");

mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trkasir_detail WHERE id_dtrkasir = '$id_dtrkasir'");

?>
