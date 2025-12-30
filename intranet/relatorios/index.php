<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
    
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">		
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
		include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	     <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
		    	<h1 class="h2">Licitações Cadastradas</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>
			    </div>    
			 </div>        		
			 <table class="table table-hover table-sm">                  
                <thead>
                    <tr align="center">                    
                      <th>Código</th>
                      <th>Nº Pregão</th>
                      <th>Nº Processo</th>
                      <th>Data de Homologação</th>                    
                      <th>Ações</th>
                    </tr>
                </thead>                  
                  <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL
                      $sql = "SELECT * FROM licitacao ORDER BY codlic desc;";
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr align="center">                                            	
                          <td><?php echo $row['codlic']; ?></td>
                          <td><?php echo $row['npregao']; ?></td>
                          <td><?php echo $row['nprocesso']; ?></td>
                          <td><?php echo $row['datahomologacao']; ?></td>
                         
                          <td>
                             <a title="Estatística" class="btn btn-warning" style="font-size:10px;" href="estatistica.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                              <span class="fas fa-align-right"></span>
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