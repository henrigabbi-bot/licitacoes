<?php

	session_start();
	include("conexao.php");


	$arquivo = fopen('meuarquivo.txt','w');
//verificamos se foi criado
if ($arquivo == false) die('Não foi possível criar o arquivo.');



	$sql = "SELECT pesquisa.codprod,pesquisa.quantidade,pesquisa.unidade,pesquisa.vlrunitario, produto.descricao FROM pesquisa  INNER JOIN produto on produto.codprod=pesquisa.codprod";


    $query = mysql_query($sql);                     
   
    while($row = mysql_fetch_array($query)) { 
   
   	$codprod=$row['codprod'];
   	$descricao=$row['descricao'];   
   	$quantidade=$row['quantidade'];
   	$unidade=$row['unidade'];
   	$vlrunitario=number_format($row['vlrunitario'], 4, ',', '.');

   	$linha=$codprod.";".$descricao.";".$quantidade.";".$unidade.";".$vlrunitario. "\r\n";
   	fwrite($arquivo,$linha);
   
   	}




//Fechamos o arquivo após escrever nele
fclose($arquivo);


		


?>
	