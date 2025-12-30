
<?php
session_start();
include("../conexao.php");
$idlic = $_SESSION["valor"];
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$dados=file($arquivo_tmp);





$contproduto=0;
$contfornecedor=0;
$cont=0;

foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);

	$item =$valor[0];
	$codprod=$valor[1];	
	$descricaoprod=utf8_encode($valor[2]);	
	$marca=utf8_encode($valor[3]);
	$quantidade=$valor[4];
	$vlrunitario = str_replace(',', '.', $valor[5]);
	$vlrtotal = str_replace(',', '.', $valor[6]);
	$cnpj=preg_replace("/\D+/", "", $valor[7]);	
	$nomeforn=utf8_encode($valor[8]); 
	$nomeforn=mb_strtoupper($nomeforn);
	$unidade=utf8_encode($valor[9]);
	$unidade=mb_strtoupper($unidade);	
	$vlrunitario2 =  str_replace(',', '.', $valor[10]);
	$porcentagem = $valor[11];
	$diferenca =str_replace(',', '.', $valor[12]);

					
		//verifica se o produto já está cadastrado, se não, faz o cadastro.
		$query1 = mysql_query("SELECT * FROM produto WHERE codprod = '$codprod'"); 
		$consulta1 = mysql_num_rows($query1);
		if ($consulta1 == 0) {
			$sql="INSERT INTO produto (codprod,descricao,unidade) VALUES ('$codprod','$descricaoprod','$unidade')";
			mysql_query($sql);
			$contproduto++;
			
		} 

		
		
		//verifica se o fornecedor já está cadastrado, se não, faz o cadastro.
		$query = mysql_query("SELECT * FROM fornecedor WHERE cnpj = '$cnpj'"); 
		$consulta = mysql_num_rows($query);		
		if ($consulta == 0) {
			$sql="INSERT INTO fornecedor (cnpj,nomefornecedor ) VALUES ('$cnpj','$nomeforn')";
			mysql_query($sql);
			$contfornecedor++;
		} 
		
		
		$query6=mysql_query("SELECT * FROM desagio where cnpj='$cnpj' and codprod='$codprod'");
		$consulta6 = mysql_num_rows($query6);		
		if ($consulta6 == 0) {
			//Cadastra o resultado da licitação
			$sql="INSERT INTO desagio( item,codprod,marca,quantidade,vlrunitario,vlreferencia,desagio,diferenca,cnpj) VALUES ('$item','$codprod','$marca','$quantidade','$vlrunitario','$vlrunitario2','$porcentagem','$diferenca','$cnpj')";
				
			if(mysql_query($sql)){
		$cont++;
		}	
		}

	

		
	

	
}

$_SESSION["msg"]=1;
$_SESSION["msg2"]=$contproduto;
$_SESSION["msg3"]=$contfornecedor;
$_SESSION["msg4"]=$cont;
header("Location:index.php");

?>