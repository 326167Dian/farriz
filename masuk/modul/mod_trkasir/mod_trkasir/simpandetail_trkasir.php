<?php 
include "../../../configurasi/koneksi.php";

$kd_trkasir = $_POST['kd_trkasir'];
$id_dtrkasir = $_POST['id_dtrkasir'];
$id_barang = $_POST['id_barang'];
$kd_barang = $_POST['kd_barang'];
$nmbrg_dtrkasir = $_POST['nmbrg_dtrkasir'];
$qty_dtrkasir = $_POST['qty_dtrkasir'];
$sat_dtrkasir = $_POST['sat_dtrkasir'];
$hrgjual_dtrkasir = $_POST['hrgjual_dtrkasir'];
$indikasi = $_POST['indikasi'];


if($qty_dtrkasir == ""){
$qty_dtrkasir = "1";
}else{

}

if($id_dtrkasir == "" || $id_dtrkasir == null){

//cek apakah barang sudah ada
$cekdetail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, kd_barang, kd_trkasir, id_dtrkasir, qty_dtrkasir 
FROM trkasir_detail 
WHERE kd_barang='$kd_barang' AND kd_trkasir='$kd_trkasir'");

$ketemucekdetail=mysqli_num_rows($cekdetail);
$rcek=mysqli_fetch_array($cekdetail);
if ($ketemucekdetail > 0){

$id_dtrkasir = $rcek['id_dtrkasir'];
$qtylama = $rcek['qty_dtrkasir'];
$ttlqty = $qtylama + $qty_dtrkasir;
$ttlharga = $ttlqty * $hrgjual_dtrkasir;

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trkasir_detail SET qty_dtrkasir = '$ttlqty',
										hrgjual_dtrkasir = '$hrgjual_dtrkasir',
										hrgttl_dtrkasir = '$ttlharga'
										WHERE id_dtrkasir = '$id_dtrkasir' and kd_barang='$kd_barang'");
										
//update stok
//cek tambah stok
    $tambahstok = mysqli_query($GLOBALS["___mysqli_ston"],"select id_dtrkasir, kd_trkasir, qty_dtrkasir 
    from trkasir_detail where kd_trkasir='$kd_trkasir' and kd_barang='$kd_barang'");
    $ketemutambahstok = mysqli_fetch_array($tambahstok);
    $angka = $ketemutambahstok[$qty_dtrkasir];
    if($angka==$ttlqty) {

        $cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang 
        WHERE id_barang='$id_barang'");
        $rst = mysqli_fetch_array($cekstok);

        $stok_barang = $rst['stok_barang'];
        $stokakhir = (($stok_barang + $qtylama) - $ttlqty);

        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");
                     }
    else{}

					
}else{

$ttlharga = $qty_dtrkasir * $hrgjual_dtrkasir;


mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO trkasir_detail(kd_trkasir,
										id_barang,
										kd_barang,
										nmbrg_dtrkasir,
										qty_dtrkasir,
										sat_dtrkasir,
										hrgjual_dtrkasir,
										hrgttl_dtrkasir)
								  VALUES('$kd_trkasir',
										'$id_barang',
										'$kd_barang',
										'$nmbrg_dtrkasir',
										'$qty_dtrkasir',
										'$sat_dtrkasir',
										'$hrgjual_dtrkasir',
										'$ttlharga')");

//cek transaksi sukses
$cekmasuk = mysqli_query($GLOBALS["___mysqli_ston"],"select id_dtrkasir, kd_trkasir from trkasir_detail 
where kd_trkasir='$kd_trkasir'");
$ketemucekmasuk = mysqli_fetch_array($cekmasuk);
if($ketemucekmasuk > 0 ) {
//update stok
    $cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang 
    WHERE id_barang='$id_barang'");
    $rst = mysqli_fetch_array($cekstok);

    $stok_barang = $rst['stok_barang'];
    $stokakhir = $stok_barang - $qty_dtrkasir;

    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");
}
else{}
}

}else{
//
$cekdetail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail 
WHERE id_dtrkasir='$id_dtrkasir'");
$rcek=mysqli_fetch_array($cekdetail);
$id_dtrkasir = $rcek['id_dtrkasir'];
$qtylama = $rcek['qty_dtrkasir'];
$qtybaru = $qtylama + $qty_dtrkasir;
$ttlharga = $qtybaru * $hrgjual_dtrkasir;

mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE trkasir_detail SET qty_dtrkasir = '$qtybaru',
										hrgjual_dtrkasir = '$hrgjual_dtrkasir',
										hrgttl_dtrkasir = '$ttlharga'
										WHERE id_dtrkasir = '$id_dtrkasir'");
										
//update stok
    //cek untuk update
    $cekmasuk2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail 
    WHERE id_dtrkasir='$id_dtrkasir'");
    $ceklagi = $cekmasuk2[$qty_dtrkasir];
    if($ceklagi == $qtybaru) {
        $cekstok = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_barang, stok_barang FROM barang 
        WHERE id_barang='$id_barang'");
        $rst = mysqli_fetch_array($cekstok);

        $stok_barang = $rst['stok_barang'];
        $stokakhir = (($stok_barang + $qtylama) - $qty_dtrkasir);

        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE barang SET stok_barang = '$stokakhir' WHERE id_barang = '$id_barang'");
    }
    else{}
}


?>
