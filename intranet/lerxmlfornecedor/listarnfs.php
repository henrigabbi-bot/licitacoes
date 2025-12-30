<?php 
session_start();
  if (isset($_GET['id'])) {   
    $_SESSION['descricaolic']=$_GET['id']; 
    $_SESSION['npedido']=$_GET['npedido'];
    $_SESSION['npregao']=$_GET['npregao'];  
  }
  
  $codlic=$_SESSION['descricaolic'];
  $npregao= $_SESSION['npregao'];
  $npedido= $_SESSION['npedido'];
?>


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
    <?php include("cabecalho.php");?> 

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Notas Fiscais do Pregão <?php echo $npregao?> - Pedido <?php echo $npedido?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="index.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div> 
          <?php 
          include("../conexao.php"); 

          $sql1 = "SELECT  sum(valornf) as valortotal, count(chavedeacesso) as contnf FROM notafiscalfornecedor where codlic='$codlic'and pedido='$npedido'";
          $query1 = mysql_query($sql1);    
          $row1 = mysql_fetch_assoc($query1);
          $valortotal=number_format($row1['valortotal'], 2, ',', '.');
          $contnf=$row1['contnf'];  
          
          ?>


          <h4>Valor Total: R$ <?php echo $valortotal ?></h4>
          <h4>Nº de NFs: <?php echo $contnf ?></h4>
        

          <div class="table-responsive">
            <table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr>
                    <th>Chave de Acesso</th>
                    <th>Numero</th> 
                    <th>Vlr. NF</th>                         
                    <th>Fornecedor</th>                   
                    <th>Ações</th> 
                                   
                  </tr>
              </thead>  
              <tbody>
                <?php    

                  $sql = "SELECT *,fornecedor.nomefornecedor FROM notafiscalfornecedor 
                  INNER JOIN fornecedor on notafiscalfornecedor.cnpj=fornecedor.cnpj                  
                  WHERE codlic='$codlic'and pedido='$npedido';";
                   
                 
                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                            ?>
                            <tr>                           
                              <td><?php echo $row['chavedeacesso']; ?></td>
                              <td><?php echo $row['numeronf']; ?></td> 
                              <td><?php echo $row['valornf'];?></td>                              
                              <td><?php echo $row['nomefornecedor']; ?></td>                               
                              <td>
                             <a title="Visualizar Nota Fiscal" class="btn btn-success" style="font-size:10px;" href="visualizarnf.php?id=<?php echo $row['chavedeacesso'];?>&amp;numeronf=<?php echo $row['numeronf']?>"">
                              <span class="fas fa-search"></span>
                              </a>
                               <a title="Editar" class="btn btn-warning" style="font-size:10px;" href="editarnf.php?id=<?php echo $row['chavedeacesso'];?>">
                              <span class="fas fa-edit"></span>
                              </a>
                              <a title="Excluir Nota Fiscal" class="btn btn-danger" style="font-size:10px;" href="deletarnf.php?id=<?php echo $row['chavedeacesso'];?>">
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
        
  
 
  </body>
</html>