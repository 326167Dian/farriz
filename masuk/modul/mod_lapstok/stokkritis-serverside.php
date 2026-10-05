<?php
include_once '../../../configurasi/koneksi.php';

if ($_GET['action'] == "table_data") {

    $columns = array(
        0 => 'id_barang',
        1 => 'kategori',
        2 => 'nm_barang',
        3 => 'stok_barang',
        4 => 't30',
        5 => 'sfcmin',
        6 => 'sfcmax',
        7 => 'satuan',

    );

    $querycount = $db->query("SELECT count(id_barang) as jumlah FROM barang left join trbmasuk_detail on(barang.id_barang=trbmasuk_detail.id_barang) 
                                  where trbmasuk_detail.kd_trbmasuk is not null group by barang.id_barang order by barang.nm_barang asc");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];

    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    if (empty($_POST['search']['value'])) {
        $query = $db->query("SELECT id_barang,
                                    kd_barang,
                                    nm_barang,
                                    stok_barang,                                    
                                    sat_barang
                                    
                                    
            FROM barang 
            left join trbmasuk_detail on(barang.id_barang=trbmasuk_detail.id_barang) 
                                  where trbmasuk_detail.kd_trbmasuk is not null group by barang.id_barang
            ORDER BY $order $dir LIMIT $limit OFFSET $start");
    } else {
        $search = $_POST['search']['value'];
        $query = $db->query("SELECT id_barang,
                                    kd_barang,
                                    nm_barang,
                                    stok_barang,                                    
                                    sat_barang                                    
            FROM barang left join trbmasuk_detail on(barang.id_barang=trbmasuk_detail.id_barang) 
                                  where trbmasuk_detail.kd_trbmasuk is not null group by barang.id_barang
                        AND nm_barang LIKE '%$search%'
                        
            ORDER BY $order $dir LIMIT $limit OFFSET $start");

        $querycount = $db->query("SELECT count(id_barang) as jumlah 
            FROM barang WHERE stok_barang <= stok_buffer
                        AND nm_barang LIKE '%$search%'
                        OR hrgsat_barang LIKE '%$search%'");

        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($value = $query->fetch_array()) {

            $pass = $db->query("SELECT count(id_dtrkasir) AS jumlah,
                    SUM(trkasir_detail.qty_dtrkasir) as pw
                FROM trkasir_detail JOIN trkasir
                ON trkasir.kd_trkasir = trkasir_detail.kd_trkasir 
                WHERE trkasir_detail.id_barang = '$value[id_barang]'
                AND trkasir.tgl_trkasir BETWEEN '$_GET[start]' AND '$_GET[finish]'");
            $pass1 = $pass->fetch_array();

            $hargabeli = $value['hrgsat_barang'];

            // for column
            $nestedData['no'] = $no;
            $nestedData['kategori'] = 'MACET';
            $nestedData['nm_barang'] = $value['nm_barang'];
            $nestedData['stok_barang'] = $value['stok_barang'];
            $nestedData['stok_buffer'] = $value['stok_buffer'];
            $nestedData['t30'] = $pass1['jumlah'];
            $nestedData['q30'] = (($pass1['pw'] <= 0) ? 0 : $pass1['pw']);
            $nestedData['satuan'] = $value['sat_barang'];
            $nestedData['harga_beli'] = $hargabeli;
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = [
        "draw"              => intval($_POST['draw']),
        "recordsTotal"      => intval($totalData),
        "recordsFiltered"   => intval($totalFiltered),
        "data"              => $data
    ];

    echo json_encode($json_data);
}
