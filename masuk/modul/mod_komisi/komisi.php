<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_komisi/aksi_komisi.php";

switch($_GET['act']){
  // tampil satuan
  default:

  
      $tampil_komisi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang WHERE komisi != 0");
      
	  ?>
			
			
			<div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">TAMBAH DAN TUTUP KOMISI</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body table-responsive">
				    <?php if($_SESSION['level'] == 'pemilik'):?>
					<a  class ='btn  btn-success btn-flat' href='?module=komisi&act=tambah'>TAMBAH KOMISI</a>
					<a  class ='btn  btn-warning btn-flat' href='<?=$aksi."?module=komisi&act=hapus&id=all"?>'>HAPUS SEMUA KOMISI</a>
					<a  class ='btn  btn-danger btn-flat' href='?module=komisi&act=tutupkomisi'>TUTUP KOMISI</a>
                    <?php endif;?>

					<br><br>
					
					
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Barang</th>
								<th style="text-align: right; ">Qty/Stok</th>
								<th style="text-align: right; ">Satuan</th>
								<th style="text-align: center; ">Jenis Obat</th>
								<th style="text-align: right; ">Harga Jual</th>
								<th style="text-align: right; ">Komisi Pegawai</th>
								<?php
                                $lupa = $_SESSION['level'];
                                if($lupa=='pemilik')
                                { echo "<th>Aksi</th> "; }
                                else{}
                                ?>
							</tr>
						</thead>
						<tbody>
						    <?php
						        $no=1;
						        while($r = mysqli_fetch_array($tampil_komisi)):
						            $hargajual = format_rupiah($r['hrgjual_barang']);
						            $komisi = format_rupiah($r['komisi']);
						    ?>
						    <tr>
								<td><?=$no++?></td>
								<td><?=$r['kd_barang']?></td>
								<td><?=$r['nm_barang']?></th>
								<td style="text-align: center; "><?=$r['stok_barang']?></td>
								<td style="text-align: center; "><?=$r['sat_barang']?></td>
								<td style="text-align: center; "><?=$r['jenisobat']?></td>
								<td style="text-align: right; "><?=$hargajual?></td>
								<td style="text-align: right; "><?=$komisi?></td>
								<?php
                                $lupa = $_SESSION['level'];
                                if($lupa=='pemilik'):
                                ?>
                                <td style="width: 80px; text-align: center">
                                    <a href="?module=komisi&act=editkomisi&id=<?=$r['id_barang']?>" title="EDIT" class="glyphicon glyphicon-pencil">&nbsp</a> 
									<a href="javascript:confirmdelete('<?=$aksi."?module=komisi&act=hapus&id=".$r['id_barang']?>')" title="HAPUS" class="glyphicon glyphicon-remove">&nbsp</a>
								</td>
                                <?php endif;?>
							</tr>
						    <?php
						        endwhile;
						    ?>
						</tbody>
					</table>
				</div>
			</div>	
             

<?php
    
    break;
	
	case "tambah":
        
?>        
		  <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>TAMBAH KOMISI</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
				
						<form method="POST" action="<?=$aksi?>?module=komisi&act=input_komisi" enctype="multipart/form-data" class="form-horizontal">
							   
							  <div class='form-group'>
									<label class="col-sm-2 control-label">NAMA BARANG</label>        		
									 <div class="col-sm-3">
										<!--<select name="barang" class="form-control js-example-basic-single" >-->
										<!--	<option value="all">All</option>-->
										    <?php
										      //  $getbarang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY id_barang ASC");
										      //  while($br = mysqli_fetch_array($getbarang)):
										    ?>
											<!--<option value="<?=$br['id_barang']?>"><?=$br['nm_barang']?></option>-->
										    <?php
										      //  endwhile;
										    ?>
										</select>
										<input type="text" name="barang" id="barang" class="form-control typeahead" required="required" autocomplete="off">
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class="col-sm-2 control-label">&nbsp</label>        		
									 <div class="col-sm-3">
										<select name="metode" class="form-control" >
											<option value="nominal">Nominal</option>
											<option value="persentase">Persentase</option>
										</select>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>JUMLAH KOMISI</label>        		
									 <div class='col-sm-6'>
										<input type="number" name="komisi" class="form-control" required="required" autocomplete="off">
									 </div>
							  </div>
							  
							  <div class="form-group">
									<label class="col-sm-2 control-label"></label>       
										<div class="col-sm-5">
											<input class="btn btn-primary" type="submit" value="SIMPAN">
											<input class="btn btn-danger" type="button" value="BATAL" onclick="self.history.back()">
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>
			
			<script>
		        $('#barang').typeahead({
            		source: function(query, process) {
            			return $.post('modul/mod_komisi/autonamabarang.php', {
            				query: query
            			}, function(data) {
            
            				data = $.parseJSON(data);
            				return process(data);
            
            			});
            		}
            	});

		    </script>		
		    
					
<?php	
    break;
    case "editkomisi":

        $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang WHERE id_barang='$_GET[id]'");
        $r=mysqli_fetch_array($edit);

?>
        

            <div class='box box-primary box-solid'>
				<div class='box-header with-border'>
					<h3 class='box-title'>EDIT KOMISI</h3>
					<div class='box-tools pull-right'>
						<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class='box-body'>
				
						<form method="POST" action="<?=$aksi?>?module=komisi&act=update_komisi" enctype="multipart/form-data" class="form-horizontal">
							   
							  <div class='form-group'>
									<label class="col-sm-2 control-label">NAMA BARANG</label>        		
									 <div class="col-sm-3">
										<select name="barang" class="form-control js-example-basic-single" >
											<option value="<?=$r['id_barang']?>"><?=$r['nm_barang']?></option>
										</select>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class="col-sm-2 control-label">&nbsp</label>        		
									 <div class="col-sm-3">
										<select name="metode" class="form-control" >
											<option value="nominal">Nominal</option>
											<option value="persentase">Persentase</option>
										</select>
									 </div>
							  </div>
							  
							  <div class='form-group'>
									<label class='col-sm-2 control-label'>Jumlah Komisi</label>        		
									 <div class='col-sm-6'>
										<input type="number" name="komisi" class="form-control" required="required" value="<?=$r['komisi']?>" autocomplete="off">
									 </div>
							  </div>
							  
							  <div class="form-group">
									<label class="col-sm-2 control-label"></label>       
										<div class="col-sm-5">
											<input class="btn btn-primary" type="submit" value="SIMPAN">
											<input class="btn btn-danger" type="button" value="BATAL" onclick="self.history.back()">
										</div>
								</div>
								
							  </form>
							  
				</div> 
				
			</div>
		
<?php
        break;

  case "tutupkomisi":
      $staff = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM admin WHERE akses_level = 'petugas' ORDER BY id_admin ASC");
      
?>
      
      <div class="box box-primary box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">TUTUP KOMISI</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body table-responsive">
				    
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Telp/HP</th>
								<th>Start Date</th>
								<th>Finish Date</th>
								<th style="text-align: right; ">Total Komisi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						    <?php
						        $no=1;
						        while($r = mysqli_fetch_array($staff)):
						            
						            $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT SUM(ttl_komisi) as total_komisi, MIN(tgl_komisi) as min_date, MAX(tgl_komisi) as max_date
						                FROM komisi_pegawai WHERE id_admin = '$r[id_admin]' AND status_komisi = 'on'");
						          
						            $kms = mysqli_fetch_array($query);
						    ?>
						    <tr>
								<td><?=$no++?></td>
								<td><?=$r['nama_lengkap']?></td>
								<td><?=$r['no_telp']?></th>
								<td style="text-align: center; "><?=$kms['min_date']?></td>
								<td style="text-align: center; "><?=$kms['max_date']?></td>
								<td style="text-align: right; "><?=format_rupiah($kms['total_komisi'])?></td>
								<td style="width: 80px; text-align: center">
								    <?php if($kms['total_komisi'] > 0):?>
                                        <a href="<?=$aksi?>?module=komisi&act=close&id=<?=$r['id_admin']?>" title="closed" class="btn btn-primary">CLOSED</a> 
								    <?php else:?>
                                        <a href="#" title="closed" class="btn btn-primary" disabled>CLOSED</a> 
								    <?php endif;?>
								</td>
                                
							</tr>
						    <?php
						        endwhile;
						    ?>
						</tbody>
					</table>
				</div>
			</div>	
            
<?php
    
    break;




}
}
?>

<script type="text/javascript">
    $(function(){
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    });
 
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>