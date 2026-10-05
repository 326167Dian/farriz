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
  if ($module == 'carabayar' and $act == 'input_carabayar') {

    $cekganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nm_carabayar FROM carabayar WHERE nm_carabayar='$_POST[nm_carabayar]'");
    $ada = mysqli_num_rows($cekganda);
    if ($ada > 0) {
      echo "<script type='text/javascript'>alert('Jenis sudah ada!');history.go(-1);</script>";
    } else {

      mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO carabayar(nm_carabayar)
								 VALUES('$_POST[nm_carabayar]')");


      //echo "<script type='text/javascript'>alert('Data berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
      header('location:../../media_admin.php?module=' . $module);
    }
  }
  //updata carabayar
  elseif ($module == 'carabayar' and $act == 'update_carabayar') {

    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE carabayar SET nm_carabayar = '$_POST[nm_carabayar]'
									WHERE id_carabayar = '$_POST[id]'");

    //echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
    header('location:../../media_admin.php?module=' . $module);
  }
  //Hapus Proyek
  elseif ($module == 'carabayar' and $act == 'hapus') {

    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM carabayar WHERE id_carabayar = '$_GET[id]'");
    //echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
    header('location:../../media_admin.php?module=' . $module);
  }
}
