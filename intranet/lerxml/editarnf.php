<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">		
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/jquery-1.11.3.min.js"></script>
    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	</head>
	<body>
		
				<!-- MENU SUPERIOR -->
			<?php include("cabecalho.php"); ?>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		    	<h1 class="h2">Editar NF</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="listarnfs.php" role="button">Voltar</a>
			    </div>    
			</div>  
			 	<div class="col-md-12">
						<?php
						// Carrega o arquivo
						include("../conexao.php");
						// Verifica a URL por valor em ID
						if($_GET['id']) {
							// Atribui à variável o valor armazenado na URL
							$id_cli = $_GET['id'];
							// Cláusula SQL
							$sql_cli = "SELECT * FROM notafiscal
										WHERE chavedeacesso = '$id_cli';";
									
							// Executa SQL
							$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
							if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
								$row_cli = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado
								if($_POST) {
									// Atribui às variáveis os valores preenchidos
									
									$numeronf=$_POST['numeronf'];
									$codlic=$_POST['codlic'];
									$pedido=$_POST['pedido'];
									
									// Executa a SQL
									$sql = "UPDATE notafiscal SET
											
											
											
											numeronf='$numeronf',
											codlic='$codlic',
											pedido='$pedido'
											
											WHERE chavedeacesso='$id_cli';";
										
									if(mysql_query($sql)) {
										// Mensagem de sucesso
										$msg = 1;
										unset($_POST);
										
									} else {
										// Mensagem de erro
										$msg = 2;
									}
								}
								?>
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
								</div>
											
					<form method="post" action="editarnf.php?id=<?php echo $id_cli; ?>">
							<div class="row">							
									
								<div class="col-md-6">											
									<div class="form-group">
										<label for="numeronf">Número NF</label>
										<input type="text" name="numeronf" id="numeronf" maxlength="60" class="form-control" required value="<?php if(isset($_POST['numeronf'])) { echo $_POST['numeronf']; } else { echo $row_cli['numeronf']; } ?>" Readonly>
									</div>
									<div class="form-group">
										<label for="codlic">Número Licitação</label>
										<input type="text" name="codlic" id="codlic" maxlength="60" class="form-control" required value="<?php if(isset($_POST['codlic'])) { echo $_POST['codlic']; } else { echo $row_cli['codlic']; } ?>">
									</div>
									<div class="form-group">
										<label for="pedido">Número Pedido</label>
										<input type="text" name="pedido" id="pedido" maxlength="60" class="form-control" required value="<?php if(isset($_POST['pedido'])) { echo $_POST['pedido']; } else { echo $row_cli['pedido']; } ?>">
									</div>						
								</div>
							</div>																		
							
							
								<input class="btn btn-success" type="submit">
					</form>
							
								
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