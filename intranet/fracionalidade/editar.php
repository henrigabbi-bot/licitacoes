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
							$sql_cli = "SELECT * FROM fracionamento
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
									$descricao= $_POST['descricao'];							
									$unidade	= $_POST['unidade'];	
									
									
									
									// Executa a SQL
									$sql = "UPDATE fracionamento SET
											
											descricao='$descricao',
											unidade='$unidade'
																						
											WHERE id ='$id_cli';";
										
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
										<input type="text" name="descricao" id="descricao maxlength="60" class="form-control" required value="<?php if(isset($_POST['descricao'])) { echo $_POST['descricao']; } else { echo $row_cli['descricao']; } ?>">
									</div>
										<div class="form-group">
												<label for="unidade">Unidade</label>
												<select name="unidade" id="unidade" class="form-control">
													<option value="Caixa"<?php 
														if($_POST and ($_POST['unidade'] == "Caixa")) { 
															echo "selected='selected'"; 
														} 
													?>>Caixa</option>
													<option value="Comprimido"<?php 
														if($_POST and ($_POST['unidade'] == "Comprimido")) { 
															echo "selected='selected'"; 
														} 
													?>>Comprimido</option>
													
													<option value="AP"<?php 
														if($_POST and ($_POST['unidade'] == "AP")) { 
															echo "selected='selected'"; 
														} 
													?>>Amapá</option>
													<option value="AM"<?php 
														if($_POST and ($_POST['unidade'] == "AM")) { 
															echo "selected='selected'"; 
														} 
													?>>Amazonas</option>
													<option value="BA"<?php 
														if($_POST and ($_POST['unidade'] == "BA")) { 
															echo "selected='selected'"; 
														} 
													?>>Bahia</option>
													<option value="CE"<?php 
														if($_POST and ($_POST['unidade'] == "CE")) { 
															echo "selected='selected'"; 
														} 
													?>>Ceará</option>
													<option value="DF"<?php 
														if($_POST and ($_POST['unidade'] == "DF")) { 
															echo "selected='selected'"; 
														} 
													?>>Distrito Federal</option>
													<option value="ES"<?php 
														if($_POST and ($_POST['unidade'] == "ES")) { 
															echo "selected='selected'"; 
														} 
													?>>Espirito Santo</option>
													<option value="GO"<?php 
														if($_POST and ($_POST['unidade'] == "GO")) { 
															echo "selected='selected'"; 
														} 
													?>>Goiás</option>
													<option value="MA"<?php 
														if($_POST and ($_POST['unidade'] == "MA")) { 
															echo "selected='selected'"; 
														} 
													?>>Maranhão</option>
													<option value="MS"<?php 
														if($_POST and ($_POST['unidade'] == "MS")) { 
															echo "selected='selected'"; 
														} 
													?>>Mato Grosso do Sul</option>
													<option value="MT"<?php 
														if($_POST and ($_POST['unidade'] == "MT")) { 
															echo "selected='selected'"; 
														} 
													?>>Mato Grosso</option>
													<option value="MG"<?php 
														if($_POST and ($_POST['unidade'] == "MG")) { 
															echo "selected='selected'"; 
														} 
													?>>Minas Gerais</option>
													<option value="PA"<?php 
														if($_POST and ($_POST['unidade'] == "PA")) { 
															echo "selected='selected'"; 
														} 
													?>>Pará</option>
													<option value="PB"<?php 
														if($_POST and ($_POST['unidade'] == "PB")) { 
															echo "selected='selected'"; 
														} 
													?>>Paraíba</option>
													<option value="PR"<?php 
														if($_POST and ($_POST['unidade'] == "PR")) { 
															echo "selected='selected'"; 
														} 
													?>>Paraná</option>
													<option value="PE"<?php 
														if($_POST and ($_POST['unidade'] == "PE")) { 
															echo "selected='selected'"; 
														} 
													?>>Pernambuco</option>
													<option value="PI"<?php 
														if($_POST and ($_POST['unidade'] == "PI")) { 
															echo "selected='selected'"; 
														} 
													?>>Piauí</option>
													<option value="RJ"<?php 
														if($_POST and ($_POST['unidade'] == "RJ")) { 
															echo "selected='selected'"; 
														} 
													?>>Rio de Janeiro</option>
													<option value="RN"<?php 
														if($_POST and ($_POST['unidade'] == "RN")) { 
															echo "selected='selected'"; 
														} 
													?>>Rio Grande do Norte</option>
													<option value="RS"<?php 
														if($_POST and ($_POST['unidade'] == "RS")) { 
															echo "selected='selected'"; 
														} 
													?>>Rio Grande do Sul</option>
													<option value="RO"<?php 
														if($_POST and ($_POST['unidade'] == "RO")) { 
															echo "selected='selected'"; 
														} 
													?>>Rondônia</option>
													<option value="RR"<?php 
														if($_POST and ($_POST['unidade'] == "RR")) { 
															echo "selected='selected'"; 
														} 
													?>>Roraima</option>
													<option value="SC"<?php 
														if($_POST and ($_POST['unidade'] == "SC")) { 
															echo "selected='selected'"; 
														} 
													?>>Santa Catarina</option>
													<option value="SP"<?php 
														if($_POST and ($_POST['unidade'] == "SP")) { 
															echo "selected='selected'"; 
														} 
													?>>São Paulo</option>
													<option value="SE"<?php 
														if($_POST and ($_POST['unidade'] == "SE")) { 
															echo "selected='selected'"; 
														} 
													?>>Sergipe</option>
													<option value="TO"<?php 
														if($_POST and ($_POST['unidade'] == "TO")) { 
															echo "selected='selected'"; 
														} 
													?>>Tocantins</option>												
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