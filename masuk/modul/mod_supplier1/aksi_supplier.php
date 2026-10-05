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
	if ($module == 'supplier' and $act == 'input_supplier') {

		$cekganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM supplier WHERE nm_supplier='$_POST[nm_supplier]'AND tlp_supplier='$_POST[tlp_supplier]'");
		$ada = mysqli_num_rows($cekganda);
		if ($ada > 0) {
			echo "<script type='text/javascript'>alert('Nama Supplier dengan nomor telepon ini sudah ada!');history.go(-1);</script>";
		} else {

			mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO supplier(nm_supplier, tlp_supplier, alamat_supplier, ket_supplier)
								 VALUES('$_POST[nm_supplier]','$_POST[tlp_supplier]','$_POST[alamat_supplier]','$_POST[ket_supplier]')");


			//echo "<script type='text/javascript'>alert('Data berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
			header('location:../../media_admin.php?module=' . $module);
		}
	}
	//updata supplier
	elseif ($module == 'supplier' and $act == 'update_supplier') {

		mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE supplier SET nm_supplier = '$_POST[nm_supplier]',
									tlp_supplier = '$_POST[tlp_supplier]',
									alamat_supplier = '$_POST[alamat_supplier]',
									ket_supplier = '$_POST[ket_supplier]'
									WHERE id_supplier = '$_POST[id]'");

		//echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
		header('location:../../media_admin.php?module=' . $module);
	}
	//Hapus Proyek
	elseif ($module == 'supplier' and $act == 'hapus') {

		mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM supplier WHERE id_supplier = '$_GET[id]'");
		//echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
		header('location:../../media_admin.php?module=' . $module);
	}
	// simpan data obat supplier
	elseif ($module == 'supplier' and $act == 'simpanbarang') {
		# code...
		$idsupplier = $_POST['id_supplier'];
		$idbarang = $_POST['id_barang'];
		mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO barang_supplier(id_supplier, id_barang)
								 VALUES('" . $_POST['id_supplier'] . "','" . $_POST['id_barang'] . "')");
	}
	// hapus data obat supplier
	elseif ($module == 'supplier' and $act == 'hapusbarang') {
		# code...
		mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM barang_supplier WHERE id_brgsup = '$_POST[id_brgsup]'");
	}
}
