<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">
		 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
	
		
		
	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
			include("cabecalho.php"); ?>
		  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
		        <h1 class="h2">Resultados das Licitações</h1>	            
		            
			</div>          		
			
		
          
          <table class="table table-striped table-sm">                  
                <thead>
                    <tr>                    
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
                        <tr>                                              
                          <td><?php echo $row['codlic']; ?></td>
                          <td><?php echo $row['npregao']; ?></td>
                          <td><?php echo $row['nprocesso']; ?></td>
                          <td><?php echo $row['datahomologacao']; ?></td>
                          <td>
                             <a title="Importar Vencedores" class="btn btn-primary" style="font-size:10px;"  href="importarresultado/importar.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                              <span class="fas fa-file-import"></span>
                              </a>
                              <a title="Visualizar Vencedores" class="btn btn-success" style="font-size:10px;" href="listar.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                                <span class="fas fa-search"></span>
                              </a>
                              <a title="Listar Empresas" class="btn btn-warning" style="font-size:10px;"
                             href="listarempresa.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                                <span class="far fa-building"></span>
                              </a>
                               
                                <a title="Planilha BPS" class="btn btn-dark" style="font-size:10px;"
                             href="gerarplanilhabps.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                                <span class="fa-solid fa-table"></span>



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