<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">		
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/jquery-1.11.3.min.js"></script>
    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	</head>
	<body>
		
				<!-- MENU SUPERIOR -->
			<?php include("cabecalho.php"); ?>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		    	<h1 class="h2">Editar Valor do Produto</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="valordositensnopedido.php" role="button">Voltar</a>
			    </div>    
			</div>   
						<?php
						// Carrega o arquivo
						include("../conexao.php");
						// Verifica a URL por valor em ID
						if($_GET['id']) {
							// Atribui à variável o valor armazenado na URL
							$id_cli = $_GET['id'];
							// Cláusula SQL
							$sql_cli = "SELECT valordositensnopedido.codprod, produto.descricao,valordositensnopedido.vlrunitario FROM valordositensnopedido
										 INNER JOIN produto on valordositensnopedido.codprod=produto.codprod
										WHERE id = '$id_cli';";
								
							// Executa SQL
							$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
							if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
								$row_cli = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado
								if($_POST) {
									// Atribui às variáveis os valores preenchidos
									
									$codprod		= $_POST['codprod'];
									$descricao		= $_POST['descricao'];
									$vlrunitario	= $_POST['vlrunitario'];
									
									$vlrunitario  = str_replace(',', '.', $vlrunitario );
									// Executa a SQL
									$sql = "UPDATE valordositensnopedido SET											
											vlrunitario='$vlrunitario'											
											WHERE id='$id_cli';";
								
									if(mysql_query($sql)) {
										// Mensagem de sucesso
										$msg = 1;
										
										
									} else {
										// Mensagem de erro
										$msg = 2;
									}
								}
								?>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<?php
													if(isset($msg) and ($msg==1)) {
														?>
														<div class="alert alert-success">
															<span class="glyphicon glyphicon-ok"></span> 
															Operação realizada com sucesso!
														</div>
														<?php
													} elseif(isset($msg) and ($msg==2)) {
														?>
														<div class="alert alert-danger">
															<span class="glyphicon glyphicon-remove"></span> 
															Ocorreu um erro ao realizar a operação!
														</div>
														<?php
													}
												?>
											</div>
											<div class="col-md-12">
												<form method="post" action="valoreditar.php?id=<?php echo $id_cli; ?>">
													<div class="form-group">
														<label for="codprod">Codigo do Produto</label>
														<input type="text" name="codprod" id="codprod" maxlength="60" class="form-control" required value="<?php if(isset($_POST['codprod'])) { echo $_POST['codprod']; } else { echo $row_cli['codprod']; } ?>" Readonly>
													</div>
													<div class="form-group">
														<label for="descricao">Produto</label>
														<input type="text" name="descricao" id="descricao" maxlength="60" class="form-control" required value="<?php if(isset($_POST['descricao'])) { echo $_POST['descricao']; } else { echo $row_cli['descricao']; } ?>" Readonly>
													</div>
													<div class="form-group">
														<label for="vlrunitario'">Valor Unitário</label>
														<input type="text" name="vlrunitario" id="vlrunitario" maxlength="60" class="form-control" required value="<?php if(isset($_POST['vlrunitario'])) { echo $_POST['vlrunitario']; } else { echo $row_cli['vlrunitario']; } ?>">
													</div>																							
													
													<input class="btn btn-success" type="submit">
												</form>
											</div>
										</div>
									</div>
								</div>
						<?php 
							// Se não encontrar o registro buscado no banco de dados
							} else {
								// Carrega o arquivo 404.php na página
								header("Location: ../404.php");
								
							}
						// Se não houver valor na URL
						} else {
							// Carrega o arquivo 404.php na página
						
							header("Location: ../404.php");
							
						}
						?>
					</main>
				
	</body>
</html>