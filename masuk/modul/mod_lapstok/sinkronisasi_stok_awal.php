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

$tampil_barang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY barang.id_barang ");
$no=1;

while ($r=mysqli_fetch_array($tampil_barang)) {

        $r1 = $r[kd_barang];
        $stokbarang = $r[stok_barang];
        //tarik waktu awal input dan total quantity input
        $tampilmasuk = mysqli_query($GLOBALS["___mysqli_ston"], "select sum(qty_dtrbmasuk) as subtotal,min(waktu) as masukawal from trbmasuk_detail
                                                where kd_barang=$r1 ");
        $masuk = mysqli_fetch_array($tampilmasuk);
        $masuk1 = $masuk[subtotal];
        $masuk2 = $masuk[masukawal];
        //tarik waktu awal keluar barang
        $tampilkeluar = mysqli_query($GLOBALS["___mysqli_ston"],
            "select min(waktu) as keluarawal, max(waktu) as keluarakhir from trkasir_detail where kd_barang=$r1");
        $keluar = mysqli_fetch_array($tampilkeluar);
        $keluar1 = $keluar[keluarawal];
        $keluar2 = $keluar[keluarakhir];

        //tetapkan waktu standar keluar awal dan input awal
        if ($keluar1 < $masuk2) {
            $patokan = $masuk2;
        } else {
            $patokan = $keluar1;
        }
        $transaksi_atas = mysqli_query($GLOBALS["___mysqli_ston"],
            "select sum(qty_dtrkasir) as qty_atas from trkasir_detail 
                                                where kd_barang=$r1 and waktu between '$keluar1' and '$masuk2'");
        $qty_atas2 = mysqli_fetch_array($transaksi_atas);
        $qty_atas3 = $qty_atas2[qty_atas];

        $transaksi_bawah = mysqli_query($GLOBALS["___mysqli_ston"],
            "select sum(qty_dtrkasir) as qty_bawah from trkasir_detail 
                                                where kd_barang=$r1 and waktu between '$masuk2' and '$keluar2'");
        $qty_bawah2 = mysqli_fetch_array($transaksi_bawah);
        $qty_bawah3 = $qty_bawah2[qty_bawah];
        $stokmasukreal = $qty_atas3 + $masuk1 ;
        $stok_real = $qty_atas3 + $masuk1 - ($qty_atas3+$qty_bawah3);

        //tarik stok awal input barang
        $awalinput = mysqli_query($GLOBALS["___mysqli_ston"],"select qty_dtrbmasuk from trbmasuk_detail where waktu='$masuk2'");
        $inputawal = mysqli_fetch_array($awalinput);
        $stokawalinput = $inputawal[qty_dtrbmasuk];
        $stokbaru = $stokawalinput + $qty_atas3 ;

        if($qty_atas3 > 0 ) {
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stok_real' where kd_barang ='$r1' ");
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trbmasuk_detail SET qty_dtrbmasuk = '$stokbaru' where waktu ='$masuk2' ");
        }
        else{}


}
        header('location:../../media_admin.php?module=koreksistok');
    
}
?>
