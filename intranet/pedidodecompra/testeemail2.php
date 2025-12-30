<?php
// Crie uma nova instância do PHPMailer
include ("PHPMailer/PHPMailerAutoload.php");    

$mail =new PHPMailer();
// Diga ao PHPMailer para usar SMTP
$mail-> isSMTP ();
// Habilitar depuração de SMTP
// SMTP :: DEBUG_OFF = off (para uso em produção)
// SMTP :: DEBUG_CLIENT = mensagens do cliente
// SMTP :: DEBUG_SERVER = mensagens do cliente e do servidor
$mail->SMTPDebug = SMTP :: DEBUG_CLIENT;
// Defina o nome do host do servidor de e-mail
$mail->Host = 'smtplw.com.br';  
// Defina o número da porta SMTP - provavelmente 25, 465 ou 587
$mail->Port = 465;  
// Se deve usar autenticação SMTP
$mail->SMTPAuth = true ;
// Nome de usuário a ser usado para autenticação SMTP
$mail->Username = 'farmacia@cisaijui.com.br';                        // Usuário do SMTP
$mail->Password = 'd84h2s8t5';   
// Defina de quem a mensagem deve ser enviada
$mail->setFrom ( 'farmacia@cisaijui.com.br' , 'Primeiro Último' );
// Defina um endereço de resposta alternativo
$mail->addReplyTo ( 'henrique.cbt@hotmail.com' , 'Primeiro Último' );
// Defina para quem a mensagem deve ser enviada
$mail->addAddress ( 'henri.gabbi@gmail.com' , 'John Doe' );
// Defina a linha de assunto
$mail->Subject = 'Aqui o assunto da mensagem';
// Ler o corpo de uma mensagem HTML de um arquivo externo, converter imagens referenciadas em incorporadas,
// converter HTML em um corpo alternativo de texto simples básico
$mail->Body    = 'Esse é o body de uma mensagem HTML <strong>em negrito!</strong>';
$mail->AltBody = 'Esse é o corpo da mensagem em formato "plain text" para clientes de email não-HTML';

if(!$mail->send()) {
    echo 'A mensagem não pode ser enviada';
    echo 'Mensagem de erro: ' . $mail->ErrorInfo;
} else {
    echo 'Mensagem enviada com sucesso';
}

?>