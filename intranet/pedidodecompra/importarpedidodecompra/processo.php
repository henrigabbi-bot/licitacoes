
<?php
session_start();
include("conexao.php");
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
	
	$query6=mysql_query("SELECT * FROM pedidodecompra where cnpj='$cnpj' and idlic='$idlic' and codprod='$codprod' AND pedido='$idped'");
	$consulta6 = mysql_num_rows($query6);		
	if ($consulta6 == 0) {

			$sql="INSERT INTO pedidodecompra (idlic,pedido,cnpj,codprod,quantidade) VALUES ('$idlic',$idped,'$cnpj','$codprod','$quantidade')";		
			if(mysql_query($sql)) {		
				$continsercao++;					
			}
	}
}

$_SESSION["msg"]=$continsercao;
header("Location:importar.php");

?>