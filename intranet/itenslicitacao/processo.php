
<?php
session_start();
include("conexao.php");
$idlic = $_SESSION["valor"];
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$dados=file($arquivo_tmp);

$nomecoluna= 'valor'."".$idlic;

// Altera a tabela banco de preços, add a coluna referente ao pregão importado.


$sql8="DELETE FROM resultadolicitacao where idlic='$idlic'";	
mysql_query($sql8);

$contproduto=0;
$contfornecedor=0;
$cont=0;
$itemnumero=1;

foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);


	$codprod=$valor[0];
	$descricaoprod=utf8_encode($valor[1]);	
	$quantidade=$valor[2];	
	$unidade=utf8_encode($valor[3]);
	$unidade=mb_strtoupper($unidade);
	$vlrunitario = str_replace(',', '.', $valor[4]);	
	

					
		//verifica se o produto já está cadastrado, se não, faz o cadastro.
	
			$sql="INSERT INTO itneslicitacao (itemnumero,codprod,descricao,quantidade,unidade,vlrunitario) VALUES ('$itemnumero','$codprod','$descricaoprod','$quantidade','$unidade','$vlrunitario')";
			mysql_query($sql);
			$itemnumero++;
			
		

	
}


$_SESSION["msg2"]=$contproduto;

header("Location:importar.php");

?>