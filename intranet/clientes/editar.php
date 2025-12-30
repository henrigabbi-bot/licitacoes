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
		    	<h1 class="h2">Editar Cliente</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
			    </div>    
			</div>   
					<?php
						// Carrega o arquivo
					//include("../conexao.php");
						// Verifica a URL por valor em ID
					if($_GET['id']) {
							// Atribui à variável o valor armazenado na URL
						$id_cli = $_GET['id'];
							// Cláusula SQL
						$sql_cli = "SELECT * FROM cliente
										WHERE cnpj = '$id_cli';";
									
							// Executa SQL
						$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
						if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
							$row_cli = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado
							if($_POST) {
								// Atribui às variáveis os valores preenchidos
								$nome= $_POST['nomecliente'];
								$codext= $_POST['codext'];
								$consorcio=$_POST['consorcio'];	
								$email=$_POST['email'];								
								// Executa a SQL
								$sql = "UPDATE cliente SET					
											nomecliente='$nome',
											codigoexterno='$codext',
											consorcio='$consorcio',
											email='$email'
											WHERE cnpj='$id_cli';";
									echo $sql;
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
												<form method="post" action="editar.php?id=<?php echo $id_cli; ?>">
													<div class="form-group">
														<label for="nomecliente">Cliente</label>
														<input type="text" name="nomecliente" id="nomecliente" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nomecliente'])) { echo $_POST['nomecliente']; } else { echo $row_cli['nomecliente']; } ?>">
													</div>
													<div class="form-group">
														<label for="codext">Código Externo</label>
														<input type="codext" name="codext" id="codext" maxlength="4" class="form-control" required value="<?php if(isset($_POST['codext'])) { echo $_POST['codext']; } else { echo $row_cli['codext']; } ?>">
													</div>
													<div class="form-group">
														<label for="email">E-mail</label>
														<input type="email" name="email" id="email"  class="form-control" required value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } else { echo $row_cli['email']; } ?>">
													</div>
													<div class="form-group">
										<label for="consorcio">Consórcio</label>

											<select name="consorcio" id="consorcio" class="form-control">
												<option  value="">Selecione...</option>

													<option value="CISA"<?php 
														if(!$_POST and ($row_cli['consorcio'] == "CISA")) { 
																echo "selected='selected'"; 
														}elseif($_POST['consorcio']=="CISA") {echo "selected='selected'"; 
																}?>>CISA
													</option>
													<option value="COIS"<?php 
														if(!$_POST and ($row_cli['consorcio'] == "COIS")) { 
																echo "selected='selected'"; 
														} elseif($_POST['consorcio']=="COIS") {
																echo "selected='selected'"; 
																}?>>COIS
													</option>

													<option value="COMAJA"<?php 
														if(!$_POST and ($row_cli['consorcio'] == "COMAJA")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['consorcio']=="COMAJA") {
																	echo "selected='selected'"; 
																}
																?>>COMAJA</option>
																												
																</select>
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