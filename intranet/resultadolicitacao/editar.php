<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">		
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/jquery-1.11.3.min.js"></script>
		<script src="../../js/custom3.js"></script>
    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	</head>
	<body>
		<?php 
			session_start();
			if (isset($_SESSION['login'])) {				
			
		?>
		
				<!-- MENU SUPERIOR -->
		<?php include("cabecalho.php"); ?>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		    	<h1 class="h2">Editar Produto</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="empresaitens.php" role="button">Voltar</a>
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
							$sql_cli = "SELECT *, produto.descricao FROM resultadolicitacao
							INNER JOIN produto on resultadolicitacao.codprod=produto.codprod
										WHERE id= '$id_cli';";
									
							// Executa SQL
							$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
							if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
								$row_cli = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado




								if($_POST) {
									// Atribui às variáveis os valores preenchidos
									$item= $_POST['item'];
									$descricao= $_POST['descricao'];							
									
									$cnpjfabricante= $_POST['cnpjfabricante'];							
									$registroanvisa= $_POST['registroanvisa'];		
									
									if(strlen($registroanvisa)==0 or strlen($registroanvisa)==13 or strlen($registroanvisa)==11){

										// Executa a SQL
										$sql = "UPDATE resultadolicitacao SET
												
												cnpjfabricante='$cnpjfabricante',
												registroanvisa='$registroanvisa'
																							
												WHERE id='$id_cli';";
											
											
										if(mysql_query($sql)) {
											// Mensagem de sucesso
											$msg = 1;
											unset($_POST);
											
										} else {
											// Mensagem de erro
											$msg = 2;
										}

									} else{
										// Mensagem de erro
										$msg = 3;
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
													}elseif(isset($msg) and ($msg==3)) {
														?>
														<div class="alert alert-danger">
															<span class="glyphicon glyphicon-remove"></span> 
															Registro não possui 13 dígitos!
														</div>
														<?php
													}
												?>
									</div>
								</div>
											
					<form method="post" action="editar.php?id=<?php echo $id_cli; ?>">
							<div class="row">
								<div class="col-md-6">	
								<div class="form-group">
										<label for="item">Item</label>
										<input type="text" name="item" id="item" maxlength="60" class="form-control"  disabled="" required value="<?php if(isset($_POST['item'])) { echo $_POST['item']; } else { echo $row_cli['item']; } ?>">
									</div>											
									<div class="form-group">
										<label for="descricao">Descrição</label>
										<input type="text" name="descricao" id="descricao" maxlength="60" class="form-control"  disabled="" required value="<?php if(isset($_POST['descricao'])) { echo $_POST['descricao']; } else { echo $row_cli['descricao']; } ?>">
									</div>
									<div class="form-group">
										<label for="cnpjfabricante">CNPJ Fabricante</label>
										<input type="text" name="cnpjfabricante" id="cnpjfabricante" placeholder="Somente números" maxlength="18" oninput="maskCPF(this)"class="form-control"  required value="<?php if(isset($_POST['cnpjfabricante'])) { echo $_POST['cnpjfabricante']; } else { echo $row_cli['cnpjfabricante']; } ?>">
									</div>
									<div class="form-group">
										<label for="registroanvisa">Registro Anvisa</label>
										<input type="text" name="registroanvisa" id="registroanvisa" maxlength="13" class="form-control" value="<?php if(isset($_POST['registroanvisa'])) { echo $_POST['registroanvisa']; } else { echo $row_cli['registroanvisa']; } ?>">
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
					<?php

				}else {
					header("Location: ../403.php");
				}	
				
				?>
	</body>

</html>