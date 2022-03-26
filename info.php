<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Informações - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link href="./css/info.css" rel="stylesheet">
		<link rel="icon" href="./imagens/icone.png">
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
		<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

	</head>
	<body>
		<style type="text/css">
			#location-map
			{
		        height: 540px;
		        width: 50%;
		     }
		</style>

		<?php
		include 'conexao.php';

			if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
			{
				$cepinho = $_POST["txtCep"];
				$medicamento = $_POST["txtMedicamento"];

				try
				{
					$Comando = $conexao->prepare("SELECT * FROM tb_medicamento_anvisa WHERE nome=?");
					$Comando->bindParam(1, $medicamento);
					if ($Comando->execute()) 
					{
						if ($Comando->rowCount() > 0) 
						{
							while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)) 
							{
								$id = $Linha->id;
								$idfarmacias[] = $Linha->ID_FARM;
								$principio = $Linha->principio_ativo;
								$cnpj = $Linha->cnpj;
								$laboratorio = $Linha->laboratorio;
								$codggrem = $Linha->codggrem;
								$ean = $Linha->ean;
								$nome = $Linha->nome;
								$apresentacao = $Linha->apresentacao;
								$precofab = $Linha->precofab;
								$precocomercial = $Linha->precocomercial;
								$restricaohospitalar = $Linha->restricaohospitalar;
							}
						}
						else
						{
							echo "<script> alert('Medicamento inexistente, porfavor procure por outro!'); location.href='busca.php'</script>";
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
		?>

		    <?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->

		    <p class="titulu">Informações sobre o medicamento:</p>

			<center><div id="demoparagraph">
				<p><strong>Medicamento:</strong> <?php echo $medicamento; ?> </p>
				<p><strong>Princípio Ativo:</strong> <?php echo $principio; ?> </p>
				<p><strong>Apresentação:</strong> <?php echo $apresentacao; ?> </p>
				<p><strong>Laboratorio:</strong> <?php echo $laboratorio; ?> </p>
				<p><strong>CNPJ:</strong> <?php echo $cnpj; ?> </p>
				<p><strong>Código GGREM:</strong> <?php echo $codggrem; ?> </p>
				<p><strong>Código EAN:</strong> <?php echo $ean; ?> </p>
				<p><strong>Preço de fabricação:</strong> R$<?php echo $precofab; ?> </p>
				<p><strong>Preço comercial:</strong> R$<?php echo $precocomercial; ?> </p>
				<p><strong>Restrição hospitalar:</strong> <?php echo $restricaohospitalar; ?> </p>
			</div></center>
			

			
			<p class="titulu">Farmácias que possuem este medicamento:</p>
				<?php 
					$Arrayzinho = '(' . implode(',', $idfarmacias) .')'; // Pegando o Array Farmácias e setando vírgulas para separar os valores dos índices
					// Função para limpar os caracteres especiais
				    function limpa_caractere($Arrayzinho)
				    {
				        return preg_replace("/[()]/", "", $Arrayzinho); 
				    }

				    // Setando a variavel sem os caracteres especiais
				    $Arrayzinho2 = limpa_caractere($Arrayzinho);

				    // Função para pegar o endereço da rua através do CEP
					function get_endereco($cep)
					{
						
						//formatar o cep removendo caracteres nao numericos
						$cep = preg_replace("/[^0-9]/", "", $cep);
						$url = "http://viacep.com.br/ws/$cep/xml/";

						$xml = simplexml_load_file($url);
						return $xml;
					}

					$endereco = (get_endereco($cepinho));

					$rua = $endereco->logradouro;
					$bairro = $endereco->bairro;
					$cidade = $endereco->cidade;
					$uf = $endereco->uf;
					$ibge = $endereco->ibge;

					if ($rua == "") 
					{
						echo("<script> alert('CEP Inválido! Porfavor tente novamente.'); location.href='busca.php'; </script>");
					}
					else
					{
						$ruaS = (string)$rua;
						$bairroS = (string)$bairro;
						$cidadeS = (string)$cidade;
						$ufS = (string)$uf;
						$ibgeS = (string)$ibge;

							
						$location = $ruaS . ", " . $bairroS . ", " . $cidadeS . "- " . $ufS;
					  	$url = 'https://nominatim.openstreetmap.org/search/'.rawurlencode($location).'?format=json&limit=1&email=locafarma10@gmail.com';

					    $data = ''; 
					    $opts = array
					    (
					        'http' => array
					        (
					        'header' => "Content-type: text/html\r\nContent-Length: " . strlen($data) . "\r\n",
					        'method' => 'POST'
					        ),
					    ); 
					    
					    $context = stream_context_create($opts);
					    $jsonfile = file_get_contents($url, false, $context);
					    
					    if (!json_decode($jsonfile, TRUE)) {return false;}else
					    {
						    $resp = json_decode($jsonfile, true);
						    $gps['latitude'] = $resp[0]['lat'];
						    $gps['longitude'] = $resp[0]['lon'];
					    }

						$latt = $gps['latitude'];
						$longg = $gps['longitude'];
					}
				?>
			<!-- maaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaapa -->
			<center> <div id="location-map" class="mapa"></div> </center>
			<!-- maaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaapa -->
			<script>

					// Recebendo a latitude e longitude via php
					var latt = "<?php echo($latt); ?>";
					var longg = "<?php echo($longg); ?>";

					// Setando a latitude e a longitude no mapa para abrir com a localização do usuário
					var map = L.map('location-map').setView([latt, longg], 17);
      				map.setZoom(14.2); // Definindo um zoom padrão

			      	mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';

			      	L.tileLayer(
			        'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', 
			        {
			          maxZoom: 20,
			          attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
			        }).addTo(map);

			        var smallIcon = new L.Icon({
					    iconUrl: './imagens/icone.png',
					    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-icon-2x.png',
					    iconSize:    [45, 51],
					    iconAnchor:  [19, 41],
					    popupAnchor: [1, -34],
					    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
					    shadowSize:  [45, 51]
					  });

			        function onEachFeature(feature, layer) 
			        {
					    if (feature.properties && feature.properties.popupContent) 
					    {
					        layer.bindPopup(feature.properties.name + '<hr>' + feature.properties.popupContent);
					    }
					}

			        function readTextFile(file, callback) 
			        {
					    var rawFile = new XMLHttpRequest();
					    rawFile.overrideMimeType("application/json");
					    rawFile.open("GET", file, true);
					    rawFile.onreadystatechange = function() {
					        if (rawFile.readyState === 4 && rawFile.status == "200") {
					            callback(rawFile.responseText);
					        }
					    }
					    rawFile.send(null);
					}

					var farmPossui = "<?php echo($Arrayzinho); ?>";

					readTextFile("./json/geoJson.json", function(text)
					{

						const data = JSON.parse(text).filter(function (entry) 
					    {
					    	return farmPossui.indexOf(entry.properties.id) !== -1;
						});

						L.geoJSON(data, 
						{
							pointToLayer: function(feature, latlng) 
							{
					        	return L.marker(latlng, {
					          	icon: smallIcon
					        });
					      },
						    onEachFeature: onEachFeature
						}).addTo(map);
					});
			</script>

			<br><br><br>

			<?php include './templates/rodape.php'; ?>
    		<script src="./js/navsticky.js"></script>
	</body>
</html>