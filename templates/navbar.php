<br>
<br>
<img src="./imagens/remedio.png" align="left" class="remedio1">
<div class="titulo">
<img src="./imagens/remedio2.png" align="right" class="remedio2">
<img src="./imagens/ursinho2.png" align="left" class="ursinho"> <br><br>
<h1>LocaFarma</h1>
<h2 class="h2navbar">Rápido, fácil e gratuito.</h2>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<link href="./css/navbar.css" rel="stylesheet">
<!-- navbar bonito -->
<div id="navbar">
	<ul>
	  <li><a href="home.php">Home</a></li>
	  <li><a href="busca.php">Busca</a></li>
	  <li><a href="sobre.php">Sobre nós</a></li>
	  <?php 
	  	 if (isset($_SESSION["opcao_usuario"]))
	  	 {
	  	 	echo "<div class=dropdown>";
	  		echo "<button class=dropbtn>";
	  		echo $_SESSION["nome"];
	  		echo "</button>";
	  		echo "<div class=dropdown-content>";
	  		echo "<a href=javascript:void(0); onclick=modalSolicitacao();>Solicitar um Medicamento</a>";
	  		echo "<a href=javascript:void(0); onclick=modalAlterarDados();>Alterar Dados</a>";
	  		echo "<a href=faleconosco.php>Dar uma sugestão</a>";
	  		echo "<a href=?acao=sair style=color:#f75e5e;>Sair</a>";
	  		echo "</div>";
	  		echo "</div>";
	  		?>
	  			<?php 
	  					include_once 'conexao.php';
						$Comando=$conexao->prepare("SELECT * FROM tb_usuario WHERE ID_USU=?");
						$Comando->bindParam(1, $_SESSION["id_usu"]);
                          if ($Comando->execute()) 
                          {
                              while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                              {
                                $idUsu = $Linha->ID_USU;
                                $nomeUsu = $Linha->NOME_USU;
                                $emailUsu = $Linha->EMAIL_USU;
                                $cepUsu = $Linha->CEP_USU;
                                $senhaUsuC = $Linha->SENHA_USU;

                                // Colocando os caracteres especiais no CEP
                				$cep = substr_replace($cepUsu, '.', 2, 0);
                				$cep = substr_replace($cep, '-', 6, 0);
                            }
                            $senhaUsu = base64_decode($senhaUsuC);
                        }
					?>

	  			<!-- Arquivos de estilo -->
				<link rel="stylesheet" type="text/css" href="./css/busca.css">
				<link rel="stylesheet" type="text/css" href="./css/modal.css">

				<!-- Modal Solicita Medicamentos -->
				<div class="popup" id="solicitaMedicamento">
				      <div class="overlay"></div>
				      <div class="content">
				        <div class="close-btn" onclick="modalSolicitacao()">&times;</div>
				            <div class="form-style-6">
								<h1>Solicitação de medicamentos</h1>
								<form name="formLogin" action="?solicitacao=solicitar" method="POST">
									<!-- <p>*Nome e E-mail</p> -->
									<input type="hidden" name="nome_usu" placeholder="Nome" style="width: 40%" required value="<?php echo($nomeUsu) ?>" />
									<input type="hidden" name="email_usu" placeholder="example@email.com" style="width: 59%"  value="<?php echo($emailUsu) ?>" />
									<p>*Farmácia</p>
									<select name="opcoes_farmacias">
									  <?php 
									  include_once 'conexao.php';
										  $Comando=$conexao->prepare("SELECT * FROM tb_farmacia");

										  if ($Comando->execute()) 
										  {
										  	if ($Comando->rowCount() > 0) 
										  	{
										  		while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                              					{
                              						$idFarm = $Linha->ID_FARM;
                              						$nomeFarm = $Linha->NOME_FARM;

                              						echo "<option value=$idFarm>".$nomeFarm."</option>";
                              					}
										  	}
										  	else
										  	{
										  		echo "<option>Não há farmácias Disponíveis!</option>";
										  	}
										  }
										  else
										  {
										  	throw new Exception("Error Processing Request", 1);
										  }
									  ?>	
									</select>
									<p>*Nome do Medicamento</p>
									<input type="text" name="nome_med" maxlength="60" placeholder="Medicamento" required />
									<p>Descrição do pedido</p>
									<textarea name="desc_ped" maxlength="120" placeholder="Ex: Ibuprofeno 600 MG 20 Comprimidos." style="height: 150px"></textarea>
									Atenção! Os campos marcados com (*) são obrigatórios.<br><br>
									<input name="Botao" type="submit" value="Enviar" style="cursor:pointer;"/>
								</form>
							</div>
				      </div>
				    </div>

				    <script type="text/javascript">
				        function modalSolicitacao()
				        {
				            document.getElementById("solicitaMedicamento").classList.toggle("active");
				        }
				    </script>
				<!-- Modal Solicita Medicamentos -->
				<!-- |
				|
				|
				|
				|
				| -->
					<script type="text/javascript" src="./js/mascara.js"></script>

					<!-- Modal Alterar Dados -->
					<div class="popup" id="alterarDados">
				      <div class="overlay"></div>
				      <div class="content">
				        <div class="close-btn" onclick="modalAlterarDados()">&times;</div>
				            <div class="form-style-6">
							<h1>Alterar Dados</h1>
							<form name="form1" action="?alterarDados=enviado" method="POST">
								<input type="text" id="nome_altera" placeholder="✎ Nome" name="nome_altera" maxlength="60" required autofocus value="<?php echo($nomeUsu) ?>" />
                                <input type="text" name="cep_altera" maxlength="10" placeholder="✉ CEP" onkeydown="javascript: fMasc( this, mCEP );" value="<?php echo($cep); ?>"/>
								<input type="hidden" name="email_registrado" class="form-control" value="<?php echo($emailUsu); ?>" >
								<input type="email" placeholder="✉ Email" name="email_usuario" maxlength="60" required value="<?php echo($emailUsu) ?>" />
								<input type="password" id="senha_altera" placeholder="⌨ Senha" name="senha_altera" minlength="8" maxlength="15" required value="<?php echo($senhaUsu) ?>" />
								<input type="password" id="senha_confirma_altera" placeholder="⌨ Confirmar Senha" name="senha_confirma_altera" minlength="8" maxlength="15" required value="<?php echo($senhaUsu) ?>"/>
								*Não compartilharemos suas informações com ninguém!
								
								<br><br>
								<input name="Botao" type="submit" value="Alterar" style="cursor:pointer; width: 49%;"/>
								<input name="Botao" type="submit" value="Excluir Cadastro" onclick="return confirm('Você realmente deseja excluir seu cadastro? Sentiremos sua falta!');" style="cursor:pointer; width: 49%; background: #f58282;"/>
								<br><br>
							</form>
						</div>
				      </div>
				    </div>

				    <script type="text/javascript">
				        function modalAlterarDados()
				        {
				            document.getElementById("alterarDados").classList.toggle("active");
				        }
				    </script>
				<!-- Modal Alterar Dados -->
				<?php
					// Alteração de Dados do usuário
					if(isset($_REQUEST['alterarDados']) and ($_REQUEST['alterarDados'] == 'enviado')) 
					{
						$Nome = $_POST["nome_altera"];
						$Cep = $_POST["cep_altera"];
						$email = $_POST["email_usuario"];
						$email_registrado = $_POST["email_registrado"];
						$Senha_altera = $_POST["senha_altera"];
						$Senha_altera_confirma = $_POST["senha_confirma_altera"];
						$Botao = $_POST["Botao"];

						// Função para limpar os caracteres especiais
					    function limpa_caractere($Cep)
					    {
					        return preg_replace("/[^0-9]/", "", $Cep); 
					    }

					    // Setando a variavel sem os caracteres especiais
					    $Cep = limpa_caractere($Cep);
					    $tamanhoCep = strlen($Cep);
							
						if ($Botao == "Alterar") 
						{
							try
							{
								if ($Senha_altera == $Senha_altera_confirma) 
								{
									$Senha_alteraC = base64_encode($Senha_altera);

									// Validando o CEP
									if ($tamanhoCep < 8) 
									{
										echo "<script> alert('CEP inválido! Porfavor tente novamente.'); location.href='home.php'; </script>";
									}
									else
									{
										// Verificando se já há um e-mail existente no banco de dados
										$Comando = $conexao->prepare("SELECT * FROM tb_usuario WHERE EMAIL_USU <> ? AND EMAIL_USU = ?");
										$Comando->bindParam(1, $email_registrado);
										$Comando->bindParam(2, $email);

										if ($Comando->execute()) 
										{
											if ($Comando->rowCount() > 0) 
											{
												echo "<script> alert('E-mail já existente! Porfavor insira outro.'); location.href='home.php'; </script>";
											}
											else
											{
												$Comando=$conexao->prepare("UPDATE tb_usuario SET NOME_USU=?, EMAIL_USU=?, CEP_USU=?, SENHA_USU=? WHERE ID_USU=?");
												$Comando->bindParam(1, $Nome);
												$Comando->bindParam(2, $email);
												$Comando->bindParam(3, $Cep);
												$Comando->bindParam(4, $Senha_alteraC);
												$Comando->bindParam(5, $idUsu);

												if ($Comando->execute()) 
												{
													echo "<script> alert('Dados alterados com sucesso!'); location.href='home.php';</script>";
													$Cep = null;
													$_SESSION["nome"] = $Nome; // Atualizando a Session Nome
													$_SESSION["email"] = $email;
												}
												else
												{
													throw new PDOException("Erro! Não foi possivel efetuar a declaração sql.");
												}	
											}
										}
										else
										{
											throw new Exception("Error Processing Request", 1);
										}
									}
								}
								else
								{
									echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='home.php'; </script>";
								}
							}
							catch(Exception $erro)
							{
								echo "Erro!" . $erro->getMessage();
							}
						}

						if ($Botao == "Excluir Cadastro") 
						{
							try 
							{
								$Comando=$conexao->prepare("DELETE FROM tb_usuario WHERE ID_USU=?");
								$Comando->bindParam(1, $idUsu);

								if ($Comando->execute()) 
								{
									echo("<script> alert('Cadastro excluído com sucesso!'); location.href='home.php'; </script>");
									session_destroy();
								}
								else
								{
									throw new Exception("Erro ao excluir o usuário!", 1);
								}
							} 
							catch (Exception $erro) 
							{
								echo "Erro !" . $erro->getMessage();	
							}
						}
					}

					// if(isset($_REQUEST['excluirDados']) and ($_REQUEST['excluirDados'] == 'excluir')) 
					// {
						
					// }
					// Alteração de Dados do usuário

					// Solicitação de medicamentos
					if(isset($_REQUEST['solicitacao']) and ($_REQUEST['solicitacao'] == 'solicitar'))
					{
						// include_once 'conexao.php';

						$Botao = $_POST["Botao"];
						$nomeUsu = ucfirst($_POST["nome_usu"]);
						$emailUsu = $_POST["email_usu"];
						$nomeMed = ucfirst($_POST["nome_med"]);
						$descMed = $_POST["desc_ped"];
						$opcaoFarmacia = $_POST["opcoes_farmacias"];

						if ($Botao == "Enviar") 
						{
							try 
							{
								$Comando=$conexao->prepare("INSERT INTO tb_pedido (ID_FARM, NOME_USU, EMAIL_USU, NOME_MED, DESC_MED) VALUES (?, ?, ?, ?, ?)");
								$Comando->bindParam(1, $opcaoFarmacia);
								$Comando->bindParam(2, $nomeUsu);
								$Comando->bindParam(3, $emailUsu);
								$Comando->bindParam(4, $nomeMed);
								$Comando->bindParam(5, $descMed);

								if ($Comando->execute()) 
								{
									echo "<script> alert('Solicitação enviada com sucesso! Agradecemos o pedido.'); location.href='home.php'; </script>";
									$opcaoFarmacia = null;
									$nomeUsu = null;
									$emailUsu = null;
									$nomeMed = null;
									$descMed = null;
								}
								else
								{
									throw new Exception("Error Processing Request", 1);
								}
							} 
							catch (Exception $erro) 
							{
								echo "Erro !" . $erro->getMessage();	
							}
						}
					}
					// Solicitação de medicamentos
				?>
	  		<?php
	  	 }

	  	 elseif (isset($_SESSION["opcao_farmacia"]))
	  	 {
	  	 	echo "<div class=dropdown>";
	  		echo "<button class=dropbtn>";
	  		echo $_SESSION["nome"];
	  		echo "</button>";
	  		echo "<div class=dropdown-content>";
	  		echo "<a href=?acao=painel>Painel Farmacêutico</a>";
	  		echo "<a href=faleconosco.php>Dar uma sugestão</a>";
	  		echo "<a href=?acao=sair style=color:#f75e5e;>Sair</a>";
	  		echo "</div>";
	  		echo "</div>";
	  	 }

	  	 elseif (isset($_SESSION["opcao_adm"]))
	  	 {
	  	 	echo "<div class=dropdown>";
	  		echo "<button class=dropbtn>";
	  		echo $_SESSION["nome"];
	  		echo "</button>";
	  		echo "<div class=dropdown-content>";
	  		echo "<a href=?acao=painel>Painel Administrativo</a>";
	  		echo "<a href=?acao=sair style=color:#f75e5e;>Sair</a>";
	  		echo "</div>";
	  		echo "</div>";
	  	 }
	  	 else
	  	 {
	  	 	echo "<li><a href=?acao=painel class=botaoLogin>Fazer Login</a></li>";
	  	 }
	  ?>
	</ul>
</div>
<!-- navbar bonito -->

<?php 

if (isset($_GET["acao"])) 
{
	if($_GET["acao"] == "sair")
	{
		session_destroy();
		// header("location: home.php");
		echo "<script> location.href='home.php'; </script>";
	}

	if ($_GET["acao"] == "painel") 
	{

		if (isset($_SESSION["opcao_farmacia"])) 
		{
			$opcao = $_SESSION["opcao_farmacia"];
			header("Location: painelFarm.php");
		}

		if (isset($_SESSION["opcao_adm"])) 
		{
			$opcao = ($_SESSION["opcao_adm"]);
			header("Location: painelAdm.php");
		}

		if ($opcao == null) 
		{
			header("Location: login.php");
			session_destroy();
		}
	}
}

?>