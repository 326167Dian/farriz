<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
    echo "<link href=../css/style.css rel=stylesheet type=text/css>";
    echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";

} else {
    
    $tgl_awal = date('Y-m-d');
    $tgl_kemarin = date('Y-m-d', strtotime('-1 days', strtotime( $tgl_awal)));
    $tgl_akhir = date('Y-m-d', strtotime('-60 days', strtotime( $tgl_awal)));
    $tampil_trkasir = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM trkasir JOIN carabayar ON trkasir.id_carabayar = carabayar.id_carabayar WHERE tgl_trkasir BETWEEN '$tgl_akhir' AND '$tgl_kemarin' ORDER BY id_trkasir DESC");
?>

    <div class="box box-primary box-solid">
		<div class="box-header with-border">
			<h3 class="box-title">TRANSAKSI PENJUALAN KEMARIN</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box-tools -->
		</div>
		<div class="box-body table-responsive">
			<a  class ='btn  btn-warning  btn-flat' href='#'></a>
            <small>* Pembayaran belum lunas</small>
            <div></div>
			<br><br>
					
			<table id="example1" class="table table-bordered table-striped" >
				<thead>
					<tr>
						<th>No</th>
						<th>Kode</th>
						<th>Tanggal</th>
						<th>Pelanggan</th>
						<th>Kasir</th>
						<th>Cara Bayar</th>
						<th>Total</th>
                        <th width="70">Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				    $no=1;
				    while($r = mysqli_fetch_array($tampil_trkasir)){
				        $ttl_trkasir = $r['ttl_trkasir'];
						$ttl_trkasir2 = format_rupiah($ttl_trkasir);
					?>
					    <tr>
					        <td class="text-center" style="<?=($r['id_carabayar']==3)?'background-color:#ffbf00;':''?>"><?=$no?></td>
					        <td style="<?=($r['id_carabayar']==3)?'background-color:#ffbf00;':''?>"><?=$r['kd_trkasir']?></td>
					        <td><?=$r['tgl_trkasir']?></td>
					        <td><?=$r['nm_pelanggan']?></td>
					        <td><?=$r['petugas']?></td>
					        <td><?=$r['nm_carabayar']?></td>
					        <td><?=$ttl_trkasir2?></td>
					        <td width="100px">
				<?php
					       echo "
					            <a href='?module=trkasir&act=ubah&id=$r[id_trkasir]' title='EDIT' class='glyphicon glyphicon-pencil'></a> 
								<a class='glyphicon glyphicon-print' onclick=\"window.open('modul/mod_laporan/struk.php?kd_trkasir=$r[kd_trkasir]','nama window','width=500,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no, scrollbars=no,resizable=yes,copyhistory=no')\"></a>
								<a href=javascript:confirmdelete('$aksi?module=trkasir&act=hapus&id=$r[id_trkasir]') title='HAPUS' class='glyphicon glyphicon-remove'></a>
					       ";
				?>							 
					        </td>
					    </tr>
					<?php
						$no++;		
				    }	
				?>
			    </tbody>
            </table>
		</div>
	</div>


<?php    
}
?>