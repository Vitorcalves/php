<?php

    require_once "vendor/autoload.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //

    $mail = new PHPMailer();

    try {

            //Server settings
            $mail->CharSet      = "utf-8";
            //$mail->SMTPDebug    = SMTP::DEBUG_SERVER;                                 // Habilitar saída de depuração detalhada
            $mail->isSMTP(true);                                                        // Enviar usando SMTP
            $mail->Host         = 'smtp.gmail.com';                                     // Host
            $mail->SMTPAuth     = true;                                                 // Habilitar autenticação SMTP
            $mail->Username     = 'contatofoody@gmail.com';             
            // $mail->Password     = 'f@@dy2021';  
            $mail->Password     = "wejz cwcd doba uktn";                      
            $mail->SMTPSecure   = PHPMailer::ENCRYPTION_SMTPS;                          // Habilitar criptografia TLS implícita
            $mail->Port         = 465;

            //Recipients
            $mail->setFrom($_POST['email'], $_POST['nome']);                            // Rementente
            $mail->addAddress('aldecirfonseca@gmail.com', 'Aldecir Fonseca');           // Destinatário
            //$mail->addReplyTo('info@example.com', 'Information');                     // E-mail de resposta
            //$mail->addCC('cc@example.com');                                           // cópia
            //$mail->addBCC('bcc@example.com');                                         // Cópia oculta
    
            // Anexos
            //$mail->addAttachment('/var/tmp/file.tar.gz');                             // Adicionar Anexos
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');
    
            //Content
            $mail->isHTML(true);                                                        // Defina o formato do e-mail para HTML
            $mail->Subject = $_POST['assunto'];
            $mail->Body    = $_POST['mensagem'];                                        // Corpo do e-mail no formato HTML
            $mail->AltBody = $_POST['mensagem'];                                        // Corpo do e-mail no formato texto
            
        if ($mail->send()) {
            return header("Location: faleConosco.php?msgSucesso=E-mail enviado com sucesso.");
        } else {
            return header("Location: faleConosco.php?msgError=Error ao tentar enviar e-mail: " . $mail->ErrorInfo);
        }
    } catch (\Exception $e) {
        return header("Location: faleConosco.php?msgError=Error ao tentar enviar e-mail: " . $mail->ErrorInfo);
    }