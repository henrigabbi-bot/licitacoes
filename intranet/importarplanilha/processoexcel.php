<?php
	session_start();
	include("conexao.php");
	

	
	if(!empty($_FILES['arquivo']['tmp_name'])){
		$arquivo = new DomDocument();
		$arquivo->load($_FILES['arquivo']['tmp_name']);
		//var_dump($arquivo);
		
		$linhas = $arquivo->getElementsByTagName("Row");
		//var_dump($linhas);
		
		
		
		foreach($linhas as $linha){
		
				$codprod = $linha->getElementsByTagName("Data")->item(0)->nodeValue;			
				
				$descricaoprod = $linha->getElementsByTagName("Data")->item(1)->nodeValue;		
				
				$quantidade = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
				
				$unidade = $linha->getElementsByTagName("Data")->item(3)->nodeValue;

				$vlrunitario = $linha->getElementsByTagName("Data")->item(4)->nodeValue;
				
				
				//Inserir o usuário no BD				
				$query1 = mysql_query("SELECT * FROM produto WHERE codprod = '$codprod'"); 
				$consulta1 = mysql_num_rows($query1);
					
				if ($consulta1 == 0) {
					$sql2="INSERT INTO produto (codprod,descricao,unidade) VALUES ('$codprod','$descricaoprod','$unidade')";
					mysql_query($sql2);
				
				} 

    			
				$sql="INSERT INTO pesquisa (codprod,quantidade,unidade,vlrunitario) VALUES ('$codprod','$quantidade','$unidade','$vlrunitario')";		
				
				 echo $sql;
				if(mysql_query($sql)) {		
				$continsercao++;					
				}
				

				

			
			
		}
	}

//$_SESSION["msg"]=$continsercao;
//header("Location:importar.php");
?>