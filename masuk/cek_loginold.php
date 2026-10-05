<?php
include "../configurasi/koneksi.php";
include "../configurasi/fungsi_logs.php";
function anti_injection($data)
{
  $filter = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
  return $filter;
}

$username = anti_injection($_POST['username']);
$pass     = anti_injection(md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) or !ctype_alnum($pass)) {
  echo "<link href=css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Injeksi Gagal</div>";
} else {
  $login = mysqli_query(
    $GLOBALS["___mysqli_ston"],
    "SELECT * FROM admin WHERE username='$username' AND password='$pass' AND blokir='N'"
  );
  $ketemu = mysqli_num_rows($login);
  $r = mysqli_fetch_array($login);

  // Apabila username dan password ditemukan
  if ($ketemu > 0) {
    session_start();
    echo $ketemu;
    include "timeout.php";

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
    
    // session timeout
    $_SESSION['login'] = 1;
    timer();

    $sid_lama = session_id();

    session_regenerate_id();

    $sid_baru = session_id();


    insertlogs($r['id_admin'], $r['nama_lengkap'], "Masuk Login");
    header('location:media_admin.php?module=home');
  } else {
    echo "<link href=css/style.css rel=stylesheet type=text/css>";
    echo "<div class='error msg'>Login Gagal, Username atau Password salah, atau account anda sedang di blokir. ";
    echo "<a href=index.php><b>ULANGI LAGI</b></a></center></div>";
  }
}
