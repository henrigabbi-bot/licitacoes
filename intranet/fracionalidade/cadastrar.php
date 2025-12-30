<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">	
	
		<script src="../../js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		        <h1 class="h2">Cadastro de Produto com Restrição</h1>	            
		            <div class="btn-toolbar mb-2 mb-md-0">
			            <div class="btn-group mr-2">		              
			            	<a class="btn btn-primary" href="index.php" role="button">Voltar</a> 
			                          
			             </div>     	
	                </div>  
			</div>          		
			<div class="col-md-5">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							$codprod	= $_POST['codprod'];
							$embalagem	= $_POST['embalagem'];
											
							
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO fracionamento
									(codprod,embalagem)
									VALUES
									('$codprod','$embalagem');";
							
							if(mysql_query($sql)) {
								// Mensagem de sucesso
								$msg = 1;
								// Limpa os valores armazenados
								unset($_POST);
							} else {
								// Mensagem de erro
								$msg = 2;
							}
						}						
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
									
		
										

								
						<form method="post" action="cadastrar.php">
							<div class="form-group">
							<label for="codprod">Selecione o Medicamento</label>	
							<select id="codprod" name="codprod" class="form-control">							
								<option>Selecione...</option>
								<?php
									include("../conexao.php");
									$sql_cli = "SELECT produto.codprod,produto.descricao FROM produto
LEFT JOIN fracionamento on produto.codprod=fracionamento.codprod WHERE fracionamento.codprod is null";
									echo $sql_cli;
									$query_cli = mysql_query($sql_cli);
									if(mysql_num_rows($query_cli)>0) {
										while($row_cli = mysql_fetch_array($query_cli)) {
											?>
											<option value="<?php echo $row_cli['codprod'];?>">
											<?PHP echo $row_cli['codprod'];?> - <?php echo $row_cli['descricao'];?>
											</option>
									<?php
									}
											}
									?>
							</select>
						</div>

							
							
							<div class="form-group">
								<label for="embalagem">Embalagem</label>
								<input type="text" name="embalagem" id="embalagem" maxlength="60" class="form-control" required value="<?php if(isset($_POST['embalagem'])) { echo $_POST['embalagem']; } ?>">
							</div>
																	
							<input class="btn btn-success" type="submit">
						</form>					
					</div>
		
		
		</main>	
						
				
	</body>
</html>