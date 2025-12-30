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
			        <a class="btn btn-primary" href="listarlicitacoes.php" role="button">Voltar</a>
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
							$sql_cli = "SELECT * FROM comparativo WHERE codlic = '$id_cli';";						
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
									$linkprocesso=$_POST['linkprocesso'];
									$municipio=$_POST['municipio'];
									$dataabertura=$_POST['dataabertura'];									
									$datapublicacao=$_POST['datapublicacao'];
									$ativo=$_POST['ativo'];
									// Executa a SQL
									$sql = "UPDATE comparativo SET
											
											npregao='$npregao',
											nprocesso ='$nprocesso',
											datahomologacao='$datahomologacao',
											linkprocesso='$linkprocesso',	
											municipio='$municipio',										
											dataabertura='$dataabertura',
											datapublicacao='$datapublicacao',
											ativo='$ativo'
											
											WHERE codlic='$id_cli';";
										
									if(mysql_query($sql)) {
										// Mensagem de sucesso
										$msg = 1;
										unset($_POST);
										$sql_cli = "SELECT * FROM comparativo WHERE codlic = '$id_cli';";	
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
										<label for="muni">Link do Processo</label>
										<input type="text" name="linkprocesso" id="linkprocesso" maxlength="60" class="form-control" required value="<?php if(isset($_POST['linkprocesso'])) { echo $_POST['linkprocesso']; } else { echo $row_cli['linkprocesso']; } ?>">
										
									</div>	
									<div class="form-group">
										<label for="municipio">Município</label>
										<input type="text" name="municipio" id="municipio" maxlength="60" class="form-control" required value="<?php if(isset($_POST['municipio'])) { echo $_POST['municipio']; } else { echo $row_cli['municipio']; } ?>">
										
									</div>	
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="datapublicacao">Data Publicação</label>
										<input type="date" name="datapublicacao" id="datapublicacao" maxlength="8" class="form-control" required value="<?php if(isset($_POST['datapublicacao'])) { echo $_POST['datapublicacao']; } else { echo $row_cli['datapublicacao']; } ?>">
									</div>	
									<div class="form-group">
										<label for="dataabertura">Data Abertura</label>
										<input type="date" name="dataabertura" id="dataabertura" maxlength="8" class="form-control" required value="<?php if(isset($_POST['dataabertura'])) { echo $_POST['dataabertura']; } else { echo $row_cli['dataabertura']; } ?>">
									</div>	
									<div class="form-group">
										<label for="datahomologacao">Data Homologação</label>
										<input type="date" name="datahomologacao" id="datahomologacao" maxlength="8" class="form-control" required value="<?php if(isset($_POST['datahomologacao'])) { echo $_POST['datahomologacao']; } else { echo $row_cli['datahomologacao']; } ?>">
									</div>
										<div class="form-group">
												<label for="ativo">Ativo</label>

													<select name="ativo" id="ativo" class="form-control">
													<option  value="">Selecione...</option>

													
													<option value="SIM"<?php 
														if(!$_POST and ($row_cli['ativo'] == "SIM")) { 
																echo "selected='selected'"; 
														}elseif($_POST['ativo']=="SIM") {echo "selected='selected'"; 
																}?>>SIM
													</option>
													<option value="NÃO"<?php 
														if(!$_POST and ($row_cli['ativo'] == "NÃO")) { 
																echo "selected='selected'"; 
														} elseif($_POST['ativo']=="NÃO") {
																echo "selected='selected'"; 
																}?>>NÃO
													</option>

											
																								
												</select>
									</div>						
																
										
											
											

															
																	
																																			
													
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