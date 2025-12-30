
<?php

session_start();

include("conexao.php");
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];

$dados=file($arquivo_tmp);

foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);

	$item=$item[0];	
	$codprod=$valor[1];	
	$descricao=$valor[2];
	$quantidade=$valor[2];
	$unidade=$valor[3];	
		
	
	$sql="UPDATE produto SET descricao='$descricao' WHERE codprod='$codprod'";
	mysql_query($sql);
	
	
}
$_SESSION["msg"]=1;
header("Location:importar.php")
?>