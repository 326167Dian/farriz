<?php 
// Date_Default_timezone_set('Asia/jakarta');
// $server = "localhost"; 
// $user = "root"; 
// $password = ""; 
// $database = "farriz";
// set_time_limit(1800); 
// ($GLOBALS["___mysqli_ston"] = mysqli_connect($server, $user, $password)) or die ("Koneksi gagal"); 
// mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die ("Database tidak ditemukan"); 
// // $koneksi = new mysqli($server, $user, $password) or die ("Koneksi gagal");
// $db = mysqli_connect('localhost', 'root', '', 'farriz');


Date_Default_timezone_set('Asia/jakarta');
$server = "localhost";
$user = "u933031560_desweri";
$password = "7390091979Dian&&";
$database = "u933031560_farriz";
set_time_limit(1800);

include_once "conn.php";
($GLOBALS["___mysqli_ston"] = mysqli_connect($server, $user, $password)) or die("Koneksi gagal");
mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die("Database tidak ditemukan");
$db = mysqli_connect('localhost', 'u933031560_desweri', '7390091979Dian&&', 'u933031560_farriz');

?>

