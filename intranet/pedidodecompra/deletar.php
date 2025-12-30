<?php
	// Abre a sessão
	session_start();
	// Verifica se o usuário está logado
	if(isset($_SESSION['login'])) {
		// Carrega o arquivo
		include("../conexao.php");
		// Verifica a URL por valor em ID
		if(isset($_GET['codlic'])) {
			// Atribui à variável o valor armazenado na URL
			$codlic = $_GET['codlic'];			
			$npedido = $_GET['npedido'];
			// Cláusula SQL
			$sql = "DELETE FROM pedido WHERE codlic = '$codlic' AND npedido='$npedido';";
			// Executa SQL					
			if(mysql_query($sql)) {
					// Redireciona para a página
					$sql2 = "DELETE FROM pedidodecompra WHERE idlic = '$codlic' AND pedido='$npedido';";	
					mysql_query($sql2);		
					header("Location: index.php");
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