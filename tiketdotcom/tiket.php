<?php
$KodeAsal       = $_GET['kodeasal'];
$NamaAsal       = $_GET['namaasal'];
$KodeTujuan     = $_GET['kodetujuan'];
$NamaTujuan     = $_GET['namatujuan'];
$Tanggal    = $_GET['tanggal'];

$Secret		= '87ec16a248fa7088b0a489b8dad4d03b';

function cariHari($tanggal)
{
	mysql_connect("localhost","root","");
	mysql_select_db("tiket");
	$query = "SELECT datediff('$tanggal', CURDATE()) as selisih";
	$hasil = mysql_query($query);
	$data  = mysql_fetch_array($hasil);
	$selisih = $data['selisih'];
	$x= mktime(0, 0, 0, date("m"), date("d")+$selisih, date("Y"));
	$namahari = date("l", $x);
	if ($namahari == "Sunday") $namahari = "Minggu";
	else if ($namahari == "Monday") $namahari = "Senin";
	else if ($namahari == "Tuesday") $namahari = "Selasa";
	else if ($namahari == "Wednesday") $namahari = "Rabu";
	else if ($namahari == "Thursday") $namahari = "Kamis";
	else if ($namahari == "Friday") $namahari = "Jumat";
	else if ($namahari == "Saturday") $namahari = "Sabtu";
	return $namahari;
}
$GetToken = "http://api.master18.tiket.com/apiv1/payexpress?method=getToken&secretkey=".$Secret."&output=json";
$TokenJSON=json_decode(file_get_contents($GetToken), true);
$Token=$TokenJSON['token'];
$jsonfile = "http://api.master18.tiket.com/search/flight?d=".$KodeAsal."&a=".$KodeTujuan."&date=".$Tanggal."&adult=1&child=0&infant=0&ret_date=&token=".$Token."&output=json";
$data = json_decode(file_get_contents($jsonfile), true);
if (isset($data['departures']['result'])){
	$n=count($data['departures']['result']);
}else{
	$n=0;
}

function formatRupiah($nilaiUang)
{
  $nilaiRupiah 	   = "";
  $jumlahAngka  = strlen($nilaiUang);
  while($jumlahAngka > 3)
  {
    $nilaiRupiah    = "." . substr($nilaiUang,-3) . $nilaiRupiah;
    $sisaNilai         = strlen($nilaiUang) - 3;
    $nilaiUang       = substr($nilaiUang,0,$sisaNilai);
    $jumlahAngka = strlen($nilaiUang);
  }
  $nilaiRupiah       = "IDR " . $nilaiUang . $nilaiRupiah.",00";
  return $nilaiRupiah;
}
?>
<center>
Jadwal Penerbangan dari <b><?php echo $NamaAsal;?></b> menuju <b><?php echo $NamaTujuan;?></b> Hari <b><?php echo cariHari($Tanggal);?></b>, Tanggal <b><?php echo $Tanggal;?></b>
<?php if ($n!=0) {?>
<table border="1">
<tr>
	<th colspan="2">Pesawat</th>
	<th>Pergi</th>
	<th>Tiba</th>
	<th>Transit</th>
	<th>Durasi</th>
	<th colspan="2">Harga</th>
</tr>

<?php 
	for ($i=0;$i<$n; $i++){
?>
<tr>
	<td><img src="<?php echo $data['departures']['result'][$i]['image'];?>" title="<?php echo $data['departures']['result'][$i]['airlines_name'];?>" /></td>
	<td><b><?php echo $data['departures']['result'][$i]['flight_number'];?></b></td>
	<td><?php echo $data['departures']['result'][$i]['simple_departure_time'];?></td>
	<td><?php echo $data['departures']['result'][$i]['simple_arrival_time'];?></td>
	<td><?php echo $data['departures']['result'][$i]['stop'];?></td>
	<td><?php echo $data['departures']['result'][$i]['duration'];?></td>
	<td>
		<font color="green"><b>
		<?php 
			$harga=$data['departures']['result'][$i]['price_value'];
			$find='.00';
			$replace='';
			$harga=str_replace($find,$replace,$harga);
			$harga=formatRupiah($harga);
			echo $harga;
		?>
		</b></font><br />
		per orang		
	</td>
	<td>
		<button onclick="window.location.href='http://www.tiket.com/?twh=19566524'">Pilih</button>
	</td>	
</tr>
<?php }?>
</table>
<?php }else{echo '<h3>TIDAK ADA</h3>';}?>
</center>
