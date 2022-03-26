<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="http://localhost/LocaFarma%202.0/css/css.css">
	<link rel="stylesheet" type="text/css" href="http://localhost/LocaFarma%202.0/css/busca.css">
</head>
	<body>
		<?php
		include "conexao.php";

		if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
		{ 
			session_start();
			$codigo = base64_decode($_SESSION["codigo"]); // Recebendo a session 'código' do esqueceusenha.php
			$tipoUsu = $_SESSION["opcao"]; // Recebendo o tipo do usuário

			$Comando=$conexao->prepare("SELECT id FROM tb_codigos WHERE codigo=? AND data > NOW()");		
			$Comando->bindParam(1, $codigo);

			if ($Comando->execute()) 
			{
				if ($Comando->rowCount () > 0)
				{
					while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
					{
						$id_usuario = $Linha->id; // Pegamos o id do usuário na tabela 'tb_codigos' e setamos na variável

						try
						{
							$Botao = $_POST["Botao"];
					    	$SenhaNova = $_POST["nova_senha"];
					    	$SenhaNovaC = base64_encode($SenhaNova);

					    	if($Botao == "Enviar")
					    	{
				    			if($_POST["nova_senha"] == $_POST["nova_senha_confirma"])
								{
									// =============Opção usuário==============
									if ($tipoUsu == "opcao_usuario") 
									{
										$Comando=$conexao->prepare("UPDATE tb_usuario SET SENHA_USU=? WHERE ID_USU=?");
										$Comando->bindParam(1, $SenhaNovaC);
										$Comando->bindParam(2, $id_usuario);	

										if($Comando->execute())
										{
											// Se o comando for executado com sucesso, podemos excluir o código da tabela.
											$Comando=$conexao->prepare("DELETE FROM tb_codigos WHERE codigo=?");
											$Comando->bindParam(1, $codigo);
											$Comando->execute();
											session_destroy();
											echo ("<script> alert('Senha redefinida com sucesso!'); location.href='http://localhost/LocaFarma%202.0/login.php'</script>");
										}
										else
										{
											throw new Exception("Erro ao executar a declaração SQL!", 1);
										}
									}
									// =============Opção usuário==============

									// =============Opção Farmácia==============
									if($tipoUsu == "opcao_farmacia")
									{
										$Comando=$conexao->prepare("UPDATE tb_farmacia SET SENHA_FARM=? WHERE ID_FARM=?");
										$Comando->bindParam(1, $SenhaNovaC);
										$Comando->bindParam(2, $id_usuario);	

										if($Comando->execute())
										{
											// Se o comando for executado com sucesso, podemos excluir o código da tabela.
											$Comando=$conexao->prepare("DELETE FROM tb_codigos WHERE codigo=?");
											$Comando->bindParam(1, $codigo);
											$Comando->execute();
											session_destroy();
											echo ("<script> alert('Senha redefinida com sucesso!'); location.href='http://localhost/LocaFarma%202.0/login.php'</script>");
										}
										else
										{
											throw new Exception("Erro ao executar a declaração SQL!", 1);
										}
									}
									// =============Opção Farmácia==============
				    			}
				    			else
				    			{
				    				echo ("<script> alert('Senhas não conferem!'); </script>");
				    			}
					    	}
						}
						catch(PDOExepction $erro)
						{
							echo "Erro" . $erro->getMessage();
						}
					} 
				}
				else // Se o código tiver expirado, deletamos do banco de dados.
				{
					$Comando=$conexao->prepare("DELETE FROM TB_CODIGOS WHERE CODIGO=?");
					$Comando->bindParam(1, $codigo);
					$Comando->execute();
					echo "<script>alert('Código expirado e/ou inexistente! Redirecionando...'); </script>";
				} 
			}
			else
			{
				throw new PDOException("Erro! Não foi possível executar a declaração SQL.");
			}
		}
		?>
			<p class="titulu"> Recuperação de senha </p>
			
			<div class="form-style-6" style="width: 400px">
				<h1>LocaFarma</h1>
				<form action="recuperarsenha.php?valor=enviado" method="POST">
					<input name="nova_senha" type="password" placeholder="Nova senha" required />
					<input name="nova_senha_confirma" type="password" placeholder="Confirmar senha" required />
					<br><br>
					<input name="Botao" type="submit" value="Enviar" style="cursor:pointer;"/>
				</form>
			</div>
	</body>
</html>