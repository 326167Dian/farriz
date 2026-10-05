<?php
include "../../../configurasi/koneksi.php";

	$sql = "SELECT * FROM pelanggan
	   WHERE nm_pelanggan LIKE '%".$_GET['query']."%'
	   OR tlp_pelanggan LIKE '%".$_GET['query']."%'
	   LIMIT 10"; 
	 $result    = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
	  
	 $json = [];
	// $json2 = [];
	 while($row = mysqli_fetch_assoc($result)){
		  $json[] = $row['nm_pelanggan']."/".$row['tlp_pelanggan'];
		  //$json2[] = array('nm_pelanggan'=> $row['nm_pelanggan'],
				//	'tlp_pelanggan'=> $row['tlp_pelanggan'],
				//	'alamat_pelanggan'=> $row['alamat_pelanggan']);
	 }

	 echo json_encode($json);

?>
