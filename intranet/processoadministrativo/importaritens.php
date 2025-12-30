<?php 
	session_start();
		if (isset($_GET['id'])) {									
			$id_lic = $_GET['id'];
			$_SESSION ['npregao'] = $_GET['npregao'];
			$_SESSION ['valor']= $id_lic;
			
		}	
		$npregao=$_SESSION ['npregao']; 			
?>
<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos :: Importar Itens</title>		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">
		<script src="../js/bootstrap.min.js"></script>
	</head>
	<body>					
				<?php include("cabecalho.php"); ?>

				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
	            	<h1 class="h2">Importar itens da Licitação Nº <?php echo $npregao ?> </h1>	            
	            	<div class="btn-toolbar mb-2 mb-md-0">
			            <div class="btn-group mr-2">		              
			            	<a class="btn btn-primary" href="index.php" role="button">Voltar</a> 
			                          
			             </div>     	
	                </div> 
				</div>          		
				<div class="col-md-6">	
				<?php	
					if(isset($_SESSION['msg'])) {
							$msg2= $_SESSION['msg2'];	
													
							$msg4= $_SESSION['msg4'];
						unset($_SESSION['msg']);
						unset($_SESSION['msg2']);										
						unset($_SESSION['msg4']);
				?>
						<div class="alert alert-warning">
							<span class="glyphicon glyphicon-ok"></span> 
								Aviso!<br>									
									<?php echo $msg2 ?> Novo(s) Produto(s) cadastrado(s). <br>
									<?php echo $msg4 ?> Linha(s) Importada(s).<br>	
									

						</div>
					<?php
				
					}
					
					if(isset($_SESSION['msg3'])) {	
						$msg3= $_SESSION['msg3'];	
						unset($_SESSION['msg3']);	
						?>
						<div class="alert alert-danger">
							<span class="glyphicon glyphicon-ok"></span> 
																
								
									Erro(s) na importação do(s) item(s)  <?php echo $msg3 ?>
									

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