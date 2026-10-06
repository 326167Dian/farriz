<?php
include "../../../configurasi/koneksi.php";

function esc($data) {
	return mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $data);
}

$id_dtrbmasuk = esc($_POST['id_dtrbmasuk']);

//ambil data
$ambildata = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_dtrbmasuk, id_barang, qty_dtrbmasuk FROM trbmasuk_detail
WHERE id_dtrbmasuk='$id_dtrbmasuk'");
$r = mysqli_fetch_array($ambildata);

$sukses = (bool) $r;

mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);

if ($sukses) {
	$id_barang     = esc($r['id_barang']);
	$qty_dtrbmasuk = $r['qty_dtrbmasuk'];

	//update stok
	$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang
WHERE id_barang='$id_barang'");
	$rst = mysqli_fetch_array($cekstok);

	$stok_barang = $rst ? $rst['stok_barang'] : 0;
	$stokakhir = $stok_barang - $qty_dtrbmasuk;

	$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");

	if ($sukses) {
		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trbmasuk_detail WHERE id_dtrbmasuk = '$id_dtrbmasuk'");
	}
}

if ($sukses) {
	mysqli_commit($GLOBALS["___mysqli_ston"]);
	echo 'success';
} else {
	mysqli_rollback($GLOBALS["___mysqli_ston"]);
	echo 'failed';
}
