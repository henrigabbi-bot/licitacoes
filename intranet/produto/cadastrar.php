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
		        <h1 class="h2">Cadastro de Produtos</h1>	            
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
							$descricao	= $_POST['descricao'];
							$unidade	= $_POST['unidade'];							
							
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO produto
									(codprod,descricao,unidade)
									VALUES
									('$codprod','$descricao','$unidade');";
							
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
								<label for="codprod">Código Externo</label>
								<input type="text" name="codprod" id="codprod" maxlength="60" class="form-control"  required value="<?php if(isset($_POST['codprod'])) { echo $_POST['codprod']; } ?>">
							</div>
							<div class="form-group">
								<label for="descricao">Descrição</label>
								<input type="text" name="descricao" id="descricao" maxlength="60" class="form-control" required value="<?php if(isset($_POST['descricao'])) { echo $_POST['descricao']; } ?>">
							</div>
							<div class="form-group">
												<label for="unidade">Unidade</label>
												<select name="unidade" id="unidade" class="form-control">
													
													
													<option value="Ampola"<?php 
														if($_POST and ($_POST['unidade'] == "Ampola")) { 
															echo "selected='selected'"; 
														} 
													?>>Ampola</option>
												
													<option value="Bisnaga"<?php 
														if($_POST and ($_POST['unidade'] == "Bisnaga")) { 
															echo "selected='selected'"; 
														} 
													?>>Bisnaga</option>
													<option value="Caixa"<?php 
														if($_POST and ($_POST['unidade'] == "Caixa")) { 
															echo "selected='selected'"; 
														} 
													?>>Caixa</option>
													<option value="Cápsula"<?php 
														if($_POST and ($_POST['unidade'] == "Cápsula")) { 
															echo "selected='selected'"; 
														} 
													?>>Cápsula</option>
													<option value="Comprimido"<?php 
														if($_POST and ($_POST['unidade'] == "Comprimido")) { 
															echo "selected='selected'"; 
														} 
													?>>Comprimido</option>
													<option value="Envelope"<?php 
														if($_POST and ($_POST['unidade'] == "Envelope")) { 
															echo "selected='selected'"; 
														} 
													?>>Envelope</option>
														<option value="Frasco"<?php 
														if($_POST and ($_POST['unidade'] == "Frasco")) { 
															echo "selected='selected'"; 
														} 
													?>>Frasco</option>
													<option value="Unidade"<?php 
														if($_POST and ($_POST['unidade'] == "Unidade")) { 
															echo "selected='selected'"; 
														} 
													?>>Unidade</option>
													<option value="Lata"<?php 
														if($_POST and ($_POST['unidade'] == "Lata")) { 
															echo "selected='selected'"; 
														} 
													?>>Lata</option>
																								
												</select>
									</div>	
																
							<input class="btn btn-success" type="submit">
						</form>					
					</div>
		
		
		</main>	
						
				
	</body>
</html>