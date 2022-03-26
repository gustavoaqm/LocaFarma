<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Cadastro Farmacêutico - LocaFarma</title>

		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    	<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>

		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="stylesheet" type="text/css" href="./css/login.css">
		<link rel="stylesheet" type="text/css" href="./css/modal.css">
		<link rel="icon" href="./imagens/icone.png">

		<script type="text/javascript" src="./js/mascara.js"></script>
	</head>
	<body>

	<style type="text/css">
		.container { width:95%;max-width:980px;padding:1% 2%;margin:0 auto }
      	#lat, #lon { text-align:right }
     	#map { width:50%;height:25%;padding:0;margin:0; }
      	.address { cursor:pointer }
      	.address:hover { color:#AA0000;text-decoration:underline }
	</style>
			
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->

			<p class="titulu">Cadastro Farmacêutico - Seja Bem-Vindo! </p>
			
			<div class="form-style-6" style="">
				<h1>Cadastro</h1>
				<form name="form1" action="cadastroFarmacia.php?valor=enviado" method="POST">

					<div class="popup" id="popup-end">
				      <div class="overlay"></div>
				      <div class="content">
				        <div class="close-btn" onclick="modalEndereco()">&times;</div>
				            <div class="form-style-6">
				                <strong><p class="titulomodal" style="font-size: 15px;">Olá! Faça uma pesquisa por seu endereço, e em seguida escolha um abaixo:</p></strong>
						        <input type="hidden" name="latitude" id="lat" size=12 value="">
						        <input type="hidden" name="longitude" id="lon" size=12 value="">
						      <div id="search">
							      <input type="text" name="addr" value="" id="addr"  style="width: 75%;"><br>
							      <button class="botaoCad" style="cursor: pointer; width: 25%;" type="button" onclick="addr_search();">Pesquisar</button>
							      <!-- <b>Selecione seu endereço abaixo:</b> -->
							      <div id="results" onclick="modalEndereco()"></div>
						      </div>
						      <br>
						      <div id="map"></div>
				            </div>
				      </div>
				    </div>

				    <script type="text/javascript">
				        function modalEndereco()
				        {
				            document.getElementById("popup-end").classList.toggle("active");
				        }
				    </script>

					<input type="text" placeholder="✎ Nome Farmácia" name="nome_farmacia" maxlength="60" autofocus style="width: 40%;" required />
					<input type="email" placeholder="✉ Email" name="email_farmacia" maxlength="60" style="width: 59%;" required/>
					<input type="text" name="txtTelefone" maxlength="15" placeholder="☎ Telefone" onkeydown="javascript: fMasc( this, mTel );" style="width: 59%;" required/>
					<input type="text" name="txtCnes" maxlength="7" placeholder="CNES" onkeydown="javascript: fMasc(this, mNum);" style="width: 40%;" required/>
					<input type="text" name="txtCnpj" maxlength="18" placeholder="CNPJ" onkeydown="javascript: fMasc( this, mCNPJ );" style="width: 59%;" required/>
					<input type="text" name="txtGestao" maxlength="50" placeholder="Gestão" style="width: 40%;" required/>
					<b><a href="javascript:void(0);" class="botaoCad"  onclick="modalEndereco();">Adicionar Endereço</a></b>
					&nbsp;&nbsp;Atende ao Sus?&nbsp;
					<select name="atende_sus" style="width: 49%">
					  <option name="opcao_sim">Sim</option>
					  <option name="opcao_nao">Não</option>
					</select>
					<input type="password" placeholder="⌨ Senha" name="senha_farmacia" minlength="8" maxlength="15" required/>
					<input type="password" placeholder="⌨ Confirmar Senha" name="senha_confirma" minlength="8" maxlength="15" required/>
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
    		<script src="./js/funcaoMapa.js"></script>
	</body>
</html>
<?php 
include 'conexao.php';

if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
{ 
	$botao = $_POST["Botao"];
	$nomeFarmacia = $_POST["nome_farmacia"];
	$emailFarmacia = $_POST["email_farmacia"];
	$telFarmacia = $_POST["txtTelefone"];
	$cepFarmacia = $_POST["txtCep"];
	$cnesFarmacia = $_POST["txtCnes"];
	$cnpjFarmacia = $_POST["txtCnpj"];
	$gestaoFarmacia = $_POST["txtGestao"];
	$opcaoAtendeSus = $_POST["atende_sus"];
	$senhaFarmacia = $_POST["senha_farmacia"];
	$confirmaSenha = $_POST["senha_confirma"];

	$longitude = $_POST["longitude"];
	$latitude = $_POST["latitude"];

	//Convertendo lat e long para endereço
	$url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=".$latitude."&lon=".$longitude."&zoom=27&addressdetails=1&email=locafarma10@gmail.com";
	$resp_json = file_get_contents($url);
	$resp = json_decode($resp_json, true);
	$enderecoFarmacia = $resp['display_name'];

	// Funções para retirar os caracteres especiais
    function limpa_caractere_tel($telFarmacia)
    {
        return preg_replace("/[^0-9]/", "", $telFarmacia); 
    }
    $telFarmacia2 = limpa_caractere_tel($telFarmacia);

    function limpa_caractere_cnpj($cnpjFarmacia)
    {
        return preg_replace("/[^0-9]/", "", $cnpjFarmacia); 
    }
    $cnpjFarmacia = limpa_caractere_cnpj($cnpjFarmacia);
	// Funções para retirar os caracteres especiais

	if ($botao == "Cadastrar") 
	{
		try 
		{
			if ($senhaFarmacia == $confirmaSenha) // Verificando se as senhas são iguais
			{	
				$senhaFarmaciaC = base64_encode($senhaFarmacia); // Criptografando a Senha

				// Validando campos
			    $tamanhoTel = strlen($telFarmacia2);
			    $tamanhoCNPJ = strlen($cnpjFarmacia);
			    $tamanhoCNES = strlen($cnesFarmacia);
			    $tamanhoEnd = strlen($enderecoFarmacia);

				if ($tamanhoTel < 10 || $tamanhoCNPJ < 14 || $tamanhoCNES < 7 || $tamanhoEnd < 1) 
				{
					echo "<script> alert('Campos inválidos! Porfavor tente novamente.'); location.href='cadastroFarmacia.php'; </script>";
				}
				else
				{
					// Verificando se há um e-mail existente no banco de dados
					$Comando = $conexao->prepare("SELECT * FROM tb_farmacia WHERE email_farm=?");
					$Comando->bindParam(1, $emailFarmacia);

					if ($Comando->execute()) 
					{
						if ($Comando->rowCount() > 0) // Se houver um e-mail existente, recarregue a página
						{
							echo "<script> alert('E-mail já existente! Porfavor insira outro.'); location.href='cadastroFarmacia.php'; </script>";
						}
						else // Se não, faça a inserção normalmente.
						{
							$Comando = $conexao->prepare("INSERT INTO tb_farmacia(NOME_FARM, CNES_FARM, CNPJ_FARM, ENDERECO_FARM, TEL_FARM, GESTAO, ATENDE_SUS, EMAIL_FARM, SENHA_FARM) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
							$Comando->bindParam(1, $nomeFarmacia);
							$Comando->bindParam(2, $cnesFarmacia);
							$Comando->bindParam(3, $cnpjFarmacia);
							$Comando->bindParam(4, $enderecoFarmacia);
							$Comando->bindParam(5, $telFarmacia2);
							$Comando->bindParam(6, $gestaoFarmacia);
							$Comando->bindParam(7, $opcaoAtendeSus);
							$Comando->bindParam(8, $emailFarmacia);
							$Comando->bindParam(9, $senhaFarmaciaC);

							if ($Comando->execute()) 
							{
								$Comando = $conexao->prepare("SELECT ID_FARM FROM tb_farmacia WHERE EMAIL_FARM=?");
								$Comando->bindParam(1, $emailFarmacia);

								if ($Comando->execute()) 
								{
									while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
									{
										$idFarm = $Linha->ID_FARM;

										// PARTE 2 - Salvando as coordernadas geoJson para serem lidas no mapa   
							            $geojsonfile = array
							            (
							                'type' => 'Feature', 
							                'properties' => array
							                (
							                	'id' => $idFarm,
							                    'name' => "<h2>".$nomeFarmacia."</h2>",
                								'popupContent' => "<b>Endereço: </b>".$enderecoFarmacia."<br><b>Telefone: </b>".$telFarmacia."<br><b>E-mail: </b>".$emailFarmacia
							                ),
							                'geometry' => array
							                (
							                    'type' => 'Point',
							                    'coordinates' => array($longitude, $latitude)
							                )
							            );
							         
							            $arquivo_json2 = file_get_contents("./json/geoJson.json");
							            $decodifica_json2 = json_decode($arquivo_json2);
							            array_push($decodifica_json2, $geojsonfile);
							            $arquivo_json_alterado2 = json_encode($decodifica_json2);
							            file_put_contents('./json/geoJson.json', $arquivo_json_alterado2);

										echo("<script> alert('Cadastro realizado com sucesso !!!'); location.href='login.php'; </script>"); // alert, redirecionamento
									}
								}
								else
								{
									throw new Exception("Error Processing Request", 1);
								}
							}
							else
							{
								throw new Exception("Erro ao executar a declaração SQL.", 1);
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
				echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='cadastroFarmacia.php'; </script>";
			}	
		} 
		catch (Exception $erro) 
		{
			echo "Erro ao efetuar o cadastro!" . $erro->getMessage();	
		}
	}
}

?>