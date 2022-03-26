<?php
	try
    {
        require("PHPMailer-master/src/PHPMailer.php");
        require("PHPMailer-master/src/SMTP.php");

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP(); // enable SMTP

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

        $mail->addAddress($emailSolicitante); // email do destinatario.

        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Medicamento Solicitado Já Disponível!"; 
        $mail->Body = $mensagem  . "<br><br> Este e-mail é gerado automaticante, porfavor não responda-o.";;

        if(!$mail->Send())
        {
            echo "Erro ao enviar Email:" . $mail->ErrorInfo;
        }

            echo "<script> alert('E-mail enviado com sucesso!'); location.href='painelFarm.php';</script>"; 
    }   
    catch (PDOException $erro)
    {
        echo "Erro !" . $erro->getMessage();
    }
?>