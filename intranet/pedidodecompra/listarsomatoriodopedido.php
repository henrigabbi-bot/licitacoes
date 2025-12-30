
<?php session_start();

      if (isset($_GET['npedido']) and isset($_GET['codlic']) ) {             
          $_SESSION['npedido']=$_GET['npedido']; 
          $_SESSION['idlic']=$_GET['codlic'];  
      }  ?>
<!DOCTYPE html>

<html lang="en">
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
            <h1 class="h2">Somatório do Pedido</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="index.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div>        

          <?php 
           include("../conexao.php"); 
            $id_ped =$_SESSION['npedido'];
            $id_lic=$_SESSION['idlic'];

           ?>
        

          <div class="table-responsive">
            <table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr>                        
                    <th>Código</th>                        
                    <th>Produto</th>
                    <th>Quantidade Lic. <?php echo $id_lic ?> Pedido <?php echo $id_ped ?></th>
                    <th>Vlr. Unitario</th>
                    <th>Vlr. Total</th>
                  </tr>
              </thead>  
              <tbody>
                <?php    
                                  
              $sql = "SELECT produto.codprod, produto.descricao, sum(pedidodecompra.quantidade)as quantidade, resultadolicitacao.vlrunitario, (resultadolicitacao.vlrunitario * sum(pedidodecompra.quantidade)) as valortotal FROM produto 
              left join resultadolicitacao on resultadolicitacao.codprod=produto.codprod AND resultadolicitacao.idlic='$id_lic'
              LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$id_lic' AND pedidodecompra.pedido='$id_ped' GROUP BY produto.codprod";
                   
                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                            ?>
                            <tr>
                              <td><?php echo $row['codprod']; ?></td> 
                              <td><?php echo $row['descricao']; ?></td>
                              <td><?php echo $row['quantidade']; ?></td>
                              <td><?php echo number_format($row['vlrunitario'], 4, ',', '.'); ?></td>
                              <td>R$ <?php echo number_format($row['valortotal'], 2, ',', ''); ?></td>
                            </tr>
                        <?php
                      }
                      ?>
            </tbody>
        </table>        
    </main>   
    <script src="//code.jquery.com/jquery-3.3.1.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
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
                buttons: [ 'csv', 'excel', 'pdf']


            });

          
      });
    </script>
        
  
 
  </body>
</html>