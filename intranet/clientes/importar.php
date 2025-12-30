<?php 
	session_start();
	if (isset($_GET['codlic']) ) {  
		$_SESSION['codlic']=$_GET['codlic'];
		$_SESSION['npedido']=$_GET['npedido'];
	}				

?>

<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos :: Importar </title>		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">
		<script src="../../js/bootstrap.min.js"></script>
	</head>
	<body>	
		
				
				<?php include("cabecalho.php"); ?>

				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	            	<h1 class="h2">Importar Municípios</h1>	            
		            <div class="btn-group mr-2">		              
				        <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>
				    </div>        
				</div>	
				<?php	
					if(isset($_SESSION['msg'])) {
						$msg=$_SESSION['msg'];
						unset($_SESSION['msg']);
				?>
						<div class="alert alert-success">
							<span class="glyphicon glyphicon-ok"></span> 
								Operação realizada com sucesso! </br>
								<?php echo $msg ?> Linhas(s) importada(s).
						</div>
				<?php
				
					}
				?>			
				<div class="row">		        		
				

				
				<div class="col-md-5">		
				<form method="post" action="processoexcel.php" enctype="multipart/form-data">
					<div class="form-group">
						<h5> Selecione um arquivo para importação (.xls). </h5>					
						<input type="file" name="arquivo" id="arquivo" maxlength="25" class="form-control" >
					</div>
																	
					<input class="btn btn-success" type="submit" value="Importar">
					<div class="form-group">
						<h7>Obs: O arquivo do excel tem que ser salvo no tipo "Planilha XML 2003".</h7>
					</div>
				</form>	
				</div>				
			</div>
		</main>			
	</body>
</html>