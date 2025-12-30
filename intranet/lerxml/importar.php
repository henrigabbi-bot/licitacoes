<?php 
	session_start();
	if(isset($_GET['id'])) {			
		$_SESSION['codlic'] =$_GET['id'];
		$_SESSION['npedido'] =$_GET['npedido'];
		$_SESSION['npregao'] =$_GET['npregao'];
	}	

	$npregao=$_SESSION['npregao'];
	$npedido=$_SESSION['npedido'];

?>
<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos :: Importar </title>		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">
		<script src="../js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		       	<h1 class="h2">Importar Notas Fiscais de Saída - Pregão <?php echo $npregao?> - Pedido <?php echo $npedido ?></h1>	 
		          	<div class="btn-toolbar mb-2 mb-md-0">
				        <div class="btn-group mr-2">		              
				           <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
				       </div> 
				    </div> 
			</div>				        		
			<div class="col-md-6">
				<?php
				if(isset($_SESSION['aux'])) {
					$msg= $_SESSION['msg'];						
					$msg2= $_SESSION['msg2'];
					$msg3= $_SESSION['msg3'];
					?>	<div class="alert alert-warning">
							<span class="glyphicon glyphicon-remove"></span> 
								Aviso!<br>
								<?php echo $msg2 ?> NF(s) de Devolução.<br>
								<?php echo $msg3 ?> Arquivo(s) já importado(s). <br>
								<?php echo $msg ?> Arquivo(s) importado(s).
						</div>
					<?php
						unset($_SESSION['aux']);
						unset($_SESSION['msg']);
						unset($_SESSION['msg2']);
						unset($_SESSION['msg3']);		
				}				

				?>		
								
				<form method="post" action="processo.php" enctype="multipart/form-data">
					<div class="form-group">
						<h5> Selecione os XMLs para importação</h5>					
						<input type="file" name="arquivo[]" id="arquivo" maxlength="25" multiple="multiple"class="form-control">						
					</div>																
					<input class="btn btn-success" type="submit" value="Importar">
				</form>
									
			</div>
		</main>		
	</body>
</html>