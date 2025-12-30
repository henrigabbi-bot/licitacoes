<?php  

 if (isset($_GET['cnpj'])and isset($_GET['codlic'])) {             
          $cnpj=$_GET['cnpj'];
          $codlic=$_GET['codlic'];
          $npedido=$_GET['pedido'];

      }     

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
            <h1>Relatório de Economicidade</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="index.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div>

          <?php  
          include("../conexao.php"); 

          $sql1 ="SELECT * FROM cliente WHERE CNPJ='$cnpj'";
          $query1 = mysql_query($sql1);                  
          $row1 = mysql_fetch_assoc($query1);
          $nomecliente= $row1['nomecliente'];

          $sql2 ="SELECT * FROM licitacao WHERE codlic='$codlic'";
          $query2 = mysql_query($sql2);                  
          $row2 = mysql_fetch_assoc($query2);
          $npregao= $row2['npregao'];

          $sql = "SELECT COUNT(DISTINCT itensprocesso.codprod) AS itenscomparados, COUNT(DISTINCT pedidodecompra.codprod) AS itenssolicitados
                  FROM pedidodecompra INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
                  INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
                  LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
                  WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$npedido'  ";
            // Executa consulta SQL
            $query = mysql_query($sql);  
            $row = mysql_fetch_assoc($query);
            $itenscomparados=$row['itenscomparados'];
            $itenssolicitados=$row['itenssolicitados'];

            $sql2 = "SELECT pedidodecompra.quantidade,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso
                        FROM pedidodecompra 
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
                        LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
                        WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$npedido'
                        GROUP BY pedidodecompra.codprod;";
                       
                          // Executa consulta SQL
                            $query = mysql_query($sql2);  
                          // Enquanto houverem registros no banco de dados
                            
                          while($row = mysql_fetch_array($query)) {
                            if ($row['vlrunitarioprocesso'] != 0) {                                       
                                  $economia=(($row['vlrunitario']* $row['quantidade']) - ($row['vlrunitarioprocesso']*$row['quantidade'])); 
                                        $aux=$aux + $economia; 
                            }   
                          }
              ?> 
          
           <h2><?php echo $nomecliente?> - Pregão <?php echo $npregao ?> - Pedido <?php echo $npedido ?></h2>  
           
            <div class="container text-center">
                <div class="row">
                  <div class="list-group-item d-flex justify-content-between lh-condensed col-4">
                    <h4 class="my-0">Itens Solicitados</h4> 
                    <h4 class="my-0"><?php echo $itenssolicitados ?></h4>
                  </div>
                  <div class="list-group-item d-flex justify-content-between lh-condensed col-4">
                    <div class="text-success">
                        <h4 class="my-0">Itens Comparados</h4>                       
                      </div>
                      <h4 class="my-0 text-success"><?php echo $itenscomparados ?></h4>
                  </div>
                  
                  <div class="list-group-item d-flex justify-content-between lh-condensed col-4">
                    <h4 class="my-0">Economia</h4> 
                    <h4 class="my-0"> R$ <?PHP echo $aux= number_format($aux, 2, ',', '.'); ?></h4>  
                  </div>
            </div>
          </div>          

          <br>
           <br>

          <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="minhaTabela">
                  <thead>
                      <tr>                      
                        <th>Código</th>                        
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Vlr. CISA</th>                        
                        <th>Vlr. Unitário</th> 
                        <th>Economia %</th>  
                        <th>Economia R$</th>                
                      </tr>
                  </thead>  
                  <tbody>
                    <?php 
                      $sql = "SELECT pedidodecompra.codprod,produto.descricao,pedidodecompra.quantidade, pedidodecompra.idlic,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso
                        FROM pedidodecompra 
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
                        LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
                        WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$npedido'
                        GROUP BY pedidodecompra.codprod;
                        ";
                       
                          // Executa consulta SQL
                            $query = mysql_query($sql);  
                          // Enquanto houverem registros no banco de dados
                            while($row = mysql_fetch_array($query)) {
                              
                                ?>
                                <tr>
                                  <td><?php echo $row['codprod']; ?></td> 
                                  <td><?php echo $row['descricao']; ?></td>
                                  <td><?php echo $row['quantidade']; ?></td>
                              <td><?php echo $vlrunitario=number_format($row['vlrunitario'], 4, '.', ',');?></td> 
                              <td><?php echo $vlrunitarioprocesso=number_format($row['vlrunitarioprocesso'], 4, '.', ',');?></td> 
                                  
                                  <td><?php 
                                  if ($row['vlrunitarioprocesso'] != 0) {
                                   $porcentagem=((($row['vlrunitario']-$row['vlrunitarioprocesso'])/ $row['vlrunitario'])*100); 
                                       echo $porcentagem= number_format($porcentagem, 2, ',', '');
                                       ?>% <?PHP
                                  }
                                    ?> 
                                  
                                   </td> 
                                   <td> <?php 
                                   if ($row['vlrunitarioprocesso'] != 0) { ?>
                                      R$
                                      <?php
                                      $porcentagem=(($row['vlrunitario']* $row['quantidade']) - ($row['vlrunitarioprocesso']*$row['quantidade'])); 
                                       echo $porcentagem= number_format($porcentagem, 2, ',', '.');
                                   } 
                                    

                                   ?> 
                                   </td>                              
                                 
                                </tr>
                            <?php
                            }
                              ?>
                </tbody>

            </table>

          </div>
          </div>

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