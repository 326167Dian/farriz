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


if ($module=='profil' AND $act=='update_profil'){
  if (empty($_POST['password'])) {
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE admin SET nama_lengkap   = '$_POST[nama_lengkap]',
                                  no_telp        = '$_POST[no_telp]'                
                           WHERE  id_admin     = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST['password']);
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE admin SET password        = '$pass',
                                  nama_lengkap    = '$_POST[nama_lengkap]',
                                  no_telp         = '$_POST[no_telp]'
                           WHERE id_admin      = '$_POST[id]'");
  }
  header('location:../../media_admin.php?module='.$module);
}


}
?>
