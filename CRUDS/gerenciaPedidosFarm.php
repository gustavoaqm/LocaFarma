
	<div class="container" style="width: auto;">
		<div class="row">
            <table id="gerencia_pedidos" class="display" style="width: 99%; font-size: 85%;">
                <thead>
                    <tr>
                        <th>Id Pedido</th>
                        <th>Nome do solicitante</th>
                        <th>E-mail do solicitante</th>                                
                        <th>Medicamento Solicitado</th>  
                        <th>Descrição</th> 

                        <th>Responder</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                	      include("conexao.php");

                          $Comando=$conexao->prepare("SELECT * FROM tb_pedido WHERE ID_FARM=?");
                          $Comando->bindParam(1, $idFarm);

                          if ($Comando->execute()) 
                          {
                              if ($Comando->rowCount() > 0) 
                              {
                                  while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                                  {
                                        $idPedido = $Linha->ID_PED;
                                        $nomeSolicitante = $Linha->NOME_USU;
                                        $emailSolicitante = $Linha->EMAIL_USU;
                                        $nomeMedicamento = $Linha->NOME_MED;
                                        $descMedicamento = $Linha->DESC_MED;
                                    ?>
                                    <tr>
                                        <td><?php echo $idPedido; ?></td>
                                        <td><?php echo $nomeSolicitante; ?></td>
                                        <td><?php echo $emailSolicitante; ?></td>
                                        <td><?php echo $nomeMedicamento; ?></td>
                                        <td><?php if($descMedicamento == ""){ echo"Sem Descrição";}else{echo $descMedicamento;} ?></td>
                                        
                                        <td><a href="<?php echo "painelFarm.php?action=responderUsu&idPed=$idPedido";?>" class="butaomodal">Responder</a></td>
                                        <td><a href="<?php echo "painelFarm.php?action=excluirPed&idPed=$idPedido";?>" class="butaomodal" onclick="return confirm('Você realmente deseja excluir este pedido?')">Excluir</a></td>
                                    </tr>
                                    <?php
                                  }
                              }
                              else
                              {
                                  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Olá ". $nomeFarm ."! Você ainda não possui nenhum pedido solicitado!</b><br><br> ";  
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

    <script type="text/javascript">
    	$(document).ready(function() 
        {
            $('#gerencia_pedidos').DataTable({

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

if (isset($_GET["action"])) 
{

    // BOTÃO EXCLUIR ======================================
    if ($_GET["action"] == "excluirPed") 
    {
        $id = $_GET["idPed"];
        $Comando=$conexao->prepare("DELETE FROM tb_pedido WHERE ID_PED=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            echo("<script> alert('Pedido excluído com sucesso!'); location.href='painelFarm.php'; </script>");
        }
        else
        {
            throw new Exception("Error Processing Request", 1);
        }
    } 
    // BOTÃO EXCLUIR ========================================

    if ($_GET["action"] == "responderUsu") 
    {
        $idPedido = $_GET["idPed"];
        $Comando=$conexao->prepare("SELECT * FROM tb_pedido WHERE ID_PED=?");
        $Comando->bindParam(1, $idPedido);

        if ($Comando->execute()) 
        {
            while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
            {
                $nomeSolicitante = $Linha->NOME_USU;
                $emailSolicitante = $Linha->EMAIL_USU;
                $nomeMedicamento = $Linha->NOME_MED;

                $mensagem = "Olá " . $nomeSolicitante . "!" . " Obrigado por solicitar o medicamento no nosso site! Estamos passando aqui para lhe avisar que o(a) " . $nomeMedicamento . " Já está disponível na(o) " . $nomeFarm . "!";

                ?>
               
                <div class="popup" id="popup-resp-usu">
                  <div class="overlay"></div>
                  <div class="content">
                    <div class="close-btn" onclick="modalResponderUsuario()">&times;</div>
                    <!-- <h1>Alterar Usuário</h1> -->
                        <div class="form-style-6" style="">
                            <h1>Responder Usuário</h1>
                            <form name="form1" action="painelFarm.php?valor=enviarResposta" method="POST">
                                <input type="hidden" name="id" class="form-control" value="<?php echo($idPedido); ?>" >
                                <input type="text" placeholder="✎ Nome Cliente" name="nome_usuario" required autofocus style="width: 40%;" value="<?php echo($nomeSolicitante) ?>" readonly="true" />
                                <input type="email" placeholder="✉ Email Cliente" name="email_usuario" required style="width: 59%;"  value="<?php echo($emailSolicitante) ?>" readonly="true"  />
                                <textarea name="mensagem" placeholder="✉ Mensagem" style="height: 150px" ><?php echo($mensagem) ?></textarea>
                                <br><br>
                                <input name="BotaoFarm" type="submit" value="Enviar Resposta" style="cursor:pointer;"/>
                                <!-- <input name="Botao" type="submit" value="Excluir Cadastro" style="cursor:pointer; width: 49%; background: #f58282;"/> -->
                            </form>
                        </div>
                  </div>
                </div>  
                    <script type="text/javascript">
                        document.getElementById("popup-resp-usu").classList.toggle("active");

                        var opcao = "respUsu";
                        
                        function modalResponderUsuario() 
                        {
                            document.getElementById("popup-resp-usu").classList.toggle("active");
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
}

if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviarResposta')) 
{
    $mensagem = $_POST["mensagem"];
    $emailSolicitante = $_POST["email_usuario"];
    include './funcoes/respondeEmailFarm.php';
}
?>