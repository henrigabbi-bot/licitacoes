<?php
	// Abre a sessão
	session_start();
	// Verifica se o usuário está logado
	if(isset($_SESSION['login'])) {
		// Carrega o arquivo
		include("../conexao.php");
		// Verifica a URL por valor em ID
		if($_GET['id']) {
			// Atribui à variável o valor armazenado na URL
			$id_can = $_GET['id'];
			// Cláusula SQL
			$sql_can = "SELECT * FROM admin
						WHERE id = '$id_can';";
			// Executa SQL
			$query_can = mysql_query($sql_can);
			// Se encontrar um registro (e somente um)
			if(mysql_num_rows($query_can) == 1) {
				// Clásula SQL
				$sql = "DELETE FROM admin
						WHERE id = '$id_can';";
				// Executa SQL
				if(mysql_query($sql)) {
					// Redireciona para a página
					header("Location: index.php");
				// Se houver erro
				} else {
					?><p>Erro ao deletar registro</p><?php
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
		}
	// Se o usuário não está logado
	} else {
		// Carrega o arquivo 403.php na página
		//header("Location: ../403.php");
	}
?>