<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_setheader/aksi_setheader.php";
$aksi_setheader = "masuk/modul/mod_setheader/aksi_setheader.php";
switch($_GET[act]){
  // Tampil Siswa
  default:

    
	$edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM setheader");
		$r=mysqli_fetch_array($edit);
			
		echo "
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>SETTING HEADER CETAK STRUK</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
						<form method=POST method=POST action=$aksi?module=setheader&act=update_setheader  enctype='multipart/form-data' class='form-horizontal'>
							  <input type=hidden name=id value='$r[id_setheader]'>
							  
							  <h3 class='box-title'>HEADER STRUK</h3>
							  <legend class='scheduler-border'></legend>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 1</label>        		
									 <div class='col-sm-6'>
										<input type=text name='satu' class='form-control' value='$r[satu]' autocomplete='off'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 2</label>        		
									 <div class='col-sm-6'>
										<input type=text name='dua' class='form-control' value='$r[dua]' autocomplete='off'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 3</label>        		
									 <div class='col-sm-6'>
										<input type=text name='tiga' class='form-control' value='$r[tiga]' autocomplete='off'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 4</label>        		
									 <div class='col-sm-6'>
										<input type=text name='empat' class='form-control' value='$r[empat]' autocomplete='off'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 5</label>        		
									 <div class='col-sm-6'>
										<input type=text name='lima' class='form-control' value='$r[lima]' autocomplete='off'>
									 </div>
							  </div>
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 6</label>        		
									 <div class='col-sm-6'>
										<input type=text name='enam' class='form-control' value='$r[enam]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 7</label>        		
									 <div class='col-sm-6'>
										<input type=text name='tujuh' class='form-control' value='$r[tujuh]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <h3 class='box-title'>FOOTER STRUK</h3>
							  <legend class='scheduler-border'></legend>
							  
							   <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 1</label>        		
									 <div class='col-sm-6'>
										<input type=text name='delapan' class='form-control' value='$r[delapan]' autocomplete='off'>
									 </div>
							  </div>
							  
							   <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 2</label>        		
									 <div class='col-sm-6'>
										<input type=text name='sembilan' class='form-control' value='$r[sembilan]' autocomplete='off'>
									 </div>
							  </div>
							  
							   <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 3</label>        		
									 <div class='col-sm-6'>
										<input type=text name='sepuluh' class='form-control' value='$r[sepuluh]' autocomplete='off'>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Baris 4</label>        		
									 <div class='col-sm-6'>
										<input type=text name='sebelas' class='form-control' value='$r[sebelas]' autocomplete='off'>
										<p>
										<div class='col-sm-6'>
											<input class='btn btn-primary' type=submit value=SIMPAN>
											<input class='btn btn-danger' type=button value=BATAL onclick=self.history.back()>
										</div>
									 </div>
							  </div>
								
							  </form>
							  
				</div> 
				
			</div>";	

 
    
    break;


}
}
?>