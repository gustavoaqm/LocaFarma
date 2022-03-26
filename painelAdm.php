<?php 

   // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) session_start();
    
  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['confirma_adm'])) 
  {
	  // Destrói a sessão por segurança
	  session_destroy();
	  // Redireciona o visitante de volta pro login
	  header("Location: login.php"); exit;
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Painel Administrativo - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link rel="stylesheet" type="text/css" href="./css/painel.css">
		<link rel="stylesheet" type="text/css" href="./css/painelFarm.css">
		<!-- <link rel="stylesheet" type="text/css" href="./css/painelAdm.css"> -->
		<link rel="icon" href="./imagens/icone.png">
		<script type="text/javascript" src="./js/mascara.js"></script>
		
	</head>
	<body>


			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->
			<p class="titulu">Olá <?php echo $_SESSION["nome"]; ?>, seja bem-vindo(a) ao seu painel administrativo!</p>
			<p class="titulu" style="font-size: 80%;">Aqui você pode alterar, inserir e excluir cadastros no site! Sinta-se livre para fazer o que quiser!</p> 

			<div class="tab">
			  <button class="tablinks" onclick="openCity(event, 'usuarios')" id="abrirUsuarios">Usuários</button>
			  <button class="tablinks" onclick="openCity(event, 'farmacias')" id="abrirFarmacias">Farmácias</button>
			  <button class="tablinks" onclick="openCity(event, 'sugestoes')" id="abrirSugestoes">Mensagens</button>
			</div>

			<div id="usuarios" class="tabcontent">	
				<?php include './CRUDS/gerenciaUsuAdm.php'; ?>
			</div>

			<div id="farmacias" class="tabcontent">
			  <?php include './CRUDS/gerenciaFarmAdm.php'; ?>
			</div>

			<div id="sugestoes" class="tabcontent">
			  <?php include './CRUDS/gerenciaSugestoes.php'; ?>
			</div>
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

			<script src="./js/painelfarm.js"></script>

			
			
			<script type="text/javascript">
		    	var usu = document.getElementById("abrirUsuarios").click();
				var farm = document.getElementById("abrirFarmacias");
				var sug = document.getElementById("abrirSugestoes");

				if (opcao == "farm") 
				{
					farm.click();
				}

		    </script>
			<?php include './templates/rodape.php'; ?>
    		<script src="./js/navsticky.js"></script>
	</body>
</html>