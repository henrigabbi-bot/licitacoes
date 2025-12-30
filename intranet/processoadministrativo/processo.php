<?php
session_start();
include("../conexao.php");
$idlic = $_SESSION["valor"];
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$dados=file($arquivo_tmp);



$query1 = mysql_query("DELETE FROM itenslicitacao WHERE idlic = '$idlic'"); 

$itemnumero=1;
$contproduto=0;
$cont=0;



foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);

	
	$codprod=$valor[0];
	$descricao=$valor[1];	
	$quantidade=$valor[2];		
	$unidade=$valor[3];	
	$vlrreferencia = str_replace(',', '.', $valor[4]);

					
	
		
	$sql="INSERT INTO itenslicitacao(itemnumero,idlic, codprod, quantidade, vlrreferencia) VALUES ($itemnumero,'$idlic','$codprod','$quantidade','$vlrreferencia')";
	
	mysql_query($sql);
	$itemnumero++;
		
}



header("Location:importaritens.php");

?>