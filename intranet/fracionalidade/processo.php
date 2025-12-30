<?php
session_start();
include("../conexao.php");
$idlic = $_SESSION["codlic"];
$idped = $_SESSION["npedido"];
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$dados=file($arquivo_tmp);
$continsercao=0;

foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);

	$cnpj=$valor[0];
	$nomecli=$valor[1];
	$codprod=$valor[2];
	$descricaoprod=$valor[3];
	$unidade=$valor[4];
	$quantidade=$valor[5];	
	
	$sql="SELECT * FROM fracionamento WHERE codprod = '$codprod'"; 
	
	$query = mysql_query($sql);    
  	$row = mysql_fetch_assoc($query);  
  	$embalagem=$row['embalagem'];
  	
	
    $sql1= "SELECT * FROM fracionamento WHERE codprod = '$codprod'";  
    $query1 = mysql_query($sql1); 
	$consulta1 = mysql_num_rows($query1);
   
		
	if ($consulta1 == 1) {
			
			$resto=$quantidade %  $embalagem;
			  if ($resto==0)
			  { 

			  

				}else{
						$sql="INSERT INTO itensadquacao (cnpj,nomecli,codprod,quantidade ) VALUES ('$cnpj','$nomecli','$codprod',$quantidade)";
			  	
					mysql_query($sql); ;

				}


		
	} 
	


}

//$_SESSION["msg"]=$continsercao;
header("Location:listar.php");

?>