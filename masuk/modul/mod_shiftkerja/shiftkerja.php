<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href=../css/style.css rel=stylesheet type=text/css>";
	echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
} else {

	$aksi = "modul/mod_shiftkerja/aksi_shiftkerja.php";

	switch ($_GET['act']) {
			// tampil satuan
		default:


			$tampil_waktukerja = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM waktukerja ORDER BY id_shift desc");

?>


			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">OPENING DAN CLOSING TRANSAKSI PENJUALAN</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div><!-- /.box-tools -->
				</div>
				<div class="box-body table-responsive">
					<a class='btn  btn-success btn-flat' href='?module=shiftkerja&act=tambah'>OPEN KASIR</a>
					<a class='btn  btn-danger btn-flat' href='?module=shiftkerja&act=edit'>TUTUP KASIR</a>


					<br><br>


					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Petugas Buka</th>
								<th>Petugas Tutup</th>
								<th>Shift</th>
								<th>Tanggal</th>
								<th>Buka</th>
								<th>Tutup</th>
								<th>Saldo awal</th>
								<th>Saldo akhir</th>
								<th>Status</th>
								<th>Koreksi</th>
								<?PHP
								// $lupa = $_SESSION['level'];
								// if ($lupa == 'pemilik') {
								// 	echo "<th>Koreksi</th> ";
								// } else {
								// }
								?>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($r = mysqli_fetch_array($tampil_waktukerja)) {
								$rupiahawal = format_rupiah($r['saldoawal']);
								$rupiahakhir = format_rupiah($r['saldoakhir']);
								echo "<tr class='warnabaris' >
											<td>$no</td>           
											 <td>$r[petugasbuka]</td>
											 <td>$r[petugastutup]</td>
											 <td>$r[shift]</td>
											 <td>$r[tanggal]</td>
											 <td>$r[waktubuka]</td>
											 <td>$r[waktututup]</td>
											 <td align='center'>$rupiahawal</td>
											 <td align='center'>$rupiahakhir</td>
											 <td align='center'>$r[status]</td>";
								$lupa = $_SESSION['level'];
								if ($lupa == 'pemilik') {
									echo "<td>
									<a href='?module=shiftkerja&act=editkoreksi&id=$r[id_shift]' title='EDIT' class='glyphicon glyphicon-pencil'>&nbsp</a> 
									
									<a href=javascript:confirmdelete('$aksi?module=shiftkerja&act=hapus&id=$r[id_shift]') title='HAPUS' class='glyphicon glyphicon-remove'>&nbsp</a>
									
									<a class='glyphicon glyphicon-print' onclick=\"javascript:window.open('modul/mod_shiftkerja/laporanshiftday.php?idshift=$r[id_shift]','nama window','width=500,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no')\">&nbsp</a>
											 </td> ";
								} else {
									echo "<td>
									<a class='glyphicon glyphicon-print' onclick=\"javascript:window.open('modul/mod_shiftkerja/laporanshiftday.php?idshift=$r[id_shift]','nama window','width=500,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no')\">&nbsp</a>
											 </td> ";
								}


								echo " <!--	 <td><a href='?module=satuan&act=edit&id=$r[id_satuan]' title='EDIT' class='btn btn-warning btn-xs'>EDIT</a> 
											 <a href=javascript:confirmdelete('$aksi?module=satuan&act=hapus&id=$r[id_satuan]') title='HAPUS' class='btn btn-danger btn-xs'>HAPUS</a>
											 </td>
										-->	 
											
										</tr>";
								$no++;
							}
				// 			echo "</tbody></table>";
							?>
						</tbody>
					</table>
				</div>
			</div>


<?php

			break;

		case "tambah":
			$petugas = $_SESSION['namalengkap'];
			$tglharini = date('Y-m-d');
			$waktu = date('H:i:s');
			Date_Default_timezone_set('Asia/jakarta');

			echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>BUKA KASIR</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
				
						<form method=POST action='$aksi?module=shiftkerja&act=input_shiftkerja' enctype='multipart/form-data' class='form-horizontal'>
						
						<input type=hidden name='id_shift' id='id_shift' value='0'>
					    <input type=hidden name='petugasbuka' id='petugasbuka' value='$petugas'>
					    <input type=hidden name='tanggal' id='tanggal' value='$tglharini'>
					    <input type=hidden name='waktubuka' id='waktubuka' value='$waktu'>
					    <input type=hidden name='status' id='status' value='ON'>
							  
							   
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>SHIFT</label>        		
									 <div class='col-sm-3'>
										<select name='shift' class='form-control' >
											<option value='1'>SHIFT 1 </option>
											<option value='2'>SHIFT 2 </option>
											<option value='3'>SHIFT 3 </option>
										</select>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Saldo Awal</label>        		
									 <div class='col-sm-6'>
										<input type=text name='saldoawal' class='form-control' required='required' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-5'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-danger' type=button value=BATAL onclick=self.history.back()>
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>";


			break;
		case "edit":

			$edit = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM waktukerja WHERE id_shift='$_GET[id]'");
			$r = mysqli_fetch_array($edit);


			$tglharini = date('Y-m-d');
			$cekganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM waktukerja WHERE tanggal ='$tglharini' 
        and status='ON'");
			$ada = mysqli_num_rows($cekganda);
			if ($ada < 1) {
				echo "<script type='text/javascript'>alert('Kasir sudah ditutup!');history.go(-1);</script>";
			} else {

				$petugas = $_SESSION['namalengkap'];
				$waktu = date('H:i:s');
				$edit = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM waktukerja WHERE tanggal='$tglharini' and status='ON' ");
				$r = mysqli_fetch_array($edit);
				$shiftbaru = $r['shift'];
				$tanggalbaru = $r['tanggal'];




				echo "
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>TUTUP KASIR</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
						<form method=POST action=$aksi?module=shiftkerja&act=update_waktukerja  enctype='multipart/form-data' class='form-horizontal'>
							  						 
                              <input type=hidden name='petugastutup' id='petugastutup' value='$petugas'>                              
                              <input type=hidden name='waktututup' id='waktututup' value='$waktu'>
                              <input type=hidden name='shift' id='shift' value='$shiftbaru'>
                              <input type=hidden name='tanggal' id='tanggal' value='$tanggalbaru'>
                              <input type=hidden name='status' id='status' value='OFF'>
							  
							  
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Saldo Akhir</label>        		
									 <div class='col-sm-6'>
										<input type=text name='saldoakhir' class='form-control' value='$r[saldoakhir]' autocomplete='off'>
										
									 </div>
							  </div>
							  
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-5'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-danger' type=button value=BATAL onclick=self.history.back()>
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>";
			}



			break;

		case "editkoreksi":
			$edit = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM waktukerja WHERE id_shift='$_GET[id]'");
			$r = mysqli_fetch_array($edit);

			$petugas = $_SESSION['namalengkap'];
			$waktu = date('H:i:s');

			echo "
		  <div class='box box-danger box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>TUTUP KASIR KOREKSI</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body table-responsive'>
						<form method=POST action=$aksi?module=shiftkerja&act=update_waktukerjakoreksi  enctype='multipart/form-data' class='form-horizontal'>
						  <input type=hidden name=id value='$r[id_shift]'>
						  
							   <div class='form-group'>
									<label class='col-sm-2 control-label'>Petugas Buka</label>        		
									 <div class='col-sm-6'>
										<input type=text name='petugasbuka' class='form-control' value='$r[petugasbuka]' autocomplete='off'>
									 </div>
							  </div>
							  
							 <div class='form-group'>
									<label class='col-sm-2 control-label'>Petugas Tutup</label>        		
									 <div class='col-sm-6'>
										<select name='petugastutup' type=text class='form-control' >";
			$tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM admin ORDER BY nama_lengkap ASC");
			while ($rk = mysqli_fetch_array($tampil)) {
				echo "<option value='$rk[nama_lengkap]'>$rk[nama_lengkap]</option>";
			}
			echo "</select>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>SHIFT</label>        		
									 <div class='col-sm-6'>
										<select name='shift' class='form-control' >
											<option value='1'>SHIFT 1 </option>
											<option value='2'>SHIFT 2 </option>
											<option value='3'>SHIFT 3 </option>
										</select>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Tanggal</label>        		
									 <div class='col-sm-6'>
										<input type=date name='tanggal' class='form-control' value='$r[tanggal]' autocomplete='off'>									
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Waktu Buka</label>        		
									 <div class='col-sm-6'>
										<input type=time name='waktubuka' class='form-control' value='$r[waktubuka]' autocomplete='off'>									
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Waktu Tutup</label>        		
									 <div class='col-sm-6'>
										<input type=time name='waktututup' class='form-control' value='$r[waktututup]' autocomplete='off'>									
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Saldo Awal</label>        		
									 <div class='col-sm-6'>
										<input type=text name='saldoawal' class='form-control' value='$r[saldoawal]' autocomplete='off'>									
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Saldo Akhir</label>        		
									 <div class='col-sm-6'>
										<input type=text name='saldoakhir' class='form-control' value='$r[saldoakhir]' autocomplete='off'>									
									 </div>
							  </div>
							   
							   <div class='form-group'>
									<label class='col-sm-2 control-label'>Status</label>        		
									 <div class='col-sm-6'>
										<select name='status' class='form-control' >
											<option value='OFF'>OFF</option>
											<option value='ON'>ON</option>											
										</select>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'></label>       
										<div class='col-sm-5'>
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

<script type="text/javascript">
	$(function() {
		$(".datepicker").datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
		});
	});
</script>