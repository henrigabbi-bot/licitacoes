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
		    	<h1 class="h2">Editar Pessoa</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
			    </div>    
			</div>  
			 	<div class="col-md-12">
						<?php
						// Carrega o arquivo
						include("../conexao.php");
						// Verifica a URL por valor em ID
						if($_GET['cpf']) {
							// Atribui à variável o valor armazenado na URL
							$id_cli = $_GET['cpf'];
							// Cláusula SQL
							$sql_cli = "SELECT * FROM pessoas
										WHERE cpf = '$id_cli';";
									
							// Executa SQL
							$query_cli = mysql_query($sql_cli);
							// Se encontrar um registro (e somente um)
							if(mysql_num_rows($query_cli) == 1) {
								// Recupera os dados do banco
								$row_cli = mysql_fetch_array($query_cli);
								// Verifica se o formulário foi enviado
								if($_POST) {
									// Atribui às variáveis os valores preenchidos
									$nome= mb_strtoupper($_POST['nome']);							
									$rg	= $_POST['rg'];	
									$tipo=mb_strtoupper($_POST['tipo']);
									
									
									// Executa a SQL
									$sql = "UPDATE pessoas SET
											
											nome='$nome',
											rg ='$rg',
											tipo='$tipo'
											
											
											WHERE cpf='$id_cli';";
										
									if(mysql_query($sql)) {
										// Mensagem de sucesso
										$msg = 1;
										unset($_POST);
										$sql_cli = "SELECT * FROM pessoas
										WHERE cpf = '$id_cli';";	
										$query_cli = mysql_query($sql_cli);
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
															O usuário <b><?PHP echo $nome ?> </b> foi alterado com sucesso!
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
											
					<form method="post" action="editar.php?cpf=<?php echo $id_cli; ?>">
							<div class="row">
								<div class="col-md-6">												
									<div class="form-group">
										<label for="nome">Nome</label>
										<input type="text" name="nome" id="nome" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nome'])) { echo $_POST['nome']; } else { echo $row_cli['nome']; } ?>">
									</div>
									<div class="form-group">
										<label for="rg">RG</label>
										<input type="rg" name="rg" id="rg" maxlength="10" class="form-control"  value="<?php if(isset($_POST['rg'])) { echo $_POST['rg']; } else { echo $row_cli['rg']; } ?>">
									</div>		
									<div class="form-group">
										<label for="tipo">Tipo</label>
										<select name="tipo" id="tipo" class="form-control">
											<option value="Ordenador" 
												<?php 
													// Se não submetido e valor no banco igual a Cachorro
													if(!$_POST and ($row_cli['tipo']=="ORDENADOR")) { 
														echo "selected='selected'"; 
																// Se submetido e valor igual a Cachorro
													} elseif($_POST['tipo']=="ORDENADOR") {
														echo "selected='selected'"; 
													}
												?>>Ordenador</option>
											<option value="Representante"
												<?php 
													if(!$_POST and ($row_cli['tipo']=="REPRESENTANTE")) { 
														echo "selected='selected'"; 
													} elseif($_POST['tipo']=="REPRESENTANTE") {
														echo "selected='selected'"; 
													}
												?>>Representante</option>
											<option value="Juridico"
												<?php 
													if(!$_POST and ($row_cli['tipo']=="JURIDICO")) { 
														echo "selected='selected'"; 
													} elseif($_POST['tipo']=="JURIDICO") {
														echo "selected='selected'"; 
													}
												?>>Juridico</option>
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
						
							//header("Location: ../404.php");
							echo "erro aqui";
							
						}
						?>
		</main>
				
	</body>
</html>