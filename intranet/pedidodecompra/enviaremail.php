<?php
 	session_start();
 	include("../conexao.php");
 	include ("PHPMailer/PHPMailerAutoload.php");
 	
 	if (isset($_GET['cnpj'])) {             
         $_SESSION['cnpj']=$_GET['cnpj'];

    }
    $cnpj= $_SESSION['cnpj']; 

   
 	$sql1 ="SELECT * FROM cliente WHERE CNPJ='$cnpj'";
    $query1 = mysql_query($sql1);                  
    $row1 = mysql_fetch_assoc($query1);
    $nomecliente=$row1['nomecliente'];
    $email= $row1['email'];
    

	//gerar anexo
   

 		
	$Mailer = new PHPMailer();

	
	
	
	$Mailer->IsSMTP();
	
	//Aceitar carasteres especiais
	$Mailer->Charset = 'UTF-8';
	
	//Configurações
	
	
	//nome do servidor
	$Mailer->Port = 465;
	$Mailer->Host = 'smtp.gmail.com';
	$Mailer->isHTML(true);
	$Mailer->Mailer='smtp';
	$Mailer->SMTPSecure = 'ssl';

	
	//Dados do e-mail de saida - autenticação

	$Mailer->SMTPAuth = true;
	$Mailer->Username = 'henri.gabbi@gmail.com';
	$Mailer->Password = 'henrique771';
	
	//E-mail remetente (deve ser o mesmo de quem fez a autenticação)
	//$Mailer->From = 'usuario@dominio.com';
	
	//Nome do Remetente
	$Mailer->FromName = 'Henrique';

	//Assunto da mensagem
	$Mailer->Subject = 'Listagem para empenho';
	
	//Corpo da Mensagem
	$Mailer->Body = 'Segue em anexo listagem para empenho';

	$caminho='../../../../../../Users/Henrique/Downloads/';
	$ficheiro=$nomecliente.'.xls';

	$Mailer->AddAttachment($caminho.$ficheiro); 
	
	//Corpo da mensagem em texto
	//$Mailer->AltBody = 'conteudo do E-mail em texto';
	
	//Destinatario 
	$Mailer->AddAddress($email);
	
	if($Mailer->Send()){
			$_SESSION['msg'] = 1;
			$_SESSION['nomecliente']=$nomecliente;
			$_SESSION['email']=$email;
			header("Location: listarclientesdopedido.php");
	}else{
		$_SESSION['msg']=2;
		$_SESSION['msgerro'] = "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
header("Location: listarclientesdopedido.php");
	
	}
	
	

?>
