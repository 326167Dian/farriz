<?php
session_start();
include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_logs.php";

$id = $_POST['id'];

$login = mysqli_query(
    $GLOBALS["___mysqli_ston"],
    "SELECT * FROM admin WHERE username='$_SESSION[username]' AND password='$_SESSION[passuser]' AND blokir='N'"
  );
$r = mysqli_fetch_array($login);
$ketemu = mysqli_num_rows($login);

if ($ketemu > 0) {
    // session_start();
    session_reset();
    
    $_SESSION['idadmin']    = $r['id_admin'];
    $_SESSION['username']    = $r['username'];
    $_SESSION['namauser']    = $r['username'];
    $_SESSION['namalengkap'] = $r['nama_lengkap'];
    $_SESSION['passuser']    = $r['password'];
    $_SESSION['leveluser']   = "admin";
    $_SESSION['mpengguna']   = $r['mpengguna'];
    $_SESSION['mheader']   = $r['mheader'];
    $_SESSION['mjenisbayar']     = $r['mjenisbayar'];
    $_SESSION['mpelanggan']     = $r['mpelanggan'];
    $_SESSION['msupplier']     = $r['msupplier'];
    $_SESSION['msatuan']   = $r['msatuan'];
    $_SESSION['mjenisobat']   = $r['mjenisobat'];
    $_SESSION['mbarang']      = $r['mbarang'];
    $_SESSION['tbm']    = $r['tbm'];
    $_SESSION['tbmpbf']    = $r['tbmpbf'];
    $_SESSION['tpk']    = $r['tpk'];
    $_SESSION['lpitem'] = $r['lpitem'];
    $_SESSION['lpbrgmasuk'] = $r['lpbrgmasuk'];
    $_SESSION['lpkasir'] = $r['lpkasir'];
    $_SESSION['lpsupplier'] = $r['lpsupplier'];
    $_SESSION['lppelanggan'] = $r['lppelanggan'];
    $_SESSION['mstok'] = $r['mstok'];
    $_SESSION['stok_kritis'] = $r['stok_kritis'];
    $_SESSION['orders'] = $r['orders'];
    $_SESSION['penjualansebelum'] = $r['penjualansebelum'];
    $_SESSION['labapenjualan'] = $r['labapenjualan'];
    $_SESSION['byrkredit'] = $r['byrkredit'];
    $_SESSION['stokopname'] = $r['stokopname'];
    $_SESSION['soharian'] = $r['soharian'];
    $_SESSION['labajenisobat'] = $r['labajenisobat'];
    $_SESSION['koreksistok'] = $r['koreksistok'];
    $_SESSION['shiftkerja'] = $r['shiftkerja'];
    $_SESSION['neraca'] = $r['neraca'];
    $_SESSION['level'] = $r['akses_level'];
    $_SESSION['komisi'] = $r['komisi'];
    $_SESSION['kartustok'] = $r['kartustok'];
    $_SESSION['catatan'] = $r['catatan'];
    $_SESSION['cekdarah'] = $r['cekdarah'];
}
?>