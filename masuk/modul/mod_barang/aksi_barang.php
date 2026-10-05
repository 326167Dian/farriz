<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {

	include "../../../configurasi/koneksi.php";
	include "../../../configurasi/fungsi_thumb.php";
	include "../../../configurasi/library.php";

	$module = $_GET['module'];
	$act = $_GET['act'];

	// Input admin
	if ($module == 'barang' and $act == 'input_barang') {

		$cekganda1 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT kd_barang FROM barang WHERE kd_barang='$_POST[kd_barang]'");
		$ada1 = mysqli_num_rows($cekganda1);
		if ($ada1 > 0) {
			echo "<script type='text/javascript'>alert('Kode Barang sudah ada!');history.go(-1);</script>";
		} else {

			$cekganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nm_barang FROM barang WHERE nm_barang='$_POST[nm_barang]'");
			$ada = mysqli_num_rows($cekganda);
			if ($ada > 0) {
				echo "<script type='text/javascript'>alert('Nama Barang sudah ada!');history.go(-1);</script>";
			} else {

				$cekganda3 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT kd_barang, nm_barang, sat_barang FROM barang 
				WHERE kd_barang='$_POST[kd_barang]' AND nm_barang='$_POST[nm_barang]' AND sat_barang='$_POST[sat_barang]'");
				$ada3 = mysqli_num_rows($cekganda3);
				if ($ada3 > 0) {
					echo "<script type='text/javascript'>alert('Kode dengan Nama Barang dan Satuan ini sudah ada!');history.go(-1);</script>";
				} else {

					mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO barang(kd_barang,
										 nm_barang,										
										 stok_buffer,
										 sat_barang,
										 jenisobat,
										 hrgsat_barang,
										 hrgjual_barang,
										 indikasi,
										 ket_barang)
								 VALUES('$_POST[kd_barang]',
										'$_POST[nm_barang]',										
										'$_POST[stok_buffer]',
										'$_POST[sat_barang]',
										'$_POST[jenisobat]',
										'$_POST[hrgsat_barang]',
										'$_POST[hrgjual_barang]',
										'$_POST[indikasi]',
										'$_POST[ket_barang]')");

					//echo "<script type='text/javascript'>alert('Data berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
					header('location:../../media_admin.php?module=' . $module);
				}
			}
		}
	}
	//update barang
	elseif ($module == 'barang' and $act == 'update_barang') {

		mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET
                                    kd_barang = '$_POST[kd_barang]',
									nm_barang = '$_POST[nm_barang]',									
									stok_buffer = '$_POST[stok_buffer]',
									sat_barang = '$_POST[sat_barang]',
									jenisobat = '$_POST[jenisobat]',
									hrgsat_barang = '$_POST[hrgsat_barang]',
									hrgjual_barang = '$_POST[hrgjual_barang]',
									indikasi = '$_POST[indikasi]',
									ket_barang = '$_POST[ket_barang]'
									WHERE id_barang = '$_POST[id]'");

		//echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
		header('location:../../media_admin.php?module=' . $module);
	}
	//Hapus Proyek
	elseif ($module == 'barang' and $act == 'hapus') {

		mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM barang WHERE id_barang = '$_GET[id]'");
		//echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
		header('location:../../media_admin.php?module=' . $module);
	}
}
