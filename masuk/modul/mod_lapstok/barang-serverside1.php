<?php
include "../../../configurasi/fungsi_rupiah.php";
include "../../../configurasi/koneksi.php";
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use

$table = 'barang';

$primaryKey = 'id_barang';

$no = 1;
$columns = array(
    array('db' => 'id_barang', 'dt' => 0),
    array('db' => 'kd_barang', 'dt' => 1),
    array('db' => 'nm_barang', 'dt' => 2),
    array('db' => 'stok_barang', 'dt' => 3),
    array(
        'db' => 'id_barang', 'dt' => 4,
        'formatter' => function ($d, $row) {
            $tgl_awal = date('Y-m-d');
            $tgl_akhir = date('Y-m-d', strtotime('-30 days', strtotime($tgl_awal)));
            $start = $_GET['start'];
            $finish = $_GET['finish'];


            $pass = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir JOIN trkasir_detail ON(trkasir.kd_trkasir = trkasir_detail.kd_trkasir) WHERE kd_barang = '$row[kd_barang]' AND(tgl_trkasir BETWEEN '$start' AND '$finish')");
            $pass1 = mysqli_num_rows($pass);
            return $pass1;
        }
    ),
    array(
        'db' => 'id_barang', 'dt' => 5,
        'formatter' => function ($d, $row) {
            $tgl_awal = date('Y-m-d');
            $tgl_akhir30 = date('Y-m-d', strtotime('-30 days', strtotime($tgl_awal)));
            $tgl_akhir60 = date('Y-m-d', strtotime('-60 days', strtotime($tgl_awal)));
            $start = $_GET['start'];
            $finish = $_GET['finish'];
            $tgl60 = date('Y-m-d', strtotime('-30 days', strtotime($start)));


            $pass30 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir JOIN trkasir_detail
            ON (trkasir.kd_trkasir=trkasir_detail.kd_trkasir) WHERE kd_barang = '$row[kd_barang]' AND (tgl_trkasir BETWEEN '$start' and '$finish')");
            $pass1 = mysqli_num_rows($pass30);

            $pass60 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir JOIN trkasir_detail ON(trkasir.kd_trkasir = trkasir_detail.kd_trkasir) WHERE kd_barang = '$row[kd_barang]' AND(tgl_trkasir BETWEEN '$tgl60' AND '$finish')");
            $pass4 = mysqli_num_rows($pass60);

            $pass5 = $pass4 - $pass1;
            return $pass5;
        }
    ),
    array(
        'db' => 'id_barang', 'dt' => 6,
        'formatter' => function ($d, $row) {
            $tgl_awal = date('Y-m-d');
            $tgl_akhir30 = date('Y-m-d', strtotime('-30 days', strtotime($tgl_awal)));
            $tgl_akhir60 = date('Y-m-d', strtotime('-60 days', strtotime($tgl_awal)));
            $start = $_GET['start'];
            $finish = $_GET['finish'];
            $tgl60 = date('Y-m-d', strtotime('-30 days', strtotime($start)));

            $pass30 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir JOIN trkasir_detail
            ON (trkasir.kd_trkasir=trkasir_detail.kd_trkasir) WHERE kd_barang = '$row[kd_barang]' AND (tgl_trkasir BETWEEN '$start' and '$finish')");
            $pass1 = mysqli_num_rows($pass30);

            $pass60 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir JOIN trkasir_detail ON(trkasir.kd_trkasir = trkasir_detail.kd_trkasir) WHERE kd_barang = '$row[kd_barang]' AND(tgl_trkasir BETWEEN '$tgl60' AND '$finish')");
            $pass4 = mysqli_num_rows($pass60);

            $pass5 = intval($pass4 - $pass1);

            $pass6 = ($pass5 == 0) ? 0 : intval(round(($pass1 / $pass5 * 100) - 100));
            return $pass6;
        }
    ),
    array(
        'db' => 'id_barang', 'dt' => 7,
        'formatter' => function ($d, $row) {
            $tgl_awal = date('Y-m-d');
            $tgl_akhir30 = date('Y-m-d', strtotime('-30 days', strtotime($tgl_awal)));
            $start = $_GET['start'];
            $finish = $_GET['finish'];
            $tgl60 = date('Y-m-d', strtotime('-30 days', strtotime($start)));

            $tot = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT
                                            trkasir_detail.kd_barang,
                                            trkasir_detail.id_dtrkasir,
                                            trkasir_detail.kd_trkasir,
                                            SUM(trkasir_detail.qty_dtrkasir) as pw,
                                            trkasir.kd_trkasir,
                                            trkasir.tgl_trkasir                            
                                            FROM trkasir_detail 
                                            JOIN trkasir ON (trkasir_detail.kd_trkasir=trkasir.kd_trkasir)
                                            WHERE kd_barang = '$row[kd_barang]' AND (tgl_trkasir BETWEEN '$start' and '$finish')");
            $t2 = mysqli_fetch_array($tot);
            $tnum = ($t2['pw'] <= 0) ? 0 : $t2['pw'];
            return  $tnum;
        }
    ),
    array('db' => 'sat_barang', 'dt' => 8),
    array(
        'db' => 'hrgsat_barang', 'dt' => 9
    ),
    array(
        'db' => 'hrgsat_barang', 'dt' => 10,
        'formatter' => function ($d, $row) {
            $nilaibarang = $d * $row['stok_barang'];
            return $nilaibarang;
        }
    ),
    array('db' => 'id_barang', 'dt' => 11),
    array(
        'db' => 'id_barang', 'dt' => 12,
        'formatter' => function ($d, $row) {

            return $row[10];
        }
    ),
);

include_once '../../../configurasi/conn.php';

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('../../../configurasi/ssp.class.php');

echo json_encode(
    // SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
    SSP::custom($_GET, $sql_details, $table, $primaryKey, $columns)
);
