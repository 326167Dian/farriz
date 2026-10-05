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

	$module = "trkasir";
	$stt_aksi = $_POST['stt_aksi'];
	if ($stt_aksi == "input_trkasir" || $stt_aksi == "ubah_trkasir") {
		$act = $stt_aksi;
	} else {
		$act = $_GET['act'];
	}

	// Input admin
	if ($module == 'trkasir' and $act == 'input_trkasir') {
        
        $cariitem = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir = '$_POST[kd_trkasir]'");
        $countItem = mysqli_num_rows($cariitem);

        if($countItem <= 0){
            $data['message'] = 'failed';
			echo json_encode($data);
        } else {
    		$insert = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir(
    										kd_trkasir,	
    										petugas,
    										shift,																		
    										tgl_trkasir,																			
    										nm_pelanggan,										
    										tlp_pelanggan,
    										alamat_pelanggan,
    										ttl_trkasir,
    										diskon2,
    										dp_bayar,
    										sisa_bayar,
    										ket_trkasir,
    										id_carabayar
    										)
    								 VALUES('$_POST[kd_trkasir]',
    								 		'$_POST[petugas]',
    								 		'$_POST[shift]',
    										'$_POST[tgl_trkasir]',										
    										'$_POST[nm_pelanggan]',
    										'$_POST[tlp_pelanggan]',
    										'$_POST[alamat_pelanggan]',
    										'$_POST[ttl_trkasir]',
    										'$_POST[diskon2]',
    										'$_POST[dp_bayar]',
    										'$_POST[sisa_bayar]',
    										'$_POST[ket_trkasir]',
    										'$_POST[id_carabayar]'
    										
    										)");

            mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO kartu_stok(kode_transaksi) VALUES('$_POST[kd_trkasir]')");
    		if ($insert) {
    			# code...
    			mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kdtk SET stt_kdtk = 'OFF' WHERE id_admin = '$_SESSION[idadmin]'AND kd_trkasir = '$_POST[kd_trkasir]'");
    
    //             $ambildatainduk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir WHERE id_trkasir='$_GET[id]'");
                $ambildatainduk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir WHERE kd_trkasir='$_POST[kd_trkasir]'");
    			$r1 = mysqli_fetch_array($ambildatainduk);
    			$kd_trkasir = $r1['kd_trkasir'];
    			
    			//loop data detail
    			$ambildatadetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir='$kd_trkasir'");
    			while ($r = mysqli_fetch_array($ambildatadetail)) {
                    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir_restore(
    						kd_trkasir, petugas, shift, tgl_trkasir, nm_pelanggan, tlp_pelanggan, alamat_pelanggan,
    						ttl_trkasir, dp_bayar, diskon1, diskon2, sisa_bayar, ket_trkasir, id_carabayar, id_barang,
    						kd_barang, nmbrg_dtrkasir, qty_dtrkasir, sat_dtrkasir, hrgjual_dtrkasir, hrgttl_dtrkasir)
    					VALUES(
    						'$r1[kd_trkasir]','$r1[petugas]','$r1[shift]','$r1[tgl_trkasir]','$r1[nm_pelanggan]','$r1[tlp_pelanggan]','$r1[alamat_pelanggan]','$r1[ttl_trkasir]','$r1[dp_bayar]','$r1[diskon1]','$r1[diskon2]','$r1[sisa_bayar]','$r1[ket_trkasir]','$r1[id_carabayar]','$r[id_barang]','$r[kd_barang]','$r[nmbrg_dtrkasir]','$r[qty_dtrkasir]','$r[sat_dtrkasir]','$r[hrgjual_dtrkasir]','$r[hrgttl_dtrkasir]')");
    
                }
                
    			$data['message'] = 'success';
    			echo json_encode($data);
    		} else {
    			$data['message'] = 'failed';
    			echo json_encode($data);
    		}

        }
		//echo "<script type='text/javascript'>alert('Transkasi berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
	}

	//updata trkasir
	elseif ($module == 'trkasir' and $act == 'ubah_trkasir') {

		$ubah = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trkasir SET tgl_trkasir = '$_POST[tgl_trkasir]',
									petugas = '$_POST[petugas]',
									nm_pelanggan = '$_POST[nm_pelanggan]',									
									tlp_pelanggan = '$_POST[tlp_pelanggan]',
									alamat_pelanggan = '$_POST[alamat_pelanggan]',
									ttl_trkasir = '$_POST[ttl_trkasir]',
									diskon2 = '$_POST[diskon2]',
									dp_bayar = '$_POST[dp_bayar]',
									sisa_bayar = '$_POST[sisa_bayar]',
									ket_trkasir = '$_POST[ket_trkasir]',
									id_carabayar = '$_POST[id_carabayar]'
									WHERE id_trkasir = '$_POST[id_trkasir]'");


        if($ubah){
            $data['message'] = 'success';
    		echo json_encode($data);
    	} else {
    		$data['message'] = 'failed';
    		echo json_encode($data);
    	}
		//echo "<script type='text/javascript'>alert('Transkasi berhasil Ubah !');window.location='../../media_admin.php?module=".$module."'</script>";


	}
	//Hapus Proyek
	elseif ($module == 'trkasir' and $act == 'hapus') {

		if ($_SESSION['level'] != 'pemilik') {
			echo "<script type='text/javascript'>window.location='../../media_admin.php?module=" . $module . "'</script>";
		} else {
			//update bagian stok dulu
			//ambil data induk
			$ambildatainduk = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir WHERE id_trkasir='$_GET[id]'");
			$r1 = mysqli_fetch_array($ambildatainduk);
			$kd_trkasir = $r1['kd_trkasir'];

			//loop data detail
			$ambildatadetail = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir='$kd_trkasir'");
			while ($r = mysqli_fetch_array($ambildatadetail)) {

				$id_dtrkasir = $r['id_dtrkasir'];
				$id_barang = $r['id_barang'];
				$qty_dtrkasir = $r['qty_dtrkasir'];

				mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir_restore(
						kd_trkasir, petugas, shift, tgl_trkasir, nm_pelanggan, tlp_pelanggan, alamat_pelanggan,
						ttl_trkasir, dp_bayar, diskon1, diskon2, sisa_bayar, ket_trkasir, id_carabayar, id_barang,
						kd_barang, nmbrg_dtrkasir, qty_dtrkasir, sat_dtrkasir, hrgjual_dtrkasir, hrgttl_dtrkasir)
					VALUES(
						'$r1[kd_trkasir]','$r1[petugas]','$r1[shift]','$r1[tgl_trkasir]','$r1[nm_pelanggan]','$r1[tlp_pelanggan]','$r1[alamat_pelanggan]','$r1[ttl_trkasir]','$r1[dp_bayar]','$r1[diskon1]','$r1[diskon2]','$r1[sisa_bayar]','$r1[ket_trkasir]','$r1[id_carabayar]','$r[id_barang]','$r[kd_barang]','$r[nmbrg_dtrkasir]','$r[qty_dtrkasir]','$r[sat_dtrkasir]','$r[hrgjual_dtrkasir]','$r[hrgttl_dtrkasir]')");

				//update stok
				$cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang 
			WHERE id_barang='$id_barang'");
				$rst = mysqli_fetch_array($cekstok);

				$stok_barang = $rst['stok_barang'];
				$stokakhir = $stok_barang + $qty_dtrkasir;

				mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");


				mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trkasir_detail WHERE id_dtrkasir = '$id_dtrkasir'");
				
				mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM komisi_pegawai WHERE id_dtrkasir = '$id_dtrkasir'");
			}


			mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM trkasir WHERE id_trkasir = '$_GET[id]'");
            mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM kartu_stok WHERE kode_transaksi = '$kd_trkasir'");

			echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=" . $module . "'</script>";
		}
	}
}
