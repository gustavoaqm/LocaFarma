<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cadastro Usuário - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link rel="icon" href="./imagens/icone.png">

		<script type="text/javascript" src="./js/mascara.js"></script>
	</head>
	<body>
		<?php
			session_start();
			include "conexao.php";

			if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
			{ 
				$Botao = $_POST["Botao"];
				$Nome = $_POST["nome_cadastro"];
				$Email = $_POST["usuario_cadastro"];
				$Cep = $_POST["txtCep"];
		    	$Senha = $_POST["senha_cadastro"];

		    	// Retirando os caracteres especiais do CEP para inserir no BD
		    	// $a_cep = str_replace(".", "", $Cep);
    			// $b_cep = str_replace("-", "", $a_cep);

    			// Função para limpar os caracteres especiais
				function limpa_caractere($Cep)
				{
				  	return preg_replace("/[^0-9]/", "", $Cep); 
				}

				// Exibe a variavel sem os caracteres especiais
				$Cep = limpa_caractere($Cep);
			
				if ($Botao == "Cadastrar")
				{ 
					try
		 			{
		 				if ($_POST["senha_cadastro"] == $_POST["senha_confirma"])
						{
							$SenhaC = base64_encode($Senha); // Criptografando a senha

							// Validando o CEP
							$tamanhoCep = strlen($Cep);
							if ($tamanhoCep < 8) 
							{
								echo "<script> alert('CEP inválido! Porfavor tente novamente.'); location.href='cadastroUsuario.php'; </script>";
							}
							else
							{
								$Comando=$conexao->prepare("SELECT * FROM TB_USUARIO WHERE EMAIL_USU=?");
								$Comando->bindParam(1, $Email);
							
					    		if ($Comando->execute()) 
					    		{
					    			if ($Comando->rowCount() > 0) 
					    			{
					    				echo "<script> alert('Usuário já existente! Porfavor insira outro.'); location.href='cadastroUsuario.php'; </script>";
					    			}
					    			else
					    			{
					    				$Comando=$conexao->prepare("INSERT INTO TB_USUARIO (NOME_USU, EMAIL_USU, CEP_USU, SENHA_USU) VALUES (?, ?, ?, ?)");
					           			$Comando->bindParam(1, $Nome);
					           			$Comando->bindParam(2, $Email);
					  	    			$Comando->bindParam(3, $Cep);
					  	    			$Comando->bindParam(4, $SenhaC);
					             
					    				if ($Comando->execute())
					    				{
							           		echo("<script> alert('Cadastro realizado com sucesso !!!'); location.href='login.php';</script>"); // alert, redirecionamento
					        			}
					     				else 
					        			{ 
					           				throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
					        			}
				        			}   
			        			}
				        		else 
								{
									throw new Exception("Não foi possível executar a declaração SQL.", 1);
								} 
							}
						}
						else
						{
							echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='cadastroUsuario.php'; </script>";
						}    
		    		}   
		    		catch (PDOException $erro)
		    		{
						echo "Erro!" . $erro->getMessage();
		    		}
				}
		 	}
 		?>
		
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->

			<p class="titulu">Cadastro Usuário - Seja Bem-Vindo! </p>
			
			<div class="form-style-6" style="width: 400px">
				<h1>Cadastro</h1>
				<form name="form1" action="cadastroUsuario.php?valor=enviado" method="POST">
					<input type="text" id="nome_cadastro" placeholder="✎ Nome" name="nome_cadastro" maxlength="60" required autofocus />
					<input type="email" id="usuario_cadastro" placeholder="✉ Email" name="usuario_cadastro" maxlength="60" required />
					<input type="text" name="txtCep" minlength="10" maxlength="10" placeholder="✉ CEP" autofocus required onkeydown="javascript: fMasc( this, mCEP );"/>
					<input type="password" id="senha_cadastro" placeholder="⌨ Senha" name="senha_cadastro" minlength="8" maxlength="15" required/>
					<input type="password" id="senha_confirma" placeholder="⌨ Confirmar Senha" name="senha_confirma" minlength="8" maxlength="15" required/>
					*Não compartilharemos suas informações com ninguém!
					<br><br>
					<input name="Botao" type="submit" value="Cadastrar" style="cursor:pointer;"/>
				</form>
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