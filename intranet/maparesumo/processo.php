
<?php
session_start();
include("../conexao.php");
$idlic = $_SESSION["valor"];
$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$dados=file($arquivo_tmp);



// Altera a tabela mapa rerumo add a coluna referente ao pregão importado.


$contproduto=0;
$contfornecedor=0;
$cont=0;

foreach ($dados as $linha) {
	$linha= trim($linha);	
	$valor= explode(';' ,$linha);

	$item =$valor[0];
	$codprod=$valor[1];
	$descricaoprod=utf8_encode($valor[2]);	
	//$marca=utf8_encode($valor[3]);
	$quantidade=$valor[4];
	$vlrunitario = str_replace(',', '.', $valor[5]);
	//$vlrtotal = str_replace(',', '.', $valor[6]);
	$cnpj=preg_replace("/\D+/", "", $valor[7]);	
	$nomeforn=utf8_encode($valor[8]); 
	$nomeforn=mb_strtoupper($nomeforn);
	$unidade=utf8_encode($valor[9]);
	$unidade=mb_strtoupper($unidade);	
	

					
		//verifica se o produto já está cadastrado, se não, faz o cadastro.
		$query1 = mysql_query("SELECT * FROM produto WHERE codprod = '$codprod'"); 
		$consulta1 = mysql_num_rows($query1);
		if ($consulta1 == 0) {
			$sql="INSERT INTO produto (codprod,descricao,unidade) VALUES ('$codprod','$descricaoprod','$unidade')";
			//mysql_query($sql);
			$contproduto++;
			
		} 

		
		$valor= explode(" ",$nomeforn);
		$novonome =$valor[0];
			

		$query6=mysql_query("SELECT * FROM maparesumo where cnpj='$cnpj'");
		$consulta6 = mysql_num_rows($query6);		


		if ($consulta6 == 0) {
			$sql2="ALTER TABLE maparesumo ADD $novonome varchar(250);";	
			mysql_query($sql2);
			echo $novonome;

		}	
		

		$sql="INSERT INTO maparesumo(item, codprod,quantidade,$novonome, cnpj) VALUES ('$item','$codprod','$quantidade','$vlrunitario','$cnpj')";
		mysql_query($sql);
		echo $sql;
		
		}

//$_SESSION["msg"]=1;
//$_SESSION["msg2"]=$contproduto;
//$_SESSION["msg3"]=$contfornecedor;
//$_SESSION["msg4"]=$cont;
//header("Location:importar.php");

?>