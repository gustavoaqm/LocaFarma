<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Esqueceu Senha - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link rel="icon" href="./imagens/icone.png">


		<script src="https://kit.fontawesome.com/977199c798.js" crossorigin="anonymous"></script>

	</head>
	<body>

	<?php
		if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
		{ 
			$Botao = $_POST["Botao"];
			$Email = $_POST["Email"];
			$opcao = $_POST["opcao"];

			if ($Botao == "Enviar")
			{ 

				include "conexao.php";

				if ($opcao == "opcao_usuario") 
				{
					$Comando=$conexao->prepare("SELECT ID_USU, NOME_USU, EMAIL_USU FROM TB_USUARIO WHERE EMAIL_USU=?");   
					$Comando->bindParam(1, $Email);

					if ($Comando->execute()) 
					{
						if ($Comando->rowCount() > 0) 
						{
							while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
		      				{
								$id = $Linha->ID_USU;
								$nome = $Linha->NOME_USU;
								$email = $Linha->EMAIL_USU;
								session_start();
								$_SESSION["opcao"] = $opcao; // Enviando a opção por session
								include './funcoes/solicitaEmail.php';
							}
						}
						else
						{
							echo "<script> alert('E-mail inválido e/ou não existente, porfavor insira outro!'); location.href='esqueceusenha.php'; </script>";
						}
					}
					else
					{
						throw new Exception("Error Processing Request", 1);
					}
				}

				if ($opcao == "opcao_farmacia") 
				{
					$Comando=$conexao->prepare("SELECT ID_FARM, NOME_FARM, EMAIL_FARM FROM TB_FARMACIA WHERE EMAIL_FARM=?");   
					$Comando->bindParam(1, $Email);

					if ($Comando->execute()) 
					{
						if ($Comando->rowCount() > 0) 
						{
							while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
		      				{
								$id = $Linha->ID_FARM;
								$nome = $Linha->NOME_FARM;
								$email = $Linha->EMAIL_FARM;
								session_start();
								$_SESSION["opcao"] = $opcao; // Enviando a opção por session
								include './funcoes/solicitaEmail.php';
							}
						}
						else
						{
							echo "<script> alert('E-mail inválido e/ou não existente, porfavor insira outro!'); location.href='esqueceusenha.php'; </script>";
						}
					}
					else
					{
						throw new Exception("Error Processing Request", 1);
					}
				}	
			}
 		}
 	?>
		
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->

			<p class="titulu">Recuperação de login </p>
			
			<div class="form-style-6" style="width: 400px">
				<h1>Esqueceu Senha</h1>
				<form action="esqueceusenha.php?valor=enviado" method="POST">
					<p>Informe o endereço de email para sua conta. Um código de verificação será enviado a você. Uma vez recebido o código você poderá escolher uma nova senha para sua conta.</p>
					<input type="email" name="Email" placeholder="✉ example@email.com" required />
					<select name="opcao" id="opcao">
					  <option value="opcao_usuario" name="opcao_usuario">Usuário</option>
					  <option value="opcao_farmacia" name="opcao_farmacia">Farmácia</option>
					</select>
					<input type="submit" name="Botao" value="Enviar" style="cursor:pointer;"/>

				</form>
			</div>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br><br>
			<br>
			<br>
			
			<?php include './templates/rodape.php'; ?>
    		<script src="./js/navsticky.js"></script>
			
	</body>
</html>
