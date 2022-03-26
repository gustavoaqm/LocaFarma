<?php 
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Sobre nós - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/sobre.css">
		<link rel="icon" href="./imagens/icone.png">
	</head>
	<body>
		
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->
			
			<p class="titulu"> Sobre Nós</p>

			<center><div class="conteudo">
			<img src="./imagens/quem-somos.png" class="triangulo" style="width: 50%;" />
			<p class="sobretitulo">
			    - LocaFarma -
			</p>
			
			<p>A LocaFarma é um website, criado em 2020, por um grupo de jovens da Etec Lauro Gomes com a ideia de facilitar e minimizar o tempo de busca de medicamentos. O qual se faz de extrema importância na realidade atual de nossa sociedade! Este site conjuga rapidez e eficiência para você que não deseja perder tempo no dia a dia.
			Aqui nós queremos garantir que você tenha a melhor experiência, logo priorizamos a comodidade do usuário, trazendo informações, disponibilidade e localização do medicamento que deseja em apenas uma só plataforma.
			<br><br>
			Esperamos que você goste de nossos serviços tanto quanto gostamos de oferecer a você. Se você tiver alguma dúvida ou sugestão de funcionalidade, não hesite em nos <strong><a href="faleconosco.php" class="contactar" >contactar</a></strong>.<br><br>

			Atenciosamente,
			Equipe Locafarma.
			</p>
			</div></center>

			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			
			</div>

			<?php include './templates/rodape.php'; ?>
    		<script src="./js/navsticky.js"></script>
	</body>
</html>