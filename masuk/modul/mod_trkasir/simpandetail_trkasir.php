<?php
session_start();
include "../../../configurasi/koneksi.php";

function esc($data) {
	return mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $data);
}

$kd_trkasir       = esc($_POST['kd_trkasir']);
$id_dtrkasir      = esc($_POST['id_dtrkasir']);
$id_barang        = esc($_POST['id_barang']);
$kd_barang        = esc($_POST['kd_barang']);
$nmbrg_dtrkasir   = esc($_POST['nmbrg_dtrkasir']);
$qty_dtrkasir     = esc($_POST['qty_dtrkasir']);
$sat_dtrkasir     = esc($_POST['sat_dtrkasir']);
$hrgjual_dtrkasir = esc($_POST['hrgjual_dtrkasir']);
$indikasi         = esc($_POST['indikasi']);
$jenisobat        = esc($_POST['jenisobat']);
$komisi           = esc($_POST['komisi_dtrkasir']);
$currentdate      = date('Y-m-d', time());
$id_admin         = esc($_POST['id_admin']);
$id_admin_sesi    = isset($_SESSION['idadmin']) ? esc($_SESSION['idadmin']) : '';

if ($qty_dtrkasir == "") {
	$qty_dtrkasir = "1";
} else {
}

$sukses = true;
mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);

