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
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
		
	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();

		     if (isset($_GET['codlic']) ) {             
		         $_SESSION['codlic']=$_GET['codlic']; 
		      
		     } 
		    
		    
        	$codlic=$_SESSION['codlic'];
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		        <h1 class="h2">Cadastrar Item no Processo</h1>	            
		    <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="listarlicitacoes.php" role="button">Voltar</a>
			    </div>        
			</div>          		
			<div class="col-md-5">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							$codprod=$_POST['codprod']; 
							$quantidade= $_POST['quantidade'];
							$vlrunitario= $_POST['vlrunitario'];				
							$vlrunitario = str_replace(',', '.', $vlrunitario);		
						
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO itensprocesso
									(codlic,codprod,quantidade,vlrunitario)
									VALUES
									('$codlic','$codprod',$quantidade,$vlrunitario);";	

								
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
													Ocorreu um erro ao realizar a operação! Pedido já cadastrado.
												</div>
												<?php
											}
										?>										
									
							
						<form method="post" action="cadastraritemlicitacao.php">
							<div class="col-md-8">

							<div class="form-group">
							<label for="codprod">Selecione o Medicamento</label>	
							
							<select name="codprod" id="codprod" class="selectpicker" data-live-search="true">
													
								<option data-tokens>Selecione...</option>
								<?php
									include("../conexao.php");								
									$sql_cli = "SELECT produto.codprod,produto.descricao FROM produto
									LEFT JOIN itensprocesso on produto.codprod=itensprocesso.codprod and itensprocesso.codlic='$codlic'
									WHERE itensprocesso.codprod is null";															
									$query_cli = mysql_query($sql_cli);
									if(mysql_num_rows($query_cli)>0) {
										while($row_cli = mysql_fetch_array($query_cli)) {
											?>
											<option value="<?php echo $row_cli['codprod'];?>">
											<?PHP echo $row_cli['codprod'];?> - <?php echo $row_cli['descricao'];?>
											</option>
									<?php
									}
											}
									?>
							</select>										              
							</div>											
							<div class="form-group">
								<label for="quantidade">Quantidade</label>
								<input type="text" oninput="maskQtd(this) "name="quantidade" id="quantidade" maxlength="60" class="form-control" required value="<?php if(isset($_POST['quantidade'])) {echo $_POST['quantidade']; } ?>">
												
							</div>
							<div class="form-group">
								<label for="vlrunitario">Vlr. Unitário</label>
								<input type="text" name="vlrunitario" id="vlrunitario" maxlength="60" class="form-control" required value="<?php if(isset($_POST['vlrunitario'])) {echo $_POST['vlrunitario']; } ?>">
												
							</div>
						</div>
												
							<input class="btn btn-success" type="submit">
						</form>					
					</div>
		</main>
		 <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>	
		 <script src="../../js/custom2.js"></script>
		
	</body>
</html>