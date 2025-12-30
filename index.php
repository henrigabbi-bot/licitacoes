<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		
		
		<script src="js/jquery-1.11.3.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<style>
			body {

			  background-image: url('img/fundo.jpg');
			  
			}
			</style>
	</head>
	<body>
		


		
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
			if(isset($_SESSION['login'])) {
				// Redireciona o usuário
				header("Location: intranet/index.php");
			// Se o usuário não está logado
			} else {
				?>
				<!-- LOGIN -->

				
				<div class="container" style="margin-top:50px">
					<div class="col-md-12 text-center">
						<div class="row justify-content-md-center">
							<div class="col-md-12 ">
								<img src="img/logocisa.png">
								<h3 style="color:white;padding-top: 50px;">Login</h3>
							</div>
							<div class="col-md-4">
								
								
								<?php
								// Havendo erro
								if(isset($_GET['erro'])) {
									// Se o erro for 1
									if($_GET['erro']==1) {
										?>
										<div class="col-md-12 alert alert-danger">
											<span class="glyphicon glyphicon-remove"></span> Email e/ou senha incorreto(s)!
										</div>
										<?php
									}
								}
								?>
								
								<!-- FORMULARIO -->	
								<form method="post" action="intranet/login_confirma.php">
									<div class="form-group">
										<input type="email" name="email" placeholder="Email" class="form-control">
									</div>
									<div class="form-group">
										<input type="password" name="senha" placeholder="Senha" class="form-control">
									</div>
									
									<input type="submit" value="Entrar" class="btn btn-success">
									
								</form>
							
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		?>
	</body>
</html>