<?php
include_once '../../../configurasi/koneksi.php';

if ($_GET['action'] == "table_data") {

    $columns = array(
        0 => 'id_trbmasuk',
        1 => 'kd_trbmasuk',
        2 => 'petugas',
        3 => 'tgl_trbmasuk',
        4 => 'nm_supplier',
        5 => 'ket_trbmasuk',
        6 => 'sisa_bayar',
        7 => 'jatuh_tempo',
        8 => 'carabayar',
        9 => 'id_trbmasuk'
    );

    $querycount = $db->query("SELECT count(id_trbmasuk) as jumlah FROM trbmasuk WHERE id_resto = 'pusat' AND jenis = 'pbf'");
    $datacount = $querycount->fetch_array();

    $totalData = $datacount['jumlah'];

    $totalFiltered = $totalData;

    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order']['0']['column']];
    $dir = $_POST['order']['0']['dir'];

    if (empty($_POST['search']['value'])) {
        $query = $db->query("SELECT *
            FROM trbmasuk
            WHERE trbmasuk.id_resto = 'pusat' AND trbmasuk.jenis = 'pbf'
            ORDER BY $order DESC LIMIT $limit OFFSET $start");
    } else {
        $search = $_POST['search']['value'];
        $query = $db->query("SELECT * 
            FROM trbmasuk
            WHERE trbmasuk.id_resto = 'pusat' AND trbmasuk.jenis = 'pbf'
                        AND kd_trbmasuk LIKE '%$search%'
                        OR petugas LIKE '%$search%'
                        OR tgl_trbmasuk LIKE '%$search%'
                        OR nm_supplier LIKE '%$search%'
                        OR ket_trbmasuk LIKE '%$search%'
                        OR sisa_bayar LIKE '%$search%'
                        OR carabayar LIKE '%$search%'
            ORDER BY $order DESC LIMIT $limit OFFSET $start");

        $querycount = $db->query("SELECT count(id_trbmasuk) as jumlah 
            FROM trbmasuk
            WHERE trbmasuk.id_resto = 'pusat' AND trbmasuk.jenis = 'pbf'
                        AND kd_trbmasuk LIKE '%$search%'
                        OR petugas LIKE '%$search%'
                        OR tgl_trbmasuk LIKE '%$search%'
                        OR nm_supplier LIKE '%$search%'
                        OR ket_trbmasuk LIKE '%$search%'
                        OR sisa_bayar LIKE '%$search%'
                        OR carabayar LIKE '%$search%'");

        $datacount = $querycount->fetch_array();
        $totalFiltered = $datacount['jumlah'];
    }

    $data = array();
    // $totalNilaiBarang = 0;
    if (!empty($query)) {
        $no = $start + 1;
        while ($value = $query->fetch_array()) {
            // for column
            $nestedData['no'] = $no;
            $nestedData['kd_trbmasuk'] = $value['kd_trbmasuk'];
            $nestedData['petugas'] = $value['petugas'];
            $nestedData['tgl_trbmasuk'] = $value['tgl_trbmasuk'];
            $nestedData['nm_supplier'] = $value['nm_supplier'];
            $nestedData['ket_trbmasuk'] = $value['ket_trbmasuk'];
            $nestedData['jatuh_tempo'] = $value['jatuhtempo'];
            $nestedData['sisa_bayar'] = $value['sisa_bayar'];
            $nestedData['carabayar'] = $value['carabayar'];
            $nestedData['aksi'] = "<a href='?module=trbmasukpbf&act=ubah&id=$value[id_trbmasuk]' title='EDIT' class='btn btn-warning btn-xs'>TAMPIL</a>";
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
