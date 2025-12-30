<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">		
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/jquery-1.11.3.min.js"></script>
    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" crossorigin="anonymous">
	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
		include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		        <h1 class="h2">Cadastrar Motorista</h1>	            
		         <div class="btn-group mr-2">		              
			            	<a class="btn btn-primary" href="index.php" role="button">Voltar</a> 
			                          
			             </div>      
			</div>          		
			<div class="col-md-12">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							
							$nome=mb_strtoupper($_POST['nome']);											
							$cpf=$_POST['cpf'];
							$rg=$_POST['rg'];				
							$cnpj=$_POST['cnpj'];
						
							
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO motorista
									(nome,cpf,rg,cnpj)
									VALUES
									('$nome','$cpf','$rg','$cnpj');";
							echo $sql;
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
										<label for="nome">Nome Completo</label>
										<input type="text" name="nome" id="nome" maxlength="60" class="form-control"  required value="<?php if(isset($_POST['nome'])) { echo $_POST['nome']; } ?>">
									</div>

									   <div class="form-group ">
                                <label for="cpf">CPF</label>
                                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="Somente número do CPF" maxlength="14" oninput="maskCPF(this)" required value="<?php if(isset($_POST['cpf'])) { echo $_POST['cpf']; } ?>">
                            	</div>
								
									<div class="form-group">
										<label for="rg">RG </label>
										<input type="text" name="rg" id="rg" maxlength="15" class="form-control"  value="<?php if(isset($_POST['rg'])) { echo $_POST['rg']; } ?>">
									</div>
								</div>
								<div class="col-md-5">		
												
									<div class="form-group">

								<label for="cnpj">Município</label>	
									<select id="cnpj" name="cnpj" class="form-control">							
										<option>Selecione...</option>
										<?php
											include("../conexao.php");
											$sql_cli = "SELECT * FROM cliente ORDER BY nomecliente";

											$query_cli = mysql_query($sql_cli);
											if(mysql_num_rows($query_cli)>0) {
												while($row_cli = mysql_fetch_array($query_cli)) {
													?>
													<option value="<?php echo $row_cli['cnpj'];?>">
													<?php echo $row_cli['nomecliente'];?>
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
			 <script src="../../js/custom.js"></script>
				
	</body>
</html>