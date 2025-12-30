<?php
include ("PHPMailer/PHPMailerAutoload.php");      // https://github.com/PHPMailer/PHPMailer

$mail = new PHPMailer;
$mail->setLanguage('br');                             // Habilita as saídas de erro em Português
$mail->CharSet='UTF-8';                               // Habilita o envio do email como 'UTF-8'

//$mail->SMTPDebug = 3;                               // Habilita a saída do tipo "verbose"

$mail->isSMTP();                                      // Configura o disparo como SMTP
$mail->Host = 'smtplw.com.br';                        // Especifica o enderço do servidor SMTP da Locaweb
$mail->SMTPAuth = true;                               // Habilita a autenticação SMTP
$mail->Username = 'farmacia@cisaijui.com.br';                        // Usuário do SMTP
$mail->Password = 'd84h2s8t5';                          // Senha do SMTP
//$mail->SMTPSecure = 'tls';                            // Habilita criptografia TLS | 'ssl' também é possível
$mail->Port = 587;                                    // Porta TCP para a conexão

$mail->From = 'farmacia@cisaijui.com.br';                          // Endereço previamente verificado no painel do SMTP
$mail->FromName = 'SMTP Locaweb';                     // Nome no remetente
$mail->addAddress('henri.gabbi@gmail.com', 'Henrique');// Acrescente um destinatário


$mail->isHTML(true);                                  // Configura o formato do email como HTML

$mail->Subject = 'Aqui o assunto da mensagem';
$mail->Body    = 'Esse é o body de uma mensagem HTML <strong>em negrito!</strong>';
$mail->AltBody = 'Esse é o corpo da mensagem em formato "plain text" para clientes de email não-HTML';

if(!$mail->send()) {
    echo 'A mensagem não pode ser enviada';
    echo 'Mensagem de erro: ' . $mail->ErrorInfo;
} else {
    echo 'Mensagem enviada com sucesso';
}