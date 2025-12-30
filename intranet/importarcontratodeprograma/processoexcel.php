<?php
	session_start();
	include("../conexao.php");
	



	//$dados = $_FILES['arquivo'];
	//var_dump($dados);
	
	if(!empty($_FILES['arquivo']['tmp_name'])){
		$arquivo = new DomDocument();
		$arquivo->load($_FILES['arquivo']['tmp_name']);
		//var_dump($arquivo);
		
		$linhas = $arquivo->getElementsByTagName("Row");
		//var_dump($linhas);
		
		
		
		foreach($linhas as $linha){			




				
				$id = $linha->getElementsByTagName("Data")->item(0)->nodeValue;		
				$programamedicamentos = $linha->getElementsByTagName("Data")->item(1)->nodeValue;
				$programacisa = $linha->getElementsByTagName("Data")->item(2)->nodeValue;
				$programaceo = $linha->getElementsByTagName("Data")->item(3)->nodeValue;
					
												  			
			
				$query6=mysql_query("SELECT * FROM contratodeprograma where id='$id'");

				$consulta6 = mysql_num_rows($query6);		
				if ($consulta6 == 0) {

					$sql="INSERT INTO contratodeprograma (id,programamedicamentos,programacisa,programaceo) VALUES ('$id','$programamedicamentos','$programacisa','$programaceo')";	
					
										
					if(mysql_query($sql)) {		
						$continsercao++;					
					}
				}

					
		}
	}
$_SESSION["msg"]=$continsercao;
header("Location:importar.php");
?>