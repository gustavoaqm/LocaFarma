<?php

	$idFarm = $_SESSION["id_farm"];

	try 
	{
		$Comando=$conexao->prepare("SELECT * FROM tb_farmacia WHERE ID_FARM=?");
		$Comando->bindParam(1, $idFarm);

		if ($Comando->execute()) 
		{
			if ($Comando->rowCount() > 0) 
			{
				while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
				{
	                $nomeFarm = $Linha->NOME_FARM;
	                $cnesFarm = $Linha->CNES_FARM;
	                $cnpjFarm = $Linha->CNPJ_FARM;
	                $endFarm = $Linha->ENDERECO_FARM;
	                $telFarm = $Linha->TEL_FARM;
	                $gestao = $Linha->GESTAO;
	                $atende_sus = $Linha->ATENDE_SUS;
	                $emailFarm = $Linha->EMAIL_FARM;
	                $senhaFarm = $Linha->SENHA_FARM;

                    // Colocando os caracteres especiais no Telefone
                    $tamanhoTel = strlen($telFarm);
                    if ($tamanhoTel == 11) 
                    {
                    	$telFarm = substr_replace($telFarm, '(', 0,0);
                    	$telFarm = substr_replace($telFarm, ') ', 3,0);
                    	$telFarm = substr_replace($telFarm, '-', 10,0);
                    }
                    else
                    {
                    	$telFarm = substr_replace($telFarm, '(', 0,0);
                    	$telFarm = substr_replace($telFarm, ') ', 3,0);
                    	$telFarm = substr_replace($telFarm, '-', 9,0);
                    }

                    // Colocando os caracteres especiais no CNPJ
                    function formatoCnpj($cnpjFarm)
                    {
                        return preg_replace("/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/", "\\1.\\2.\\3/\\4-\\5", $cnpjFarm);
                    }
                    $cnpjFarm = formatoCnpj($cnpjFarm);
				}
			}
			else
			{
				echo "<script> alert('Essa farmácia não possui cadastro!'); </script>";
			}
		}
		else
		{
			throw new Exception("Erro ao efetuar a consulta.", 1);
		}
	} 
	catch (Exception $e) 
	{
		echo "Erro !" . $e->getMessage();
	}
?>
<div class="form-style-6" style="">
	<h1>Cadastro Farmacêutico</h1>
	<form name="form1" action="painelFarm.php?valor=alterar" method="POST">
		<input type="text" placeholder="✎ Nome Farmácia" name="nome_farmacia" maxlength="60" required autofocus style="width: 40%;" value="<?php echo($nomeFarm) ?>" />
		<input type="email" placeholder="✉ Email" name="email_farmacia" maxlength="60" required style="width: 59%;"  value="<?php echo($emailFarm) ?>" />
		<input type="text" name="txtEndereco" maxlength="60" placeholder="Endereço" style="width: 59%;" value="<?php echo($endFarm) ?>"/>
		<input type="text" name="txtTelefone" maxlength="15" placeholder="☎ Telefone" onkeydown="javascript: fMasc( this, mTel );"  value="<?php echo($telFarm) ?>" style="width: 40%;" required/>
		<input type="text" name="txtCnes" maxlength="7" placeholder="CNES" onkeydown="javascript: fMasc( this, mNum );" style="width: 40%;"  value="<?php echo($cnesFarm) ?>"/>
		<input type="text" name="txtCnpj" maxlength="18" placeholder="CNPJ" onkeydown="javascript: fMasc( this, mCNPJ );" style="width: 59%;"  value="<?php echo($cnpjFarm) ?>"/>
		<input type="text" name="txtGestao" maxlength="60" placeholder="Gestão" style="width: 40%;"  value="<?php echo($gestao) ?>"/>
		&nbsp;&nbsp;Atende ao Sus?
		<select name="atende_sus" id="atende_sus" style="width: 39%">
		  <?php 
			  if ($atende_sus == "Sim") 
			  {
			  	 echo "<option name=opcao_sim>Sim</option>";
			  	 echo "<option name=opcao_nao>Não</option>";
			  }
			  if ($atende_sus == "Não") 
			  {
			   	 echo "<option name=opcao_nao>Não</option>";
			  	 echo "<option name=opcao_sim>Sim</option>";
			  } 
		  ?>	
		</select>

		<input type="password" placeholder="⌨ Senha" name="senha_farmacia" minlength="8" maxlength="15" required value="<?php echo(base64_decode($senhaFarm)) ?>" />
		<input type="password" placeholder="⌨ Confirmar Senha" name="senha_confirma" minlength="8" maxlength="15" required value="<?php echo(base64_decode($senhaFarm)) ?>" />
		*Não compartilharemos suas informações com ninguém!
		<br><br>
		<input name="Botao" type="submit" value="Alterar Cadastro" style="cursor:pointer; width: 49%;"/>
		<input name="Botao" type="submit" value="Excluir Cadastro" onclick="return confirm('Você realmente deseja excluir sua farmácia? Seus medicamentos também serão excluídos!')" style="cursor:pointer; width: 49%; background: #f58282;"/>
	</form>
