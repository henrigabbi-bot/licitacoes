<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
    <title>Central de Medicamentos</title>    
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../css/dashboard.css">
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
          <h1 class="h2">Movimentação Financeira</h1>  
          <div class="btn-group mr-2">                  
              <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
          </div>   
        </div> 

           
     
                      
<div align="center" class="col-md-6">

      <?php 
        include("../conexao.php"); 
          $sql1 = "SELECT sum(valornf) as valornf FROM nfsaida;";              
          $query1 = mysql_query($sql1);    
          $row1 = mysql_fetch_assoc($query1); 
          $valorfaturado=$row1['valornf'];
          $valorfaturado=number_format($valorfaturado, 2, ',', '.');
        
          $sql2 = "SELECT sum(valornf) as valornf FROM nfentrada;";              
          $query2 = mysql_query($sql2);    
          $row2 = mysql_fetch_assoc($query2); 
          $valorrecebido=$row2['valornf'];
          $valorrecebido=number_format($valorrecebido, 2, ',', '.')

        ?>
        <h3>Valor Faturado: R$ <?php echo $valorfaturado ?></h3>
        <h3>Valor Recebido: R$ <?php echo $valorrecebido ?></h3>

     </div>  
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
          <h3>Notas Fiscais de Saída</h3>       
          <div class="btn-group mr-2">                  
              <a class="btn btn-primary" href="lerxml/importar.php" role="button">Importar NF de Saída</a>
          </div>    
       </div>  

			<table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr>
                    
                    <th>Numero</th> 
                    <th>Vlr. NF</th>                      
                    <th>Data</th> 
                    <th>Cliente</th> 
                    <th>Ações</th> 
                  </tr>
              </thead>  
              <tbody>
                <?php   
                  $sql = "SELECT *, cliente.nomecliente FROM nfsaida 
                  INNER JOIN cliente on nfsaida.cnpj=cliente.cnpj;";
                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                            ?>
                            <tr>
                              <td><?php echo $row['numeronf']; ?></td> 
                              <td><?php echo $row['valornf']; ?></td>
                              <td><?php echo $row['data']; ?></td>  
                              <td><?php echo $row['nomecliente']; ?></td> 
                              <td>
                                <a title="Excluir Nota Fiscal" class="btn btn-danger" style="font-size:10px;" href="lerxml/deletarnf.php?id=<?php echo $row['chavedeacesso'];?>">
                                <span class="fas fa-trash-alt"></span>
                                </a>
                              </td> 
                            </tr>
                        <?php
                      }
                      ?>
            </tbody>
        </table> 
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        
        <h3>Notas Fiscais de Entrada</h3>
        <div class="btn-group mr-2">                  
            <a class="btn btn-primary" href="lerxmlfornecedor/importar.php" role="button">Importar NF de Entrada</a>
          </div> 
      </div>
          

          <table class="table table-striped table-sm" id="minhaTabela1">
                <thead>
                    <tr>
                     
                      <th>Numero</th> 
                      <th>Vlr. NF</th>                      
                      <th>Data</th> 
                      <th>Fornecedor</th> 
                      <th>Ações</th> 
                                     
                    </tr>
                </thead>  
                <tbody>
                  <?php                 
                 

                    
                    $sql = "SELECT *, fornecedor.nomefornecedor FROM nfentrada 
                    INNER JOIN fornecedor on nfentrada.cnpj=fornecedor.cnpj;";
                     
                   
                        // Executa consulta SQL
                          $query = mysql_query($sql);  
                        // Enquanto houverem registros no banco de dados
                            while($row = mysql_fetch_array($query)) {
                              ?>
                              <tr> 
                                <td><?php echo $row['numeronf']; ?></td> 
                                <td><?php echo $row['valornf']; ?></td>
                                <td><?php echo $row['data']; ?></td>  
                                <td><?php echo $row['nomefornecedor']; ?></td> 
                                <td> 
                                <a title="Excluir Nota Fiscal" class="btn btn-danger" style="font-size:10px;" href="lerxmlfornecedor/deletarnf.php?id=<?php echo $row['chavedeacesso'];?>">
                                 <span class="fas fa-trash-alt"></span>
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
    
    <script>      
      $(document).ready(function(){
          $('#minhaTabela').DataTable({
              "language": {
                    "lengthMenu": "Exibir_MENU_ Registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Exibindo _START_ - _END_ de _MAX_", 
                    "infoEmpty": "Nenhum registro disponível",
                    "paginate": {                 
                  "next":       "Próximo",
                  "previous":   "Anterior"
              },                    
                    "search":         "Procurar:"   
              
                }, 
            dom: 'Bfrtip',
            buttons: [
            'csv', 'excel', 'pdf'
            ]
            });
      });
    </script>
       <script>      
      $(document).ready(function(){
          $('#minhaTabela1').DataTable({
              "language": {
                    "lengthMenu": "Exibir_MENU_ Registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Exibindo _START_ - _END_ de _MAX_", 
                    "infoEmpty": "Nenhum registro disponível",
                    "paginate": {                 
                  "next":       "Próximo",
                  "previous":   "Anterior"
              },                    
                    "search":         "Procurar:"   
              
                }, 
            dom: 'Bfrtip',
            buttons: [
            'csv', 'excel', 'pdf'
            ]
            });
      });
    </script>
  </body>
</html>