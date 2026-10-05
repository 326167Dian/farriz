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
if ($module=='setheader' AND $act=='update_setheader'){
 
     mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE setheader SET satu = '$_POST[satu]',
										dua = '$_POST[dua]',
										tiga = '$_POST[tiga]',
										empat = '$_POST[empat]',
										lima = '$_POST[lima]',
										enam = '$_POST[enam]',
										tujuh = '$_POST[tujuh]',
										delapan = '$_POST[delapan]',
										sembilan = '$_POST[sembilan]',
										sepuluh = '$_POST[sepuluh]',
										sebelas = '$_POST[sebelas]'
									WHERE id_setheader = '$_POST[id]'");
									
	echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
	//header('location:../../media_admin.php?module='.$module);
	
}

}
?>
