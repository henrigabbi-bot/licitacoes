<!DOCTYPE>
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
          <h1 class="h2">Emissão de Contrato de Rateio</h1>              
                
       </div>           		
			<table class="table table-striped table-sm" id="minhaTabela">               
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nº Contrato</th>
                      <th>CNPJ</th>
                      <th>Nome</th>  
                      <th>Taxa Medicamentos</th>                   
                      <th>Taxa CISA</th> 
                      <th>Taxa CEO</th> 
                      <th>Ações</th> 
                    </tr>
                </thead>                  
                  <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL

                      $ncontrato=1;

                       $sql = "SELECT cliente.id, cliente.nomecliente,cliente.cnpj, contratoderateio.id, contratoderateio.taxamedicamentos, contratoderateio.taxacisa, contratoderateio.taxaceo  FROM contratoderateio left JOIN cliente on cliente.id=contratoderateio.id ORDER BY cliente.id;";
                  
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados                     
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr> 
                        <td><?php echo $row['id']; ?></td> 
                        <td><?php echo $ncontrato; ?></td>                          	
                          <td><?php echo $row['cnpj']; ?></td>
                          <td><?php echo $row['nomecliente']; ?></td>

                          <td>R$ <?php echo $programamedicamentos =number_format($row['taxamedicamentos'], 2, ',', '.');?></td>
                          <td>R$ <?php echo $programacisa=number_format($row['taxacisa'], 2, ',', '.');?></td>
                          <td>R$ <?php echo $programaceo =number_format($row['taxaceo'], 2, ',', '.');?></td>
                         
                        
                                                    
                          <td>
                              <a title="Contrato" class="btn btn-primary" style="font-size:5px;" href="gerarpdfcomtimbre.php?id=<?php echo $row['id'];?>&amp;ncontrato=<?php echo $ncontrato ?>">
                                  <span class="far fa-copy"></span>
                                </a> 


                               
                                                   
                          </td>
                        </tr>
                      <?php

                       $ncontrato++;                      
                      
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
                          "infoFiltered": "(filtrado de _MAX_ registros no total)",
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