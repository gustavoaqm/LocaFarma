
	<div class="container" style="width: auto;">

        <br><center><button class="butao" onclick="modalAdicionarFarm()">Adicionar Farmácia</button></center>

		<div class="row">
            <table id="tabelaFarmacia" class="display" style="width: 99%; font-size: 85%;">

                <thead>
                    <tr>
                        <th>Id Farm</th>
                        <th>Nome Farmácia</th>
                        <th>CNES</th>                                
                        <th>CNPJ</th>  
                        <th>Endereço</th>
                        <th>Telefone</th>
                        <th>Gestão</th>
                        <th>Atende Sus</th>
                        <th>E-mail</th>
                        <th>Senha</th>
                        
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                	      // include("conexao.php");

                          $Comando=$conexao->prepare("SELECT * FROM tb_farmacia");
                          if ($Comando->execute()) 
                          {
                              while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                              {
                                $idFarm = $Linha->ID_FARM;
                                $nomeFarm = $Linha->NOME_FARM;
                                $cnesFarm = $Linha->CNES_FARM;
                                $cnpjFarm = $Linha->CNPJ_FARM;
                                $enderecoFarm = $Linha->ENDERECO_FARM;
                                $telFarm = $Linha->TEL_FARM;
                                $gestaoFarm = $Linha->GESTAO;
                                $atendeFarm = $Linha->ATENDE_SUS;
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
                                    $cnpjFarm = substr_replace($cnpjFarm, '.', 2, 0);
                                    $cnpjFarm = substr_replace($cnpjFarm, '.', 6, 0);
                                    $cnpjFarm = substr_replace($cnpjFarm, '/', 10, 0);
                                    $cnpjFarm = substr_replace($cnpjFarm, '-', 15, 0);
                                ?>
                                <tr>
                                    <td><?php echo $idFarm; ?></td>
                                    <td><?php echo $nomeFarm; ?></td>
                                    <td><?php echo $cnesFarm; ?></td>
                                    <td><?php echo $cnpjFarm; ?></td>
                                    <td><?php echo $enderecoFarm; ?></td>
                                    <td><?php echo $telFarm; ?></td>
                                    <td><?php echo $gestaoFarm; ?></td>
                                    <td><?php echo $atendeFarm; ?></td>
                                    <td><?php echo $emailFarm; ?></td>
                                    <td><?php echo $senhaFarm; ?></td>
                                    
                                    <td><a href="<?php echo "painelAdm.php?acao=editarFarm&idfarm=$idFarm";?>" class="butaomodal">Editar</a></td>
                                    <td><a href="<?php echo "painelAdm.php?acao=excluirFarm&id=$idFarm";?>"class="butaomodal" onclick="return confirm('Você realmente deseja excluir esta farmácia?')">Excluir</a></td>
                                </tr>
                                <?php
                              }
                          }
                          else
                          {
                             throw new Exception("Erro ao processar a solicitação", 1);
                          }
                	?>
                </tbody>
            </table>
		</div>
	</div>

    <!-- ===================================== modaaaaaaaaaaal cadastraaaaaaaar =========================================== -->
    <div class="popup" id="popup-adc-farm">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-btn" onclick="modalAdicionarFarm()">&times;</div>
        <!-- <h1>Adicionar Usuário</h1> -->
            <div class="form-style-6" style="">
                <h1>Adicionar Farmácia</h1>
                <form name="form1" action="painelAdm.php?valor=cadastrarFarm" method="POST">
                    <input type="text" placeholder="✎ Nome Farmácia" maxlength="60" name="nome_farmacia" required autofocus style="width: 40%;" />
                    <input type="email" placeholder="✉ Email" maxlength="60" name="email_farmacia" required style="width: 59%;" />
                    <input type="text" name="txtEndereco" maxlength="60" placeholder="Endereço" style="width: 59%;"/>
                    <input type="text" name="txtTelefone" maxlength="15" placeholder="☎ Telefone" onkeydown="javascript: fMasc( this, mTel );"  style="width: 40%;"/>
                    <input type="text" name="txtCnes" maxlength="7" placeholder="CNES" onkeydown="javascript: fMasc(this, mNum);" style="width: 40%;"/>
                    <input type="text" name="txtCnpj" maxlength="18" placeholder="CNPJ" onkeydown="javascript: fMasc( this, mCNPJ );" style="width: 59%;"/>
                    <input type="text" name="txtGestao" maxlength="60" placeholder="Gestão" style="width: 40%;"/>
                    &nbsp;&nbsp;Atende ao Sus?
                    <select name="atende_sus" style="width: 33%">
                      <option name="opcao_sim">Sim</option>
                      <option name="opcao_nao">Não</option>
                    </select>
                    <input type="password" placeholder="⌨ Senha" name="senha_farmacia" minlength="8" maxlength="15" required/>
                    <input type="password" placeholder="⌨ Confirmar Senha" name="senha_confirma" minlength="8" maxlength="15" required/>
                    *Não compartilharemos suas informações com ninguém!
                    <br><br>
                    <input name="BotaoFarm" type="submit" value="Adicionar" style="cursor:pointer;"/>
                </form>
            </div>
      </div>
    </div>

    <script type="text/javascript">
        function modalAdicionarFarm()
        {
            document.getElementById("popup-adc-farm").classList.toggle("active");
        }
    </script>
    <!-- ===================================== modaaaaaaaaaaal cadastraaaaaaaar =========================================== -->

    <script type="text/javascript">
    	$(document).ready(function() 
        {
            $('#tabelaFarmacia').DataTable({
                "language" : 
                {

                    "decimal":        "",
                    "emptyTable":     "<b>Sem dados disponíveis na tabela</b>",
                    "info":           "&nbsp;&nbsp;<b>Mostrando de _START_ até _END_ de _TOTAL_ registros</b>",
                    "infoEmpty":      "&nbsp;&nbsp;<b>Mostrando 0 de 0 até 0 registros</b>",
                    "infoFiltered":   "<b>(Filtrando um total de  _MAX_  entradas)</b>",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "&nbsp;&nbsp;<b>Mostrar _MENU_ registros</b><br><br>",
                    "loadingRecords": "<b>Carregando...</b>",
                    "processing":     "<b>Processando...</b>",
                    "search":         "<b>Pesquisar:</b>",
                    "zeroRecords":    "Nenhum registro correspondente encontrado",
                    "paginate" : 
                    {
                        "first":      "<b>Primeiro</b>",
                        "last":       "<b>Último</b>",
                        "next":       "<b>Próximo</b>",
                        "previous":   "<b>Anterior</b>"
                    }
                }
            });
        });
    </script>
    <script src="./js/funcaoMapa.js"></script>

