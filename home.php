<?php 
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="icon" href="./imagens/icone.png">
		<script src="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js"></script>
		<link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />
	</head>
	<body>
		<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>
		<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.css" type="text/css"/>
		<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
			
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->
			<div class="fundaumHome">
			<br><br><br><br>
			<img src="./imagens/banner.png" class="bannerHome">
			<br><br><br><br>
			

			<center><h1 class="bemvindoHome">Remédio para todos.</h1><br>
			<h1 class="bemvindoHome" style="font-size: 125%;"> Clique no botão abaixo para buscar por medicamentos em nossa plataforma!</h1><br>
			<br>
			<a href="busca.php"><button class="botaoHome">Prosseguir</button></a></center>
			<br><br><br><br><br><br><br><br>
			<br><br><br><br><br><br><br><br>
			<br><br><br><br><br><br><br><br>
			<br><br><br><br><br><br><br><br>
			
			
			</div>

			

			<?php include './templates/rodape.php'; ?>
    		<script src="./js/navsticky.js"></script>
	</body>
</html>