    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="./css/modal.css">
    <link rel="stylesheet" type="text/css" href="./css/crud.css">
    

	<div class="container" style="width: auto;">
        <center><br><button class="butao" onclick="modalAdicionarUsu()">Adicionar Usuário</button></center>

		<div class="row">
            <table id="gerencia_usu" class="display" style="width: 99%; font-size: 85%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome Usuário</th>
                        <th>E-mail</th>                                
                        <th>CEP</th>  
                        <th>Senha</th>
                        
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                	      include("conexao.php");

                          $Comando=$conexao->prepare("SELECT * FROM tb_usuario");
                          if ($Comando->execute()) 
                          {
                              while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                              {
                                $idUsu = $Linha->ID_USU;
                                $nomeUsu = $Linha->NOME_USU;
                                $emailUsu = $Linha->EMAIL_USU;
                                $cepUsu = $Linha->CEP_USU;
                                $senhaUsu = $Linha->SENHA_USU;

                                // Colocando os caracteres especiais no CEP
                                $cep = substr_replace($cepUsu, '.', 2, 0);
                                $cep = substr_replace($cep, '-', 6, 0);

                                ?>
                                <tr>
                                    <td><?php echo $idUsu; ?></td>
                                    <td><?php echo $nomeUsu; ?></td>
                                    <td><?php echo $emailUsu; ?></td>
                                    <td><?php echo $cep; ?></td>
                                    <td><?php echo $senhaUsu; ?></td>
                                    
                                    <td><a href="<?php echo "painelAdm.php?acao=editarUsu&id=$idUsu";?>" class="butaomodal">Editar</a></td>
                                    <td><a href="<?php echo "painelAdm.php?acao=excluirUsu&id=$idUsu";?>"class="butaomodal" onclick="return confirm('Você realmente deseja excluir este usuário?')">Excluir</a></td>
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
    <div class="popup" id="popup-adc-usu">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-btn" onclick="modalAdicionarUsu()">&times;</div>
        <!-- <h1>Adicionar Usuário</h1> -->
                <div class="form-style-6" style="width: 400px">
                <form name="form1" action="painelAdm.php?valor=cadastrarUsu" method="POST">
                    <h1>Adicionar Usuário</h1>
                    <input type="hidden" name="id" class="form-control" >
                    <input type="text" id="nome_cadastro" placeholder="✎ Nome" maxlength="60" name="nome_cadastro" required autofocus />
                    <input type="email" id="usuario_cadastro" placeholder="✉ Email" maxlength="50" name="usuario_cadastro" required />
                    <input type="text" name="txtCep" maxlength="10" placeholder="✉ CEP" autofocus required onkeydown="javascript: fMasc( this, mCEP );"/>
                    <input type="password" id="senha_cadastro" placeholder="⌨ Senha" name="senha_cadastro_usu" minlength="8" maxlength="15" required/>
                    <input type="password" id="senha_confirma" placeholder="⌨ Confirmar Senha" name="senha_confirma_usu" minlength="8" maxlength="15" required/>
                    *Não compartilharemos suas informações com ninguém!
                    <br><br>
                    <input name="Botao" type="submit" value="Adicionar" style="cursor:pointer;"/>
                </form>
            </div>
      </div>
    </div>

    <script type="text/javascript">
        function modalAdicionarUsu()
        {
            document.getElementById("popup-adc-usu").classList.toggle("active");
        }
    </script>
    <!-- ===================================== modaaaaaaaaaaal cadastraaaaaaaar =========================================== -->

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() 
    {
        $('#gerencia_usu').DataTable({
             
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
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'cadastrarUsu')) 
{
    $Nome = $_POST["nome_cadastro"];
    $Email = $_POST["usuario_cadastro"];
    $Cep = $_POST["txtCep"];
    $Senha = $_POST["senha_cadastro_usu"];
    $SenhaConfirma = $_POST["senha_confirma_usu"];
    $botao = $_POST["Botao"];

    // Função para limpar os caracteres especiais
    function limpa_caractere($Cep)
    {
        return preg_replace("/[^0-9]/", "", $Cep); 
    }

    // Setando a variavel sem os caracteres especiais
    $Cep = limpa_caractere($Cep);

    if ($botao == "Adicionar") 
    {
        try
        {
            if ($Senha == $SenhaConfirma)
            {
                $SenhaC = base64_encode($Senha);
                $tamanhoCep = strlen($Cep);

                // Validando o CEP
                if ($tamanhoCep < 8) 
                {
                    echo "<script> alert('CEP inválido! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
                }
                else
                {
                    $Comando=$conexao->prepare("SELECT * FROM TB_USUARIO WHERE EMAIL_USU=?");
                    $Comando->bindParam(1, $Email);
                
                    if ($Comando->execute()) 
                    {
                        if ($Comando->rowCount() > 0) 
                        {
                            echo "<script> alert('Usuário já existente! Porfavor insira outro.'); location.href='painelAdm.php'; </script>";
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
                                echo("<script> alert('Usuário cadastrado com sucesso !!!'); location.href='painelAdm.php';</script>"); // alert, redirecionamento
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
                echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
            }    
        }   
        catch (PDOException $erro)
        {
            echo "Erro!" . $erro->getMessage();
        }
    }   
}
// ======================= BOTÃO CADASTRAR AOOOO =================================

// ======================= BOTÃO ALTERAR =================================
if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'alterarUsu')) 
{
    $idUsu = $_POST["id"];
    $emailRegistrado = $_POST["email_registrado"];
    $Nome = $_POST["nome_cadastro"];
    $Email = $_POST["usuario_cadastro"];
    $Cep = $_POST["txtCep"];
    $Senha = $_POST["senha_cadastro_usu"];
    $SenhaConfirma = $_POST["senha_confirma_usu"];
    $botao = $_POST["Botao"];

    // Função para limpar os caracteres especiais
    function limpa_caractere($Cep)
    {
        return preg_replace("/[^0-9]/", "", $Cep); 
    }

    // Setando a variavel sem os caracteres especiais
    $Cep = limpa_caractere($Cep);

    if ($botao == "Alterar") 
    {
        try 
        {
            if ($Senha == $SenhaConfirma) 
            {
                $SenhaC = base64_encode($Senha);

                // Validando o CEP
                $tamanhoCep = strlen($Cep);
                if ($tamanhoCep < 8) 
                {
                    echo "<script> alert('CEP inválido! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
                }
                else
                {
                    $Comando=$conexao->prepare("SELECT * FROM tb_usuario WHERE EMAIL_USU <> ? AND EMAIL_USU = ?");
                    $Comando->bindParam(1, $emailRegistrado);
                    $Comando->bindParam(2, $Email);

                    if ($Comando->execute()) 
                    {
                        if ($Comando->rowCount() > 0) 
                        {
                            echo "<script> alert('E-mail já existente! Porfavor insira outro.'); location.href='painelAdm.php'; </script>";
                        }
                        else
                        {
                            $Comando=$conexao->prepare("UPDATE tb_usuario SET NOME_USU=?, EMAIL_USU=?, CEP_USU=?, SENHA_USU=? WHERE ID_USU=?");
                            $Comando->bindParam(1, $Nome);
                            $Comando->bindParam(2, $Email);
                            $Comando->bindParam(3, $Cep);
                            $Comando->bindParam(4, $SenhaC);
                            $Comando->bindParam(5, $idUsu);

                            if ($Comando->execute()) 
                            {
                                echo("<script> alert('Dados atualizados com sucesso !!!'); location.href='painelAdm.php'; </script>"); // alert, redirecionamento
                            }
                            else
                            {
                                throw new Exception("Erro ao efetuar a alteração", 1);
                            }
                        }
                    }
                    else
                    {
                        throw new Exception("Erro ao efetuar a alteração.", 1);
                    }
                }
            }
            else
            {
                echo "<script> alert('Senhas não conferem! Porfavor tente novamente.'); location.href='painelAdm.php'; </script>";
            }      
        } 
        catch (Exception $e) 
        {
            echo "Erro !" . $e->getMessage();
        }
    }   
}
// ======================= BOTÃO ALTERAR =================================


if (isset($_GET["acao"])) 
{

    // BOTÃO EXCLUIR ======================================
    if ($_GET["acao"] == "excluirUsu") 
    {
        $id = $_GET["id"];
        $Comando=$conexao->prepare("DELETE FROM tb_usuario WHERE ID_USU=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            echo("<script> alert('Usuário excluído com sucesso!'); location.href='painelAdm.php'; </script>");
        }
        else
        {
            throw new Exception("Error Processing Request", 1);
        }
    } 
    // BOTÃO EXCLUIR ========================================

    // =========================== BOTÃO EDITAR ================================
    if ($_GET["acao"] == "editarUsu") 
    {
        $id = $_GET["id"];
        $Comando=$conexao->prepare("SELECT * FROM tb_usuario WHERE ID_USU=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
            {
                $idUsu = $Linha->ID_USU;
                $nomeUsu = $Linha->NOME_USU;
                $emailUsu = $Linha->EMAIL_USU;
                $cepUsu = $Linha->CEP_USU;
                $senhaUsu = $Linha->SENHA_USU;

                 // Colocando os caracteres especiais no CEP
                $cep = substr_replace($cepUsu, '.', 2, 0);
                $cep = substr_replace($cep, '-', 6, 0);
                ?>
               
                <div class="popup" id="popup-alt-usu">
                  <div class="overlay"></div>
                  <div class="content">
                    <div class="close-btn" onclick="modalEditarUsu()">&times;</div>
                    <!-- <h1>Alterar Usuário</h1> -->
                            <div class="form-style-6" style="width: 400px">
                                <h1>Alteração de Cadastro</h1>
                            <form name="form1" action="painelAdm.php?valor=alterarUsu" method="POST">
                                <input type="hidden" name="id" class="form-control" value="<?php echo($idUsu); ?>" >
                                <input type="hidden" name="email_registrado" class="form-control" value="<?php echo($emailUsu); ?>" >
                                <input type="text" id="nome_cadastro" placeholder="✎ Nome" maxlength="60" name="nome_cadastro" required autofocus value="<?php echo($nomeUsu); ?>" />
                                <input type="email" id="usuario_cadastro" placeholder="✉ Email" maxlength="50" name="usuario_cadastro" required value="<?php echo($emailUsu); ?>" />
                                <input type="text" name="txtCep" maxlength="10" placeholder="✉ CEP" onkeydown="javascript: fMasc( this, mCEP );" value="<?php echo($cep); ?>"/>
                                <input type="password" id="senha_cadastro" placeholder="⌨ Senha" name="senha_cadastro_usu" minlength="8" maxlength="15" required value="<?php echo(base64_decode($senhaUsu)); ?>"/>
                                <input type="password" id="senha_confirma" placeholder="⌨ Confirmar Senha" name="senha_confirma_usu" minlength="8" maxlength="15" required value="<?php echo(base64_decode($senhaUsu)); ?>"/>
                                *Não compartilharemos suas informações com ninguém!
                                <br><br>
                                <input name="Botao" type="submit" value="Alterar" style="cursor:pointer;"/>
                            </form>
                        </div>
                  </div>
                </div>
                   
                    <script type="text/javascript">
                        document.getElementById("popup-alt-usu").classList.toggle("active");
                        function modalEditarUsu() 
                        {
                            document.getElementById("popup-alt-usu").classList.toggle("active");
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