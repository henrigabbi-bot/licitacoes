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

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
		
	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

	        <div class="d-flex justify-content-between align-items-center flex-wrap pt-3 pb-2 mb-3 border-bottom">

    			<!-- Título e descrição -->
				<div>
					<h3 class="mb-1">
						<i class="fa fa-file-alt me-2"></i> Cadastro de Licitação
					</h3>
					<p class="text-muted mb-0">
						Preencha os dados abaixo para cadastrar uma nova licitação.
					</p>
				</div>

				<!-- Ações -->
				<div class="btn-group">
					<a href="index.php" class="btn btn-primary">
						<i class="fa fa-arrow-left me-1"></i> Voltar
					</a>
				</div>

				</div>

			<div class="col-md-12">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							$codlic= $_POST['codlic'];
							$npregao=$_POST['npregao'];
							$nprocesso=$_POST['nprocesso'];
							$objeto= $_POST['objeto'];							
							$datahomologacao= $_POST['datahomologacao'];	
							$cpf= $_POST['cpf'];	
							$cpf2= $_POST['cpf2'];					
							
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
					$sql = "INSERT INTO licitacao(codlic,npregao,nprocesso,objeto,datahomologacao,cpf,cpf2)VALUES('$codlic','$npregao','$nprocesso','$objeto','$datahomologacao','$cpf','$cpf2');";	


													
											
							if(mysql_query($sql)) {
								// Mensagem de sucesso
								$msg = 1;
								// Limpa os valores armazenados
								unset($_POST);
							} elseif(isset($_POST['cpf']) and isset($_POST["cpf2"])) {
								// Mensagem de erro
								$msg = 3;
								echo $sql;
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
								<label for="codlic">Código Interno da Licitação</label>
								<input type="text" name="codlic" id="codlic" maxlength="4" class="form-control"  required value="<?php if(isset($_POST['codlic'])) { echo $_POST['codlic']; } ?>">
							</div>
								<div class="form-group">
								<label for="npregao">Número de Pregão</label>
								<input type="text" name="npregao" id="npregao" maxlength="60" class="form-control"  required value="<?php if(isset($_POST['npregao'])) { echo $_POST['npregao']; } ?>">
							</div>
							<div class="form-group">
								<label for="nprocesso">Número do Processo</label>
								<input type="text" name="nprocesso" id="nprocesso" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nprocesso'])) { echo $_POST['nprocesso']; } ?>">

							</div>
						

						   <div class="form-group">
							<label for="objeto">Objeto</label>	
								<textarea name="objeto" id="objeto" class="form-control" rows="4" required><?php
								if (isset($_POST['objeto'])) {
									echo trim($_POST['objeto']);
								}
							?></textarea>
							</div>


							
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="datahomologacao">Data da Homologação</label>
								<input type="date" name="datahomologacao" id="datahomologacao" maxlength="10" class="form-control" required value="<?php if(isset($_POST['datahomologacao'])) {echo $_POST['datahomologacao']; } ?>">												
							</div>
							<div class="form-group">
							<label for="cpf">Autoridade Competente</label>	
						<select id="cpf" name="cpf" class="form-control">							
							<option>Selecione...</option>
							<?php
								include("../conexao.php");
								$sql_cli = "SELECT * FROM pessoas where tipo='ordenador' ";

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
						<div class="form-group">
						<label for="cpf2">Assessor Jurídico</label>	
						<select id="cpf2" name="cpf2" class="form-control">							
							<option>Selecione...</option>
							<?php
								include("../conexao.php");
								$sql_cli = "SELECT * FROM pessoas where tipo='jurídico' ";

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
							

										<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar Licitação</button>

						</form>					
				</div>
		</main>		
	</body>
</html>