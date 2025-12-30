<?php
 	session_start();
 	include("../conexao.php");
 	include ("PHPMailer/PHPMailerAutoload.php");
 	
 	if (isset($_GET['cnpj'])) {             
         $_SESSION['cnpj']=$_GET['cnpj'];
         $_SESSION['validade']=$_GET['validade'];
         $quantidade=$_GET['quantidade'];
         $descricao=$_GET['descricao'];
         $codprod=$_GET['codprod'];

    }
    $cnpj= $_SESSION['cnpj']; 
    $validade=$_SESSION['validade'];

	$sql1 ="SELECT * FROM produto WHERE codprod='$codprod'";
    $query1 = mysql_query($sql1);                  
    $row1 = mysql_fetch_assoc($query1);
    $unidade=$row1['unidade'];
 

   
 	$sql1 ="SELECT * FROM cliente WHERE CNPJ='$cnpj'";
    $query1 = mysql_query($sql1);                  
    $row1 = mysql_fetch_assoc($query1);
    $nomecliente=$row1['nomecliente'];
    $email= $row1['email'];
    

	//gerar anexo




 		
$mailer = new PHPMailer();
$mailer->IsSMTP();
$mailer->SMTPDebug = 1;
                       




$mailer->Port = 587; //Indica a porta de conexão 
$mailer->Host = 'smtplw.com.br';//Endereço do Host do SMTP 
$mailer->SMTPAuth = true; //define se haverá ou não autenticação 
//$mailer->SMTPSecure = 'tls';
                                  // Configura o disparo como SMTP
 $mailer->SMTPSecure = 'tls';                     
$mailer->Username = 'farmacia@cisaijui.com.br';                        // Usuário do SMTP
$mailer->Password = 'd84h2s8t5';                          // Senha do SMTP
                           // Habilita criptografia TLS | 'ssl' também é possível
$mailer->Port = 587;   
$mailer->isHTML(true);   
$mailer->From = 'farmacia@cisaijui.com.br'; //Obrigatório ser a mesma caixa postal configurada no remetente do SMTP
$mailer->AddAddress('henri.gabbi@gmail.com','Nome do //Destinatários
destinatário');



$mailer->Subject = 'Teste enviado através do PHP Mailer 
SMTPLW';
$mailer->Body = 'Este é um teste realizado com o PHP Mailer 
SMTPLW';
if(!$mailer->Send())
{
echo "Message was not sent";
echo "Mailer Error: " . $mailer->ErrorInfo; exit; }
print "E-mail enviado!";


/*


$Mailer = new PHPMailer();
$Mailer->IsSMTP();
$Mailer->SMTPDebug = 3;
$Mailer->Port = 587; //Indica a porta de conexão 
$Mailer->Host = 'smtplw.com.br';//Endereço do Host do SMTP 
$Mailer->SMTPAuth = true; //define se haverá ou não autenticação 
//$Mailer->SMTPSecure = 'tls';
$mailer->Username = 'farmacia@cisaijui.com.br'; //Login de autenticação do SMTP
$Mailer->Password = 'd84h2s8t5'; //Senha de autenticação do SMTP
$Mailer->FromName = 'Bart S. Locaweb'; //Nome que será exibido
$Mailer->isHTML(true);   
$Mailer->From = 'farmacia@cisaijui.com.br'; //Obrigatório ser a mesma caixa postal configurada no remetente do SMTP


	
	

	
	$mensagem= "Olá! <br>
	<br>
	A empresa pediu autorização para faturar o item " .$descricao. " com a validade para "  .date('d/m/Y', strtotime($validade)).  ". O município de " .$nomecliente. " encomendou " .$quantidade." " .$unidade."s. Assim, gostaria de saber se o município consegue dispensar alguma quantidade desse item? <br>

		<br>
		Aguardo retorno o mais breve possível <br>
		<br>
		<br>
		Att Bruna R. Weber <br>
		Farmacêutica CISA
		";


	
	//Nome do Remetente
	$Mailer->FromName = utf8_decode('CISA - Farmácia');
	//Assunto da mensagem
	$Mailer->Subject = utf8_decode('Autorização de validade, item '.$descricao.'');
	
	//Corpo da Mensagem
	$Mailer->Body = utf8_decode($mensagem);

	//$caminho='../../../../../../Users/Henrique/Downloads/';
	//$ficheiro=$nomecliente.'.xls';

//	$Mailer->AddAttachment($caminho.$ficheiro); 
	
	//Corpo da mensagem em texto
	//$Mailer->AltBody = 'conteudo do E-mail em texto';
	
	//Destinatario 
	$Mailer->AddAddress($email);
	
	if($Mailer->Send()){
			$_SESSION['msg'] = 1;
			$_SESSION['nomecliente']=$nomecliente;
			$_SESSION['email']=$email;
			header("Location: listarprodutosporcliente.php");
	}else{
		$_SESSION['msg']=2;
		$_SESSION['msgerro'] = "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
		header("Location: listarprodutosporcliente.php");
	
	}
	
	*/

?>
