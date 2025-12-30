<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
    
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="../../css/dashboard.css">


	</head>
	<body>
		<?php
			// Abre a sessão
			session_start();
			// Verifica se o usuário está logado
		include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	     <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
		    	<h1 class="h2">Processos Administrativos</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="cadastrar.php" role="button">Cadastrar Licitação</a>
			    </div>    
			 </div>        		
			 <table class="table table-striped table-sm" id="minhaTabela" style="font-size:12px;">                 
                <thead>
                    <tr align="center">  
                      <th>Nº Processo</th>                 
                      <th>Modalidade</th>
                      <th>Nº Licitação</th>     
                      <th>Ano Licitação</th>  
                      <th>Objeto</th>                
                      <th>Data</th>                      
                      <th>Valor</th>
                        <th>icones</th>
                     
	



                    </tr>
                </thead>                  
                  <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL
                      $sql = "SELECT *,DATE_FORMAT(dataprocesso, '%d/%m/%Y ') AS data_formatada FROM processoadministrativo ORDER BY nprocesso desc;";
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr align="center">                                            	
                          <td><?php echo $row['nprocesso']; ?></td>
                          <td><?php echo $row['modalidade']; ?></td>
                          <td><?php echo $row['nlicitacao']; ?></td>
                          <td><?php echo $row['anolicitacao']; ?></td>
                          <td ><?php echo $row['objeto']; ?></td>
                          <td><?php echo $row['data_formatada']; ?></td>
                        
                          <td ><?php echo $row['valorestimado']; ?></td>
                          <td>
                             <a title="Editar registro" class="btn btn-warning" style="font-size:10px;" href="editar.php?id=<?php echo $row['codlic'];?>">
                              <span class="fas fa-edit"></span>
                              </a>
                             <a title="Deletar registro" class="btn btn-danger" style="font-size:10px;" href="deletar.php?id=<?php echo $row['codlic'];?>">
												        <span class="fas fa-trash-alt"></span>
							               </a> 
                              <a title="Visualizar Itens" class="btn btn-success" style="font-size:10px;" href="listaritens.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                                <span class="fas fa-search"></span>
                              </a>  
                             <a title="Importar Itens" class="btn btn-primary" style="font-size:10px;"  href="importaritens.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
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
    <script src="//code.jquery.com/jquery-3.3.1.js"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 
    <script src="//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script> 
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>  
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>     
      
	</body>
</html>