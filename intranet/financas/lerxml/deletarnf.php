<?php
	// Abre a sessão
	session_start();
	// Verifica se o usuário está logado
	if(isset($_SESSION['login'])) {
		// Carrega o arquivo
		include("../../conexao.php");
		// Verifica a URL por valor em ID
		if($_GET['id']) {
			// Atribui à variável o valor armazenado na URL
			$id_cli = $_GET['id'];
			// Cláusula SQL
			$sql_cli = "SELECT * FROM nfsaida
						WHERE chavedeacesso = '$id_cli';";
					
			// Executa SQL
			$query_cli = mysql_query($sql_cli);
			// Se encontrar um registro (e somente um)
			if(mysql_num_rows($query_cli) == 1) {
				// Clásula SQL
				$sql = "DELETE FROM nfsaida
						WHERE chavedeacesso = '$id_cli';";
						
				// Executa SQL
				if(mysql_query($sql)) {
					// Redireciona para a página
					header("Location: ../index.php");
				// Se houver erro
				} else {
					?><?php
				}
			// Se não encontrar o registro buscado no banco de dados
			} else {
				// Carrega o arquivo 404.php na página
				
				//header("Location: ../404.php");
			}
		// Se não houver valor na URL
		} else {
			// Carrega o arquivo 404.php na página
			//header("Location: ../404.php");
			//echo "erro aqui";
		}
	// Se o usuário não está logado
	} else {
		// Carrega o arquivo 403.php na página
	//	header("Location: ../403.php");
	}
?>