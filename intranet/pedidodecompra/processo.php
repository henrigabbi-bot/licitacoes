<?php
session_start();
include("../conexao.php");
$idlic = $_SESSION["codlic"];
$idped = $_SESSION["npedido"];


	
// Consulta SQL
$sql = "SELECT idlic, codprod, vlrunitario FROM  resultadolicitacao WHERE idlic='$idlic';";
// Executa consulta SQL
$query = mysql_query($sql);
 // Enquanto houverem registros no banco de dados                     
 while($row = mysql_fetch_array($query)) {	
 	
 	$codprod=$row['codprod'];
 	$vlrunitario=$row['vlrunitario'];


 	$query5 = mysql_query("SELECT * FROM valordositensnopedido WHERE codprod = '$codprod' and idlic='$idlic' and pedido='$idped'"); 
	$consulta5 = mysql_num_rows($query5);
	if ($consulta5 == 0) {		
 		$sql2="INSERT INTO valordositensnopedido (idlic, pedido,codprod,vlrunitario) values('$idlic','$idped','$codprod','$vlrunitario')";
 		mysql_query($sql2);
 	}

}


header("Location:valordositensnopedido.php");

?>