</div>

<?php

if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'alterar')) 
{
	$nomeFarmacia = $_POST["nome_farmacia"];
	$emailFarmacia = $_POST["email_farmacia"];
	$telFarmacia = $_POST["txtTelefone"];
	$enderecoFarmacia = $_POST["txtEndereco"];
	$cnesFarmacia = $_POST["txtCnes"];
	$cnpjFarmacia = $_POST["txtCnpj"];
	$gestaoFarmacia = $_POST["txtGestao"];
	$opcaoAtendeSus = $_POST["atende_sus"];
	$senhaFarmacia = $_POST["senha_farmacia"];
	$confirmaSenha = $_POST["senha_confirma"];
	$botao = $_POST["Botao"];

	$Assunto = "Alteração de Dados";
	$Msg = "Atualização de Nome, E-mail, Telefone e/ou Endereço na farmácia com respectivo ID: " . $idFarm;

	// Funções para retirar os caracteres especiais
    function limpa_caractere_tel($telFarmacia)
    {
        return preg_replace("/[^0-9]/", "", $telFarmacia); 
    }
    function limpa_caractere_cnpj($cnpjFarmacia)
    {
        return preg_replace("/[^0-9]/", "", $cnpjFarmacia); 
    }
    $telFarmacia2 = limpa_caractere_tel($telFarmacia);
    $cnpjFarmacia = limpa_caractere_cnpj($cnpjFarmacia);
	// Funções para retirar os caracteres especiais

	if ($botao == "Alterar Cadastro") 
	{
		try 
		{
			if ($senhaFarmacia == $confirmaSenha) // Verificando se as senhas são iguais
			{
				$senhaFarmaciaC = base64_encode($senhaFarmacia);

				// Validando campos
			    $tamanhoEnd = strlen($enderecoFarmacia);
			    $tamanhoTel = strlen($telFarmacia2);
			    $tamanhoCNPJ = strlen($cnpjFarmacia);
			    $tamanhoCNES = strlen($cnesFarmacia);
				if ($tamanhoTel < 10 || $tamanhoCNPJ < 14 || $tamanhoCNES < 7 || $tamanhoEnd < 1) 
				{
					echo "<script> alert('Campos inválidos! Porfavor tente novamente.'); location.href='painelFarm.php'; </script>";
				}
				else
				{
					// Verificando se já há um e-mail existente no banco de dados
					$Comando = $conexao->prepare("SELECT * FROM tb_farmacia WHERE EMAIL_FARM <> ? AND EMAIL_FARM = ?");
					$Comando->bindParam(1, $emailFarm);
					$Comando->bindParam(2, $emailFarmacia);

					if ($Comando->execute()) 
					{
						if ($Comando->rowCount() > 0) 
						{
							echo "<script> alert('E-mail já existente! Porfavor insira outro.'); location.href='painelFarm.php'; </script>";
						}
						else
						{
							$Comando=$conexao->prepare("UPDATE tb_farmacia SET NOME_FARM=?, CNES_FARM=?, CNPJ_FARM=?, ENDERECO_FARM=?, TEL_FARM=?, GESTAO=?, ATENDE_SUS=?, EMAIL_FARM=?, SENHA_FARM=? WHERE ID_FARM=?");
							$Comando->bindParam(1, $nomeFarmacia);
							$Comando->bindParam(2, $cnesFarmacia);
							$Comando->bindParam(3, $cnpjFarmacia);
							$Comando->bindParam(4, $enderecoFarmacia);
							$Comando->bindParam(5, $telFarmacia2);
							$Comando->bindParam(6, $gestaoFarmacia);
							$Comando->bindParam(7, $opcaoAtendeSus);
							$Comando->bindParam(8, $emailFarmacia);
							$Comando->bindParam(9, $senhaFarmaciaC);
							$Comando->bindParam(10, $idFarm);

							if ($Comando->execute()) 
							{
								if ($nomeFarmacia != $nomeFarm || $enderecoFarmacia != $endFarm || $emailFarmacia != $emailFarm) 
								{
									$Comando=$conexao->prepare("SELECT * FROM tb_faleconosco WHERE EMAIL_CONTATO=? AND ASSUNTO=?");
									$Comando->bindParam(1, $emailFarmacia);
									$Comando->bindParam(2, $Assunto);

									if ($Comando->execute()) 
									{
										if ($Comando->rowCount() > 0) 
										{
											$Comando=$conexao->prepare("UPDATE tb_faleconosco SET NOME_CONTATO=?, EMAIL_CONTATO=?, ASSUNTO=?, MSG_CONTATO=? WHERE EMAIL_CONTATO=?");
											$Comando->bindParam(1, $nomeFarmacia);
											$Comando->bindParam(2, $emailFarmacia);
											$Comando->bindParam(3, $Assunto);
											$Comando->bindParam(4, $Msg);
											$Comando->bindParam(5, $emailFarmacia);

											if ($Comando->execute()) 
											{
												echo("<script> alert('Seus dados foram alterados com sucesso! As informações no mapa serão atualizadas dentro de uma semana!'); location.href='painelFarm.php'; </script>"); 
											}
										}
										else
										{
											$Comando=$conexao->prepare("INSERT INTO tb_faleconosco(NOME_CONTATO, EMAIL_CONTATO, ASSUNTO, MSG_CONTATO) VALUES (?, ?, ?, ?)");
											$Comando->bindParam(1, $nomeFarmacia);
											$Comando->bindParam(2, $emailFarmacia);
											$Comando->bindParam(3, $Assunto);
											$Comando->bindParam(4, $Msg);

											if ($Comando->execute()) 
											{
												echo("<script> alert('Seus dados foram alterados com sucesso! As informações no mapa serão atualizadas dentro de uma semana!'); location.href='painelFarm.php'; </script>"); 
											}
										}
									}
									else
									{
										throw new Exception("Error Processing Request", 1);
									}
								}
								else
								{
									echo("<script> alert('Seus dados foram atualizados com sucesso !!!'); location.href='painelFarm.php'; </script>"); // alert, redirecionamento
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
						throw new Exception("Não foi possível executar a declaração SQL.", 1);	
					}
				}
			}
			else
			{
				echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='painelFarm.php'; </script>";
			}
		}
		catch (Exception $erro) 
		{
			echo "Erro !" . $erro->getMessage();	
		}
	}

	if ($botao == "Excluir Cadastro") 
	{
		try 
		{
			$Comando=$conexao->prepare("DELETE FROM tb_farmacia WHERE ID_FARM=?");
			$Comando->bindParam(1, $idFarm);

			if ($Comando->execute()) 
			{
				$Comando=$conexao->prepare("DELETE FROM tb_medicamento_anvisa WHERE ID_FARM=?");
				$Comando->bindParam(1, $idFarm);

				if ($Comando->execute()) 
				{
					echo("<script> alert('Farmácia e medicamentos excluídos com sucesso!'); location.href='home.php'; </script>");
					session_destroy();
				}
				else
				{
					throw new Exception("Error Processing Request", 1);
				}
			}
			else
			{
				throw new Exception("Erro ao excluir a farmácia!", 1);
			}
		} 
		catch (Exception $erro) 
		{
			echo "Erro !" . $erro->getMessage();	
		}
	}
}

?>