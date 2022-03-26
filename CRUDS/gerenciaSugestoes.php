
    <style type="text/css">
        .msg{
            height: 50px;
        }
    </style>

	<div class="container" style="width: auto;">
		<div class="row">
            <table id="gerencia_sugestoes" class="display" style="width: 99%; font-size: 85%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>E-mail</th>  
                        <th>Assunto</th>                                                              
                        <th>Mensagem</th>  

                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                	<?php
                	   include("conexao.php");

                        $Comando=$conexao->prepare("SELECT * FROM tb_faleconosco");
                        if ($Comando->execute())
                        {
                            if ($Comando->rowCount () > 0) 
                            {
                                while ($Linha = $Comando->fetch(PDO::FETCH_OBJ))
                                  {
                                        $idContato = $Linha->id_contato;
                                        $nomeContato = $Linha->nome_contato;
                                        $emailContato = $Linha->email_contato;
                                        $assuntoContato = $Linha->assunto;
                                        $msgContato = $Linha->msg_contato;
                                    ?>
                                    <tr>
                                        <td><?php echo $idContato; ?></td>
                                        <td><?php echo $nomeContato; ?></td>
                                        <td><?php echo $emailContato; ?></td>
                                        <td><?php echo $assuntoContato; ?></td>
                                        <td><?php echo $msgContato; ?></td>
                                        
                                        <td><a href="<?php echo "painelAdm.php?acao=excluirSug&idSug=$idContato";?>" class="butaomodal" onclick="return confirm('Você realmente deseja excluir esta sugestão?')">Excluir</a></td>
                                    </tr>
                                    <?php
                                  }
                            }
                            else
                            {
                                echo "Olá! Você ainda não possui nenhuma sugestão!<br><br> ";  
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
            $('#gerencia_sugestoes').DataTable({
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

if (isset($_GET["acao"])) 
{

    // BOTÃO EXCLUIR ======================================
    if ($_GET["acao"] == "excluirSug") 
    {
        $id = $_GET["idSug"];
        $Comando=$conexao->prepare("DELETE FROM tb_faleconosco WHERE id_contato=?");
        $Comando->bindParam(1, $id);

        if ($Comando->execute()) 
        {
            echo("<script> alert('Sugestão excluída com sucesso!'); location.href='painelAdm.php'; </script>");
        }
        else
        {
            throw new Exception("Error Processing Request", 1);
        }
    } 
    // BOTÃO EXCLUIR ========================================

}
?>