<?php
include "../../../configurasi/koneksi.php";
include "../../../configurasi/fungsi_indotgl.php";

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="struk.css">
</head>

<body class="struk" onload="printOut()">
    <section class="sheet">
        <?php
        echo '<table cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="txt-center">' . $rh['satu'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['dua'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['tiga'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['empat'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['lima'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['enam'] . '</td>
                    </tr>
                    <tr>
                        <td class="txt-center">' . $rh['tujuh'] . '</td>
                    </tr>
                </table>';
        echo (str_repeat("=", 38) . "<br/>");

        echo '<table cellpadding="0" cellspacing="0" style="width:100%">
                    <tr>
                        <td align="left" class="txt-left">Nota&nbsp;</td>
                        <td align="left" class="txt-left">:</td>
                        <td align="left" class="txt-left">&nbsp;' . $r1['kd_trkasir'] . '</td>
                    </tr>
                    <tr>
                        <td align="left" class="txt-left">Kasir</td>
                        <td align="left" class="txt-left">:</td>
                        <td align="left" class="txt-left">&nbsp;' . $r1['petugas'] . '</td>
                    </tr>
                    <tr>
                        <td align="left" class="txt-left">Pelanggan</td>
                        <td align="left" class="txt-left">:</td>
                        <td align="left" class="txt-left">&nbsp;' . $r1['nm_pelanggan'] . '</td>
                    </tr>
                    <tr>
                        <td align="left" class="txt-left">Tgl.&nbsp;</td>
                        <td align="left" class="txt-left">:</td>
                        <td align="left" class="txt-left">&nbsp;' . tgl_indo($r1['tgl_trkasir']) . '</td>
                    </tr>
                </table>';
        echo '<br/>';
        $tItem = 'Item' . str_repeat("&nbsp;", (9 - strlen('Item')));
        $tQty  = 'Qty' . str_repeat("&nbsp;", (6 - strlen('Qty')));
        $tHarga = str_repeat("&nbsp;", (9 - strlen('Harga'))) . 'Harga';
        $tTotal = str_repeat("&nbsp;", (10 - strlen('Total'))) . 'Subtotal';
        $caption = $tItem . $tQty . $tHarga . $tTotal;

        echo    '<table cellpadding="0" cellspacing="0" style="width:100%">
                        <tr>
                            <td align="left" class="txt-left">' . $caption . '</td>
                        </tr>
                        <tr>
                            <td align="left" class="txt-left">' . str_repeat("=", 38) . '</td>
                        </tr>';

        $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir_detail WHERE kd_trkasir='$_GET[kd_trkasir]'
            ORDER BY id_dtrkasir ASC");

        $Rpsubtotal = 0;
        $diskon = 0;
        while ($r2 = mysqli_fetch_array($query)) {
            $st[]       = $r2['hrgttl_dtrkasir'];
            $gt         = array_sum($st);
            $Rpsubtotal = $gt;
            $diskon       = round((($gt - $r1['ttl_trkasir']) / $gt) * 100);

            $item = $r2['nmbrg_dtrkasir'] . str_repeat("&nbsp;", (38 - (strlen($r2['nmbrg_dtrkasir']))));
            echo '<tr>';
            echo '<td align="center" class="txt-center">' . $item . '</td>';
            echo '</tr>';

            echo '<tr>';

            $qty        = $r2['qty_dtrkasir'];
            $qty        = "&nbsp;" . str_repeat("&nbsp;", (6 - strlen($qty)));

            $qty2       = $r2['qty_dtrkasir'];
            $qty2       = str_repeat("&nbsp;", (6 - strlen($qty2))) . $qty2;

            $price      = number_format($r2['hrgjual_dtrkasir'], 0, ',', '.');
            $price      = str_repeat("&nbsp;", (13 - strlen($price))) . $price;

            $total      = number_format($r2['hrgttl_dtrkasir'], 0, ',', '.');
            $lentotal   = strlen($total);
            $total      = str_repeat("&nbsp;", (12 - $lentotal)) . $total;
            echo '<td class="txt-left" align="left">' . $qty . $qty2 . $price . $total . '</td>';

            echo '</tr>';
        }

        echo '<tr><td>' . str_repeat('-', 38) . '</td></tr>';


        //Sub Total
        $metode1    = 'Metode&nbsp;Bayar';
        $metode1    = $metode1 . str_repeat("&nbsp;", (19 - strlen($metode1)));

        $subtotal   = 'Total&nbsp;';
        $subtotal   = $subtotal . str_repeat("&nbsp;", (14 - strlen($subtotal)));
        $Ssubtotal  = number_format($Rpsubtotal, 0, ',', '.');
        $Ssubtotal  = str_repeat("&nbsp;", (14 - strlen($Ssubtotal))) . $Ssubtotal;
        echo '<tr><td>' . $metode1 . $subtotal . $Ssubtotal . '</td></tr>';

        $metode2    = $bayar['nm_carabayar'];
        $metode2    = $metode2 . str_repeat("&nbsp;", (14 - strlen($metode2)));

        $titleDisc  = 'Diskon(%)';
        $titleDisc  = $titleDisc . str_repeat("", (14 - strlen($titleDisc)));
        $Rpdisc     = $diskon;
        $Rpdisc     = str_repeat("&nbsp;", (14 - strlen($Rpdisc))) . $Rpdisc;
        echo '<tr><td>' . $metode2 . $titleDisc . $Rpdisc . '</td></tr>';

        $metode3        = '&nbsp;';
        $metode3        = $metode3 . str_repeat("&nbsp;", (19 - strlen($metode3)));
        $titleTagihan   = 'Tagihan';
        $titleTagihan   = $titleTagihan . str_repeat("", (14 - strlen($titleTagihan)));
        $Rptagihan      = number_format($r1['ttl_trkasir'], 0, ',', '.');
        $Rptagihan      = str_repeat("&nbsp;", (16 - strlen($Rptagihan))) . $Rptagihan;
        echo '<tr><td>' . $metode3 . $titleTagihan . $Rptagihan . '</td></tr>';

        $titleCash = 'Uang&nbsp;Cash';
        $titleCash = $titleCash . str_repeat("&nbsp;", (14 - strlen($titleCash)));
        $Rpcash      = number_format($r1['dp_bayar'], 0, ',', '.');
        $Rpcash      = str_repeat("&nbsp;", (14 - strlen($Rpcash))) . $Rpcash;
        echo '<tr><td>' . $metode3 . $titleCash . $Rpcash . '</td></tr>';

        $titleKembalian = 'Kembalian';
        $titleKembalian = $titleKembalian . str_repeat("", (14 - strlen($titleKembalian)));
        $Rpkembalian      = number_format($r1['sisa_bayar'], 0, ',', '.');
        $Rpkembalian      = str_repeat("&nbsp;", (14 - strlen($Rpkembalian))) . $Rpkembalian;
        echo '<tr><td>' . $metode3 . $titleKembalian . $Rpkembalian . '</td></tr>';

        echo '<tr><td>&nbsp;</td></tr>';
        echo '</table>';

        // $footer = 'Terima kasih atas kunjungan anda';
        $footer1 = $rh['delapan'];
        $starSpace1 = (34 - strlen($footer1)) / 2;
        $starFooter1 = str_repeat('*', $starSpace1 + 1);
        echo ('<center>' . '&nbsp;' . $footer1 . '&nbsp;'  . "<br/>");

        $footer2 = $rh['sembilan'];
        echo ('<center>'.$footer2 . "<br/>");

        $footer3 = $rh['sepuluh'];
        echo ('<center>'.$footer3 . "<br/><br/><br/><br/>");

        // $batas = "sobek&nbsp;disini";
        // $starSpace2 = (34 - strlen($batas)) / 2;
        // $starFooter2 = str_repeat('-', $starSpace2 + 1);
        // echo ($starFooter2 . '&nbsp;' . $batas . '&nbsp;' . $starFooter2 . "<br/>");
        // echo '<p>&nbsp;</p>';

        ?>
    </section>

    <script>
        function printOut() {
            window.print();
            setInterval(function() {
                window.close();
            }, 1000)
        }
    </script>
</body>

</html>