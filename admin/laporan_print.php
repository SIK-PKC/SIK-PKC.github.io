<?php error_reporting (0); ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>BKU DANA BLUD</title>
 	<link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">

 </head>
 <html>
<head>
    <style type= "text/css">
    /* body {font-family: arial; background-color : #ccc }
    .rangkasurat {width : 980px;margin:0 auto;background-color : #fff;height: 500px;padding: 20px;} */
    /* table {border-bottom : 5px solid # 000; padding: 5px} */
    .tengah {text-align : center;line-height: 8px;}
     </style >
</head>
<body>
<div class = "rangkasurat">
     <table width = "100%">
           <tr>
                 <td> <img src="/SIK-PKC/gambar/sistem/jayaraya.png" width="120px"> </td>
                 <!-- <td><div class="text-left"> <img src="SIK-PKC/gambar/sistem/jayaraya.png" style="max-width:30%;"></td> -->
                 <td class = "tengah">
                       <h4>PEMERINTAH DAERAH PROVINSI DKI JAKARTA</h4>
                       <h4>DINAS KESEHATAN</h4>
                       <h4>PUSAT KESEHATAN MASYARAKAT KECAMATAN CENGKARENG</h4>
                       <h3>KOTA ADMINISTRASI JAKARTA BARAT</h3>
                       <h3>JAKARTA</h3>
                       <b>Jalan Raya Kamal No. 2 Cengkareng Jakarta Barat Telp . ( 021 ) 59329583 Jakarta 11730</b>
                 </td>
            </tr>
     </table >
</div>
</body>
</html>
<hr size="10px">
<hr size="10px" />
</style>
<br/>
 	<center>
 		<h4>LAPORAN</h4>
 		<h4>BKU DANA BLUD</h4>
 	</center>


 	<?php 
 	if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari']) && isset($_GET['kategori'])){
 		$tgl_dari = $_GET['tanggal_dari'];
 		$tgl_sampai = $_GET['tanggal_sampai'];
 		$kategori = $_GET['kategori'];
 		?>

 		<div class="row">
 			<div class="col-lg-6">
 				<table class="table table-bordered">
 					<tr>
 						<th width="30%">DARI TANGGAL</th>
 						<th width="1%">:</th>
 						<td><?php echo date('d-m-Y',strtotime($tgl_dari)); ?></td>
 					</tr>
 					<tr>
 						<th>SAMPAI TANGGAL</th>
 						<th>:</th>
 						<td><?php echo date('d-m-Y',strtotime($tgl_sampai)); ?></td>
 					</tr>
 					<!-- <tr>
 						<th>KATEGORI</th>
 						<th>:</th>
 						<td> -->
 							<?php 
 							if($kategori == "semua"){
 								echo "SEMUA KATEGORI";
 							}else{
 								$k = mysqli_query($koneksi,"select * from kategori where kategori_id='$kategori'");
 								$kk = mysqli_fetch_assoc($k);
 								echo $kk['kategori'];
 							}
						
 							?>

 						</td>
 					</tr>
 				</table>

 			</div>
 		</div>

 		<div class="table-responsive">
 			<table class="table table-bordered table-striped">
 				<thead>
 					<tr>
 						<th width="1%" rowspan="2">NO BKU</th>
 						<th width="10%" rowspan="2" class="text-center">TANGGAL</th>
 						<th rowspan="2" class="text-center">KATEGORI</th>
 						<th rowspan="2" class="text-center">KETERANGAN</th>
 						<th colspan="2" class="text-center">JENIS TRANSAKSI</th>
 					</tr>
 					<tr>
 						<th class="text-center">DEBET</th>
 						<th class="text-center">KREDIT</th>
 					</tr>
 				</thead>
 				<tbody>
 					<?php 
 					include '../koneksi.php';
 					$no=1;
 					$total_pemasukan=0;
 					$total_pengeluaran=0;
 					if($kategori == "semua"){
 						$data = mysqli_query($koneksi,"SELECT * FROM transaksi,kategori where kategori_id=transaksi_kategori and date(transaksi_tanggal)>='$tgl_dari' and date(transaksi_tanggal)<='$tgl_sampai'");
 					}else{
 						$data = mysqli_query($koneksi,"SELECT * FROM transaksi,kategori where kategori_id=transaksi_kategori and kategori_id='$kategori' and date(transaksi_tanggal)>='$tgl_dari' and date(transaksi_tanggal)<='$tgl_sampai'");
 					}
 					while($d = mysqli_fetch_array($data)){

 						if($d['transaksi_jenis'] == "Pemasukan"){
 							$total_pemasukan += $d['transaksi_nominal'];
 						}elseif($d['transaksi_jenis'] == "Pengeluaran"){
 							$total_pengeluaran += $d['transaksi_nominal'];
 						}
 						?>
 						<tr>
 							<td class="text-center"><?php echo $no++; ?></td>
 							<td class="text-center"><?php echo date('d-m-Y', strtotime($d['transaksi_tanggal'])); ?></td>
 							<td><?php echo $d['kategori']; ?></td>
 							<td><?php echo $d['transaksi_keterangan']; ?></td>
 							<td class="text-center">
 								<?php 
 								if($d['transaksi_jenis'] == "Pemasukan"){
 									echo "Rp. ".number_format($d['transaksi_nominal'])." ,-";
 								}else{
 									echo "-";
 								}
 								?>
 							</td>
 							<td class="text-center">
 								<?php 
 								if($d['transaksi_jenis'] == "Pengeluaran"){
 									echo "Rp. ".number_format($d['transaksi_nominal'])." ,-";
 								}else{
 									echo "-";
 								}
 								?>
 							</td>
 						</tr>
 						<?php 
 					}
 					?>
 					<tr>
 						<th colspan="4" class="text-right">TOTAL</th>
 						<td class="text-center text-bold text-success"><?php echo "Rp. ".number_format($total_pemasukan)." ,-"; ?></td>
 						<td class="text-center text-bold text-danger"><?php echo "Rp. ".number_format($total_pengeluaran)." ,-"; ?></td>
 					</tr>
 					<tr>
 						<th colspan="4" class="text-right">SALDO</th>
 						<td colspan="2" class="text-center text-bold text-white bg-primary"><?php echo "Rp. ".number_format($total_pemasukan - $total_pengeluaran)." ,-"; ?></td>
 					</tr>
 				</tbody>
 			</table>

			 <br/>
    <br/>
	<div style="width: 400px;px;float:right">
  <td>Jakarta <?php echo date('d-m-Y',strtotime($tgl_sampai)); ?></td>
		<br/>Kepala Puskesmas Kecamatan Cengkareng 
    <br/>Kota Administrasi Jakarta Barat 
    <br/>
    <br/>
    <br/>
    <br/>
		<p>dr. Sulung Mulia Putra. MPH<br/>NIP. 198312062011011012</p>
	</div>
	<div style="clear:both"></div>
</div>

 		</div>

 		<?php 
 	}else{
 		?>

 		<div class="alert alert-info text-center">
 			Silahkan Filter Laporan Terlebih Dulu.
 		</div>

 		<?php
 	}
 	?>


 	<script>

 		window.print();
 		$(document).ready(function(){

 		});
 	</script>

 </body>
 </html>
