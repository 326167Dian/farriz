<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href=../css/style.css rel=stylesheet type=text/css>";
	echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
} else {

	$aksi = "modul/mod_barang/aksi_barang.php";
	$aksi_barang = "masuk/modul/mod_barang/aksi_barang.php";
	switch ($_GET['act']) {
			// Tampil barang
		default:

			// $tampil_barang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY barang.id_barang ");

?>


			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">DATA BARANG</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div>
				<div class="box-body table-responsive">
					<a class='btn  btn-success btn-flat' href='?module=barang&act=tambah'>TAMBAH</a>
					<a class='btn  btn-primary btn-flat' href='modul/mod_laporan/cetak_barang_excel.php' target='_blank'>EXPORT TO EXCEL</a>
					<hr>
					<CENTER><strong>MySIFA PROFIT ANALYSIS</strong></CENTER><br>
					<center><button type="button" class="btn btn-info">PROFIT>200%</button>
						<button type="button" class="btn btn-success">PROFIT = 100 - 200 % </button>
						<button type="button" class="btn btn-warning">PROFIT = 30 - 100%"</button>
						<button type="button" class="btn btn-danger">PROFIT < 30% </button>
					</center>
					<br><br>


					<table id="tes" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Barang</th>
								<th style="text-align: right; ">Qty/Stok</th>
								<th style="text-align: right; ">Satuan</th>
								<th style="text-align: center; ">Jenis Obat</th>
								<th style="text-align: right; ">Harga Beli</th>
								<th style="text-align: right; ">Harga Jual</th>
								<th style="text-align: center; ">Komposisi dan Indikasi</th>
								<!--<th style="text-align: center; ">Aksi</th>-->
								<?php
								$lupa = $_SESSION['level'];
								if ($lupa == 'pemilik') {
									echo "<th>Aksi</th> ";
								} else {
								}
								?>
							</tr>
						</thead>

					</table>
				</div>
			</div>


<?php

			break;

		case "tambah":

			echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>TAMBAH DATA BARANG</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
				
						<form method=POST action='$aksi?module=barang&act=input_barang' enctype='multipart/form-data' class='form-horizontal'>
						
						<input type=hidden name='id_supplier' id='id_supplier'>
							  							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Kode Barang</label>        		
									 <div class='col-sm-3'>
										<input type=text name='kd_barang' class='form-control' autocomplete='off'>
									 </div>
							  </div>
							  
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Nama Barang</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nm_barang' class='form-control' required='required' autocomplete='off'>
									 </div>
							  </div>
							  <!-- tidak bisa tambah stok dari sini
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Qty/Stok</label>        		
									 <div class='col-sm-3'>
										<input type=number name='stok_barang' class='form-control' required='required' autocomplete='off'>
									 </div>
							  </div> -->
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Stok Buffer</label>        		
									 <div class='col-sm-3'>
										<input type=number name='stok_buffer' class='form-control' required='required' autocomplete='off'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Satuan</label>        		
									 <div class='col-sm-3'>
										<select name='sat_barang' class='form-control' >";
                                        $tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM satuan ORDER BY nm_satuan ASC");
                                        while ($rk = mysqli_fetch_array($tampil)) {
                                            echo "<option value=$rk[nm_satuan]>$rk[nm_satuan]</option>";
                                        }
                                        echo "</select>
									 </div>
							  </div> 
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Jenis Obat</label>        		
									 <div class='col-sm-3'>
										<select name='jenisobat' class='form-control' >";
			$tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jenis_obat ORDER BY jenisobat ASC");
			while ($rk = mysqli_fetch_array($tampil)) {
				echo "<option value=$rk[jenisobat]>$rk[jenisobat]</option>";
			}
			echo "</select>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Harga Beli</label>        		
									 <div class='col-sm-3'>
										<input type='number' min='0' name='hrgsat_barang' class='form-control' required='required' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Harga Jual</label>        		
									 <div class='col-sm-3'>
										<input type='number' min='0' name='hrgjual_barang' class='form-control' required='required' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Komposisi dan Indikasi</label>
										<div class='col-sm-3'>
											<div >	
													<textarea name='indikasi' class='ckeditor' id='content' rows='3'>$r[indikasi]</textarea>
											</div>
										</div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Harga Grosir</label>        		
									 <div class='col-sm-3'>
										<textarea name='ket_barang' class='ckeditor' rows='3' id='content'></textarea>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-4'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-danger' type=button value=BATAL onclick=self.history.back()>
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>";


			break;

		case "edit":
			$edit = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang 
	WHERE barang.id_barang='$_GET[id]'");
			$r = mysqli_fetch_array($edit);

			echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>UBAH DATA BARANG</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
						<form method=POST method=POST action=$aksi?module=barang&act=update_barang  enctype='multipart/form-data' class='form-horizontal'>
							  <input type=hidden name=id value='$r[id_barang]'>
							  
							 
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Kode Barang</label>        		
									 <div class='col-sm-3'>
										<input type=text name='kd_barang' class='form-control' required='required' value='$r[kd_barang]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Nama Barang</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nm_barang' class='form-control' required='required' value='$r[nm_barang]' autocomplete='off'>
									 </div>
							  </div>
							  <!-- tidak bisa edit stok dari sini
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Qty/Stok</label>        		
									 <div class='col-sm-3'>
										<input type=number name='stok_barang' class='form-control' required='required' value='$r[stok_barang]' autocomplete='off'>
									 </div>
							  </div> -->
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Stok Buffer</label>        		
									 <div class='col-sm-3'>
										<input type=number name='stok_buffer' class='form-control' required='required' value='$r[stok_buffer]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Satuan</label>        		
									 <div class='col-sm-3'>
										<select name='sat_barang' class='form-control' >
											 <option  value=$r[sat_barang] selected>$r[sat_barang]</option>";
			$tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM satuan ORDER BY nm_satuan");
			while ($k = mysqli_fetch_array($tampil)) {
				echo "<option value=$k[nm_satuan]>$k[nm_satuan]</option>";
			}
			echo "</select>
									 </div>
							  </div> 
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Jenis Obat</label>        		
									 <div class='col-sm-3'>
										<select name='jenisobat' class='form-control' >
											 <option  value=$r[jenisobat] selected>$r[jenisobat]</option>";
			$tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jenis_obat ORDER BY idjenis");
			while ($k = mysqli_fetch_array($tampil)) {
				echo "<option value=$k[jenisobat]>$k[jenisobat]</option>";
			}
			echo "</select>
									 </div>
							  </div>
							  
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Harga Beli</label>        		
									 <div class='col-sm-3'>
										<input type='number' min='0' name='hrgsat_barang' class='form-control' required='required' value='$r[hrgsat_barang]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Harga Jual</label>        		
									 <div class='col-sm-3'>
										<input type='number' min='0' name='hrgjual_barang' class='form-control' required='required' value='$r[hrgjual_barang]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Komposisi dan Indikasi</label>
										<div class='col-sm-4'>
											<div >	
													<textarea name='indikasi' class='ckeditor' id='content' rows='3'>$r[indikasi]</textarea>
											</div>
										</div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Harga Grosir</label>        		
									 <div class='col-sm-4'>
										<textarea name='ket_barang' class='ckeditor' id='content' rows='3'>$r[ket_barang]</textarea>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-4'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-danger' type=button value=BATAL onclick=self.history.back()>
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>";




			break;
	}
}
?>

