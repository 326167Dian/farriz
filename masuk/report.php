<?php
include "../configurasi/koneksi.php";

if ($_SESSION['leveluser']=='admin'){
  $sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from modul where aktif='Y' and type = 'Report' order by urutan");
  while ($m=mysqli_fetch_array($sql)){
    echo "<li class='garisbawah'><a href='$m[link]'><i class='fa fa-circle-o'></i>$m[nama_modul]</a></li>";
  }
}
elseif ($_SESSION['leveluser']=='pengajar'){
  $sql=mysqli_query($GLOBALS["___mysqli_ston"], "select * from modul where status='pengajar' and aktif='Y' and type = 'Report' order by urutan");
  while ($m=mysqli_fetch_array($sql)){
    echo "<li class='garisbawah'><a href='$m[link]'><i class='fa fa-circle-o'></i>$m[nama_modul]</a></li>";
  }
}
?>
