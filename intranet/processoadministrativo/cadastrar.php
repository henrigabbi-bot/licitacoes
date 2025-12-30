<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Processos Administrativos</title>
		
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
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		        <h1 class="h2">Processos Administrativos</h1>	            
		    <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
			    </div>        
			</div>          		
			<div class="col-md-12">
				<?php
						// Verifica se o formulário foi enviado
						if($_POST) {
							// Atribui às variáveis os valores preenchidos
							
							$modalidade=$_POST['modalidade'];
							$fundamentacaolegal=$_POST['fundamentacaolegal'];
							$objeto= $_POST['objeto'];	
							$nlicitacao=$_POST['nlicitacao'];
							$nprocesso=$_POST['nprocesso'];
							$dataprocesso= $_POST['dataprocesso'];	
							$anoprocesso=$_POST['anoprocesso'];	
							$anolicitacao=	$_POST['anolicitacao'];		
							$valorestimado=$_POST['valorestimado'];	
							
											
							
							// Carrega o arquivo
							include("../conexao.php");
							// Executa a SQL
							$sql = "INSERT INTO processoadministrativo(modalidade,fundamentacaolegal,objeto,nlicitacao,nprocesso,dataprocesso,anoprocesso,anolicitacao,valorestimado)
							VALUES('$modalidade','$fundamentacaolegal','$objeto','$nlicitacao','$nprocesso','$dataprocesso','$anoprocesso','$anolicitacao','$valorestimado');";	

							echo $sql;
						
								
											
							if(mysql_query($sql)) {
								// Mensagem de sucesso
								$msg = 1;
								// Limpa os valores armazenados
								unset($_POST);
							}  else {
								// Mensagem de erro
								$msg = 2;
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
											}elseif(isset($msg) and ($msg==3)) {
												?>
												<div class="alert alert-danger">
													<span class="glyphicon glyphicon-remove"></span> 
													Favor cadastrar todos os campos!
												</div>
												<?php
											}

						}
												
										?>										
									
								
						<form method="post" action="cadastrar.php">
						
						<div class="row">

							<div class="col-md-5">
								<div class="form-group">
											<label for="modalidade">Modalidade</label>
												<select name="modalidade" id="modalidade" class="form-control">
													<option value="Chamamento Público - Credenciamento"<?php 
															if($_POST and ($_POST['modalidade'] == "Chamamento Público - Credenciamento")) { 
																echo "selected='selected'"; 
															} 
														?>>Chamamento Público - Credenciamento</option>
													<option value="Pregão  Eletrônico"<?php 
															if($_POST and ($_POST['modalidade'] == "Pregão  Eletrônico")) { 
																echo "selected='selected'"; 
															} 
														?>>Pregão  Eletrônico</option>
													<option value="Processo de Dispensa"<?php 
															if($_POST and ($_POST['modalidade'] == "Processo de Dispensa")) { 
																echo "selected='selected'"; 
															} 
														?>>Processo de Dispensa</option>
		
													</option>	
													<option value="Processo de Inexigibilidade"<?php 
															if($_POST and ($_POST['modalidade'] == "Processo de Inexigibilidade")) { 
																echo "selected='selected'"; 
															} 
														?>>Processo de Inexigibilidade</option>
		
													</option>											
												</select>
								</div>	

								<div class="form-group">
								<label for="objeto">Descrição do Objeto</label>								
								<textarea type="text" name="objeto" id="objeto" class="form-control" rows="4" required value="<?php if(isset($_POST['objeto'])) { echo $_POST['objeto']; } ?>"><?php if(isset($_POST['objeto'])){echo $_POST['objeto'];}?>
								 </textarea>
								
							</div>	
								
							</div>	


							<div class="col-md-4">
								<div class="form-group">
									<label for="dataprocesso">Data do Processo</label>
									<input type="date" name="dataprocesso" id="dataprocesso" maxlength="10" class="form-control" required value="<?php if(isset($_POST['dataprocesso'])) {echo $_POST['dataprocesso']; } ?>">												
								</div>

								<div class="form-group">
											<label for="fundamentacaolegal">Fundamentação Legal</label>
												<select name="fundamentacaolegal" id="fundamentacaolegal" class="form-control">
													<option value="Art. 28, inc. I, da Lei nº 14.133/21"<?php 
															if($_POST and ($_POST['fundamentacaolegal'] == "Art. 28, inc. I, da Lei nº 14.133/21o")) { 
																echo "selected='selected'"; 
															} 
														?>>Art. 28, inc. I, da Lei nº 14.133/21</option>
													<option value="Art. 75, inc. II, da Lei nº 14.133/21"<?php 
															if($_POST and ($_POST['fundamentacaolegal'] == "Art. 75, inc. II, da Lei nº 14.133/21")) { 
																echo "selected='selected'"; 
															} 
														?>>Art. 75, inc. I, da Lei nº 14.133/21</option>
													<option value="Art. 75, inc. I, da Lei nº 14.133/21"<?php 
															if($_POST and ($_POST['fundamentacaolegal'] == "Art. 75, inc. I, da Lei nº 14.133/21")) { 
																echo "selected='selected'"; 
															} 
														?>>Art. 75, inc. I, da Lei nº 14.133/21</option>
		
													</option>	
																								
												</select>
								</div>
								<div class="form-group">
									<label for="valorestimado">Valor Estimado</label>
									<input type="text" name="valorestimado" id="valorestimado" maxlength="10" class="form-control" required value="<?php if(isset($_POST['valorestimado'])) {echo $_POST['valorestimado']; } ?>">												
								</div>		

									
							
							</div>
						
						</div>	

						<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label for="nlicitacao">Número da Licitação</label>
								<input type="text" name="nlicitacao" id="nlicitacao" maxlength="5" class="form-control"  required value="<?php if(isset($_POST['nlicitacao'])) { echo $_POST['nlicitacao']; } ?>">
							</div>
							<div class="form-group">
								<label for="nprocesso">Número do Processo</label>
								<input type="text" name="nprocesso" id="nprocesso" maxlength="5" class="form-control" required value="<?php if(isset($_POST['nprocesso'])) { echo $_POST['nprocesso']; } ?>">

							</div>
							
								</div>								
							<div class="col-md-2">
							<div class="form-group">
								<label for="anolicitacao">Ano da Licitação</label>
								<input type="text" name="anolicitacao" id="anolicitacao" maxlength="4" class="form-control"  required value="<?php if(isset($_POST['anolicitacao'])) { echo $_POST['anolicitacao']; } ?>">
							</div>
							<div class="form-group">
								<label for="anoprocesso">Ano do Processo</label>
								<input type="text" name="anoprocesso" id="anoprocesso" maxlength="4" class="form-control" required value="<?php if(isset($_POST['anoprocesso'])) { echo $_POST['anoprocesso']; } ?>">

							</div>

							

					
						</div>									
						
						</div>						
							<input class="btn btn-success" type="submit">
						</form>					
				</div>
		</main>		
	</body>
</html>