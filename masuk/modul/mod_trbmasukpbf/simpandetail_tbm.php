<?php
include "../../../configurasi/koneksi.php";

function esc($data) {
	return mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $data);
}

$kd_trbmasuk       = esc($_POST['kd_trbmasuk']);
$id_barang         = esc($_POST['id_barang']);
$kd_barang         = esc($_POST['kd_barang']);
$nmbrg_dtrbmasuk   = esc($_POST['nmbrg_dtrbmasuk']);
$qty_dtrbmasuk     = esc($_POST['qty_dtrbmasuk']);
$sat_dtrbmasuk     = esc($_POST['sat_dtrbmasuk']);
$hnasat_dtrbmasuk  = esc($_POST['hnasat_dtrbmasuk']);
$hrgjual_dtrbmasuk = esc($_POST['hrgjual_dtrbmasuk']);
$diskon            = esc($_POST['diskon']);
// $hrgsat_dtrbmasuk = $hnasat_dtrbmasuk * 1.11 ;

$no_batch = esc($_POST['no_batch']);
$exp_date = esc(date('Y-m-d', strtotime($_POST['exp_date'])));

if ($qty_dtrbmasuk == "") {
	$qty_dtrbmasuk = "1";
} else {
}
if ($diskon == "") {
	$diskon = "0";
} else {
}

$hrgsat_dtrbmasuk = $hnasat_dtrbmasuk * (1 - ($diskon / 100)) * 1.11;

$sukses = true;
mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);

//cek apakah barang sudah ada
$cekdetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, kd_barang, kd_trbmasuk, id_dtrbmasuk, qty_dtrbmasuk
FROM trbmasuk_detail
WHERE kd_barang='$kd_barang' AND kd_trbmasuk='$kd_trbmasuk'");

$ketemucekdetail = mysqli_num_rows($cekdetail);
$rcek = mysqli_fetch_array($cekdetail);
if ($ketemucekdetail > 0) {

	$id_dtrbmasuk = $rcek['id_dtrbmasuk'];
	$qtylama = $rcek['qty_dtrbmasuk'];
	$ttlqty = $qtylama + $qty_dtrbmasuk;
	$ttlharga = $ttlqty * $hnasat_dtrbmasuk;

	$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trbmasuk_detail SET
                                        qty_dtrbmasuk = '$ttlqty',
										hnasat_dtrbmasuk = '$hnasat_dtrbmasuk',
										diskon = '$diskon',
										hrgsat_dtrbmasuk = '$hrgsat_dtrbmasuk',
										hrgjual_dtrbmasuk = '$hrgjual_dtrbmasuk',
										hrgttl_dtrbmasuk = '$ttlharga',
										no_batch = '$no_batch',
										exp_date = '$exp_date'
										WHERE id_dtrbmasuk = '$id_dtrbmasuk'");

	//update stok
	if ($sukses) {
		$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang
WHERE id_barang='$id_barang'");
		$rst = mysqli_fetch_array($cekstok);

		$stok_barang = $rst ? $rst['stok_barang'] : 0;
		$stokakhir = (($stok_barang - $qtylama) + $ttlqty);

		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                          stok_barang = '$stokakhir',
                                          hna = '$hnasat_dtrbmasuk',
                                          hrgsat_barang = '$hrgsat_dtrbmasuk'
                                          WHERE id_barang = '$id_barang'");
	}
} else {
	$faktordiskon = (1 - ($diskon / 100));
	$ttlharga = $qty_dtrbmasuk * $hnasat_dtrbmasuk * $faktordiskon;

	$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trbmasuk_detail(kd_trbmasuk,
										id_barang,
										kd_barang,
										nmbrg_dtrbmasuk,
										qty_dtrbmasuk,
										sat_dtrbmasuk,
										hnasat_dtrbmasuk,
										diskon,
										hrgsat_dtrbmasuk,
										hrgjual_dtrbmasuk,
										hrgttl_dtrbmasuk,
										no_batch,
										exp_date)
								  VALUES('$kd_trbmasuk',
										'$id_barang',
										'$kd_barang',
										'$nmbrg_dtrbmasuk',
										'$qty_dtrbmasuk',
										'$sat_dtrbmasuk',
										'$hnasat_dtrbmasuk',
										'$diskon',
										'$hrgsat_dtrbmasuk',
										'$hrgjual_dtrbmasuk',
										'$ttlharga',
										'$no_batch',
										'$exp_date')");

	//update stok,hna,hrgbrg+ppn
	if ($sukses) {
		$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang
WHERE id_barang='$id_barang'");
		$rst = mysqli_fetch_array($cekstok);

		$stok_barang = $rst ? $rst['stok_barang'] : 0;
		$stokakhir = $stok_barang + $qty_dtrbmasuk;

		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                                stok_barang = '$stokakhir',
                                                hna = '$hnasat_dtrbmasuk',
                                                hrgsat_barang = '$hrgsat_dtrbmasuk'
                                                WHERE id_barang = '$id_barang'");
	}
}

if ($sukses) {
	mysqli_commit($GLOBALS["___mysqli_ston"]);
	echo 'success';
} else {
	mysqli_rollback($GLOBALS["___mysqli_ston"]);
	echo 'failed';
}
?>