if ($id_dtrkasir == "" || $id_dtrkasir == null) {

	//cek apakah barang sudah ada
	$cekdetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, kd_barang, kd_trkasir, id_dtrkasir, qty_dtrkasir
FROM trkasir_detail
WHERE kd_barang='$kd_barang' AND kd_trkasir='$kd_trkasir'");

	$ketemucekdetail = mysqli_num_rows($cekdetail);
	$rcek = mysqli_fetch_array($cekdetail);
	if ($ketemucekdetail > 0) {

		$id_dtrkasir = $rcek['id_dtrkasir'];
		$qtylama = $rcek['qty_dtrkasir'];
		$ttlqty = $qtylama + $qty_dtrkasir;
		$ttlharga = $ttlqty * $hrgjual_dtrkasir;

		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trkasir_detail SET qty_dtrkasir = '$ttlqty',
												hrgjual_dtrkasir = '$hrgjual_dtrkasir',
												hrgttl_dtrkasir = '$ttlharga'
												WHERE id_dtrkasir = '$id_dtrkasir' and kd_barang='$kd_barang'");

		//update stok
		if ($sukses) {
			$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang
        WHERE id_barang='$id_barang'");
			$rst = mysqli_fetch_array($cekstok);

			$stok_barang = $rst ? $rst['stok_barang'] : 0;
			$stokakhir = (($stok_barang + $qtylama) - $ttlqty);

			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
            stok_barang = '$stokakhir',
            jenisobat = '$jenisobat',
            hrgjual_barang = '$hrgjual_dtrkasir' WHERE id_barang = '$id_barang'");
		}

		if ($sukses && $_SESSION['komisi'] == 'Y') {
			if ($_SESSION['penjualansebelum'] == 'Y') {
				$ttlkomisi = $ttlqty * $komisi;
				$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE komisi_pegawai SET ttl_komisi = '$ttlkomisi'
            WHERE id_dtrkasir='$id_dtrkasir'");
			} else {
				$ttlkomisi = $ttlqty * $komisi;
				$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE komisi_pegawai SET ttl_komisi = '$ttlkomisi'
            WHERE id_dtrkasir='$id_dtrkasir' AND id_admin='$id_admin_sesi'");
			}
		}
	} else {

		$ttlharga = $qty_dtrkasir * $hrgjual_dtrkasir;

		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir_detail(kd_trkasir,
												id_barang,
												kd_barang,
												nmbrg_dtrkasir,
												qty_dtrkasir,
												sat_dtrkasir,
												hrgjual_dtrkasir,
												hrgttl_dtrkasir)
										  VALUES('$kd_trkasir',
												'$id_barang',
												'$kd_barang',
												'$nmbrg_dtrkasir',
												'$qty_dtrkasir',
												'$sat_dtrkasir',
												'$hrgjual_dtrkasir',
												'$ttlharga')");

		$insertid_dtrkasir = mysqli_insert_id($GLOBALS["___mysqli_ston"]);

		//update stok
		if ($sukses) {
			$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang
    WHERE id_barang='$id_barang'");
			$rst = mysqli_fetch_array($cekstok);

			$stok_barang = $rst ? $rst['stok_barang'] : 0;
			$stokakhir = $stok_barang - $qty_dtrkasir;

			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
        stok_barang = '$stokakhir',
        jenisobat = '$jenisobat',
        hrgjual_barang = '$hrgjual_dtrkasir' WHERE id_barang = '$id_barang'");

			if ($sukses && $_SESSION['komisi'] == 'Y') {
				if ($_SESSION['penjualansebelum'] == 'Y') {
					$ttlkomisi = $qty_dtrkasir * $komisi;
					$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO komisi_pegawai (kd_trkasir, id_dtrkasir, id_admin, ttl_komisi, tgl_komisi, status_komisi)
            VALUES('$kd_trkasir', '$insertid_dtrkasir', '$id_admin', '$ttlkomisi', '$currentdate', 'on')");
				} else {
					$ttlkomisi = $qty_dtrkasir * $komisi;
					$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO komisi_pegawai (kd_trkasir, id_dtrkasir, id_admin, ttl_komisi, tgl_komisi, status_komisi)
            VALUES('$kd_trkasir', '$insertid_dtrkasir', '$id_admin_sesi', '$ttlkomisi', '$currentdate', 'on')");
				}
			}
		}
	}
} else {
	//
	$cekdetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail
WHERE id_dtrkasir='$id_dtrkasir'");
	$rcek = mysqli_fetch_array($cekdetail);
	$id_dtrkasir = $rcek ? $rcek['id_dtrkasir'] : $id_dtrkasir;
	$qtylama = $rcek ? $rcek['qty_dtrkasir'] : 0;
	$qtybaru = $qtylama + $qty_dtrkasir;
	$ttlharga = $qtybaru * $hrgjual_dtrkasir;

	$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trkasir_detail SET qty_dtrkasir = '$qtybaru',
											hrgjual_dtrkasir = '$hrgjual_dtrkasir',
											hrgttl_dtrkasir = '$ttlharga'
											WHERE id_dtrkasir = '$id_dtrkasir'");

	//update stok
	if ($sukses) {
		$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang
        WHERE id_barang='$id_barang'");
		$rst = mysqli_fetch_array($cekstok);

		$stok_barang = $rst ? $rst['stok_barang'] : 0;
		$stokakhir = (($stok_barang + $qtylama) - $qty_dtrkasir);

		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
            stok_barang = '$stokakhir',
            jenisobat = '$jenisobat',
            hrgjual_barang = '$hrgjual_dtrkasir' WHERE id_barang = '$id_barang'");
	}

	if ($sukses && $_SESSION['komisi'] == 'Y') {
		if ($_SESSION['penjualansebelum'] == 'Y') {
			$ttlkomisi = $qtybaru * $komisi;
			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE komisi_pegawai SET ttl_komisi = '$ttlkomisi'
            WHERE id_dtrkasir='$id_dtrkasir'");
		} else {
			$ttlkomisi = $qtybaru * $komisi;
			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE komisi_pegawai SET ttl_komisi = '$ttlkomisi'
            WHERE id_dtrkasir='$id_dtrkasir' AND id_admin='$id_admin_sesi'");
		}
	}
}

if ($sukses) {
	mysqli_commit($GLOBALS["___mysqli_ston"]);
} else {
	mysqli_rollback($GLOBALS["___mysqli_ston"]);
}

echo $sukses ? 'success' : 'failed';
?>
