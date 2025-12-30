<?php  session_start();
 if (isset($_GET['cnpj'])  ) {         
    $_SESSION['cnpj']=$_GET['cnpj'];
    $_SESSION['nomefornecedor']=$_GET['nomefornecedor'];
                                    
  }

  $cnpj=$_SESSION['cnpj'];
  $nomefornecedor= $_SESSION['nomefornecedor'];
  $codlic=$_SESSION['codlic']; 

?>
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
    <?php include("cabecalho.php"); 
      

    ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Fornecedor: <?php echo $nomefornecedor ?>  </h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="listarempresa.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div>  

          <div class="table-responsive">
            <table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr>
                    <th>Item</th>
                    <th>Descrição</th>  
                    <th>Marca</th> 
                    <th>Quantidade</th> 
                    <th>Vlr. Unitário</th>  
                    <th>CNPJ Fabricante</th>
                    <th>Registro Anvisa</th>
                    <th>Ações</th>                       
                  </tr>
              </thead>  
              <tbody>
                <?php                      
                  include("../conexao.php");
                                    
                  $sql = "SELECT resultadolicitacao.id, resultadolicitacao.item,resultadolicitacao.marca,produto.descricao,quantidade, resultadolicitacao.vlrunitario, resultadolicitacao.cnpjfabricante, resultadolicitacao.registroanvisa
                        FROM resultadolicitacao                        
                        INNER JOIN produto on resultadolicitacao.codprod=produto.codprod              
                        WHERE idlic ='$codlic' and cnpj='$cnpj'";
                        
                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                            ?>
                             <tr style="font-size:12px">                        
                                                  
                              <td><?php echo $row['item']; ?></td> 
                              <td><?php echo $row['descricao']; ?></td> 
                              <td><?php echo $row['marca']; ?></td>
                              <td><?php echo $row['quantidade']; ?></td>
                              <td><?php echo $row['vlrunitario']; ?></td>  
                              <td><?php echo $row['cnpjfabricante']; ?></td>
                              <td><?php echo $row['registroanvisa']; ?></td>
                              <td>
                                 <a title="Editar registro" class="btn btn-warning" style="font-size:10px;" href="editar.php?id=<?php echo $row['id'];?>">
                                  <span class="fas fa-edit"></span>
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
        
  
 
  </body>
</html>