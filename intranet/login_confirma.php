<?php
// intranet/login_confirma.php

// Verificar se o formulário foi submetido
if($_POST) {
	// Carrega arquivo
	include("conexao.php");
	// Formulário submetido
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	
	// Seleciona do banco de dados
	$sql = "SELECT *
			FROM admin
			WHERE email = '$email'
				AND senha = MD5('$senha');";
	// Executa a SQL
	$query = mysql_query($sql);
	// Se houver registro com as credenciais informadas
	if(mysql_num_rows($query)>0) {
		// Inicia a sessão
		session_start();
		// Atribui para o login da sessão o valor de $email
		$_SESSION['login'] = $email;
		// Redireciona o usuário para a página
		header("Location: index.php");
	// Se o usuário e senha não existirem no banco
	} else {
		// Redireciona
		header("Location: ../index.php?erro=1");
	}
	// Formulário não submetido
} else {
	// Redireciona para a página
	header("Location: ../index.php");
}
?>