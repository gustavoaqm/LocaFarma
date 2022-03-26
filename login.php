<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login - LocaFarma</title>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js" sandbox="allow-scripts allow-modals"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js" sandbox="allow-scripts allow-modals"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link rel="icon" href="./imagens/icone.png">
	</head>
	<body>
		
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->

			<p class="titulu">Login - Locafarma | Seja bem-vindo! </p>
			
			<div class="form-style-6" style="width: 400px">
				<h1>Login</h1>
				<form name="formLogin" action="login.php?valor=enviado" method="POST">
					<p>Selecione um:</p>
					<select name="opcao" id="opcao">
					  <option value="opcao_usuario" name="opcao_usuario">Usuário</option>
					  <option value="opcao_farmacia" name="opcao_farmacia">Farmácia</option>
					  <option value="opcao_adm" name="opcao_adm">Administrador</option>
					</select>
					<p>Email:</p>
					<input type="email" name="usuario_login" placeholder="example@email.com" required />
					<p>Senha:</p>
					<input type="password" name="senha_login" placeholder="xxxxxxxxxx" required />
					<a href="esqueceusenha.php" style="color: black; margin-left: 10px;"> Esqueci a senha </a>
					<a href="#ex1" rel="modal:open" style="color: black; margin-left: 140px;" > Não Possuo Cadastro </a>
					<br><br>
					<input name="Botao" type="submit" value="Logar" style="cursor:pointer;"/>
				</form>
			</div>

				<!-- Modal HTML embedded directly into document -->
				<div id="ex1" class="modal">
				  <strong><p class="titulomodal">Olá! Selecione uma opção abaixo para prosseguir:</p></strong>
				  <a href="cadastroUsuario.php"><input class="butaomodal" name="Botao" type="submit" value="Sou usuário!"/></a>
				  <a href="cadastroFarmacia.php"><input class="butaomodal" name="Botao" type="submit" value="Sou uma farmácia!"/></a>
				</div>

			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			
			<?php include './templates/rodape.php'; ?>
    		<script src="./js/navsticky.js"></script>
	</body>
</html>

<?php
	include 'conexao.php';

	if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado'))
	{
	    $Botao = $_POST["Botao"]; 
	    $login = $_POST["usuario_login"];
		$senha = $_POST["senha_login"];
		$opcao = $_POST["opcao"];

		$senhaC = base64_encode($senha);

	    if ($Botao =="Logar")
	    {
	    	// =================================================================Opção Usuario============================================================
	    	if ($opcao == "opcao_usuario") 
	    	{
	    		try
		        {
		        	$Comando=$conexao->prepare("SELECT * FROM TB_USUARIO WHERE  EMAIL_USU=? AND SENHA_USU=?");		
				    $Comando->bindParam(1, $login);
				    $Comando->bindParam(2, $senhaC);
	   
				    if ($Comando->execute()) 
				    {
				    	if ($Comando->rowCount() > 0) 
				    	{
				    		while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
					       	{
					       		$idUsu = $Linha->ID_USU;
					            $email = $Linha->EMAIL_USU;
					            $senha = $Linha->SENHA_USU;
					            $nomeUsu = $Linha->NOME_USU;
								     
					            session_start();
				    			$_SESSION["confirma_usu"] = "abc";
				    			$_SESSION["nome"] = $nomeUsu;
				    			$_SESSION["email"] = $email;
				    			$_SESSION["id_usu"] = $idUsu;
				    			$_SESSION["opcao_usuario"] = "opcao_usuario";
				     			header('location:busca.php');
					        }
				    	}
				    	else
				    	{
				    		echo "<script> alert('Login ou senha inválidos! Porfavor tente novamente.'); location.href='login.php'; </script>";
				    	}
				    }
				    else
				    {
				    	throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
				    }
		        }
		        catch(Exception $erro)
		        {
		        	echo "Erro!" . $erro->getMessage();
		        }
	    	}
	    	// =================================================================Opção Usuario============================================================

	    	// =================================================================Opção Farmacia===========================================================
	    	if ($opcao == "opcao_farmacia") 
	    	{
	    		try
		        {
		        	$Comando=$conexao->prepare("SELECT ID_FARM, NOME_FARM, EMAIL_FARM, SENHA_FARM FROM TB_FARMACIA WHERE EMAIL_FARM=? AND SENHA_FARM=?");		
				    $Comando->bindParam(1, $login);
				    $Comando->bindParam(2, $senhaC);
	   
				    if ($Comando->execute()) 
				    {
				    	if ($Comando->rowCount() > 0) 
				    	{
				    		while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
					       	{
					            $email = $Linha->EMAIL_FARM;
					            $senha = $Linha->SENHA_FARM;
					            $nomeFarm = $Linha->NOME_FARM;
					            $idFarm = $Linha->ID_FARM;
								     
					            session_start();
				    			$_SESSION["confirma_farm"] = "abc";
				    			$_SESSION["nome"] = $nomeFarm;
				    			$_SESSION["id_farm"] = $idFarm;
				    			$_SESSION["opcao_farmacia"] = "opcao_farmacia";
				     			header('location:painelFarm.php');
					        }
				    	}
				    	else
				    	{
				    		echo "<script> alert('Login ou senha inválidos! Porfavor tente novamente.'); location.href='login.php'; </script>";
				    	}
				    }
				    else
				    {
				    	throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
				    }
		        }
		        catch(Exception $erro)
		        {
		        	echo "Erro!" . $erro->getMessage();
		        }
	    	}
	    	// =================================================================Opção Farmacia===========================================================

	    	// =================================================================Opção ADM================================================================
	    	if ($opcao == "opcao_adm") 
	    	{
	    		try
		        {
		        	$Comando=$conexao->prepare("SELECT * FROM TB_CADASTRO_ADM WHERE EMAIL_ADM=? AND SENHA_ADM=?");		
				    $Comando->bindParam(1, $login);
				    $Comando->bindParam(2, $senhaC);
	   
				    if ($Comando->execute()) 
				    {
				    	if ($Comando->rowCount() > 0) 
				    	{
				    		while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
					       	{
					       		$idAdm = $Linha->ID_ADM;
					            $email = $Linha->EMAIL_ADM;
					            $senha = $Linha->SENHA_ADM;
					            $nomeAdm = $Linha->NOME_ADM;
								     
					            session_start();
				    			$_SESSION["confirma_adm"] = "opcao_adm";
				    			$_SESSION["nome"] = $nomeAdm;
				    			$_SESSION["id_adm"] = $idAdm;
				    			$_SESSION["opcao_adm"] = "opcao_adm";
				     			header('location:painelAdm.php');
					        }
				    	}
				    	else
				    	{
				    		echo "<script> alert('Login ou senha inválidos! Porfavor tente novamente.'); location.href='login.php'; </script>";
				    	}
				    }
				    else
				    {
				    	throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
				    }
		        }
		        catch(Exception $erro)
		        {
		        	echo "Erro!" . $erro->getMessage();
		        }
	    	}    
	    	// =================================================================Opção ADM================================================================
	    }
	}			
?>
