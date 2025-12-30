<?php
	// Abre a sessão
	session_start();
	// Verifica se o usuário está logado
	if(isset($_SESSION['login'])) {
		$id_lic = $_SESSION['id'];
		// Carrega o arquivo
		include("../conexao.php");
		// Verifica a URL por valor em ID
		
			// Atribui à variável o valor armazenado na URL
			
			// Cláusula SQL
			$sql = "DELETE FROM itenslicitacao where idlic='$id_lic';";
			// Executa SQL	
						
			if(mysql_query($sql)) {
					// Redireciona para a página
					$sql2 = "DELETE FROM itenslicitacao where idlic='$id_lic';";	
					mysql_query($sql2);	
					unset($_SESSION['id']);	
					header("Location: listaritens.php");
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