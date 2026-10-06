<?php
error_reporting(0);
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
	include "../../../configurasi/koneksi.php";
	include "../../../configurasi/fungsi_thumb.php";
	include "../../../configurasi/library.php";

	function esc($data) {
		return mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $data);
	}
	function esc_row($row) {
		if (!$row) return $row;
		return array_map(function ($v) {
			return $v === null ? null : mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $v);
		}, $row);
	}

	$module = "trkasir";
	$stt_aksi = esc($_POST['stt_aksi']);
	if ($stt_aksi == "input_trkasir" || $stt_aksi == "ubah_trkasir") {
		$act = $stt_aksi;
	} else {
		$act = esc($_GET['act']);
	}

	// Input transaksi kasir
	if ($module == 'trkasir' and $act == 'input_trkasir') {

		$kd_trkasir       = esc($_POST['kd_trkasir']);
		$petugas          = esc($_POST['petugas']);
		$shift            = esc($_POST['shift']);
		$tgl_trkasir      = esc($_POST['tgl_trkasir']);
		$nm_pelanggan     = esc($_POST['nm_pelanggan']);
		$tlp_pelanggan    = esc($_POST['tlp_pelanggan']);
		$alamat_pelanggan = esc($_POST['alamat_pelanggan']);
		$ttl_trkasir      = esc($_POST['ttl_trkasir']);
		$diskon2          = esc($_POST['diskon2']);
		$dp_bayar         = esc($_POST['dp_bayar']);
		$sisa_bayar       = esc($_POST['sisa_bayar']);
		$ket_trkasir      = esc($_POST['ket_trkasir']);
		$id_carabayar     = esc($_POST['id_carabayar']);
		$id_admin_sesi    = esc($_SESSION['idadmin']);

		$cariitem = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir = '$kd_trkasir'");
		$countItem = mysqli_num_rows($cariitem);

		if ($countItem <= 0) {
			$data['message'] = 'failed';
			echo json_encode($data);
		} else {

			mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);
			$sukses = true;

			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir(
											kd_trkasir, petugas, shift, tgl_trkasir, nm_pelanggan, tlp_pelanggan,
											alamat_pelanggan, ttl_trkasir, diskon2, dp_bayar, sisa_bayar, ket_trkasir, id_carabayar)
									 VALUES('$kd_trkasir','$petugas','$shift','$tgl_trkasir','$nm_pelanggan','$tlp_pelanggan',
											'$alamat_pelanggan','$ttl_trkasir','$diskon2','$dp_bayar','$sisa_bayar','$ket_trkasir','$id_carabayar')");

			if ($sukses) {
				$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO kartu_stok(kode_transaksi) VALUES('$kd_trkasir')");
			}

			if ($sukses) {
				$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kdtk SET stt_kdtk = 'OFF' WHERE id_admin = '$id_admin_sesi' AND kd_trkasir = '$kd_trkasir'");
			}

			if ($sukses) {
				$ambildatainduk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir WHERE kd_trkasir='$kd_trkasir'");
				$r1 = esc_row(mysqli_fetch_array($ambildatainduk));

				$ambildatadetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir='$kd_trkasir'");
				while ($sukses && ($r = esc_row(mysqli_fetch_array($ambildatadetail)))) {
					$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir_restore(
							kd_trkasir, petugas, shift, tgl_trkasir, nm_pelanggan, tlp_pelanggan, alamat_pelanggan,
							ttl_trkasir, dp_bayar, diskon1, diskon2, sisa_bayar, ket_trkasir, id_carabayar, id_barang,
							kd_barang, nmbrg_dtrkasir, qty_dtrkasir, sat_dtrkasir, hrgjual_dtrkasir, hrgttl_dtrkasir)
						VALUES(
							'$r1[kd_trkasir]','$r1[petugas]','$r1[shift]','$r1[tgl_trkasir]','$r1[nm_pelanggan]','$r1[tlp_pelanggan]','$r1[alamat_pelanggan]','$r1[ttl_trkasir]','$r1[dp_bayar]','$r1[diskon1]','$r1[diskon2]','$r1[sisa_bayar]','$r1[ket_trkasir]','$r1[id_carabayar]','$r[id_barang]','$r[kd_barang]','$r[nmbrg_dtrkasir]','$r[qty_dtrkasir]','$r[sat_dtrkasir]','$r[hrgjual_dtrkasir]','$r[hrgttl_dtrkasir]')");
				}
			}

			if ($sukses) {
				mysqli_commit($GLOBALS["___mysqli_ston"]);
				$data['message'] = 'success';
				echo json_encode($data);
			} else {
				mysqli_rollback($GLOBALS["___mysqli_ston"]);
				$data['message'] = 'failed';
				echo json_encode($data);
			}
		}
	}

	// update trkasir
	elseif ($module == 'trkasir' and $act == 'ubah_trkasir') {

		$id_trkasir       = esc($_POST['id_trkasir']);
		$tgl_trkasir      = esc($_POST['tgl_trkasir']);
		$petugas          = esc($_POST['petugas']);
		$nm_pelanggan     = esc($_POST['nm_pelanggan']);
		$tlp_pelanggan    = esc($_POST['tlp_pelanggan']);
		$alamat_pelanggan = esc($_POST['alamat_pelanggan']);
		$ttl_trkasir      = esc($_POST['ttl_trkasir']);
		$diskon2          = esc($_POST['diskon2']);
		$dp_bayar         = esc($_POST['dp_bayar']);
		$sisa_bayar       = esc($_POST['sisa_bayar']);
		$ket_trkasir      = esc($_POST['ket_trkasir']);
		$id_carabayar     = esc($_POST['id_carabayar']);

		$ubah = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trkasir SET tgl_trkasir = '$tgl_trkasir',
									petugas = '$petugas',
									nm_pelanggan = '$nm_pelanggan',
									tlp_pelanggan = '$tlp_pelanggan',
									alamat_pelanggan = '$alamat_pelanggan',
									ttl_trkasir = '$ttl_trkasir',
									diskon2 = '$diskon2',
									dp_bayar = '$dp_bayar',
									sisa_bayar = '$sisa_bayar',
									ket_trkasir = '$ket_trkasir',
									id_carabayar = '$id_carabayar'
									WHERE id_trkasir = '$id_trkasir'");

		if ($ubah) {
			$data['message'] = 'success';
			echo json_encode($data);
		} else {
			$data['message'] = 'failed';
			echo json_encode($data);
		}
	}
	//Hapus Proyek
	elseif ($module == 'trkasir' and $act == 'hapus') {

		if ($_SESSION['level'] != 'pemilik') {
			echo "<script type='text/javascript'>window.location='../../media_admin.php?module=" . $module . "'</script>";
		} else {

			$id_trkasir = esc($_GET['id']);

			mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);
			$sukses = true;

			//ambil data induk
			$ambildatainduk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir WHERE id_trkasir='$id_trkasir'");
			$r1 = esc_row(mysqli_fetch_array($ambildatainduk));
			$kd_trkasir = $r1 ? $r1['kd_trkasir'] : '';

			if (!$r1) {
				$sukses = false;
			} else {
				//loop data detail
				$ambildatadetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir='$kd_trkasir'");
				while ($sukses && ($r = esc_row(mysqli_fetch_array($ambildatadetail)))) {

					$id_dtrkasir  = $r['id_dtrkasir'];
					$id_barang    = $r['id_barang'];
					$qty_dtrkasir = $r['qty_dtrkasir'];

					$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir_restore(
							kd_trkasir, petugas, shift, tgl_trkasir, nm_pelanggan, tlp_pelanggan, alamat_pelanggan,
							ttl_trkasir, dp_bayar, diskon1, diskon2, sisa_bayar, ket_trkasir, id_carabayar, id_barang,
							kd_barang, nmbrg_dtrkasir, qty_dtrkasir, sat_dtrkasir, hrgjual_dtrkasir, hrgttl_dtrkasir)
						VALUES(
							'$r1[kd_trkasir]','$r1[petugas]','$r1[shift]','$r1[tgl_trkasir]','$r1[nm_pelanggan]','$r1[tlp_pelanggan]','$r1[alamat_pelanggan]','$r1[ttl_trkasir]','$r1[dp_bayar]','$r1[diskon1]','$r1[diskon2]','$r1[sisa_bayar]','$r1[ket_trkasir]','$r1[id_carabayar]','$r[id_barang]','$r[kd_barang]','$r[nmbrg_dtrkasir]','$r[qty_dtrkasir]','$r[sat_dtrkasir]','$r[hrgjual_dtrkasir]','$r[hrgttl_dtrkasir]')");

					//update stok
					if ($sukses) {
						$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang WHERE id_barang='$id_barang'");
						$rst = mysqli_fetch_array($cekstok);

						$stok_barang = $rst ? $rst['stok_barang'] : 0;
						$stokakhir = $stok_barang + $qty_dtrkasir;

						$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");
					}

					if ($sukses) {
						$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trkasir_detail WHERE id_dtrkasir = '$id_dtrkasir'");
					}

					if ($sukses) {
						$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM komisi_pegawai WHERE id_dtrkasir = '$id_dtrkasir'");
					}
				}
			}

			if ($sukses) {
				$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trkasir WHERE id_trkasir = '$id_trkasir'");
			}
			if ($sukses) {
				$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM kartu_stok WHERE kode_transaksi = '$kd_trkasir'");
			}

			if ($sukses) {
				mysqli_commit($GLOBALS["___mysqli_ston"]);
				echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=" . $module . "'</script>";
			} else {
				mysqli_rollback($GLOBALS["___mysqli_ston"]);
				echo "<script type='text/javascript'>alert('Data gagal dihapus, transaksi dibatalkan !');window.location='../../media_admin.php?module=" . $module . "'</script>";
			}
		}
	}
}
