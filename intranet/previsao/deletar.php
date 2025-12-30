<?php
	// Abre a sessão
	session_start();
	 
      $nlic=$_SESSION['idlic'];
       
	// Verifica se o usuário está logado
	if(isset($_SESSION['login'])) {
		// Carrega o arquivo
		include("../conexao.php");
		// Verifica a URL por valor em ID
		if(isset($_GET['cnpj'])) {
			// Atribui à variável o valor armazenado na URL
			$cnpj = $_GET['cnpj'];			
			
			// Cláusula SQL
			$sql = "DELETE FROM previsaodeconsumo WHERE idlic ='$nlic' AND cnpj='$cnpj';";
			
			// Executa SQL					
			if(mysql_query($sql)) {
					// Redireciona para a página
				header("Location: listarclientes.php");
				// Se houver erro
			}
			// Se encontrar um registro (e somente um)
			
		// Se não houver valor na URL
		} else {
			// Carrega o arquivo 404.php na página
			//header("Location: ../404.php");
			//echo "erro aqui";
		}
	// Se o usuário não está logado
	} else {
		// Carrega o arquivo 403.php na página

	  header("Location: ../403.php");
	}
?>