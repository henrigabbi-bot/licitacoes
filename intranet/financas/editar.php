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
		    	<h1 class="h2">Editar Fornecedor</h1>	            
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
							$sql_cli = "SELECT * FROM fornecedor
										WHERE cnpj = '$id_cli';";
									
							// Executa SQL
							$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
							if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
								$row_forn = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado
								if($_POST) {
									// Atribui às variáveis os valores preenchidos
									$nome		= mb_strtoupper($_POST['nomefornecedor']);
									$cidade		= mb_strtoupper($_POST['cidade']);
									$endereco	= ucfirst($_POST['endereco']);
									$bairro=ucfirst($_POST['bairro']);
									$cep=$_POST['cep'];
									$estado=$_POST['estado'];
									$cpf=$_POST['cpf'];
									
									
									// Executa a SQL
									if (isset($cpf)) {
										$sql = "UPDATE fornecedor SET
											
											nomefornecedor='$nome',
											cidade ='$cidade',
											estado='$estado',
											endereco='$endereco',
											bairro='$bairro',
											cep='$cep',
											cpf='$cpf'											
											
											WHERE cnpj='$id_cli';";
									} else{
										$sql = "UPDATE fornecedor SET
											
											nomefornecedor='$nome',
											cidade ='$cidade',
											estado='$estado',
											endereco='$endereco',
											bairro='$bairro',
											cep='$cep'
											
											
											WHERE cnpj='$id_cli';";
									}

									
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
										<label for="nomefornecedor">Fornecedor</label>
										<input type="text" name="nomefornecedor" id="nomefornecedor" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nomefornecedor'])) { echo $_POST['nomefornecedor']; } else { echo $row_forn['nomefornecedor']; } ?>">
									</div>
									<div class="form-group">
										<label for="endereco">Endereço</label>
										<input type="text" name="endereco" id="endereco" maxlength="60" class="form-control" value="<?php if(isset($_POST['endereco'])) { echo $_POST['endereco']; } else { echo $row_forn['endereco']; } ?>">
									</div>
									<div class="form-group">
										<label for="cep">CEP</label>
										<input type="text" name="cep" id="cep" maxlength="60" class="form-control" value="<?php if(isset($_POST['cep'])) { echo $_POST['cep']; } else { echo $row_forn['cep']; } ?>">
									</div>	
									
									<div class="form-group">
										<label for="bairro">Bairro</label>
										<input type="text" name="bairro" id="bairro" maxlength="60" class="form-control" value="<?php if(isset($_POST['bairro'])) { echo $_POST['bairro']; } else { echo $row_forn['bairro']; } ?>">
									</div>
								</div>
								<div class="col-md-6">	
										
									
									<div class="form-group">
										<label for="cidade">Cidade</label>
										<input type="text" name="cidade" id="cidade" maxlength="60" class="form-control" value="<?php if(isset($_POST['cidade'])) { echo $_POST['cidade']; } else { echo $row_forn['cidade']; } ?>">
									</div>
									<div class="form-group">
										<label for="estado">Estado</label>

											<select name="estado" id="estado" class="form-control">
																<option  value="">Selecione...</option>

																<option value="AC"<?php 
																	if($row_forn['estado'] == "AC") { 
																		echo "selected='selected'"; 
																	} 
																?>>Acre</option>
																<option value="AL"<?php 
																	if($row_forn['estado'] == "AL") { 
																		echo "selected='selected'"; 
																	} 
																?>>Alagoas</option>
																<option value="AP"<?php 
																	if($row_forn['estado']  == "AP") { 
																		echo "selected='selected'"; 
																	} 
																?>>Amapá</option>
																<option value="AM"<?php 
																	if($row_forn['estado']  == "AM") { 
																		echo "selected='selected'"; 
																	} 
																?>>Amazonas</option>
																<option value="BA"<?php 
																	if($row_forn['estado']  == "BA") { 
																		echo "selected='selected'"; 
																	} 
																?>>Bahia</option>
																<option value="CE"<?php 
																	if($row_forn['estado'] == "CE"){ 
																		echo "selected='selected'"; 
																	} 
																?>>Ceará</option>
																<option value="DF"<?php 
																	if($row_forn['estado'] == "DF") { 
																		echo "selected='selected'"; 
																	} 
																?>>Distrito Federal</option>
																<option value="ES"<?php 
																	if($row_forn['estado']  == "ES"){ 
																		echo "selected='selected'"; 
																	} 
																?>>Espirito Santo</option>
																<option value="GO"<?php 
																	if($row_forn['estado']== "GO"){ 
																		echo "selected='selected'"; 
																	} 
																?>>Goiás</option>
																<option value="MA"<?php 
																	if($row_forn['estado']  == "MA") { 
																		echo "selected='selected'"; 
																	} 
																?>>Maranhão</option>
																<option value="MS"<?php 
																	if($row_forn['estado'] == "MS") { 
																		echo "selected='selected'"; 
																	} 
																?>>Mato Grosso do Sul</option>
																<option value="MT"<?php 
																	if($row_forn['estado'] == "MT") { 
																		echo "selected='selected'"; 
																	} 
																?>>Mato Grosso</option>
																<option value="MG"<?php 
																	if($row_forn['estado']  == "MG") { 
																		echo "selected='selected'"; 
																	} 
																?>>Minas Gerais</option>
																<option value="PA"<?php 
																	if($row_forn['estado']  == "PA") { 
																		echo "selected='selected'"; 
																	} 
																?>>Pará</option>
																<option value="PB"<?php 
																	if($row_forn['estado']  == "PB") { 
																		echo "selected='selected'"; 
																	} 
																?>>Paraíba</option>
																<option value="PR"<?php 
																	if($row_forn['estado']  == "PR") { 
																		echo "selected='selected'"; 
																	} 
																?>>Paraná</option>
																<option value="PE"<?php 
																	if($row_forn['estado'] == "PE") { 
																		echo "selected='selected'"; 
																	} 
																?>>Pernambuco</option>
																<option value="PI"<?php 
																	if($row_forn['estado']  == "PI") { 
																		echo "selected='selected'"; 
																	} 
																?>>Piauí</option>
																<option value="RJ"<?php 
																	if($row_forn['estado']  == "RJ") { 
																		echo "selected='selected'"; 
																	} 
																?>>Rio de Janeiro</option>
																<option value="RN"<?php 
																	if($row_forn['estado']  == "RN") { 
																		echo "selected='selected'"; 
																	} 
																?>>Rio Grande do Norte</option>
																<option value="RS"<?php 
																	if($row_forn['estado'] == "RS") { 
																		echo "selected='selected'"; 
																	} 
																?>>Rio Grande do Sul</option>
																<option value="RO"<?php 
																	if($row_forn['estado']== "RO") { 
																		echo "selected='selected'"; 
																	} 
																?>>Rondônia</option>
																<option value="RR"<?php 
																	if($row_forn['estado'] == "RR") { 
																		echo "selected='selected'"; 
																	} 
																?>>Roraima</option>
																<option value="SC"<?php 
																	if($row_forn['estado'] == "SC") { 
																		echo "selected='selected'"; 
																	} 
																?>>Santa Catarina</option>
																<option value="SP"<?php 
																	if($row_forn['estado'] == "SP") { 
																		echo "selected='selected'"; 
																	} 
																?>>São Paulo</option>
																<option value="SE"<?php 
																	if($row_forn['estado'] == "SE") { 
																		echo "selected='selected'"; 
																	} 
																?>>Sergipe</option>
																<option value="TO"<?php 
																	if($row_forn['estado']  == "TO") { 
																		echo "selected='selected'"; 
																	} 
																?>>Tocantins</option>												
											</select>
										</div>
											
											<div class="form-group">		
												<label for="cpf">Representante</label>	
													<select id="cpf" name="cpf" class="form-control">							
														<option  value="">Selecione...</option>
														<?php
															include("../conexao.php");
															$sql_cli = "SELECT * FROM pessoas where tipo='representante' ORDER BY nome asc ";

															$query_cli = mysql_query($sql_cli);	
															while($row_pessoa = mysql_fetch_array($query_cli)) {
																	?>

																	<option value="<?php echo $row_pessoa['cpf'];?>"
																	
																	<?php 
																			if(!$_POST and ($row_forn['cpf']==$row_pessoa['cpf'])) { 
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