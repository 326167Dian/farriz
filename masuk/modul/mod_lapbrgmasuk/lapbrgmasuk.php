<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href=../css/style.css rel=stylesheet type=text/css>";
	echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
} else {

	switch ($_GET['act']) {
		default:

?>


			<div class="box box-danger box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">LAPORAN BARANG MASUK</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div>
				<div class="box-body">

					<form method="POST" action="modul/mod_laporan/cetak_brgmasuk.php" target="_blank" enctype="multipart/form-data" class="form-horizontal">

						</br></br>


						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Awal</label>
							<div class="col-sm-4">
								<div class="input-group date">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-th"></span>
									</div>
									<input type="text" class="datepicker" name="tgl_awal" required="required" autocomplete="off">
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
									<input type="text" class="datepicker" name="tgl_akhir" required="required" autocomplete="off">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="buttons col-sm-4">
								<input class="btn btn-primary" type="submit" name="btn" value="CETAK">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
								<a class='btn  btn-danger' href='?module=home'>KEMBALI</a>
							</div>
						</div>

					</form>
				</div>

			</div>


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