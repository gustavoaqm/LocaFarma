    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="./css/modal.css">
    <link rel="stylesheet" type="text/css" href="./css/crud.css">

	<div class="container" style="width: auto;">

        <br><center><button class="butao" onclick="modalAdicionarMed()">Adicionar Medicamento</button></center>

		<div class="row">
            <table id="crudMed" class="display" style="width: 99%; font-size: 85%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Principio Ativo</th>
                        <th>CPNJ</th>                                
                        <th>Laboratorio</th>  
                        <th>Codggrem</th>
                        <th>EAN</th>
                        <th>Nome</th>
                        <th>Apresentação</th>
                        <th>Preço Fabricação</th>
                        <th>Preço Comercial</th>
                        <th>Restrição Hospitalar</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                	      include("conexao.php");

                          $idFarm = $_SESSION["id_farm"];

                          $Comando=$conexao->prepare("SELECT * FROM tb_medicamento_anvisa WHERE ID_FARM=?");
                          $Comando->bindParam(1, $idFarm);
                          if ($Comando->execute()) 
                          {
                            if ($Comando->rowCount () > 0) 
                            {
                                while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                                {
                                    $idMed = $Linha->id;
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

                                    // Colocando os caracteres especiais no CNPJ
                                    $cnpj = substr_replace($cnpj, '.', 2, 0);
                                    $cnpj = substr_replace($cnpj, '.', 6, 0);
                                    $cnpj = substr_replace($cnpj, '/', 10, 0);
                                    $cnpj = substr_replace($cnpj, '-', 15, 0);

                                    ?>
                                    <tr>
                                        <td><?php echo $idMed; ?></td>
                                        <td><?php echo $principio; ?></td>
                                        <td><?php echo $cnpj; ?></td>
                                        <td><?php echo $laboratorio; ?></td>
                                        <td><?php echo $codggrem; ?></td>
                                        <td><?php echo $ean; ?></td>
                                        <td><?php echo $nome; ?></td>
                                        <td><?php echo $apresentacao; ?></td>
                                        <td><?php if ($precofab == "") {echo "-";}else {echo "R$ ".$precofab;} ?></td>
                                        <td><?php if ($precocomercial == "") { echo "-";}else{ echo "R$ ".$precocomercial;} ?></td>
                                        <td><?php echo $restricaohospitalar; ?></td>
                                        <td><a href="<?php echo "painelFarm.php?acao=editar&id=$idMed";?>" class="butaomodal">Editar</a></td>
                                        <td><a href="<?php echo "painelFarm.php?acao=excluir&id=$idMed";?>"class="butaomodal" onclick="return confirm('Você realmente deseja deletar este medicamento?')">Excluir</a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                                echo "&nbsp;&nbsp;<b>Olá ". $nomeFarm ."! Percebemos que você não possui nenhum medicamento ainda! Adicione alguns clicando no botão acima agora mesmo!!</b><br><br> ";
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
    <div class="popup" id="popup-adc-med">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-btn" onclick="modalAdicionarMed()">&times;</div>
        <!-- <h1>Adicionar Usuário</h1> -->
            <div class="form-style-6" style="">
                <h1>Adicionar Medicamento</h1>
                <form name="form1" action="painelFarm.php?valor=cadastrar" method="POST">
                    <input type="hidden" name="id" class="form-control">
                    <input type="text" placeholder="✎ Principio Ativo" name="principio_ativo" maxlength="255" autofocus style="width: 40%;" required />
                    <input type="text" placeholder="CNPJ" maxlength="18" name="cnpj" onkeydown="javascript: fMasc( this, mCNPJ );" style="width: 59%;" required/>
                    <input type="text" name="laboratorio" placeholder="Laboratorio" maxlength="160" style="width: 59%;" required/>
                    <input type="text" name="codggrem" placeholder="Código GGREM" maxlength="15" onkeydown="javascript: fMasc( this, mNum );" style="width: 40%;" required/>
                    <input type="text" name="nome" placeholder="Medicamento" maxlength="255" style="width: 54%;" required/>
                    <input type="text" name="ean" placeholder="EAN" maxlength="13" onkeydown="javascript: fMasc( this, mNum );" style="width: 45%;" required/>
                    <input type="text" name="apresentacao" placeholder="Apresentação" maxlength="255" style="width: 99%;" required/>
                    <input type="text" name="precofab" placeholder="Preço de Fabricação" style="width: 58%;" onKeyPress="return(MascaraMoeda(this,'.',',',event))" >
                    <input type="text" name="precocomercial" placeholder="Preço Comercial" style="width: 40%;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"/>
                    Restrição Hospitalar
                    <select name="restricaohospitalar" style="width: 69%;">
                      <option name="opcao_sim">Sim</option>
                      <option name="opcao_nao">Não</option>
                    </select>
                    <br><br>
                    <input name="Botao" type="submit" value="Adicionar" style="cursor:pointer;"/>
                </form>
            </div>
      </div>
    </div>

    <script type="text/javascript">
        function modalAdicionarMed()
        {
            document.getElementById("popup-adc-med").classList.toggle("active");
        }
    </script>
    <!-- ===================================== modaaaaaaaaaaal cadastraaaaaaaar =========================================== -->

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function() 
        {   
            $('#crudMed').DataTable({
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
<?php

// ======================= BOTÃO CADASTRAR AOOOO =================================
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'cadastrar')) 
{
    $idMed = $_POST['id'];
    $principio = $_POST['principio_ativo'];
    $cnpj = $_POST['cnpj'];
    $laboratorio = $_POST['laboratorio'];
    $codggrem = $_POST['codggrem'];
    $ean = $_POST['ean'];
    $nome = $_POST['nome'];
    $apresentacao = $_POST['apresentacao'];
    $precofab = $_POST['precofab'];
    $precocomercial = $_POST['precocomercial'];
    $restricaohospitalar = $_POST['restricaohospitalar'];
    $botao = $_POST['Botao'];

    // Tirando todos os caracteres especiais do cnpj
    function limpa_cnpj($cnpj)
    {
        return preg_replace("/[^0-9]/", "", $cnpj); 
    }
    $cnpj = limpa_cnpj($cnpj);

    // Validando o Codigo GGREM
    $tamanhoCodGGREM = strlen($codggrem);
    if ($tamanhoCodGGREM < 15) 
    {
        echo "<script> alert('Código GGREM inválido! Porfavor tente novamente.'); location.href='painelFarm.php'; </script>";
    }

    // Validando o Codigo EAN
    $tamanhoCodEAN = strlen($ean);
    if ($tamanhoCodEAN < 13) 
    {
        echo "<script> alert('Código EAN inválido! Porfavor tente novamente.'); location.href='painelFarm.php'; </script>";
    }

    // Verificando se os campos estão nulos e substituindo a vírgula por ponto para colocar no banco de dados
    if ($precofab == "" && $precocomercial == "") 
    {
        $precofab = "0.00"; $precocomercial = "0.00"; 
    }
    elseif ($precofab == "" && $precocomercial != "") 
    {
        $precofab = "0.00"; $precocomercial = str_replace([','],'.', $precocomercial);
    }
    elseif ($precofab != "" && $precocomercial == "") 
    {
        $precofab = str_replace([','],'.', $precofab); $precocomercial = "0.00";
    }
    elseif ($precofab != "" && $precocomercial != "")
    {
        $precofab = str_replace([','],'.', $precofab);
        $precocomercial = str_replace([','],'.', $precocomercial);
    }
 
    if ($botao == "Adicionar") 
    {
        // Validando o CNPJ
        $tamanhoCNPJ = strlen($cnpj);
        if ($tamanhoCNPJ < 14) 
        {
            echo "<script> alert('CPNJ inválido! Porfavor tente novamente.'); location.href='painelFarm.php'; </script>";
        }
        else
        {
            $Comando=$conexao->prepare("INSERT INTO tb_medicamento_anvisa(ID_FARM, principio_ativo, cnpj, laboratorio, codggrem, ean, nome, apresentacao, precofab, precocomercial, restricaohospitalar) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $Comando->bindParam(1, $idFarm);
            $Comando->bindParam(2, $principio);
            $Comando->bindParam(3, $cnpj);
            $Comando->bindParam(4, $laboratorio);
            $Comando->bindParam(5, $codggrem);
            $Comando->bindParam(6, $ean);
            $Comando->bindParam(7, $nome);
            $Comando->bindParam(8, $apresentacao);
            $Comando->bindParam(9, $precofab);
            $Comando->bindParam(10, $precocomercial);
            $Comando->bindParam(11, $restricaohospitalar);

            if ($Comando->execute()) 
            {
                echo("<script> alert('Dados cadastrados com sucesso!'); location.href='painelFarm.php'; </script>");
            }
            else
            {
                throw new Exception("Erro ao fazer a inserção!", 1);
            }
        }
    }   
}
// ======================= BOTÃO CADASTRAR =================================

// ======================= BOTÃO ALTERAR =================================
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'alterar')) 
{
    $idMed = $_POST['id_med'];
    $principio = $_POST['principio_ativo'];
    $cnpj = $_POST['cnpj'];
    $laboratorio = $_POST['laboratorio'];
    $codggrem = $_POST['codggrem'];
    $ean = $_POST['ean'];
    $nome = $_POST['nome'];
    $apresentacao = $_POST['apresentacao'];
    $precofab = $_POST['precofab'];
    $precocomercial = $_POST['precocomercial'];
    $restricaohospitalar = $_POST['restricaohospitalar'];
    $botao = $_POST['Botao'];

    // Tirando todos os caracteres especiais do cnpj
    function limpa_cnpj($cnpj)
    {
        return preg_replace("/[^0-9]/", "", $cnpj); 
    }
    $cnpj = limpa_cnpj($cnpj);

    // Verificando se os campos estão nulos e substituindo a vírgula por ponto para colocar no banco de dados
    if ($precofab == "" && $precocomercial == "") 
    {
        $precofab = "0.00"; $precocomercial = "0.00"; 
    }
    elseif ($precofab == "" && $precocomercial != "") 
    {
        $precofab = "0.00"; $precocomercial = str_replace([','],'.', $precocomercial);
    }
    elseif ($precofab != "" && $precocomercial == "") 
    {
        $precofab = str_replace([','],'.', $precofab); $precocomercial = "0.00";
    }
    elseif ($precofab != "" && $precocomercial != "")
    {
        $precofab = str_replace([','],'.', $precofab);
        $precocomercial = str_replace([','],'.', $precocomercial);
    }

    if ($botao == "Alterar") 
    {
        // Validando o CNPJ
        $tamanhoCNPJ = strlen($cnpj);
        if ($tamanhoCNPJ < 14) 
        {
            echo "<script> alert('CPNJ inválido! Porfavor tente novamente.'); location.href='painelFarm.php'; </script>";
        }
        else
        {
            $Comando=$conexao->prepare("UPDATE tb_medicamento_anvisa SET principio_ativo=?, cnpj=?, laboratorio=?, codggrem=?, ean=?, nome=?, apresentacao=?, precofab=?, precocomercial=?, restricaohospitalar=? WHERE id=?");
            $Comando->bindParam(1, $principio);
            $Comando->bindParam(2, $cnpj);
            $Comando->bindParam(3, $laboratorio);
            $Comando->bindParam(4, $codggrem);
            $Comando->bindParam(5, $ean);
            $Comando->bindParam(6, $nome);
            $Comando->bindParam(7, $apresentacao);
            $Comando->bindParam(8, $precofab);
            $Comando->bindParam(9, $precocomercial);
            $Comando->bindParam(10, $restricaohospitalar);
            $Comando->bindParam(11, $idMed);

            if ($Comando->execute()) 
            {
                echo("<script> alert('Dados atualizados com sucesso!'); location.href='painelFarm.php'; </script>");
            }
            else
            {
                throw new Exception("Erro ao executar a inserção!", 1);
            }
        }
    }   
}
// ======================= BOTÃO ALTERAR =================================


if (isset($_GET["acao"])) 
{

    // BOTÃO EXCLUIR ======================================
    if ($_GET["acao"] == "excluir") 
    {
        $id = $_GET["id"];
        $Comando=$conexao->prepare("DELETE FROM tb_medicamento_anvisa WHERE id=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            echo("<script> alert('Dados excluidos com sucesso!'); location.href='painelFarm.php'; </script>");
        }
        else
        {
            throw new Exception("Error Processing Request", 1);
        }
    } 
    // BOTÃO EXCLUIR ========================================

    // =========================== BOTÃO EDITAR ================================
    if ($_GET["acao"] == "editar") 
    {
        $id = $_GET["id"];
        $Comando=$conexao->prepare("SELECT * FROM tb_medicamento_anvisa WHERE id=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
            {
                $idMed = $Linha->id;
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

                // Colocando os caracteres especiais no CNPJ
                function cnpjMed($cnpj)
                {
                    return preg_replace("/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/", "\\1.\\2.\\3/\\4-\\5", $cnpj);
                }
                $cnpj = cnpjMed($cnpj);

                // Substituindo o ponto por vírgula para exibir no form
                $precofab = str_replace(['.'],',', $precofab);
                $precocomercial = str_replace(['.'],',', $precocomercial);

                ?>
               
                   <div class="popup" id="popup-edita-med">
                      <div class="overlay"></div>
                      <div class="content">
                        <div class="close-btn" onclick="modalEditarMed()">&times;</div>
                        <!-- <h1>Adicionar Usuário</h1> -->
                            <div class="form-style-6" style="">
                                <h1>Editar Medicamento</h1>
                                <form action="painelFarm.php?valor=alterar" method="POST">
                                    <input type="hidden" name="id_med" class="form-control" value="<?php echo($idMed) ?>">
                                    Medicamento: <input type="text" name="nome" maxlength="255" placeholder="Medicamento" style="width: 78%;" value="<?php echo($nome)?>"/>
                                    Princípio Ativo: <input type="text" placeholder="✎ Principio Ativo" maxlength="255" name="principio_ativo" autofocus style="width: 77%;" value="<?php echo($principio)?>"/>
                                    Apresentação: <input type="text" name="apresentacao" placeholder="Apresentação" maxlength="255" style="width: 78%;" value="<?php echo($apresentacao)?>"/>
                                    Laboratório: <input type="text" name="laboratorio" placeholder="Laboratorio" maxlength="160" style="width: 81%;" value="<?php echo($laboratorio)?>"/>
                                    Código GGREM: <input type="text" name="codggrem" placeholder="Código GGREM" maxlength="15" onkeydown="javascript: fMasc( this, mNum );" style="width: 32%;" value="<?php echo($codggrem)?>"/>
                                    CNPJ: <input type="text" placeholder="CNPJ" name="cnpj" maxlength="18" onkeydown="javascript: fMasc( this, mCNPJ );" style="width: 33%;"  value="<?php echo($cnpj)?>" />
                                    Código EAN: <input type="text" name="ean" placeholder="EAN" maxlength="13" onkeydown="javascript: fMasc( this, mNum );" style="width: 30%;" value="<?php echo($ean)?>"/>
                                     &nbsp;Restrição Hospitalar
                                    <select name="restricaohospitalar" style="width: 17.5%;">
                                      <?php
                                        if ($restricaohospitalar == "Sim") 
                                        {
                                            echo "<option name=opcao_sim>Sim</option>";
                                            echo "<option name=opcao_nao>Não</option>";
                                        }
                                        if ($restricaohospitalar == "Não") 
                                        {
                                            echo "<option name=opcao_sim>Não</option>";
                                            echo "<option name=opcao_nao>Sim</option>";
                                        }
                                      ?>
                                    </select>
                                    Preço de Fabricação: <input type="text" name="precofab" placeholder="Preço de Fabricação" style="width: 20%;" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo($precofab)?>"/>&nbsp;&nbsp;
                                    Preço Comercial: <input type="text" name="precocomercial" placeholder="Preço Comercial" style="width: 20%;" onKeyPress="return(MascaraMoeda(this,'.',',',event))" value="<?php echo($precocomercial)?>"/>
                                    <br><br>
                                    <input name="Botao" type="submit" value="Alterar" style="cursor:pointer;"/>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        document.getElementById("popup-edita-med").classList.toggle("active");
                        function modalEditarMed() 
                        {
                            document.getElementById("popup-edita-med").classList.toggle("active");
                            location.href='painelFarm.php';
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