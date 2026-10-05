<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href=../css/style.css rel=stylesheet type=text/css>";
	echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
} else {

	$aksi = "modul/mod_supplier/aksi_supplier.php";
	$aksi_supplier = "masuk/modul/mod_supplier/aksi_supplier.php";
	switch ($_GET['act']) {
			// Tampil Siswa
		default:

			$tampil_supplier = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM supplier ORDER BY id_supplier ASC");

?>


			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">DATA SUPPLIER</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div>
				<div class="box-body table-responsive">
					<a class='btn  btn-success btn-flat' href='?module=supplier&act=tambah'>TAMBAH</a>
					<br><br>


					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Supplier</th>
								<th>Telp</th>
								<th>Alamat</th>
								<th>Keterangan</th>
								<th width="70">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($r = mysqli_fetch_array($tampil_supplier)) {
								echo "<tr class='warnabaris' >
											<td>$no</td>           
											 <td>$r[nm_supplier]</td>
											 <td>$r[tlp_supplier]</td>
											 <td>$r[alamat_supplier]</td>
											 <td>$r[ket_supplier]</td>
											 <td>
											 <a href='?module=supplier&act=dataobat&id=$r[id_supplier]' title='EDIT' class='btn btn-primary btn-xs'>DATA OBAT</a> 
											 
											 <a href='?module=supplier&act=edit&id=$r[id_supplier]' title='EDIT' class='btn btn-warning btn-xs'>EDIT</a> 
											 <a href=javascript:confirmdelete('$aksi?module=supplier&act=hapus&id=$r[id_supplier]') title='HAPUS' class='btn btn-danger btn-xs'>HAPUS</a>
											 
											</td>
										</tr>";
								$no++;
							}
							echo "</tbody></table>";
							?>
				</div>
			</div>


		<?php

			break;

		case "tambah":

			echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>TAMBAH</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
				
						<form method=POST action='$aksi?module=supplier&act=input_supplier' enctype='multipart/form-data' class='form-horizontal'>
						
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Nama Supplier</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nm_supplier' class='form-control' required='required' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Telp</label>        		
									 <div class='col-sm-4'>
										<input type=text name='tlp_supplier' class='form-control' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Alamat</label>        		
									 <div class='col-sm-4'>
										<textarea name='alamat_supplier' class='form-control' rows='3'></textarea>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Keterangan</label>        		
									 <div class='col-sm-4'>
										<textarea name='ket_supplier' class='form-control' rows='3'></textarea>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-5'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-primary' type=button value=BATAL onclick=self.history.back()>
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>";


			break;

		case "edit":
			$edit = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM supplier WHERE id_supplier='$_GET[id]'");
			$r = mysqli_fetch_array($edit);

			echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>UBAH</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
						<form method=POST method=POST action=$aksi?module=supplier&act=update_supplier  enctype='multipart/form-data' class='form-horizontal'>
							  <input type=hidden name=id value='$r[id_supplier]'>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Nama Supplier</label>        		
									 <div class='col-sm-4'>
										<input type=text name='nm_supplier' class='form-control' value='$r[nm_supplier]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Telepon</label>        		
									 <div class='col-sm-4'>
										<input type=text name='tlp_supplier' class='form-control' value='$r[tlp_supplier]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Alamat</label>        		
									 <div class='col-sm-4'>
										<textarea name='alamat_supplier' class='form-control' rows='3'>$r[alamat_supplier]</textarea>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Keterangan</label>        		
									 <div class='col-sm-4'>
										<textarea name='ket_supplier' class='form-control' rows='3'>$r[ket_supplier]</textarea>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-5'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-primary' type=button value=BATAL onclick=self.history.back()>
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>";



			break;

		case "dataobat":

			$carisup = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM supplier WHERE id_supplier='$_GET[id]'");
			$rsup = mysqli_fetch_array($carisup);
		?>

			<div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>DATA OBAT SUPPLIER</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
					</div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>

					<form onsubmit='return false;' method=POST action='$aksi?module=trbmasuk&act=input_trbmasuk' enctype='multipart/form-data' class='form-horizontal'>

						<input type=hidden name='id_supplier' id='id_supplier' value="<?= $rsup['id_supplier'] ?>">

						<div class='col-lg-6'>

							<div class='form-group'>

								<label class='col-sm-4 control-label'>Supplier</label>
								<div class='col-sm-8'>
									<div class='input-group'>
										<input type='text' class='form-control' name='nm_supplier' id='nm_supplier' required='required' autocomplete='off' value="<?= $rsup['nm_supplier'] ?>" Disabled>
										<div class='input-group-addon'>
											<button type=button data-toggle='modal' data-target='#ModalSupplier' href='#'><span class='glyphicon glyphicon-search'></span></button>
										</div>
									</div>
								</div>

								<label class='col-sm-4 control-label'>Telepon</label>
								<div class='col-sm-8'>
									<input type=text name='tlp_supplier' id='tlp_supplier' class='form-control' autocomplete='off' value="<?= $rsup['tlp_supplier'] ?>" disabled>
								</div>

								<label class='col-sm-4 control-label'>Alamat</label>
								<div class='col-sm-8'>
									<textarea name='alamat_supplier' id='alamat_supplier' class='form-control' rows='3' style="resize: none;" disabled><?= $rsup['alamat_supplier'] ?></textarea>
								</div>

							</div>

						</div>

						<div class='col-lg-6'>


							<input type=hidden name='id_barang' id='id_barang'>

							<div class='form-group'>

								<label class='col-sm-4 control-label'>Kode Barang</label>
								<div class='col-sm-7'>
									<div class='input-group'>
										<input type='text' class='form-control' name='kd_barang' id='kd_barang' autocomplete='off'>
										<div class='input-group-addon'>
											<button type=button data-toggle='modal' data-target='#ModalItem' href='#'><span class='glyphicon glyphicon-search'></span></button>
										</div>
									</div>
								</div>

								<label class='col-sm-4 control-label'>Nama Barang</label>
								<div class='col-sm-7'>
									<input type=text name='nmbrg_dtrbmasuk' id='nmbrg_dtrbmasuk' class='form-control' autocomplete='off'>
								</div>

								<label class='col-sm-4 control-label'>Satuan</label>
								<div class='col-sm-7'>
									<input type=text name='sat_dtrbmasuk' id='sat_dtrbmasuk' class='form-control' autocomplete='off'>

									<br>
									<div class='buttons'>
										<button type='button' class='btn btn-success right-block' onclick='simpan_detail();'>SIMPAN DATA OBAT</button>
									</div>
								</div>


							</div>


						</div>
					</form>

				</div>

				<div id='tabeldata'>

				</div>


				<!-- Modal itemmat -->
				<div id="ModalItem" class="modal fade" role="dialog">
					<div class="modal-lg modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">PILIH ITEM BARANG</h4>

								<div id="box">
								</div>
							</div>

							<div class="modal-body">
								<table id="example1" class="table table-condensed table-bordered table-striped table-hover">

									<thead>
										<tr class="judul-table">
											<th style="vertical-align: middle; background-color: #008000; text-align: center; ">No</th>
											<th style="vertical-align: middle; background-color: #008000; text-align: left; ">Kode</th>
											<th style="vertical-align: middle; background-color: #008000; text-align: left; ">Nama Barang</th>
											<th style="vertical-align: middle; background-color: #008000; text-align: center; ">Satuan</th>
											<th style="vertical-align: middle; background-color: #008000; text-align: center; ">Pilih</th>
										</tr>
									</thead>
									<tbody>
										<?php $no = 1;
										$tampil_dproyek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY id_barang ASC");
										while ($rd = mysqli_fetch_array($tampil_dproyek)) {

											$stok1 = format_rupiah($rd['stok_barang']);
											$harga1 = format_rupiah($rd['hrgsat_barang']);

											echo "<tr style='font-size: 13px;'> 
										     <td align=center>$no</td>
											 <td>$rd[kd_barang]</td>
											 <td>$rd[nm_barang]</td>
											 <td align=center>$rd[sat_barang]</td>
											 <td align=center>
											 
											 <button class='btn btn-xs btn-info' id='pilihbarang' 
												 data-id_barang='$rd[id_barang]'
												 data-kd_barang='$rd[kd_barang]'
												 data-nm_barang='$rd[nm_barang]'
												 data-sat_barang='$rd[sat_barang]'>
												 <i class='fa fa-check'></i>
												 </button>
												
											</td>
										</tr>";
											$no++;
										}
										echo "</tbody></table>";
										?>
							</div>
						</div>
					</div>
				</div>
				<!-- end modal item -->


				<script>
					$(document).ready(function() {
						tabel_detail();
					});

					$(document).on('click', '#pilihbarang', function() {

						var id_barang = $(this).data('id_barang');
						var kd_barang = $(this).data('kd_barang');
						var nm_barang = $(this).data('nm_barang');
						var sat_barang = $(this).data('sat_barang');

						document.getElementById('id_barang').value = id_barang;
						document.getElementById('kd_barang').value = kd_barang;
						document.getElementById('nmbrg_dtrbmasuk').value = nm_barang;
						document.getElementById('sat_dtrbmasuk').value = sat_barang;
						//hilangkan modal
						$(".close").click();

					});

					function simpan_detail() {

						var id_barang = document.getElementById('id_barang').value;
						var id_supplier = document.getElementById('id_supplier').value;

						if (nmbrg_dtrbmasuk == "") {
							alert('Belum ada Item terpilih');
						} else {

							$.ajax({

								type: 'post',
								url: "modul/mod_supplier/aksi_supplier.php?module=supplier&act=simpanbarang",
								data: {
									'id_barang': id_barang,
									'id_supplier': id_supplier
								},
								success: function(data) {
									//alert('Tambah data detail berhasil');
									document.getElementById("id_barang").value = "";
									document.getElementById("kd_barang").value = "";
									document.getElementById("nmbrg_dtrbmasuk").value = "";
									document.getElementById("sat_dtrbmasuk").value = "";
									tabel_detail();

								}
							});
						}
					}

					//fungsi tabel detail
					function tabel_detail() {

						var id_supplier = document.getElementById('id_supplier').value;

						$.ajax({
							url: 'modul/mod_supplier/tbl_detail.php',
							type: 'post',
							data: {
								'id_supplier': id_supplier
							},
							success: function(data) {
								$('#tabeldata').html(data);
							}

						});
					}

					// fungsi hapus detail
					$(document).on('click', '#hapusdetail', function() {
						var id_brgsup = $(this).data('id_brgsup');

						$.ajax({
							type: 'post',
							url: "modul/mod_supplier/aksi_supplier.php?module=supplier&act=hapusbarang",
							data: {
								id_brgsup: id_brgsup
							},

							success: function(response) {
								tabel_detail();
								$(".close").click();
							}
						});

					});
				</script>
	<?php
			break;
	}
}
	?>