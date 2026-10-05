<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <style>
        body{
            margin:0;
            padding:0;
        }
    </style>
</head>

<body>
    <script type="text/javascript">
        window.print();
        
        setInterval(function(){
            window.close();
        }, 1000);
        
    </script>
    <?php
    include "../../../configurasi/koneksi.php";
    require('../../assets/pdf/fpdf.php');
    include "../../../configurasi/fungsi_indotgl.php";
    include "../../../configurasi/fungsi_rupiah.php";

    //ambil header
    $ah = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader ");
    $rh = mysqli_fetch_array($ah);

    $dt = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir
    JOIN carabayar ON trkasir.id_carabayar = carabayar.id_carabayar
    WHERE trkasir.kd_trkasir='$_GET[kd_trkasir]'");
    $r1 = mysqli_fetch_array($dt);

    $carabayar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM carabayar
    WHERE id_carabayar ='$r1[id_carabayar]'");
    $bayar = mysqli_fetch_array($carabayar);

    ?>
    
        <center style="font-size:10px; font-weight:bold;"><?= $rh['satu'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['dua'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['tiga'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['empat'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['lima'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['enam'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['tujuh'] ?></center>
    
    <hr style="border: solid 1px #000;">
    
    <table border="0" width="100%" style="font-size: 10px; font-weight:bold;">
        <tr>
            <td width="20%">No. Nota</td>
            <td style="text-align: center;">:</td>
            <td><?= $r1['kd_trkasir'] ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td style="text-align: center;">:</td>
            <td><?= tgl_indo($r1['tgl_trkasir']) ?></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td style="text-align: center;">:</td>
            <td><?= tgl_indo($r1['nm_pelanggan']) ?></td>
        </tr>
        <tr>
            <td>Telp/HP</td>
            <td style="text-align: center;">:</td>
            <td><?= tgl_indo($r1['tlp_pelanggan']) ?></td>
        </tr>
    </table>
    <hr style="border: solid 1px #000;">
    
    <table border="0" width="95%" style="font-size:10px; font-weight:bold;">
        <tr>
            <td style="text-align: left; width:30%">Item</td>
            <td style="text-align: center;">Qty</td>
            <td style="text-align: left;">Harga</td>
            <td style="text-align: left;">Subtotal</td>
        </tr>
        <?php
        $no = 1;
        $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir='$_GET[kd_trkasir]'
            ORDER BY id_dtrkasir ASC");

        $total = 0;
        $disc = 0;
        while ($r2 = mysqli_fetch_array($query)) :
            $st[] = $r2['hrgttl_dtrkasir'];
            $gt = array_sum($st);
            $disc = round((($gt - $r1['ttl_trkasir']) / $gt) * 100);
            $tagihan = format_rupiah($r1['ttl_trkasir']);
            // $total = format_rupiah($r2['hrgttl_dtrkasir'])
            $total = format_rupiah($gt);
        ?>
            <tr>
                <td><?= $r2['nmbrg_dtrkasir'] ?></td>
                <td style="text-align: center;"><?= $r2['qty_dtrkasir'] . ' ' . $r2['sat_dtrkasir'] ?></td>
                <td style="text-align: left;"><?= format_rupiah($r2['hrgjual_dtrkasir']) ?></td>
                <td style="text-align: left;"><?= format_rupiah($r2['hrgttl_dtrkasir']) ?></td>
            </tr>

        <?php
        endwhile; ?>
        <tr>
            <td colspan="4">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2">Metode Bayar:</td>
            <td style="text-align: right;">Total: </td>
            <td style="text-align: left;"><?= $total ?></td>
        </tr>
        <tr>
            <td colspan="1"><?= $bayar['nm_carabayar'] ?></td>
            <td colspan="2" style="text-align: right;">Diskon (%): </td>
            <td style="text-align: left;"><?= $disc ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Tagihan: </td>
            <td style="text-align: left;"><?= $tagihan ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Uang Cash: </td>
            <td style="text-align: left;"><?= format_rupiah($r1['dp_bayar']) ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Kembalian: </td>
            <td style="text-align: left;"><?= format_rupiah($r1['sisa_bayar']) ?></td>
        </tr>
    </table>
    <br>
    
    
        <center style="font-size:10px; font-weight:bold;"><?= $rh['delapan'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['sembilan'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $rh['sepuluh'] ?></center>
        <center style="font-size:10px; font-weight:bold;"><?= $r1['petugas'] ?></center>
    
</body>

</html>