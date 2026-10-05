<?php
include "../../../configurasi/koneksi.php";

$key = $_POST['query'];

$ubah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang WHERE nm_barang LIKE '%$key%'");


$json = [];
while($re=mysqli_fetch_array($ubah)){
    $json[] = $re['nm_barang'];
}
echo json_encode($json);
?>