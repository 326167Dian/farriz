<?php
session_start();
include "../../../configurasi/koneksi.php";

function esc($data) {
	return mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $data);
}

$id_dtrkasir = esc($_POST['id_dtrkasir']);

//ambil data
$ambildata = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_dtrkasir, id_barang, qty_dtrkasir FROM trkasir_detail
WHERE id_dtrkasir='$id_dtrkasir'");
$r = mysqli_fetch_array($ambildata);

$sukses = (bool) $r;
$stokakhir = 0;

mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);

if ($sukses) {
	$id_barang    = esc($r['id_barang']);
	$qty_dtrkasir = $r['qty_dtrkasir'];

	//update stok
	$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang
WHERE id_barang='$id_barang'");
	$rst = mysqli_fetch_array($cekstok);

	$stok_barang = $rst ? $rst['stok_barang'] : 0;
	$stokakhir = $stok_barang + $qty_dtrkasir;

	$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");

	if ($sukses) {
		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trkasir_detail WHERE id_dtrkasir = '$id_dtrkasir'");
	}

	if ($sukses) {
		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM komisi_pegawai WHERE id_dtrkasir = '$id_dtrkasir'");
	}
}

if ($sukses) {
	mysqli_commit($GLOBALS["___mysqli_ston"]);
	echo $stokakhir;
} else {
	mysqli_rollback($GLOBALS["___mysqli_ston"]);
	echo 'failed';
}
?>
