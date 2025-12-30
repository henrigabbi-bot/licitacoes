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
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		        <h1 class="h2">Cadastrar Fornecedor</h1>	            
		         <div class="btn-group mr-2">		              
			            	<a class="btn btn-primary" href="index.php" role="button">Voltar</a> 
			                          
			             </div>      
			</div>          		
			<div class="col-md-12">
				<?php
						



						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							$cnpj= $_POST['cnpj'];
							$nome= mb_strtoupper($_POST['nomefornecedor'],'UTF-8');
							$cidade=mb_strtoupper($_POST['cidade'],'UTF-8');
							$estado=$_POST['estado'];
							$endereco= ucwords($_POST['endereco']);
							$bairro=ucwords($_POST['bairro']);
							$cep=$_POST['cep'];
							$cpf=$_POST['cpf'];
							
							
						
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO fornecedor
									(cnpj,nomefornecedor,cidade,estado,endereco,bairro,cep,cpf)
									VALUES
									('$cnpj','$nome','$cidade','$estado','$endereco','$bairro','$cep','$cpf');";
								
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
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label for="cnpj">CNPJ</label>
										<input type="text" name="cnpj" id="cnpj" maxlength="60" class="form-control"  required value="<?php if(isset($_POST['cnpj'])) { echo $_POST['cnpj']; } ?>">
									</div>
									<div class="form-group">
										<label for="nomefornecedor">Nome</label>
										<input type="text" name="nomefornecedor" id="nomefornecedor" maxlength="80" class="form-control" required value="<?php if(isset($_POST['nomefornecedor'])) { echo $_POST['nomefornecedore']; } ?>">
									</div>
									<div class="form-group">
										<label for="endereco">Endereço</label>
										<input type="text" name="endereco" id="endereco" maxlength="60" class="form-control" required value="<?php if(isset($_POST['endereco'])) { echo $_POST['endereco']; } ?>">
									</div>
										<div class="form-group">
										<label for="bairro">Bairro</label>
										<input type="text" name="bairro" id="bairro" maxlength="60" class="form-control" required value="<?php if(isset($_POST['bairro'])) { echo $_POST['bairro']; } ?>">
									</div>
											
								
								</div>
								<div class="col-md-5">						
									
									<div class="form-group">
										<label for="cidade">Cidade</label>
										<input type="text" name="cidade" id="cidade" maxlength="60" class="form-control" required value="<?php if(isset($_POST['cidade'])) { echo $_POST['cidade']; } ?>">
									</div>
									<div class="form-group">
												<label for="estado">Estado</label>
												<select name="estado" id="estado" class="form-control">
													<option value="AC"<?php 
														if($_POST and ($_POST['estado'] == "AC")) { 
															echo "selected='selected'"; 
														} 
													?>>Acre</option>
													<option value="AL"<?php 
														if($_POST and ($_POST['estado'] == "AL")) { 
															echo "selected='selected'"; 
														} 
													?>>Alagoas</option>
													<option value="AP"<?php 
														if($_POST and ($_POST['estado'] == "AP")) { 
															echo "selected='selected'"; 
														} 
													?>>Amapá</option>
													<option value="AM"<?php 
														if($_POST and ($_POST['estado'] == "AM")) { 
															echo "selected='selected'"; 
														} 
													?>>Amazonas</option>
													<option value="BA"<?php 
														if($_POST and ($_POST['estado'] == "BA")) { 
															echo "selected='selected'"; 
														} 
													?>>Bahia</option>
													<option value="CE"<?php 
														if($_POST and ($_POST['estado'] == "CE")) { 
															echo "selected='selected'"; 
														} 
													?>>Ceará</option>
													<option value="DF"<?php 
														if($_POST and ($_POST['estado'] == "DF")) { 
															echo "selected='selected'"; 
														} 
													?>>Distrito Federal</option>
													<option value="ES"<?php 
														if($_POST and ($_POST['estado'] == "ES")) { 
															echo "selected='selected'"; 
														} 
													?>>Espirito Santo</option>
													<option value="GO"<?php 
														if($_POST and ($_POST['estado'] == "GO")) { 
															echo "selected='selected'"; 
														} 
													?>>Goiás</option>
													<option value="MA"<?php 
														if($_POST and ($_POST['estado'] == "MA")) { 
															echo "selected='selected'"; 
														} 
													?>>Maranhão</option>
													<option value="MS"<?php 
														if($_POST and ($_POST['estado'] == "MS")) { 
															echo "selected='selected'"; 
														} 
													?>>Mato Grosso do Sul</option>
													<option value="MT"<?php 
														if($_POST and ($_POST['estado'] == "MT")) { 
															echo "selected='selected'"; 
														} 
													?>>Mato Grosso</option>
													<option value="MG"<?php 
														if($_POST and ($_POST['estado'] == "MG")) { 
															echo "selected='selected'"; 
														} 
													?>>Minas Gerais</option>
													<option value="PA"<?php 
														if($_POST and ($_POST['estado'] == "PA")) { 
															echo "selected='selected'"; 
														} 
													?>>Pará</option>
													<option value="PB"<?php 
														if($_POST and ($_POST['estado'] == "PB")) { 
															echo "selected='selected'"; 
														} 
													?>>Paraíba</option>
													<option value="PR"<?php 
														if($_POST and ($_POST['estado'] == "PR")) { 
															echo "selected='selected'"; 
														} 
													?>>Paraná</option>
													<option value="PE"<?php 
														if($_POST and ($_POST['estado'] == "PE")) { 
															echo "selected='selected'"; 
														} 
													?>>Pernambuco</option>
													<option value="PI"<?php 
														if($_POST and ($_POST['estado'] == "PI")) { 
															echo "selected='selected'"; 
														} 
													?>>Piauí</option>
													<option value="RJ"<?php 
														if($_POST and ($_POST['estado'] == "RJ")) { 
															echo "selected='selected'"; 
														} 
													?>>Rio de Janeiro</option>
													<option value="RN"<?php 
														if($_POST and ($_POST['estado'] == "RN")) { 
															echo "selected='selected'"; 
														} 
													?>>Rio Grande do Norte</option>
													<option value="RS"<?php 
														if($_POST and ($_POST['estado'] == "RS")) { 
															echo "selected='selected'"; 
														} 
													?>>Rio Grande do Sul</option>
													<option value="RO"<?php 
														if($_POST and ($_POST['estado'] == "RO")) { 
															echo "selected='selected'"; 
														} 
													?>>Rondônia</option>
													<option value="RR"<?php 
														if($_POST and ($_POST['estado'] == "RR")) { 
															echo "selected='selected'"; 
														} 
													?>>Roraima</option>
													<option value="SC"<?php 
														if($_POST and ($_POST['estado'] == "SC")) { 
															echo "selected='selected'"; 
														} 
													?>>Santa Catarina</option>
													<option value="SP"<?php 
														if($_POST and ($_POST['estado'] == "SP")) { 
															echo "selected='selected'"; 
														} 
													?>>São Paulo</option>
													<option value="SE"<?php 
														if($_POST and ($_POST['estado'] == "SE")) { 
															echo "selected='selected'"; 
														} 
													?>>Sergipe</option>
													<option value="TO"<?php 
														if($_POST and ($_POST['estado'] == "TO")) { 
															echo "selected='selected'"; 
														} 
													?>>Tocantins</option>												
												</select>
									</div>
											
									
									<div class="form-group">
										<label for="cep">CEP</label>
										<input type="text" name="cep" id="cep" placeholder="00000-000" maxlength="8" class="form-control" required value="<?php if(isset($_POST['cep'])) { echo $_POST['cep']; } ?>">
									</div>
							<div class="form-group">		
								<label for="cpf">Representante</label>	
									<select id="cpf" name="cpf" class="form-control">							
										<option>Selecione...</option>
										<?php
											include("../conexao.php");
											$sql_cli = "SELECT * FROM pessoas where tipo='representante'";

											$query_cli = mysql_query($sql_cli);
											if(mysql_num_rows($query_cli)>0) {
												while($row_cli = mysql_fetch_array($query_cli)) {
													?>
													<option value="<?php echo $row_cli['cpf'];?>">
													<?php echo $row_cli['nome'];?>
													</option>
											<?php
											}
													}
											?>
									</select>
							</div>

								</div>
							</div>					
							<input class="btn btn-success" type="submit">
						</form>					
					</div>
		
		</main>	
			
				
	</body>
</html>