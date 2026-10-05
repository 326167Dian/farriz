<?php
include "../../../configurasi/koneksi.php";

$key = $_POST['id_barang'];

$ubah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang WHERE id_barang = '$key'");


$json = [];
while($re=mysqli_fetch_array($ubah)){
    $json[] = array(
            'id_barang'=> $re['id_barang'],
			'nm_barang'=> $re['nm_barang'],
			'stok_barang'=> $re['stok_barang'],
			'sat_barang'=> $re['sat_barang'],
			'indikasi'=> $re['indikasi'],
			'hrgjual_barang'=> $re['hrgjual_barang'],
			'kd_barang'=> $re['kd_barang']
	);
}
echo json_encode($json);
?>