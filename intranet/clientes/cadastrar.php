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
		        <h1 class="h2">Cadastrar Cliente</h1>	            
		         <div class="btn-group mr-2">		              
			            	<a class="btn btn-primary" href="index.php" role="button">Voltar</a> 
			                          
			             </div>      
			</div>          		
			<div class="col-md-5">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							$id= $_POST['id'];
							$cnpj= $_POST['cnpj'];
							$nomecliente= $_POST['nomecliente'];
							$nomeprefeito=$_POST['nomeprefeito'];
							$cpf= $_POST['cpf'];
						
						
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO cliente
									(id,cnpj,nomecliente,nomeprefeito,cpf)
									VALUES
									('$id','$cnpj','$nomecliente','$nomeprefeito','$cpf');";
								
								
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
								<label for="id">ID</label>
								<input type="text" name="id" id="id" maxlength="4" class="form-control"  required value="<?php if(isset($_POST['id'])) { echo $_POST['id']; } ?>">
							</div>
							<div class="form-group">
								<label for="cnpj">CNPJ</label>
								<input type="text" name="cnpj" id="cnpj" placeholder="00.000.000/0000-00" maxlength="14" class="form-control"  required value="<?php if(isset($_POST['cnpj'])) { echo $_POST['cnpj']; } ?>">
							</div>
							<div class="form-group">
								<label for="nomecliente">Nome</label>
								<input type="text" name="nomecliente" id="nomecliente" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nomecliente'])) { echo $_POST['nomecliente']; } ?>">
							</div>

							<div class="form-group">
								<label for="nomeprefeito">Nome Prefeito</label>
								<input type="text" name="nomeprefeito" id="nomeprefeito" maxlength="60" class="form-control" required value="<?php if(isset($_POST['nomeprefeito'])) { echo $_POST['nomeprefeito']; } ?>">
							</div>

							 <div class="form-group ">
                                <label for="cpf">CPF</label>
                                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Somente número do CPF" maxlength="14" oninput="maskCPF(this)"  value="<?php if(isset($_POST['cpf'])) { echo $_POST['cpf']; } ?>">
                            	</div>
								
												
							<input class="btn btn-success" type="submit">
						</form>					
					</div>
		
          
         

		
		</main>	
						
		<script src="../../js/custom.js"></script>	
	</body>
</html>