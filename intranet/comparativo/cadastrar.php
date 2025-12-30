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
		        <h1 class="h2">Cadastrar Licitação</h1>	            
		    <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="listarlicitacoes.php" role="button">Voltar</a>
			    </div>        
			</div>          		
			<div class="col-md-12">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos						
							$npregao=$_POST['npregao'];
							$nprocesso=$_POST['nprocesso'];
							$linkprocesso=$_POST['linkprocesso'];
							$municipio= $_POST['municipio'];
							$datapublicacao= $_POST['datapublicacao'];		
							$dataabertura= $_POST['dataabertura'];											
							$datahomologacao= $_POST['datahomologacao'];	
							$ativo= $_POST['ativo'];
										
							
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
					$sql = "INSERT INTO comparativo(npregao,nprocesso,linkprocesso,municipio,datapublicacao,dataabertura,datahomologacao,ativo) VALUES('$npregao','$nprocesso','$linkprocesso','$municipio','$datapublicacao','$dataabertura','$datahomologacao','$ativo');";	
						
							
											
							if(mysql_query($sql)) {
								// Mensagem de sucesso
								$msg = 1;
								// Limpa os valores armazenados
								unset($_POST);
							} elseif(isset($_POST['cpf']) and isset($_POST["cpf2"])) {
								// Mensagem de erro
								$msg = 3;
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
											}elseif(isset($msg) and ($msg==3)) {
												?>
												<div class="alert alert-danger">
													<span class="glyphicon glyphicon-remove"></span> 
													Favor cadastrar todos os campos!
												</div>
												<?php
											}
												
										?>										
									
								
						<form method="post" action="cadastrar.php">
						<div class="row">
						<div class="col-md-5">							
							<div class="form-group">
								<label for="npregao">Número de Pregão</label>
								<input type="text" name="npregao" id="npregao" maxlength="60" class="form-control"  required value="<?php if(isset($_POST['npregao'])) { echo $_POST['npregao']; } ?>">
							</div>
							<div class="form-group">
								<label for="nprocesso">Modalidade</label>
								<input type="text" name="nprocesso" id="nprocesso" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nprocesso'])) { echo $_POST['nprocesso']; } ?>">
							</div>
							<div class="form-group">
								<label for="linkprocesso">Link do Processo</label>
								<input type="url" name="linkprocesso" id="linkprocesso" maxlength="250" class="form-control"  required value="<?php if(isset($_POST['linkprocesso'])) { echo $_POST['linkprocesso']; } ?>">
							</div>
								<div class="form-group">
								<label for="municipio">Município</label>
								<input type="text" name="municipio" id="municipio" maxlength="60" class="form-control"  required value="<?php if(isset($_POST['municipio'])) { echo $_POST['municipio']; } ?>">
							</div>
							

							
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="datapublicacao">Data de Publicação</label>
								<input type="date" name="datapublicacao" id="datapublicacao" maxlength="8" class="form-control" required value="<?php if(isset($_POST['datapublicacao'])) {echo $_POST['datapublicacao']; } ?>">												
							</div>
							<div class="form-group">
								<label for="dataabertura">Data de Abertura</label>
								<input type="date" name="dataabertura" id="dataabertura" maxlength="8" class="form-control" required value="<?php if(isset($_POST['dataabertura'])) {echo $_POST['dataabertura']; } ?>">												
							</div>
							<div class="form-group">
								<label for="datahomologacao">Data de Homologação</label>
								<input type="date" name="datahomologacao" id="datahomologacao" maxlength="8" class="form-control" required value="<?php if(isset($_POST['datahomologacao'])) {echo $_POST['datahomologacao']; } ?>">												
							</div>
							<div class="form-group">
								<label for="ativo">Ativo</label>
								<select name="ativo" id="ativo" class="form-control">
												<option value="SIM"<?php 
														if($_POST and ($_POST['ativo'] == "SIM")) { 
															echo "selected='selected'"; 
														} 
													?>>SIM</option>
												<option value="NÃO"<?php 
														if($_POST and ($_POST['ativo'] == "NÃO")) { 
															echo "selected='selected'"; 
														} 
													?>>NÃO</option>
												
	
									</option>												
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