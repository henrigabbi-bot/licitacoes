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
		<?php 
			session_start();
			if (isset($_SESSION['login'])) {				
			
		?>
				<!-- MENU SUPERIOR -->
			<?php include("cabecalho.php"); ?>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		    	<h1 class="h2">Editar Licitação</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
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
							$sql_cli = "SELECT * FROM licitacao WHERE codlic = '$id_cli';";						
							// Executa SQL
							$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
							if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
								$row_cli = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado
								if($_POST) {
									// Atribui às variáveis os valores preenchidos
									$npregao		= $_POST['npregao'];
									$nprocesso		= $_POST['nprocesso'];
									$datahomologacao	= $_POST['datahomologacao'];
									$objeto=$_POST['objeto'];
									$cpf=$_POST['cpf'];									
									$cpf2=$_POST['cpf2'];
									
									// Executa a SQL
									$sql = "UPDATE licitacao SET
											
											npregao='$npregao',
											nprocesso ='$nprocesso',
											datahomologacao='$datahomologacao',
											objeto='$objeto',											
											cpf='$cpf',
											cpf2='$cpf2'
											
											WHERE codlic='$id_cli';";
										
									if(mysql_query($sql)) {
										// Mensagem de sucesso
										$msg = 1;
										unset($_POST);
										$sql_cli = "SELECT * FROM licitacao WHERE codlic = '$id_cli';";	
										$query_cli=mysql_query($sql_cli);
										$row_cli = mysql_fetch_array($query_cli);
										
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
															Licitação <b><?php echo $npregao?></b> alterada com sucesso!
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
											
					<form method="post" action="editar.php?id=<?php echo $id_cli; ?>">
							<div class="row">
								<div class="col-md-6">												
									<div class="form-group">
										<label for="npregao">Número de Pregão</label>
										<input type="text" name="npregao" id="npregao" maxlength="60" class="form-control" required value="<?php if(isset($_POST['npregao'])) { echo $_POST['npregao']; } else { echo $row_cli['npregao']; } ?>">
									</div>
									<div class="form-group">
										<label for="nprocesso">Número do Processo</label>
										<input type="text" name="nprocesso" id="nprocesso" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nprocesso'])) { echo $_POST['nprocesso']; } else { echo $row_cli['nprocesso']; } ?>">
									</div>	
									
									<div class="form-group">
										<label for="objeto">Objeto</label>
										<textarea class="form-control" id="objeto" name="objeto" rows="4"  required value="<?php if(isset($_POST['objeto'])) { echo $_POST['objeto']; } else { echo $row_cli['objeto']; } ?>"><?php echo $row_cli['objeto']; ?></textarea>
										
									</div>	
								</div>
								<div class="col-md-6">
											<div class="form-group">
										<label for="datahomologacao">Data Homologação</label>
										<input type="date" name="datahomologacao" id="datahomologacao" maxlength="60" class="form-control" required value="<?php if(isset($_POST['datahomologacao'])) { echo $_POST['datahomologacao']; } else { echo $row_cli['datahomologacao']; } ?>">
									</div>						
										
											
											<div class="form-group">		
												<label for="cpf">Autoridade Competente</label>	
													<select id="cpf" name="cpf" class="form-control">							
														<option  value="">Selecione...</option>
														<?php
															include("../conexao.php");
															$sql_cli = "SELECT * FROM pessoas where tipo='ordenador' ORDER BY nome asc ";

															$query_cli = mysql_query($sql_cli);	
															while($row_pessoa = mysql_fetch_array($query_cli)) {
																	?>

																	<option value="<?php echo $row_pessoa['cpf'];?>"
																	
																	<?php 
																			if(!$_POST and ($row_cli['cpf']==$row_pessoa['cpf'])) { 
																				echo "selected='selected'"; 
																			} else if($_POST['cpf']==$row_pessoa['cpf']) {
																				echo "selected='selected'"; 
																			}
																		?>><?php echo $row_pessoa['nome'];?>


																	</option>
															
															<?php
															}
																	
															?>																			
													</select>
											</div>
											<div class="form-group">		
												<label for="cpf2">Assessor Jurídico</label>	
													<select id="cpf2" name="cpf2" class="form-control">							
														<option  value="">Selecione...</option>
														<?php
															include("../conexao.php");
															$sql_cli = "SELECT * FROM pessoas where tipo='juridico' ORDER BY nome asc ";

															$query_cli = mysql_query($sql_cli);	
															while($row_pessoa = mysql_fetch_array($query_cli)) {
																	?>

																	<option value="<?php echo $row_pessoa['cpf'];?>"
																	
																	<?php 
																			if(!$_POST and ($row_cli['cpf']==$row_pessoa['cpf2'])) { 
																				echo "selected='selected'"; 
																			} else if($_POST['cpf']==$row_pessoa['cpf2']) {
																				echo "selected='selected'"; 
																			}
																		?>><?php echo $row_pessoa['nome'];?>


																	</option>
															
															<?php
															}
																	
															?>

															
																	
																																			
													</select>
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