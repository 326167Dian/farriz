<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_lapstok/aksi_barang.php";
$aksi_barang = "masuk/modul/mod_lapstok/aksi_barang.php";
switch($_GET[act]){
  // Tampil barang
  default:

  
      $tampil_barang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY barang.id_barang ");
      
	  ?>
			
			
			<div class="box box-primary box-solid table-responsive">
				<div class="box-header with-border">
					<h3 class="box-title">KOREKSI STOK</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
					<a  class ='btn  btn-success btn-flat' href='modul/mod_lapstok/sinkronisasi_stok.php'>SINKRONISASI</a>
                      <!--  <a class='btn  btn-danger btn-flat' href='?module=koreksistok&act=edit'>KOREKSI STOK AWAL</a> -->
                       
					<table id="example1" class="table table-bordered table-striped" >
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Barang</th>
								<th style="text-align: right; ">Masuk</th>
								<th style="text-align: right; ">Keluar</th>
								<th style="text-align: center; ">Selisih</th>
								<th style="text-align: center; ">Stok</br>Barang</th>
								<th width="70">Koreksi Stok</th>
							</tr>
						</thead>
						<tbody>
						<?php 
								$no=1;
								while ($r=mysqli_fetch_array($tampil_barang)){

                                $beli = "SELECT trbmasuk.tgl_trbmasuk,                                           
                                       SUM(trbmasuk_detail.qty_dtrbmasuk) AS totalbeli                                            
                                       FROM trbmasuk_detail join trbmasuk 
                                       on (trbmasuk_detail.kd_trbmasuk=trbmasuk.kd_trbmasuk)
                                       WHERE kd_barang =$r[kd_barang]" ;
                                $buy = mysqli_query($GLOBALS["___mysqli_ston"],$beli);
                                $buy2 = mysqli_fetch_array($buy);

                                $jual = "SELECT trkasir.tgl_trkasir,                                
                                        sum(trkasir_detail.qty_dtrkasir) AS totaljual
                                        FROM trkasir_detail join trkasir 
                                        on (trkasir_detail.kd_trkasir=trkasir.kd_trkasir)
                                        WHERE kd_barang =$r[kd_barang]" ;
                                $jokul = mysqli_query($GLOBALS["___mysqli_ston"],$jual);
                                $sell = mysqli_fetch_array($jokul);
                                $selisih = $buy2[totalbeli]-$sell[totaljual];


									echo "<tr class='warnabaris' >
                                             <td>$no</td>                                    										     
											 <td>$r[kd_barang]</td>
											 <td>$r[nm_barang]</td>";
									if($buy2[totalbeli]<"0")
                                    {echo"<td align=center> 0 </td>";}
									else{echo "<td align=center>$buy2[totalbeli]</td>";}

									if($sell[totaljual]<"0")
                                    {echo"<td align=center> 0 </td>";}
									else{echo "<td align=center>$sell[totaljual]</td>";}
									echo" <td align=center>$selisih</td>";

									if($selisih==$r[stok_barang])
                                        {echo "<td align=right>$r[stok_barang]</td>";}
									else{echo"<td style='background-color:#ffbf00; text-align: right;'>$r[stok_barang]</td>";}
									echo"	 	
											 <td style='text-align: center;'><a href='?module=koreksistok&act=edit&id=$r[id_barang]' title='EDIT' class='btn btn-primary btn-xs'>KOREKSI</a> 	
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

  case "edit":
      $tampil_barang = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM barang ORDER BY barang.id_barang ");
      ?>

    <div class="box box-success box-solid table-responsive">
				<div class="box-header with-border">
					<h3 class="box-title">KOREKSI STOK AWAL</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						
                    </div><!-- /.box-tools -->
				</div>
				<div class="box-body">
                        <a class='btn  btn-primary btn-flat' href='modul/mod_lapstok/sinkronisasi_stok_awal.php'>SINKRONISASI STOK AWAL</a>
                        <input class='btn btn-danger' type='button' value=KEMBALI onclick=self.history.back()>
                        <BR> KOREKSI STOK AWAL HANYA BISA <STRONG>SEKALI</STRONG> SETELAH SEMUA ITEM DIINPUT DENGAN LENGKAP
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Nama Barang</th>
								<th style="text-align: center; ">Penjualan lebih cepat</th>
								<th style="text-align: center; ">Stok Masuk</th>
								<th style="text-align: center; ">Penjualan Setelah<br> Stok Masuk</th>
								<th style="text-align: center; ">Stok Barang Real</th>
								<th width="70">Koreksi Stok</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($r = mysqli_fetch_array($tampil_barang)) {
                                $r1=$r[kd_barang];
                                $tampilmasuk = mysqli_query($GLOBALS["___mysqli_ston"],"select sum(qty_dtrbmasuk) as subtotal,min(waktu) as masukawal from trbmasuk_detail
                                                where kd_barang=$r1 ");
                                $masuk = mysqli_fetch_array($tampilmasuk);
                                $masuk1 = $masuk[subtotal];
                                $masuk2 = $masuk[masukawal];

                                $tampilkeluar = mysqli_query($GLOBALS["___mysqli_ston"],
                                    "select min(waktu) as keluarawal, max(waktu) as keluarakhir from trkasir_detail where kd_barang=$r1");
                                $keluar = mysqli_fetch_array($tampilkeluar);
                                $keluar1= $keluar[keluarawal];
                                $keluar2= $keluar[keluarakhir];

                                if ($keluar1<$masuk2)
                                  { $patokan = $masuk2;}
                                else
                                  {$patokan = $keluar1;}
                                $transaksi_atas = mysqli_query($GLOBALS["___mysqli_ston"],
                                          "select sum(qty_dtrkasir) as qty_atas from trkasir_detail 
                                                where kd_barang=$r1 and waktu between '$keluar1' and '$masuk2'");
                                $qty_atas2= mysqli_fetch_array($transaksi_atas);
                                $qty_atas3= $qty_atas2[qty_atas];

                                $transaksi_bawah = mysqli_query($GLOBALS["___mysqli_ston"],
                                    "select sum(qty_dtrkasir) as qty_bawah from trkasir_detail 
                                                where kd_barang=$r1 and waktu between '$masuk2' and '$keluar2'");
                                $qty_bawah2= mysqli_fetch_array($transaksi_bawah);
                                $qty_bawah3= $qty_bawah2[qty_bawah];
                                $stok_real = $qty_atas3 + $masuk1 - ($qty_atas3+$qty_bawah3);

								echo "<tr class='warnabaris' >
                                             <td>$no</td>                                    										     
											 <td>$r[kd_barang]</td>
											 <td>$r[nm_barang]</td>
											 <td align='center'>$qty_atas3</td>
											 <td align='center'>$masuk1</td>
											 <td align='center'>$qty_bawah3</td>
											 <td align='center'>$stok_real</td>
											 <td style='text-align: center;'><a href='?module=koreksistok&act=edit&id=$r[id_barang]' title='EDIT' class='btn btn-primary btn-xs'>KOREKSI</a> 	
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
 <script type="text/javascript" src="..vendors/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var editor = CKEDITOR.replace("content", {
        filebrowserBrowseUrl    : '',
        filebrowserWindowWidth  : 1000,
        filebrowserWindowHeight : 500
    });
    </script>