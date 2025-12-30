<?php  
 session_start();
 $codlic=$_SESSION['codlic'];

 if (isset($_GET['nomecliente'])  ) {      
  $_SESSION['nomecliente']=$_GET['nomecliente'];
  }
  $lic_fornecedor =$_SESSION['nomecliente'];

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
            <h1 class="h2">Relatório de Consumo</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="listarmunicipio.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div>
          <h2> <?php echo $lic_fornecedor ?></h2> 
          <div class="table-responsive">
            <table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr>                      
                    <th>Código</th>                        
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Pedido</th>                        
                    <th>Saldo</th> 
                    <th>% Utilizado</th>                  
                  </tr>
              </thead>  
              <tbody>
                <?php 
                 $cnpj = $_GET['cnpj']; 
               

                  include("../conexao.php"); 
                  $sql = "SELECT previsaodeconsumo.codprod,produto.descricao,previsaodeconsumo.quantidade, SUM(pedidodecompra.quantidade) as pedido, previsaodeconsumo.idlic
                    FROM previsaodeconsumo 
                    INNER JOIN produto on previsaodeconsumo.codprod=produto.codprod 
                    INNER JOIN cliente on previsaodeconsumo.cnpj=cliente.cnpj 
                    LEFT JOIN pedidodecompra on previsaodeconsumo.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj'                    WHERE previsaodeconsumo.idlic='$codlic' and previsaodeconsumo.cnpj='$cnpj'
                     GROUP BY previsaodeconsumo.codprod ";
                 
                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                        while($row = mysql_fetch_array($query)) {
                            ?>
                            <tr>
                              <td><?php echo $row['codprod']; ?></td> 
                              <td><?php echo $row['descricao']; ?></td>
                              <td><?php echo $row['quantidade']; ?></td>
                              <td><?php echo $row['pedido']; ?></td> 
                              <td><?php echo $saldo=($row['quantidade'] - $row['pedido']);?></td> 
                              <td><?php $porcentagem=($row['pedido']*100  / $row['quantidade']); 
                                   echo $porcentagem= number_format($porcentagem, 2, ',', '');?> 
                               %</td>                            
                             
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