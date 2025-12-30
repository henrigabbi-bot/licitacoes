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
							$sql_cli = "SELECT * FROM produto
										WHERE codprod = '$id_cli';";
									
							// Executa SQL
							$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
							if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
								$row_cli = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado




								if($_POST) {
									// Atribui às variáveis os valores preenchidos
									$descricao= $_POST['descricao'];							
									$unidade= $_POST['unidade'];
									$codigobr= $_POST['codigobr'];							
									$codigounidade= $_POST['codigounidade'];		
									
									
									
									// Executa a SQL
									$sql = "UPDATE produto SET
											
											descricao='$descricao',
											unidade='$unidade',
											codigobr='$codigobr',
											codigounidade='$codigounidade'
																						
											WHERE codprod='$id_cli';";
										
										echo $sql;
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
											
					<form method="post" action="editar.php?id=<?php echo $id_cli; ?>">
							<div class="row">
								<div class="col-md-6">												
									<div class="form-group">
										<label for="descricao">Descrição</label>
										<input type="text" name="descricao" id="descricao" maxlength="250" class="form-control" required value="<?php if(isset($_POST['descricao'])) { echo $_POST['descricao']; } else { echo $row_cli['descricao']; } ?>">
									</div>
									<div class="form-group">
										<label for="codigobr">Código BR</label>
										<input type="text" name="codigobr" id="codigobr" maxlength="9" class="form-control" required value="<?php if(isset($_POST['codigobr'])) { echo $_POST['codigobr']; } else { echo $row_cli['codigobr']; } ?>">
									</div>
									<div class="form-group">
										<label for="codigounidade">Código Unidade</label>
										<input type="text" name="codigounidade" id="codigounidade" maxlength="4" class="form-control" value="<?php if(isset($_POST['codigounidade'])) { echo $_POST['codigounidade']; } else { echo $row_cli['codigounidade']; } ?>">
									</div>
										<div class="form-group">
												<label for="unidade">Unidade</label>

													<select name="unidade" id="unidade" class="form-control">
													<option  value="">Selecione...</option>

													
													<option value="Ampola"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Ampola")) { 
																echo "selected='selected'"; 
														}elseif($_POST['unidade']=="Ampola") {echo "selected='selected'"; 
																}?>>Ampola
													</option>
													<option value="Comprimido"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Comprimido")) { 
																echo "selected='selected'"; 
														} elseif($_POST['unidade']=="Comprimido") {
																echo "selected='selected'"; 
																}?>>Comprimido
													</option>

													<option value="Bisnaga"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Bisnaga")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Bisnaga") {
																	echo "selected='selected'"; 
																}
																?>>Bisnaga</option>
													
													<option value="Caixa"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Caixa")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Caixa") {
																	echo "selected='selected'"; 
																}
																?>>Caixa</option>

													<option value="Cápsula"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Cápsula")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Cápsula") {
																	echo "selected='selected'"; 
																}
																?>>Cápsula</option>	
													<option value="Dragea"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Dragea")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Dragea") {
																	echo "selected='selected'"; 
																}
																?>>Drágea</option>																	
													<option value="Envelope"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Envelope")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Envelope") {
																	echo "selected='selected'"; 
																}
																?>>Envelope</option>	

																<option value="Frasco"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Frasco")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Frasco") {
																	echo "selected='selected'"; 
																}
																?>>Frasco</option>	

													<option value="Unidade"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Unidade")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Unidade") {
																	echo "selected='selected'"; 
																}
																?>>Unidade</option>	
													
													<option value="Lata"<?php 
														if(!$_POST and ($row_cli['unidade'] == "Lata")){ 
																		echo "selected='selected'"; 
																	} elseif($_POST['unidade']=="Lata") {
																	echo "selected='selected'"; 
																}
																?>>Lata</option>	
													

												
													
																								
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