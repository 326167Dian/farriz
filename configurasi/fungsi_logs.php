<?php
function insertlogs($id, $petugas, $action)
{
    $tglcurrent = date("Y-m-d H:i:S", time());
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO logs(id_admin, petugas, aksi, waktu)VALUES('$id','$petugas', '$action', '$tglcurrent')");
}
