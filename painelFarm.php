<?php 
include 'conexao.php';
   // A sessão precisa ser iniciada em cada página diferente
  if (!isset($_SESSION)) session_start();

  // Verifica se não há a variável da sessão que identifica o usuário
  if (!isset($_SESSION['confirma_farm'])) 
  {
	  // Destrói a sessão por segurança
	  session_destroy();
	  // Redireciona o visitante de volta pro login
	  header("Location: login.php"); exit;
  }
  		$idFarm = $_SESSION["id_farm"];
  		$Comando=$conexao->prepare("SELECT * FROM tb_farmacia WHERE ID_FARM=?");
		$Comando->bindParam(1, $idFarm);

		if ($Comando->execute()) 
		{
			while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
			{
	            $nomeFarm = $Linha->NOME_FARM;
	            $_SESSION["nome"] = $nomeFarm;
			}	
		}
		else
		{
			throw new Exception("Erro ao efetuar a consulta.", 1);
		}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Painel Farmacêutico - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link rel="stylesheet" type="text/css" href="./css/painel.css">
		<link rel="stylesheet" type="text/css" href="./css/painelFarm.css">
		<link rel="icon" href="./imagens/icone.png">

		<script type="text/javascript" src="./js/mascara.js"></script>
	</head>
	<body>
		
		<?php 
		include './templates/navbar.php'; ?>
		
			<p class="titulu">Olá <?php echo $_SESSION["nome"]; ?>, seja bem-vinda(o) ao seu painel!</p>
			<p class="titulu" style="font-size: 80%;">Aqui você pode alterar seu cadastro, gerenciar seus medicamentos e visualizar os pedidos! Sinta-se livre para fazer o que quiser!</p> 

			<div class="tab">
			  <button class="tablinks" onclick="openCity(event, 'Medicamento')" id="abrirMedicamentos">Medicamentos</button>
			  <button class="tablinks" onclick="openCity(event, 'Cadastro')" id="abrirCadastroFarm">Cadastro</button>
			  <button class="tablinks" onclick="openCity(event, 'Pedidos')" id="abrirPedidos">Pedidos</button>
			</div>

			<div id="Medicamento" class="tabcontent">
				<?php include './CRUDS/crudMed.php'; ?>
			</div>

			<div id="Cadastro" class="tabcontent">
			  	<?php include './CRUDS/gerenciaCadFarm.php';?> 
			</div>

			<div id="Pedidos" class="tabcontent">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Aqui você poderá excluir os pedidos realizados pelos usuários, assim como avisá-los quando o medicamento estiver disponível!</b><br><br>
				<?php include './CRUDS/gerenciaPedidosFarm.php'; ?>
			</div>


			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			
			<script src="./js/painelfarm.js"></script>
			<script type="text/javascript">
		    	var med = document.getElementById("abrirMedicamentos").click();
				var cad = document.getElementById("abrirCadastroFarm");
				var ped = document.getElementById("abrirPedidos");

				if (opcao == "respUsu") 
				{
					ped.click();
				}

		    </script>

    		<script src="./js/navsticky.js"></script>
    		<?php include './templates/rodape.php'; ?>
	</body>
</html>

<?php

if (isset($_GET["acao"])) 
{
	if($_GET["acao"] == "sair")
	{
		session_destroy();
		header("location: login.php");
	}
}


?>