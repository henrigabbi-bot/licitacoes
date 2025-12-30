<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">		
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
		include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	     <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
		    <h1 class="h2">Previsão de Consumo Cadastrada</h1>  
                 
	      </div>        		
			<table class="table table-striped table-sm">                  
                <thead>
                    <tr>
                      <th>Código da Licitação</th>
                      <th>Nº do Pregão</th> 
                      <th>Data Homologação</th>                      
                      <th>Ações</th>
                    </tr>
                </thead>                  
                   <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL                      
                      $sql = "SELECT * FROM licitacao order by datahomologacao desc;";
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr>                          
                          <td><?php echo $row['codlic']; ?></td>
                          <td><?php echo $row['npregao']; ?></td>
                          <td><?php echo $row['datahomologacao']; ?></td>
                          <td>
                            <a title="Visualizar Previsão de Consumo" class="btn btn-success" style="font-size:10px;" href="listar.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                                <span class="fas fa-search"></span>
                              </a>
                            
                               <a title="Visualizar Previsão de Consumo por Cliente" class="btn btn-info" style="font-size:10px;" href="listarclientes.php?npedido=<?php echo $row['npedido'];?>&amp;codlic=<?php echo $row['codlic']?>">
                                  <span class="fas fa-home"></span>
                              </a>
                               <a title="Importar Previsão de Consumo" class="btn btn-primary" style="font-size:10px;" href="importarprevisao/importar.php?id=<?php echo $row['codlic'];?>"">
                              <span class="fas fa-file-import"></span>
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