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

		     if (isset($_GET['cnpj']) ) {             
		         $_SESSION['cnpj']=$_GET['cnpj']; 
		      
		     } 
		    
		    $cnpj=$_SESSION['cnpj'];
			$id_ped =$_SESSION ['npedido'];
        	$id_lic=$_SESSION['idlic'];
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		        <h1 class="h2">Cadastrar Item no Pedido</h1>	            
		    <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="listarpedidodocliente.php?cnpj=<?php echo $cnpj;?>" role="button">Voltar</a>
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
												
						
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO pedidodecompra
									(idlic,pedido,cnpj,codprod,quantidade,vlrunitario)
									VALUES
									('$id_lic','$id_ped','$cnpj','$codprod',$quantidade,$vlrunitario);";	

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
													Ocorreu um erro ao realizar a operação! Pedido já cadastrado.
												</div>
												<?php
											}
										?>										
									
							
						<form method="post" action="cadastraritemdocliente.php">
						<div class="form-group">
							<label for="codprod">Selecione o Medicamento</label>	
							<select id="codprod" name="codprod" class="form-control">							
								<option>Selecione...</option>
								<?php
									include("../conexao.php");

								
									$sql_cli = "SELECT produto.codprod,produto.descricao FROM produto
									LEFT JOIN pedidodecompra on produto.codprod=pedidodecompra.codprod and pedidodecompra.idlic='$id_lic'and pedidodecompra.cnpj='$cnpj' 
									WHERE pedidodecompra.codprod is null";
								
															
									//$sql_cli = "SELECT previsaodeconsumo.codprod,produto.descricao FROM previsaodeconsumo INNER JOIN produto on previsaodeconsumo.codprod=produto.codprod LEFT JOIN pedidodecompra on previsaodeconsumo.codprod=pedidodecompra.codprod AND pedidodecompra.cnpj='$cnpj'AND pedidodecompra.idlic='$id_lic'AND pedidodecompra.pedido='$id_ped' WHERE previsaodeconsumo.cnpj='$cnpj' AND previsaodeconsumo.idlic='$id_lic'AND pedidodecompra.codprod IS NULL ORDER BY previsaodeconsumo.codprod";
									
									
									
								
									
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
								<input type="text" name="quantidade" id="quantidade" maxlength="60" class="form-control" required value="<?php if(isset($_POST['quantidade'])) {echo $_POST['quantidade']; } ?>">
												
							</div>
							<div class="form-group">
								<label for="vlrunitario">Vlr. Unitário</label>
								<input type="text" name="vlrunitario" id="vlrunitario" maxlength="60" class="form-control" required value="<?php if(isset($_POST['vlrunitario'])) {echo $_POST['vlrunitario']; } ?>">
												
							</div>
												
							<input class="btn btn-success" type="submit">
						</form>					
					</div>
		</main>		
	</body>
</html>