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
    if ($module=='catatan' AND $act=='input_catatan'){

        $cekganda=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nm_catatan FROM catatan WHERE nm_catatan='$_POST[nm_catatan]'");
        $ada=mysqli_num_rows($cekganda);
        if ($ada > 0){
            echo "<script type='text/javascript'>alert('catatan sudah ada!');history.go(-1);</script>";
        }else{

            mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO catatan (
                                        tgl,
                                        shift,
                                        petugas,
                                        deskripsi)
								 VALUES(
								        '$_POST[tgl]',
								        '$_POST[shift]',
								        '$_POST[petugas]',
								        '$_POST[deskripsi]'
								        )");


            //echo "<script type='text/javascript'>alert('Data berhasil ditambahkan !');window.location='../../media_admin.php?module=".$module."'</script>";
            header('location:../../media_admin.php?module='.$module);

        }
    }
    //updata catatan
    elseif ($module=='catatan' AND $act=='update_catatan'){

        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE catatan SET   
                                deskripsi = '$_POST[deskripsi]'
									WHERE id_catatan = '$_POST[id]'");

        //echo "<script type='text/javascript'>alert('Data berhasil diubah !');window.location='../../media_admin.php?module=".$module."'</script>";
        header('location:../../media_admin.php?module='.$module);

    }
//Hapus Proyek
    elseif ($module=='catatan' AND $act=='hapus'){
        $petugas = $_SESSION['namalengkap'];
        $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM catatan WHERE id_catatan='$_GET[id]'");
        $r=mysqli_fetch_array($edit);

        if ( $petugas !== $r['petugas'] && $_SESSION['level']!=='pemilik')
        { echo "<script type='text/javascript'>alert('catatan harus dihapus orang yang sama atau pemilik apotek!');history.go(-1);</script>";}
        else{
            mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM catatan WHERE id_catatan = '$_GET[id]'");
            //echo "<script type='text/javascript'>alert('Data berhasil dihapus !');window.location='../../media_admin.php?module=".$module."'</script>";
            header('location:../../media_admin.php?module='.$module);

        }
    }

}
?>
