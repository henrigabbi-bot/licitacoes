<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos :: Importar </title>		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">
		
	</head>
	<body>	
		
				
				<?php include("cabecalho.php"); ?>

				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	            	<h1 class="h2">Processar Pedido de Compra</h1>	            
		            <div class="btn-group mr-2">		              
				        <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
				    </div>        
				</div>				        		
				<div class="col-md-6">
				<?php	
					if(isset($_SESSION['msg'])) {
						$msg=$_SESSION['msg'];
						unset($_SESSION['msg']);
				?>
						<div class="alert alert-success">
							<span class="glyphicon glyphicon-ok"></span> 
								Operação realizada com sucesso! </br>
								<?php echo $msg ?> Arquivo(s) importado(s).
						</div>
				<?php
				
					}
				?>			
				<form method="post" action="processo.php" enctype="multipart/form-data">
					<div class="form-group">
						<h5> Selecione o pedido para processamento</h5>					
						<input type="file" name="arquivo" id="arquivo" maxlength="25" class="form-control" >
					</div>
																	
					<input class="btn btn-success" type="submit" value="Importar">
				</form>				
			</div>
		</main>			
	</body>
</html>