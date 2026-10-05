<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href=../css/style.css rel=stylesheet type=text/css>";
    echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
} else {

    switch ($_GET['act']) {
        default:

?>


            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">LAPORAN STOK OPNAME</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools
                    -->
                </div>
                <div class="box-body">

                    <form method="POST" action="modul/mod_laporan/tampil_lap_stokopname.php" target="_blank" enctype="multipart/form-data" class="form-horizontal">


                        </br></br>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Awal</label>
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                    <input type="text" required="required" class="datepicker" name="tgl_awal" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Akhir</label>
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                    <input type="text" required="required" class="datepicker" name="tgl_akhir" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                            <label class='col-sm-2 control-label'>WAKTU STOK OPNAME</label>
                            <div class='col-sm-3'>
                                <select name='shift' class='form-control' id="shift" >
                                    <option value="0">SO BULANAN</option>
                                    <option value="1">Pagi</option>
                                    <option value="2">Sore</option>
                                    <option value="3">Malam</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="buttons col-sm-4">
                                <input class="btn btn-primary" type="submit" name="btn" value="TAMPIL">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                <a class='btn  btn-danger' href='?module=home'>KEMBALI</a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">LAPORAN ITEM BARANG BELUM DI STOK OPNAME</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools
                    -->
                </div>
                <div class="box-body">
                    <form method="POST" action="?module=lapstokopname&act=belumso" target="_blank" enctype="multipart/form-data" class="form-horizontal">


                        </br></br>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal</label>
                            <div class="col-sm-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                    <input type="text" required="required" class="datepicker" name="tgl_awal"  autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            <label class='col-sm-2 control-label'>WAKTU STOK OPNAME</label>
                            <div class='col-sm-3'>
                                <select name='shift' class='form-control' id="shift" >
                                    <option value="0">SO BULANAN</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="buttons col-sm-4">
                                <input class="btn btn-primary" type="submit" name="btn" value="TAMPIL">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                <a class='btn  btn-danger' href='?module=home'>KEMBALI</a>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
<?php
break;
        case "belumso" :
        $tgl = $_POST['tgl_awal'];

         ?>
<div class="modal-body table-responsive">
    <table id="example1" class="table table-condensed table-bordered table-striped table-hover">

        <thead>
        <tr class="judul-table">
            <th style="vertical-align: middle; background-color: #008000; text-align: center; ">No</th>
            <th style="vertical-align: middle; background-color: #008000; text-align: left; ">Kode</th>
            <th style="vertical-align: middle; background-color: #008000; text-align: left; ">Nama Barang</th>
            <th style="vertical-align: middle; background-color: #008000; text-align: right; ">Qty</th>
            <th style="vertical-align: middle; background-color: #008000; text-align: center; ">Satuan</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $belum1 = $db->query("select * from barang where stok_barang>0");
        $no=1;
        while ($bl= $belum1->fetch_array()) {
            $filter = $db->query("select * from barang 
            join stok_opname on(barang.id_barang=stok_opname.id_barang) where tgl_stokopname='$tgl 
             ");
            $hasil = $filter->num_rows;
            if ($hasil < 0) {
                echo "
                <tr>
                    <td>$no</td>
                    <td>$bl[kd_barang]</td>
                    <td>$bl[nm_barang]</td>
                    <td>$bl[stok_barang]</td>
                    <td>$bl[sat_barang]</td>
                </tr>
                ";
            } else {
            }
        }
        ?>
        </tbody>
    </table>
<?php
            break;
    }

}
?>


<script type="text/javascript">
    $(function() {
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });


</script>