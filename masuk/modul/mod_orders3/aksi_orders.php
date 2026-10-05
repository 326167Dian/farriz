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

	$module = "orders";
	$stt_aksi = $_POST['stt_aksi'];
	if ($stt_aksi == "input_trbmasuk" || $stt_aksi == "ubah_trbmasuk") {
		$act = $stt_aksi;
	} else {
		$act = $_GET['act'];
	}


	// Input admin
	if ($module == 'orders' and $act == 'input_trbmasuk') {

		mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO 
										orders(id_resto,
										kd_trbmasuk,
										tgl_trbmasuk,
										id_supplier,
										nm_supplier,
										tlp_supplier,
										alamat_trbmasuk,
										ttl_trbmasuk,
										dp_bayar,
										sisa_bayar,
										ket_trbmasuk)
								 VALUES('pesan',
										'$_POST[kd_trbmasuk]',
										'$_POST[tgl_trbmasuk]',
										'$_POST[id_supplier]',
										'$_POST[nm_supplier]',
										'$_POST[tlp_supplier]',
										'$_POST[alamat_trbmasuk]',
										'$_POST[ttl_trkasir]',
										'$_POST[dp_bayar]',
										'$_POST[sisa_bayar]',
										'$_POST[ket_trbmasuk]')");

		mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kdbm SET stt_kdbm = 'OFF' WHERE id_admin = '$_SESSION[idadmin]' AND id_resto = 'pesan' AND kd_trbmasuk = '$_POST[kd_trbmasuk]'");


		//echo "<script type='text/javascript'>alert('Transkasi berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";


	}
	//updata trbmasuk
	elseif ($module == 'orders' and $act == 'ubah_trbmasuk') {


		mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE orders SET tgl_trbmasuk = '$_POST[tgl_trbmasuk]',
									id_supplier = '$_POST[id_supplier]',
									nm_supplier = '$_POST[nm_supplier]',
									tlp_supplier = '$_POST[tlp_supplier]',
									alamat_trbmasuk = '$_POST[alamat_trbmasuk]',
									ttl_trbmasuk = '$_POST[ttl_trkasir]',
									dp_bayar = '$_POST[dp_bayar]',
									sisa_bayar = '$_POST[sisa_bayar]',
									ket_trbmasuk = '$_POST[ket_trbmasuk]'
									WHERE id_trbmasuk = '$_POST[id_trbmasuk]'");


		//echo "<script type='text/javascript'>alert('Transkasi berhasil Ubah !');window.location='../../media_admin.php?module=".$module."'</script>";

	}
	//Hapus Proyek
	elseif ($module == 'orders' and $act == 'hapus') {

		//update bagian stok dulu
		//ambil data induk
		$ambildatainduk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_trbmasuk, kd_trbmasuk FROM orders 
	WHERE id_trbmasuk='$_GET[id]'");
		$r1 = mysqli_fetch_array($ambildatainduk);
		$kd_trbmasuk = $r1['kd_trbmasuk'];

		//loop data detail
		//ambil data induk
		$ambildatadetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_dtrbmasuk, kd_trbmasuk, id_barang, qty_dtrbmasuk FROM ordersdetail WHERE kd_trbmasuk='$kd_trbmasuk'");
		while ($r = mysqli_fetch_array($ambildatadetail)) {

			$id_dtrbmasuk = $r['id_dtrbmasuk'];
			$id_barang = $r['id_barang'];
			$qty_dtrbmasuk = $r['qty_dtrbmasuk'];

			//update stok
			$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang 
	WHERE id_barang='$id_barang'");
			$rst = mysqli_fetch_array($cekstok);

			$stok_barang = $rst['stok_barang'];
			$stokakhir = $stok_barang;

			mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");

			mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM ordersdetail WHERE id_dtrbmasuk = '$id_dtrbmasuk'");
		}

		mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM orders WHERE id_trbmasuk = '$_GET[id]'");

		echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=" . $module . "'</script>";
	}
}