<script type="text/javascript" src="vendors/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	var editor = CKEDITOR.replace("content", {
		filebrowserBrowseUrl: '',
		filebrowserWindowWidth: 1000,
		filebrowserWindowHeight: 500
	});
</script>
<script>
	$(document).ready(function() {
		$('#tes').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				"url": "modul/mod_barang/barang-serverside.php?action=table_data",
				"dataType": "JSON",
				"type": "POST"
			},
			"rowCallback": function(row, data, index) {
                let q = (data['hrgjual_barang'] - data['hrgsat_barang']) / data['hrgsat_barang'];
                
                if(q <= 0.3){
                    $(row).find('td:eq(7)').css('background-color', '#ff003f');
                    $(row).find('td:eq(7)').css('color', '#ffffff');
                } else if(q > 0.3 && q <= 1){
                    $(row).find('td:eq(7)').css('background-color', '#f39c12');
                    $(row).find('td:eq(7)').css('color', '#ffffff');
                    
                } else if(q > 1 && q <= 2){
                    $(row).find('td:eq(7)').css('background-color', '#00ff3f');
                    $(row).find('td:eq(7)').css('color', '#ffffff');
                    
                } else if(q > 2){
                    $(row).find('td:eq(7)').css('background-color', '#00bfff');
                    $(row).find('td:eq(7)').css('color', '#ffffff');
                    
                }
                
            },
			columns: [{
					"data": "no",
					"className": 'text-center'
				},
				{
					"data": "kd_barang"
				},
				{
					"data": "nm_barang"
				},
				{
					"data": "stok_barang",
					"className": 'text-center'
				},
				{
					"data": "sat_barang",
					"className": 'text-center'
				},
				{
					"data": "jenisobat",
					"className": 'text-center'
				},
				{
					"data": "hrgsat_barang",
					"className": 'text-right',
					"render": function(data, type, row) {
						return formatRupiah(data);
					}
				},
				{
					"data": "hrgjual_barang",
					"className": 'text-right',
					"render": function(data, type, row) {
						return formatRupiah(data);
					}
				},
				{
					"data": "indikasi",
					"className": 'text-justify'
				},
				{
					"data": "aksi",
					"visible": <?= ($_SESSION['level'] == 'pemilik') ? 'true' : 'false'; ?>,
					"render": function(data, type, row) {
						var btn = "<div style='text-align:center'><a href='?module=barang&act=edit&id=" + data + "' title='EDIT' class='btn btn-warning btn-xs'>EDIT</a> <a href=javascript:confirmdelete('modul/mod_barang/aksi_barang.php?module=barang&act=hapus&id=" + data + "') title='HAPUS' class='btn btn-danger btn-xs'>HAPUS</a></div>";

						return btn;
					}
				},
			]
		});
	});
</script>