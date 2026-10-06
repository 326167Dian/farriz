<?php
error_reporting(0);
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])) {
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

	$module = "trbmasukpbf";
	$stt_aksi = esc($_POST['stt_aksi']);
	if ($stt_aksi == "input_trbmasuk" || $stt_aksi == "ubah_trbmasuk") {
		$act = $stt_aksi;
	} else {
		$act = esc($_GET['act']);
	}


	// Input transaksi barang masuk
	if ($module == 'trbmasukpbf' AND $act == 'input_trbmasuk') {

		$kd_trbmasuk     = esc($_POST['kd_trbmasuk']);
		$tgl_trbmasuk    = esc($_POST['tgl_trbmasuk']);
		$id_supplier     = esc($_POST['id_supplier']);
		$petugas         = esc($_POST['petugas']);
		$nm_supplier     = esc($_POST['nm_supplier']);
		$tlp_supplier    = esc($_POST['tlp_supplier']);
		$alamat_trbmasuk = esc($_POST['alamat_trbmasuk']);
		$ttl_trkasir     = esc($_POST['ttl_trkasir']);
		$dp_bayar        = esc($_POST['dp_bayar']);
		$sisa_bayar      = esc($_POST['sisa_bayar']);
		$ket_trbmasuk    = esc($_POST['ket_trbmasuk']);
		$jatuhtempo      = esc($_POST['jatuhtempo']);
		$carabayar       = esc($_POST['carabayar']);
		$id_admin_sesi   = esc($_SESSION['idadmin']);

		mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);
		$sukses = true;

		$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO
										trbmasuk(id_resto,
										kd_trbmasuk,
										tgl_trbmasuk,
										id_supplier,
										petugas,
										nm_supplier,
										tlp_supplier,
										alamat_trbmasuk,
										ttl_trbmasuk,
										dp_bayar,
										sisa_bayar,
										ket_trbmasuk,
										jatuhtempo,
										carabayar,
										jenis)
								 VALUES('pusat',
										'$kd_trbmasuk',
										'$tgl_trbmasuk',
										'$id_supplier',
										'$petugas',
										'$nm_supplier',
										'$tlp_supplier',
										'$alamat_trbmasuk',
										'$ttl_trkasir',
										'$dp_bayar',
										'$sisa_bayar',
										'$ket_trbmasuk',
										'$jatuhtempo',
										'$carabayar',
										'pbf'
										)");

		if ($sukses) {
			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO kartu_stok(kode_transaksi) VALUES('$kd_trbmasuk')");
		}

		if ($sukses) {
			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kdbm SET stt_kdbm = 'OFF' WHERE id_admin = '$id_admin_sesi' AND id_resto = 'pusat' AND kd_trbmasuk = '$kd_trbmasuk'");
		}

		if ($sukses) {
			mysqli_commit($GLOBALS["___mysqli_ston"]);
			echo 'success';
		} else {
			mysqli_rollback($GLOBALS["___mysqli_ston"]);
			echo 'failed';
		}

		//echo "<script type='text/javascript'>alert('Transkasi berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
	}
	//updata trbmasukpbf
	elseif ($module == 'trbmasukpbf' AND $act == 'ubah_trbmasuk') {

		$id_trbmasuk     = esc($_POST['id_trbmasuk']);
		$tgl_trbmasuk    = esc($_POST['tgl_trbmasuk']);
		$id_supplier     = esc($_POST['id_supplier']);
		$nm_supplier     = esc($_POST['nm_supplier']);
		$tlp_supplier    = esc($_POST['tlp_supplier']);
		$alamat_trbmasuk = esc($_POST['alamat_trbmasuk']);
		$ttl_trkasir     = esc($_POST['ttl_trkasir']);
		$dp_bayar        = esc($_POST['dp_bayar']);
		$sisa_bayar      = esc($_POST['sisa_bayar']);
		$ket_trbmasuk    = esc($_POST['ket_trbmasuk']);
		$jatuhtempo      = esc($_POST['jatuhtempo']);
		$carabayar       = esc($_POST['carabayar']);

		$ubah = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trbmasuk SET tgl_trbmasuk = '$tgl_trbmasuk',
									id_supplier = '$id_supplier',
									nm_supplier = '$nm_supplier',
									tlp_supplier = '$tlp_supplier',
									alamat_trbmasuk = '$alamat_trbmasuk',
									ttl_trbmasuk = '$ttl_trkasir',
									dp_bayar = '$dp_bayar',
									sisa_bayar = '$sisa_bayar',
									ket_trbmasuk = '$ket_trbmasuk',
									jatuhtempo = '$jatuhtempo',
									carabayar = '$carabayar'
									WHERE id_trbmasuk = '$id_trbmasuk'");

		echo $ubah ? 'success' : 'failed';

		//echo "<script type='text/javascript'>alert('Transkasi berhasil Ubah !');window.location='../../media_admin.php?module=".$module."'</script>";
	}
	//Hapus Proyek
	elseif ($module == 'trbmasukpbf' AND $act == 'hapus') {

		$id_trbmasuk = esc($_GET['id']);

		mysqli_begin_transaction($GLOBALS["___mysqli_ston"]);
		$sukses = true;

		//ambil data induk
		$ambildatainduk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_trbmasuk, kd_trbmasuk FROM trbmasuk
	WHERE id_trbmasuk='$id_trbmasuk'");
		$r1 = mysqli_fetch_array($ambildatainduk);
		$kd_trbmasuk = $r1 ? esc($r1['kd_trbmasuk']) : '';

		if (!$r1) {
			$sukses = false;
		} else {
			//loop data detail
			$ambildatadetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_dtrbmasuk, kd_trbmasuk, id_barang, qty_dtrbmasuk FROM trbmasuk_detail WHERE kd_trbmasuk='$kd_trbmasuk'");
			while ($sukses && ($r = mysqli_fetch_array($ambildatadetail))) {

				$id_dtrbmasuk  = esc($r['id_dtrbmasuk']);
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
		}

		if ($sukses) {
			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trbmasuk WHERE id_trbmasuk = '$id_trbmasuk'");
		}
		if ($sukses) {
			$sukses = $sukses && mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM kartu_stok WHERE kode_transaksi = '$kd_trbmasuk'");
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
