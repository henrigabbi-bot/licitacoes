<?php 
	session_start();
		if (isset($_GET['id'])) {									
			$id_lic = $_GET['id'];
			$_SESSION ['valor']= $id_lic;
		}				
?>
<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos :: Importar </title>		
		<link rel="stylesheet" type="text/css" href="../../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../../css/dashboard.css">
		<script src="../../js/bootstrap.min.js"></script>
	</head>
	<body>	
		
				
				<?php include("cabecalho.php"); ?>

				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	            	<h1 class="h2">Importar Previsão de Consumo</h1>	            
		            <div class="btn-group mr-2">		              
				        <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>
				    </div>        
				</div>				        		
				<div class="col-md-6">
				<?php	
					if(isset($_SESSION['msg']) and isset($_SESSION['cont'])) {
						$cont=$_SESSION['cont'];
						unset($_SESSION['msg']);
						unset($_SESSION['cont']);
				?>
						<div class="alert alert-success">
							<span class="glyphicon glyphicon-ok"></span> 
								Operação realizada com sucesso! <?php echo $cont ?> Inserções. 
						</div>
				<?php
				
					}
				?>			
				<form method="post" action="processo.php" enctype="multipart/form-data">
					<div class="form-group">
						<h5> Selecione um arquivo para importação</h5>					
						<input type="file" name="arquivo" id="arquivo" maxlength="25" class="form-control" >
					</div>													
					<input class="btn btn-success" type="submit" value="Importar">
				</form>				
			</div>
		</main>			
	</body>
</html>