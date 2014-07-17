<html>
<head>
	<title>Website API Tiket.com</title>
	<link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script>
	 $(document).ready(function () {	
		$("#loading").hide();
		$("#button").click( function()
           {
			 var kodeasal=$("#asal").val();
			 var namaasal=$("#asal :selected").text();
			 var kodetujuan=$("#tujuan").val();
			 var namatujuan=$("#tujuan :selected").text();
			 var tanggal=$("#datepicker").val();
			 $("#terbang").hide();
			 $("#loading").show();
             $.ajax({
				type:"GET",
				url:"tiket.php",
				data:"kodeasal="+kodeasal+"&namaasal="+namaasal+"&kodetujuan="+kodetujuan+"&namatujuan="+namatujuan+"&tanggal="+tanggal,
				success:function(data)
				{
					$("#terbang").show();
					$("#terbang").html(data);
					$("#loading").hide();
				}
			 });
           }
        );
	});
	</script>
</head>
<body>
	<div id="cari" style="text-align:center;margin-bottom:10px;">
	<select id="asal">
		<option value="BPN">BalikPapan</option>
		<option value="BTH">Batam</option>
		<option value="DPS">Denpasar, Bali</option>
		<option value="CGK" selected="">Jakarta</option>
		<option value="MES">Medan</option>
		<option value="PDG">Padang</option>
		<option value="PKU">Pekanbaru</option>
		<option value="SUB">Surabaya</option>
		<option value="UPG">UjungPandang, Makassar</option>
		<option value="JOG">Yogyakarta</option>
	</select>
    <select id="tujuan">
		<option value="BPN">BalikPapan</option>
		<option value="BTH">Batam</option>
		<option value="DPS" selected="">Denpasar, Bali</option>
		<option value="CGK">Jakarta</option>
		<option value="MES">Medan</option>
		<option value="PDG">Padang</option>
		<option value="PKU">Pekanbaru</option>
		<option value="SUB">Surabaya</option>
		<option value="UPG">UjungPandang, Makassar</option>
		<option value="JOG">Yogyakarta</option>
	</select>
	<input id="datepicker" type="text" />
	<img src="calender.png" height="15" />
	<button id="button">Cari Tiket</button>
	</div>
	<div id="terbang"></div>	
	<div id="loading"style="text-align:center;margin-top:70px;"><img src="ajax-loader.gif" /></div>
	<script>
		$(function(){
			$.datepicker.setDefaults(
				$.extend($.datepicker.regional[''])
			);
			$('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
</body>
</html>