
<link rel="stylesheet" type="text/css" href="./css/busca.css">
<link rel="stylesheet" type="text/css" href="./css/modal.css">

<div class="popup" id="ex1">
      <div class="overlay"></div>
      <div class="content">
        <div class="close-btn" onclick="modalSolicitacao()">&times;</div>
            <div class="form-style-6">
				<h1>Solicitação de medicamentos</h1>
				<form name="formLogin" action="./funcoes/solicitaMed.php?solicitacao=solicitar" method="POST">
					<p>*Nome e E-mail</p>
					<input type="text" name="nome_usu" placeholder="Nome" style="width: 40%" required />
					<input type="email" name="email_usu" placeholder="example@email.com" style="width: 59%" />
					<p>*Nome do Medicamento</p>
					<input type="text" name="nome_med" placeholder="Medicamento" required />
					<p>Descrição do pedido</p>
					<textarea name="desc_ped" maxlength="120" placeholder="Ex: Ibuprofeno 600 MG 20 Comprimidos." style="height: 150px"></textarea>
					Atenção! Os campos marcados com (*) são obrigatórios.<br><br>
					<input name="Botao" type="submit" value="Enviar" style="cursor:pointer;"/>
				</form>
			</div>
      </div>
    </div>

    <script type="text/javascript">
    	document.getElementById("ex1").classList.toggle("active");
        function modalSolicitacao()
        {
            document.getElementById("ex1").classList.toggle("active");
        }
    </script>

<?php

if(isset($_REQUEST['solicitacao']) and ($_REQUEST['solicitacao'] == 'solicitar'))
{
	// include_once './conexao.php';

	$Botao = $_POST["Botao"];
	$nomeUsu = ucfirst($_POST["nome_usu"]);
	$emailUsu = $_POST["email_usu"];
	$nomeMed = ucfirst($_POST["nome_med"]);
	$descMed = $_POST["desc_ped"];

	if ($Botao == "Enviar") 
	{
		try 
		{
			$Comando=$conexao->prepare("INSERT INTO tb_pedido (NOME_USU, EMAIL_USU, NOME_MED, DESC_MED) VALUES (?, ?, ?, ?)");
			$Comando->bindParam(1, $nomeUsu);
			$Comando->bindParam(2, $emailUsu);
			$Comando->bindParam(3, $nomeMed);
			$Comando->bindParam(4, $descMed);

			if ($Comando->execute()) 
			{
				echo "<script> alert('Solicitação enviada com sucesso! Agradecemos o pedido.'); location.href='../home.php'; </script>";
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

?>