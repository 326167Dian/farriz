<?php 
include "../../../configurasi/koneksi.php";

$id_dtrbmasuk  = $_POST['id_dtrbmasuk'];

//ambil data
$ambildata=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_dtrbmasuk, id_barang, qty_dtrbmasuk FROM ordersdetail 
WHERE id_dtrbmasuk='$id_dtrbmasuk'");
$r=mysqli_fetch_array($ambildata);

$id_barang = $r['id_barang'];
$qty_dtrbmasuk = $r['qty_dtrbmasuk'];

//update stok
$cekstok=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang 
WHERE id_barang='$id_barang'");
$rst=mysqli_fetch_array($cekstok);

$stok_barang = $rst['stok_barang'];
$stokakhir = $stok_barang ;

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");

mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM ordersdetail WHERE id_dtrbmasuk = '$id_dtrbmasuk'");

?>
