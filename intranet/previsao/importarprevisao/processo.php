
<?php
session_start();
include("conexao.php");
$idlic = $_SESSION["valor"];
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$dados=file($arquivo_tmp);
$cont=0;
foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);

	$cnpj=$valor[0];
	$nomecli=$valor[1];
	$codprod=$valor[2];
	$descricaoprod=$valor[3];
	$unidade=$valor[4];
	$quantidade=$valor[5];	

	$query1 = mysql_query("SELECT * FROM produto WHERE codprod = '$codprod'"); 
	$consulta1 = mysql_num_rows($query1);
		
	if ($consulta1 == 0) {
		$sql2="INSERT INTO produto (codprod,descricao,unidade) VALUES ('$codprod','$descricaoprod','$unidade')";
		mysql_query($sql2);
	
	} 

	
	$query = mysql_query("SELECT * FROM cliente WHERE cnpj = '$cnpj'"); 
	$consulta = mysql_num_rows($query);
		
	if ($consulta == 0) {
		$sql1="INSERT INTO cliente (cnpj,nomecliente ) VALUES ('$cnpj','$nomecli')";
		mysql_query($sql1);
	} 
	
	$sql="INSERT INTO previsaodeconsumo (idlic,cnpj,codprod,quantidade) VALUES('$idlic','$cnpj','$codprod','$quantidade')";	
	if(mysql_query($sql)) {		
		$cont=$cont+1;
	}
	
}

$_SESSION["msg"]=1;
$_SESSION['cont']=$cont;
header("Location:importar.php");

?>