<?php

// ======================= BOTÃO CADASTRAR  =================================
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'cadastrarFarm')) 
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
    $botao = $_POST["BotaoFarm"];

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

    if ($botao == "Adicionar") 
    {
        try 
        {
            if ($senhaFarmacia == $confirmaSenha) // Verificando se as senhas são iguais
            {
                $senhaFarmaciaC = base64_encode($senhaFarmacia);

                // Validando campos
                $tamanhoTel = strlen($telFarmacia);
                $tamanhoCNPJ = strlen($cnpjFarmacia);
                $tamanhoCNES = strlen($cnesFarmacia);
                $tamanhoEnd = strlen($enderecoFarmacia);

                if ($tamanhoTel < 10 || $tamanhoCNPJ < 14 || $tamanhoCNES < 7 || $tamanhoEnd < 1) 
                {
                    echo "<script> alert('Campos inválidos! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
                }
                else
                {
                    // Pegando a latitude e longitude com o endereço fornecido
                    $url = 'https://nominatim.openstreetmap.org/search/'.rawurlencode($enderecoFarmacia).'?format=json&limit=1&email=locafarma10@gmail.com';
 
                    $data = ''; // empty post
                    $opts = array
                    (
                        'http' => array
                        (
                        'header' => "Content-type: text/html\r\nContent-Length: " . strlen($data) . "\r\n",
                        'method' => 'POST'
                        ),
                    ); 
                    // Create a stream
                    $context = stream_context_create($opts);
                    // Open the file - get the json response using the HTTP headers set above
                    $jsonfile = file_get_contents($url, false, $context);
                    // decode the json 
                    if (!json_decode($jsonfile, TRUE)) {return false;}else
                    {
                        //if (empty(array_filter($resp))) {return false;}else{
                        $resp = json_decode($jsonfile, true);
                        //if(is_string($resp)){$resp = 'true';}else{$resp = 'itsnot';}
                        // Extract data (e.g. latitude and longitude) from the results    
                        $gps['latitude'] = $resp[0]['lat'];
                        $gps['longitude'] = $resp[0]['lon'];
                    }

                    $latitude = $gps['latitude'];
                    $longitude = $gps['longitude'];

                    // Verificando se há um e-mail existente no banco de dados
                    $Comando = $conexao->prepare("SELECT * FROM tb_farmacia WHERE EMAIL_FARM=?");
                    $Comando->bindParam(1, $emailFarmacia);

                    if ($Comando->execute()) 
                    {
                        if ($Comando->rowCount() > 0) // Se houver um e-mail existente, recarregue a página
                        {
                            echo "<script> alert('E-mail já existente! Porfavor insira outro.'); location.href='painelAdm.php'; </script>";
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
                                        
                                        echo("<script> alert('Farmácia cadastrada com sucesso !!!'); location.href='painelAdm.php'; </script>"); // alert, redirecionamento
                                    }
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
                echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
            }   
        } 
        catch (Exception $erro) 
        {
            echo "Erro ao efetuar o cadastro!" . $erro->getMessage();   
        }
    }  
}
// ======================= BOTÃO CADASTRAR =================================

// ======================= BOTÃO ALTERAR =================================
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'alterarFarm')) 
{
    $idFarm = $_POST["id"];
    $emailFarm_registrado = $_POST["email_farmacia_registrado"];
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
    $botao = $_POST["BotaoFarm"];

    // Funções para retirar os caracteres especiais
        function limpa_caractere_tel($telFarmacia)
        {
            return preg_replace("/[^0-9]/", "", $telFarmacia); 
        }
        function limpa_caractere_cnpj($cnpjFarmacia)
        {
            return preg_replace("/[^0-9]/", "", $cnpjFarmacia); 
        }
        $cnpjFarmacia = limpa_caractere_cnpj($cnpjFarmacia);
        $telFarmacia = limpa_caractere_tel($telFarmacia);
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
                $tamanhoTel = strlen($telFarmacia);
                $tamanhoCNPJ = strlen($cnpjFarmacia);
                $tamanhoCNES = strlen($cnesFarmacia);
                if ($tamanhoTel < 10 || $tamanhoCNPJ < 14 || $tamanhoCNES < 7 || $tamanhoEnd < 1) 
                {
                    echo "<script> alert('Campos inválidos! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
                }
                else
                {
                    // Verificando se já há um e-mail existente no banco de dados
                    $Comando = $conexao->prepare("SELECT * FROM tb_farmacia WHERE EMAIL_FARM <> ? AND EMAIL_FARM = ?");
                    $Comando->bindParam(1, $emailFarm_registrado);
                    $Comando->bindParam(2, $emailFarmacia);

                    if ($Comando->execute()) 
                    {
                        if ($Comando->rowCount() > 0) 
                        {
                            echo "<script> alert('E-mail já existente! Porfavor insira outro.'); location.href='painelAdm.php'; </script>";
                        }
                        else
                        {
                            $Comando=$conexao->prepare("UPDATE tb_farmacia SET NOME_FARM=?, CNES_FARM=?, CNPJ_FARM=?, ENDERECO_FARM=?, TEL_FARM=?, GESTAO=?, ATENDE_SUS=?, EMAIL_FARM=?, SENHA_FARM=? WHERE ID_FARM=?");
                            $Comando->bindParam(1, $nomeFarmacia);
                            $Comando->bindParam(2, $cnesFarmacia);
                            $Comando->bindParam(3, $cnpjFarmacia);
                            $Comando->bindParam(4, $enderecoFarmacia);
                            $Comando->bindParam(5, $telFarmacia);
                            $Comando->bindParam(6, $gestaoFarmacia);
                            $Comando->bindParam(7, $opcaoAtendeSus);
                            $Comando->bindParam(8, $emailFarmacia);
                            $Comando->bindParam(9, $senhaFarmaciaC);
                            $Comando->bindParam(10, $idFarm);

                            if ($Comando->execute()) 
                            {
                                echo("<script> alert('Dados atualizados com sucesso !!! ATENÇÃO - Necessária a atualização de dados no arquivo json manualmente.'); location.href='painelAdm.php'; </script>"); // alert, redirecionamento
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
                echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
            }
        }
        catch (Exception $erro) 
        {
            echo "Erro !" . $erro->getMessage();    
        }
    }
}
// ======================= BOTÃO ALTERAR  =================================


if (isset($_GET["acao"])) 
{

    // BOTÃO EXCLUIR ======================================
    if ($_GET["acao"] == "excluirFarm") 
    {
        $id = $_GET["id"];
        $Comando=$conexao->prepare("DELETE FROM tb_farmacia WHERE ID_FARM=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            $Comando=$conexao->prepare("DELETE FROM tb_medicamento_anvisa WHERE ID_FARM=?");
            $Comando->bindParam(1, $id);

            if ($Comando->execute()) 
            {
                echo("<script> alert('Farmácia e medicamentos excluídos com sucesso!'); location.href='painelAdm.php'; </script>");
            }
            else
            {
                throw new Exception("Error Processing Request", 1);
            }
        }
        else
        {
            throw new Exception("Error Processing Request", 1);
        }
    } 
    // BOTÃO EXCLUIR ========================================

    // =========================== BOTÃO EDITAR ================================
    if ($_GET["acao"] == "editarFarm") 
    {
        $id = $_GET["idfarm"];
        $Comando=$conexao->prepare("SELECT * FROM tb_farmacia WHERE ID_FARM=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
            {
                $idFarm = $Linha->ID_FARM;
                $nomeFarm = $Linha->NOME_FARM;
                $cnesFarm = $Linha->CNES_FARM;
                $cnpjFarm = $Linha->CNPJ_FARM;
                $endFarm = $Linha->ENDERECO_FARM;
                $telFarm = $Linha->TEL_FARM;
                $gestaoFarm = $Linha->GESTAO;
                $atendeFarm = $Linha->ATENDE_SUS;
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
                ?>
                <div class="popup" id="popup-alt-farm">
                  <div class="overlay"></div>
                  <div class="content">
                    <div class="close-btn" onclick="modalEditarFarm()">&times;</div>
                    <!-- <h1>Alterar Usuário</h1> -->
                        <div class="form-style-6" style="">
                            <h1>Cadastro Farmacêutico</h1>
                            <form name="form1" action="painelAdm.php?valor=alterarFarm" method="POST">
                                <input type="hidden" name="id" class="form-control" value="<?php echo($idFarm); ?>" >
                                <input type="hidden" name="email_farmacia_registrado" class="form-control" value="<?php echo($emailFarm); ?>" >
                                <input type="text" placeholder="✎ Nome Farmácia" name="nome_farmacia" maxlength="60" required autofocus style="width: 40%;" value="<?php echo($nomeFarm) ?>" />
                                <input type="email" placeholder="✉ Email" name="email_farmacia" maxlength="60" required style="width: 59%;" value="<?php echo($emailFarm) ?>" />
                                <input type="text" name="txtEndereco" maxlength="60" placeholder="Endereço" style="width: 59%;" value="<?php echo($endFarm) ?>"/>
                                <input type="text" name="txtTelefone" maxlength="15" placeholder="☎ Telefone" onkeydown="javascript: fMasc( this, mTel );"  value="<?php echo($telFarm) ?>" style="width: 40%;" required/>
                                <input type="text" name="txtCnes" maxlength="7" placeholder="CNES" onkeydown="javascript: fMasc( this, mNum );" style="width: 40%;"  value="<?php echo($cnesFarm) ?>"/>
                                <input type="text" name="txtCnpj" maxlength="18" placeholder="CNPJ" onkeydown="javascript: fMasc( this, mCNPJ );" style="width: 59%;"  value="<?php echo($cnpjFarm) ?>"/>
                                <input type="text" name="txtGestao" maxlength="60" placeholder="Gestão" style="width: 40%;"  value="<?php echo($gestaoFarm) ?>"/>
                                &nbsp;&nbsp;Atende ao Sus?
                                <select name="atende_sus" id="atende_sus" style="width: 33%">
                                  <?php 
                                      if ($atendeFarm == "Sim") 
                                      {
                                         echo "<option name=opcao_sim>Sim</option>";
                                         echo "<option name=opcao_nao>Não</option>";
                                      }
                                      if ($atendeFarm == "Não") 
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
                                <input name="BotaoFarm" type="submit" value="Alterar Cadastro" style="cursor:pointer;"/>
                                <!-- <input name="Botao" type="submit" value="Excluir Cadastro" style="cursor:pointer; width: 49%; background: #f58282;"/> -->
                            </form>
                        </div>
                  </div>
                </div>  
                    <script type="text/javascript">
                        document.getElementById("popup-alt-farm").classList.toggle("active");

                        var opcao = "farm";
                        
                        function modalEditarFarm() 
                        {
                            document.getElementById("popup-alt-farm").classList.toggle("active");
                            location.href='painelAdm.php';
                        }
                    </script>
                <?php
            }
        }
        else
        {
            throw new Exception("Error Processing Request", 1);
        }
    }
    // =========================== BOTÃO EDITAR ================================

}
?>