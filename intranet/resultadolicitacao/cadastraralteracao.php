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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
		
	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			if (isset($_GET['id'])) {
				$id_lic = $_GET['id'];
			}
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		        <h1 class="h2">Cadastro de Alterações do Processo</h1>	            
		            <div class="btn-toolbar mb-2 mb-md-0">
			            <div class="btn-group mr-2">		              
			            	<a class="btn btn-primary" href="index.php" role="button">Voltar</a> 
			                          
			             </div>     	
	                </div>  
			</div>          		
			<div class="col-md-5">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							$codprod	= $_POST['codprod'];
							$justifivativa	= $_POST['justifivativa'];
							$tipo=$_POST['tipo'];

							
							// Carrega o arquivo
							include("../conexao.php");

							// Executa a SQL
							$sql = "INSERT INTO alteracoeslicitacao
									(codprod,justifivativa)
									VALUES
									('$codprod','$justifivativa',,'$tipo','$id_lic');";
							
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
							<label for="codprod">Selecione o Medicamento</label>	
							<select id="codprod" name="codprod" class="form-control">							
								<option>Selecione...</option>
								<?php
									include("../conexao.php");
									$sql_cli = "SELECT produto.codprod,produto.descricao FROM produto";
									echo $sql_cli;
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
								<label for="justifivativa">Justificativa</label>
								<input type="text" name="justifivativa" id="justifivativa" maxlength="60" class="form-control" required value="<?php if(isset($_POST['justifivativa'])) { echo $_POST['justifivativa']; } ?>">
							</div>

							
									<div class="form-group">
										<label for="tipo">Tipo</label>
											<select name="tipo" id="tipo" class="form-control">
												
												<option value="Cancelamento de Item"<?php 
														if($_POST and ($_POST['tipo'] == "Cancelamento de Item")) { 
															echo "selected='selected'"; 
														} 
													?>>Cancelamento de Item</option>
												
	
											
												<option value="Realinhamento de Preços"<?php 
														if($_POST and ($_POST['tipo'] == "Realinhamento de Preços")) { 
															echo "selected='selected'"; 
														} 
													?>>Realinhamento de Preços</option>	


											</select>
									</div>
																	
							<input class="btn btn-success" type="submit">
						</form>					
					</div>
		
		
		

		 <h2>Alterações Cadastradas</h2> 
       
       <table class="table table-striped table-sm">                  
                <thead align="center">
                    <tr>                    
                      <th>Cód. Licitação</th>
                      <th>Descrição</th>
                      <th>Data Homologação</th>
                      <th>Ações</th>
                    </tr>
                </thead>                  
                  <tbody align="center">
                    <?php
                    // Inclui o arquivo
                    
                      // Consulta SQL
                      $sql = "SELECT * FROM alteracoeslicitacao where idlic='$id_lic';";
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr>                                              
                          <td><?php echo $row['codlic']; ?></td>
                          <td><?php echo $row['justificativa']; ?></td>
                          <td><?php echo $row['tipo']; ?></td>
                          <td>
                             
                             <a title="Visualizar Consumo" class="btn btn-success" style="font-size:10px;"
                             href="relatorios/listarprodutoxconsumoxempresa.php?id=<?php echo $row['codlic'];?>">
                                <span class="fas fa-search"></span>
                              </a> 
                            
                              
                                
                              </a>                          
                          </td>
                        </tr>                         

                      <?php
                    }
                    ?>
                  </tbody>
            </table>
						
			</main>		
	</body>
</html>