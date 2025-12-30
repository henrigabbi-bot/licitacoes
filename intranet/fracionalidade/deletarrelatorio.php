<?php
	// Abre a sessão
	session_start();
	// Verifica se o usuário está logado
	if(isset($_SESSION['login'])) {
		// Carrega o arquivo
		include("../conexao.php");
		// Verifica a URL por valor em ID
		
			// Atribui à variável o valor armazenado na URL
			
			// Cláusula SQL
			$sql = "DELETE FROM itensadquacao ;";
			// Executa SQL					
			if(mysql_query($sql)) {
					// Redireciona para a página
					$sql2 = "DELETE FROM itensadquacao;";	
					mysql_query($sql2);		
					header("Location: listar.php");
				// Se houver erro
			}
			// Se encontrar um registro (e somente um)
			
		// Se não houver valor na URL
		
	// Se o usuário não está logado
	} else {
		// Carrega o arquivo 403.php na página

	  header("Location: ../403.php");
	}
?>