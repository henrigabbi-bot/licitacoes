<?php
	session_start();
	include("conexao.php");
	$idped = $_SESSION["npedido"];
	$idlic = $_SESSION["codlic"];



	//$dados = $_FILES['arquivo'];
	//var_dump($dados);
	
	if(!empty($_FILES['arquivo']['tmp_name'])){
		$arquivo = new DomDocument();
		$arquivo->load($_FILES['arquivo']['tmp_name']);
		//var_dump($arquivo);
		
		$linhas = $arquivo->getElementsByTagName("Row");
		//var_dump($linhas);
		
		
		
		foreach($linhas as $linha){								
				
				$codext = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
				$codprod = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
				$descricao = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
				$unidade = $linha->getElementsByTagName("Data")->item(3)->nodeValue;		
				$vlrunitario = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
				$quantidade = $linha->getElementsByTagName("Data")->item(5)->nodeValue;	
				
				//Inserir o usuário no BD				
				$query1 = mysql_query("SELECT * FROM cliente WHERE codigoexterno = '$codext'");    
    			$row1 = mysql_fetch_assoc($query1);	
    			$cnpj=$row1['cnpj'];

    			
			
				$query6=mysql_query("SELECT * FROM pedidodecompra where cnpj='$cnpj' and idlic='$idlic' and codprod='$codprod' AND pedido='$idped'");

				$consulta6 = mysql_num_rows($query6);		
				if ($consulta6 == 0) {

					$sql="INSERT INTO pedidodecompra (idlic,pedido,cnpj,codprod,quantidade,vlrunitario) VALUES ('$idlic',$idped,'$cnpj','$codprod','$quantidade','$vlrunitario')";		
					
					if(mysql_query($sql)) {		
						$continsercao++;					
					}
				}

					
		}
	}
$_SESSION["msg"]=$continsercao;
header("Location:importar.php");
?>