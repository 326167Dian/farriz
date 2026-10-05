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

  // tambah jenis obat
  if ($module == 'jenisobat' and $act == 'input_jenisobat') {

    $cekganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT jenisobat FROM jenis_obat WHERE jenisobat ='$_POST[jenisobat]'");
    $ada = mysqli_num_rows($cekganda);

    if ($ada > 0) {
      echo "<script type='text/javascript'>alert('Jenis Obat Sudah Ada!');history.go(-1);</script>";
    } else {

      mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO jenis_obat(jenisobat,ket)
								 VALUES('$_POST[jenisobat]','$_POST[ket]')");


      //echo "<script type='text/javascript'>alert('Data berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
      header('location:../../media_admin.php?module=' . $module);
    }
  }
  //edit jenis obat
  elseif ($module == 'jenisobat' and $act == 'edit') {

    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE jenis_obat SET jenisobat = '$_POST[jenisobat]', ket = '$_POST[ket]'
									WHERE idjenis = '$_POST[idjenis]'");

    //echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
    header('location:../../media_admin.php?module=' . $module);
  }
  //Hapus jenis obat
  elseif ($module == 'jenisobat' and $act == 'hapus') {

    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM jenis_obat WHERE idjenis = '$_GET[id]'");
    //echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
    header('location:../../media_admin.php?module=' . $module);
  }
}
