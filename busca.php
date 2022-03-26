<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Busca por medicamentos - LocaFarma</title>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.24/themes/excite-bike/jquery-ui.css"/>
 		<script src="//code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="icon" href="./imagens/icone.png">
		<script type="text/javascript" src="./js/mascara.js"></script>
	</head>
	<body>
		
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->

			<p class="titulu">Faça sua busca por medicamentos aqui:</p>
			
			<div class="form-style-6">
				<h1>LocaFarma</h1>
				<form name="form1" action="info.php?valor=enviado" method="POST">
					<input type="text" name="txtCep" maxlength="10" placeholder="✉ CEP" autofocus required onkeydown="javascript: fMasc( this, mCEP );"/>
					<input type="text" id="txtMedicamento" name="txtMedicamento" placeholder="✚ Medicamento" required/>
					<input name="botao" type="submit" value="Pesquisar" style="cursor:pointer;"/>
				</form>
			</div>

    		<script type="text/javascript">
			$(document).ready(function() 
			{
				// Captura o retorno do retornaMed.php
				$.getJSON('retornaMed.php', function(data)
				{
					var dados = [];
					 
					// Armazena na array capturando somente o nome do medicamento
					$(data).each(function(key, value) 
					{
						dados.push(value.nome);
					});
					
					// Chamo o Auto complete do JQuery ui setando o id do input, array com os dados e o mínimo de caracteres para disparar o AutoComplete
					$('#txtMedicamento').autocomplete({ 
						source: dados, 
						minLength: 1
					});
				});
			});
			</script>

			<br><br><br><br><br><br><br><br><br><br><br><br><br>
			
			<?php include './templates/rodape.php'; ?>
    		<script src="./js/navsticky.js"></script>
	</body>
</html>
