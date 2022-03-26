<?php
		try
		{
			require("PHPMailer-master/src/PHPMailer.php");
			require("PHPMailer-master/src/SMTP.php");

			$mail = new PHPMailer\PHPMailer\PHPMailer();
			$mail->IsSMTP(); // enable SMTP
			
			$date = new DateTime('now + 10 minutes', new DateTimeZone('America/Sao_Paulo')); 
			$data = $date->format('Y-m-d H:i:s');

			$codigo = strtoupper(substr(bin2hex(random_bytes(10)), 1));
			$codigoCript = base64_encode($codigo);

			$link = "localhost/LocaFarma 2.0/recuperarsenha.php?codigo=".$_SESSION["codigo"] = $codigoCript;

			//configuração do gmail
			$mail->Port = '465'; //porta usada pelo gmail.
			$mail->Host = 'smtp.gmail.com'; 
			$mail->IsHTML(true); 
			$mail->Mailer = 'smtp'; 
			$mail->SMTPSecure = 'ssl';

			//configuração do usuário do gmail
			$mail->SMTPAuth = true; 
			$mail->Username = 'locafarma10@gmail.com'; // usuario gmail.   
			$mail->Password = ''; // senha do email.

			$mail->SingleTo = true; 

			// configuração do email a ver enviado.
			$mail->From = "locafarma10@gmail.com"; 
			$mail->FromName = "LocaFarma"; 

			$mail->addAddress($Email); // email do destinatario.

			$mail->CharSet = 'UTF-8';
			$mail->Subject = "Redefinir sua senha do LocaFarma"; 
			$mail->Body = "Olá " . $nome . "!" . "<br> Obrigado por entrar em contato sobre a redefinição de senha. Basta <a href='".$link."'>clicar aqui</a> e seguir as instruções. <br>" . "<br> Se você não solicitou a troca de senha, porfavor desconsidere este e-mail.";

			if(!$mail->Send())
			{
			    echo "Erro ao enviar Email:" . $mail->ErrorInfo;
			}

				$Comando=$conexao->prepare("INSERT INTO tb_codigos (id,codigo, data) VALUES (?, ?, ?)");
				$Comando->bindParam(1, $id);
				$Comando->bindParam(2, $codigo);
				$Comando->bindParam(3, $data);
				$Comando->execute();
				echo "<script> alert('E-mail enviado com sucesso! Verifique sua caixa de entrada.'); location.href='login.php';</script>"; 
		}   
		catch (PDOException $erro)
		{
			echo "Erro !" . $erro->getMessage();
		}
?>