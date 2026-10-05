<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_thumb.php";
include "../../../configurasi/library.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Input admin
if ($module=='pelanggan' AND $act=='input_pelanggan'){

$cekganda=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pelanggan WHERE nm_pelanggan='$_POST[nm_pelanggan]'AND tlp_pelanggan='$_POST[tlp_pelanggan]'");
$ada=mysqli_num_rows($cekganda);
if ($ada > 0){
echo "<script type='text/javascript'>alert('Nama Pelanggan dengan nomor telepon ini sudah ada!');history.go(-1);</script>";
}else{

    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pelanggan(nm_pelanggan, tlp_pelanggan, alamat_pelanggan, ket_pelanggan)
								 VALUES('$_POST[nm_pelanggan]','$_POST[tlp_pelanggan]','$_POST[alamat_pelanggan]','$_POST[ket_pelanggan]')");
										
										
	//echo "<script type='text/javascript'>alert('Data berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
	header('location:../../media_admin.php?module='.$module);

}
}
 //updata pelanggan
 elseif ($module=='pelanggan' AND $act=='update_pelanggan'){
 
     mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE pelanggan SET nm_pelanggan = '$_POST[nm_pelanggan]',
									tlp_pelanggan = '$_POST[tlp_pelanggan]',
									alamat_pelanggan = '$_POST[alamat_pelanggan]',
									ket_pelanggan = '$_POST[ket_pelanggan]'
									WHERE id_pelanggan = '$_POST[id]'");
									
	//echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
	header('location:../../media_admin.php?module='.$module);
	
}
//Hapus Proyek
elseif ($module=='pelanggan' AND $act=='hapus'){

  mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM pelanggan WHERE id_pelanggan = '$_GET[id]'");
  //echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
  header('location:../../media_admin.php?module='.$module);
}

}
?>
