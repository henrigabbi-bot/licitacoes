<?php
session_start();
include("conexao.php");
$idlic = $_SESSION["idlic"];
$idped = $_SESSION["npedido"];
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$dados=file($arquivo_tmp);

foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);

	$cnpj=$valor[0];
	$nomecli=$valor[1];
	$codprod=$valor[2];
	$descricaoprod=$valor[3];
	$unidade=$valor[4];
	$quantidade=$valor[5];	
	
	$query = mysql_query("SELECT * FROM pedidodecompra WHERE cnpj = '$cnpj' and codprod='$codprod'"); 
	$consulta = mysql_num_rows($query);
		
	if ($consulta == 0) {
		$sql="INSERT INTO itensnovos (cnpj,nomecli,codprod ) VALUES ('$cnpj','$nomecli','$codprod')";
		mysql_query($sql);
	} else {		
		
	}

	

}