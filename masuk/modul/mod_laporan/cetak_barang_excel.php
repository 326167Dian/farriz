<?php
session_start();
include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_indotgl.php";
include "../../../configurasi/fungsi_rupiah.php";

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_barang.xls");

?>
<center>
    <h1>DATABASE BARANG APOTEK</h1>
</center>
<?php
$tgl_awal = date('d-m-Y');
echo "Dicetak Oleh : ";

echo $_SESSION['namalengkap'];
echo "  Tanggal : ";
echo $tgl_awal; ?>
<table border="1">
    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Stok Barang</th>
        <th>Stok Buffer</th>
        <th>Satuan</th>
        <th>Jenis & Rak</th>
        <th>Harga Beli</th>
        <th>Harga Jual</th>
    </tr>
    <?php
    // koneksi database
    include "../../../configurasi/koneksi.php";
    // menampilkan data barang
    $data = mysqli_query($GLOBALS["___mysqli_ston"], "select * from barang");
    $no = 1;
    while ($d = mysqli_fetch_array($data)) {
    ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $d['kd_barang']; ?></td>
            <td><?php echo $d['nm_barang']; ?></td>
            <td><?php echo $d['stok_barang']; ?></td>
            <td><?php echo $d['stok_buffer']; ?></td>
            <td><?php echo $d['sat_barang']; ?></td>
            <td><?php echo $d['jenisobat']; ?></td>
            <td><?php echo $d['hrgsat_barang']; ?></td>
            <td><?php echo $d['hrgjual_barang']; ?></td>
        </tr>
    <?php
    }
    ?>
</table>



?>