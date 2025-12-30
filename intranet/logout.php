<?php
	// intranet/logout.php
	
	// Carrega a sessão
	session_start();
	// Destrói a sessão
	session_destroy();
	
	// Redireciona o usuário para a página
	header("Location: ../index.php");
?>