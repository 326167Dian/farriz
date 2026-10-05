<?php
include_once '../../../configurasi/koneksi.php';

if ($_GET['action'] == "table_data") {

    $columns = array(
        0 => 'id_barang',
        1 => 'kd_barang',
        2 => 'nm_barang',
        3 => 'stok_barang',
        4 => 'sat_barang',
        5 => 'jenisobat',
        6 => 'hrgsat_barang',
        7 => 'hrgjual_barang',
        8 => 'indikasi',
        9 => 'id_barang'
    );

    $querycount = $db->query("SELECT count(id_barang) as jumlah FROM barang");
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
                                    sat_barang,
                                    jenisobat,
                                    hrgsat_barang,
                                    hrgjual_barang,
                                    indikasi
            FROM barang ORDER BY $order $dir LIMIT $limit OFFSET $start");
    } else {
        $search = $_POST['search']['value'];
        $query = $db->query("SELECT id_barang,
                                    kd_barang,
                                    nm_barang,
                                    stok_barang,
                                    sat_barang,
                                    jenisobat,
                                    hrgsat_barang,
                                    hrgjual_barang,
                                    indikasi 
            FROM barang WHERE kd_barang LIKE '%$search%' 
                        OR nm_barang LIKE '%$search%'
                        OR stok_barang LIKE '%$search%'
                        OR sat_barang LIKE '%$search%'
                        OR jenisobat LIKE '%$search%'
                        OR hrgsat_barang LIKE '%$search%'
                        OR hrgjual_barang LIKE '%$search%'
                        OR indikasi LIKE '%$search%' 
            ORDER BY $order $dir LIMIT $limit OFFSET $start");

        $querycount = $db->query("SELECT count(id_barang) as jumlah 
            FROM barang WHERE kd_barang LIKE '%$search%' 
                        OR nm_barang LIKE '%$search%'
                        OR stok_barang LIKE '%$search%'
                        OR sat_barang LIKE '%$search%'
                        OR jenisobat LIKE '%$search%'
                        OR hrgsat_barang LIKE '%$search%'
                        OR hrgjual_barang LIKE '%$search%'
                        OR indikasi LIKE '%$search%'");

        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    $data = array();
    if (!empty($query)) {
        $no = $start + 1;
        while ($value = $query->fetch_array()) {
            $nestedData['no'] = $no;
            $nestedData['kd_barang'] = $value['kd_barang'];
            $nestedData['nm_barang'] = $value['nm_barang'];
            $nestedData['stok_barang'] = $value['stok_barang'];
            $nestedData['sat_barang'] = $value['sat_barang'];
            $nestedData['jenisobat'] = $value['jenisobat'];
            $nestedData['hrgsat_barang'] = $value['hrgsat_barang'];
            $nestedData['hrgjual_barang'] = $value['hrgjual_barang'];
            $nestedData['indikasi'] = $value['indikasi'];
            $nestedData['aksi'] = $value['id_barang'];;
            $data[] = $nestedData;
            $no++;
        }
    }

    $json_data = [
        "draw"            => intval($_POST['draw']),
        "recordsTotal"    => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data"            => $data
    ];

    echo json_encode($json_data);
}
