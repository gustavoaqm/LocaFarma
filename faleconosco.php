<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Fale Conosco - LocaFarma</title>
		<link href="./css/css.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="./css/busca.css">
		<link rel="icon" href="./imagens/icone.png">
	</head>
	<body>

	<?php
		session_start();

		if(isset($_REQUEST['valor']) and ($_REQUEST['valor'] == 'enviado')) 
		{ 
			$Botao = $_POST["Botao"];
			$Nome = $_POST["Nome_Contato"];
			$Email = $_POST["Email_Contato"];
	    	$Mensagem = $_POST["Mensagem_Contato"];
	    	$Assunto = $_POST["assunto"];
		
			include "conexao.php";
			if ($Botao == "Enviar")
			{ 

				$Comando=$conexao->prepare("INSERT INTO TB_FALECONOSCO (NOME_CONTATO, EMAIL_CONTATO, ASSUNTO, MSG_CONTATO) VALUES ( ?, ?, ?, ?)");
       			$Comando->bindParam(1, $Nome);
       			$Comando->bindParam(2, $Email);
       			$Comando->bindParam(3, $Assunto);
	    		$Comando->bindParam(4, $Mensagem);
             
				if ($Comando->execute())
				{
    				if ($Comando->rowCount () >0) 
    				{
                              
    					$Nome = null; 
					    $Email = null;
					    $Assunto = null;
					    $Mensagem = null;
 						echo("<script> alert('Sugestão enviada com sucesso !!! Obrigado por sua colaboração!'); location.href='faleconosco.php';</script>"); 
				        }
        			else 
        			{
            			echo "Erro ao tentar efetivar o contato.";
        			}
    			}
 				else 
    			{ 
       				throw new PDOException("Erro: Não foi possivel executar a declaração sql.");
    			}
        		
    		} 
    	}	  
	?>
			<?php include './templates/navbar.php'; ?> <!-- Navbar e layout -->

			<p class="titulu">Fale conosco:</p>
			
			<div class="form-style-6">
				<h1>LocaFarma</h1>
				<form action="faleconosco.php?valor=enviado" method="POST">
					<input type="text" name="Nome_Contato" placeholder="✎ Seu Nome" required />
					<input type="email" name="Email_Contato" placeholder="☎ Seu Email" required />
					<select name="assunto">
					  <option>Elogios</option>
					  <option>Dúvidas</option>
					  <option>Reclamações</option>
					  <option>Sugestões</option>
					</select>
					<textarea name="Mensagem_Contato" placeholder="✉ Mensagem" style="height: 150px" required maxlength="120"></textarea>
					<input name="Botao" type="submit" value="Enviar" style="cursor:pointer;"/>
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
	</body>
</html>