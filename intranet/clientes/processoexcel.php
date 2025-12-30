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
		
		
		
		foreach ($linhas as $linha) {

		    // Recupera todos os nós <Data> da linha
		    $datas = $linha->getElementsByTagName("Data");

		    // Verifica se existem pelo menos 3 nós <Data>
		    if ($datas->length < 3) {
		        // pula esta linha do XML se estiver incompleta
		        continue;
		    }

		    // Captura e remove espaços extras
		    $id           = trim($datas->item(0)->nodeValue);
		    $cnpj         = trim($datas->item(1)->nodeValue);
		    $nomecliente  = trim($datas->item(2)->nodeValue);

		    // Valida campos obrigatórios
		    if (empty($id) || empty($cnpj) || empty($nomecliente)) {
		        // pula registros com dados vazios
		        continue;
		    }

		    // Remove caracteres não numéricos do CNPJ
		    $cnpjLimpo = preg_replace('/\D/', '', $cnpj);

		    // Valida tamanho do CNPJ (14 dígitos)
		    if (strlen($cnpjLimpo) != 14) {
		        continue;
		    }

		    // Verifica se o ID já existe no banco
		    $query6 = mysql_query("SELECT 1 FROM cliente WHERE id='$id' LIMIT 1");
		    if (mysql_num_rows($query6) > 0) {
		        continue;
		    }

		    // Escapa dados para evitar erros de SQL
		    $id          = mysql_real_escape_string($id);
		    $cnpjLimpo   = mysql_real_escape_string($cnpjLimpo);
		    $nomecliente = mysql_real_escape_string($nomecliente);

		    // Insere no banco
		    $sql = "INSERT INTO cliente (id, cnpj, nomecliente)
		            VALUES ('$id', '$cnpjLimpo', '$nomecliente')";

		    if (mysql_query($sql)) {
		        $continsercao++;
		    }

							
		}
	}

$_SESSION["msg"]=$continsercao;
header("Location:importar.php");
?>