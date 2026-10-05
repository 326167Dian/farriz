<?php
include "../../../configurasi/koneksi.php";

	$kod = $_POST['kd_brg'];

	$ubah=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang WHERE kd_barang = '$kod'");
	$re=mysqli_fetch_array($ubah);
      //$json[] = $re['nm_barang'];
	  $json[] = array('id_barang'=> $re['id_barang'],
					'nm_barang'=> $re['nm_barang'],
					'stok_barang'=> $re['stok_barang'],
					'sat_barang'=> $re['sat_barang'],
					'hna'=> $re['hna'],
					'diskon'=> $re['diskon']
	  );
 
	echo json_encode($json);

?>
