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
            <h1 class="h2">Banco de Pedidos do CISA</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div>        

             
          <?php include("../conexao.php"); ?>

          <div class="table-responsive">
            <table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr>                        
                    <th>Código</th>                        
                    <th>Produto</th>

                  <?php 

                    $sql = "SELECT pedido.codlic,pedido.npedido,licitacao.npregao, pedido.data FROM pedido
                    INNER JOIN licitacao on pedido.codlic=licitacao.codlic ORDER BY data ASC LIMIT 20 "; 
                    $query = mysql_query($sql);
                    $aux=0;
                    while($row = mysql_fetch_array($query)) {
                      $pregao=$row['npregao']; 
                      $pedido=$row['npedido']; 

                    
                      $codlic[$aux]=$row['codlic'];
                      $npedido[$aux]=$row['npedido']; 
                      $cont++;
                      $aux++;
                  
                     
                  ?>   
                      <th>Qtd. Lic. <?php echo $pregao; ?> Ped. <?php echo $pedido; ?></th>
                  <?php
                    }  
                   ?>


                      
                                 
                  </tr>
              </thead>  
              <tbody>  
              

              <?php  

                     
                        $sql0= "SELECT produto.codprod, produto.descricao, sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[0]' AND pedidodecompra.pedido='$npedido[0]' GROUP BY produto.codprod";                       
                       
                                   
                         $sql1= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[1]' AND pedidodecompra.pedido='$npedido[1]' GROUP BY produto.codprod";

                         $sql2= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[2]' AND pedidodecompra.pedido='$npedido[2]' GROUP BY produto.codprod";
                       
                       
                                   
                         $sql3= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[3]' AND pedidodecompra.pedido='$npedido[3]' GROUP BY produto.codprod";

                        $sql4= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[4]' AND pedidodecompra.pedido='$npedido[4]' GROUP BY produto.codprod";
                       
                       
                                   
                         $sql5= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[5]' AND pedidodecompra.pedido='$npedido[5]' GROUP BY produto.codprod";

                         $sql6= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[6]' AND pedidodecompra.pedido='$npedido[6]' GROUP BY produto.codprod";                       
                       
                                   
                         $sql7= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[7]' AND pedidodecompra.pedido='$npedido[7]' GROUP BY produto.codprod";


                          $sql8= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[8]' AND pedidodecompra.pedido='$npedido[8]' GROUP BY produto.codprod";

                           $sql9= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[9]' AND pedidodecompra.pedido='$npedido[9]' GROUP BY produto.codprod";

                           $sql10= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[10]' AND pedidodecompra.pedido='$npedido[10]' GROUP BY produto.codprod";

                         $sql11= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[11]' AND pedidodecompra.pedido='$npedido[11]' GROUP BY produto.codprod";

                         $sql12= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[12]' AND pedidodecompra.pedido='$npedido[12]' GROUP BY produto.codprod";

                            $sql13= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[13]' AND pedidodecompra.pedido='$npedido[13]' GROUP BY produto.codprod";

                            $sql14= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[14]' AND pedidodecompra.pedido='$npedido[14]' GROUP BY produto.codprod";

                             $sql15= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[15]' AND pedidodecompra.pedido='$npedido[15]' GROUP BY produto.codprod";
                       
                           $sql16= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[16]' AND pedidodecompra.pedido='$npedido[16]' GROUP BY produto.codprod";
                       
                           $sql17= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[17]' AND pedidodecompra.pedido='$npedido[17]' GROUP BY produto.codprod";
                       
                           $sql18= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[18]' AND pedidodecompra.pedido='$npedido[18]' GROUP BY produto.codprod";

                             $sql19= "SELECT sum(pedidodecompra.quantidade)as quantidade FROM produto
                         LEFT join pedidodecompra on pedidodecompra.codprod=produto.codprod and pedidodecompra.idlic='$codlic[19]' AND pedidodecompra.pedido='$npedido[19]' GROUP BY produto.codprod";
                       
                       
                       
                      
                          $query0 = mysql_query($sql0); 
                          $query1 = mysql_query($sql1); 
                          $query2 = mysql_query($sql2);
                          $query3 = mysql_query($sql3); 
                          $query4 = mysql_query($sql4); 
                          $query5 = mysql_query($sql5); 
                          $query6 = mysql_query($sql6);
                          $query7 = mysql_query($sql7); 
                          $query8 = mysql_query($sql8); 
                          $query9 = mysql_query($sql9);
                          $query10 = mysql_query($sql10);  
                          $query11 = mysql_query($sql11);  
                          $query12 = mysql_query($sql12);  
                          $query13 = mysql_query($sql13);  
                          $query14 = mysql_query($sql14); 
                          $query15 = mysql_query($sql15);  
                          $query16 = mysql_query($sql16);  
                          $query17 = mysql_query($sql17);  
                          $query18 = mysql_query($sql18);  
                          $query19 = mysql_query($sql19);  
                   
                        
                          
                       
                        
                          // Enquanto houverem registros no banco de dados
                          while($row0 =mysql_fetch_array($query0)and $row1 =mysql_fetch_array($query1)and $row2 = mysql_fetch_array($query2)and $row3 = mysql_fetch_array($query3)and $row4 = mysql_fetch_array($query4) and $row5 = mysql_fetch_array($query5)and $row6 = mysql_fetch_array($query6)and $row7 = mysql_fetch_array($query7)and $row8 = mysql_fetch_array($query8)and $row9 = mysql_fetch_array($query9) and $row10 = mysql_fetch_array($query10)and $row11 = mysql_fetch_array($query11)and $row12 = mysql_fetch_array($query12) and $row13 = mysql_fetch_array($query13)and $row14 = mysql_fetch_array($query14)and $row15 = mysql_fetch_array($query15)and $row16 = mysql_fetch_array($query16)and $row17 = mysql_fetch_array($query17)and $row18 = mysql_fetch_array($query18)and $row19 = mysql_fetch_array($query19)){
                          ?>
                              <tr>
                                    <td><?php echo $row0['codprod']; ?></td> 
                                    <td><?php echo $row0['descricao']; ?></td> 
                                    <td><?php echo $row0['quantidade']; ?></td>                                
                                    <td><?php echo $row1['quantidade']; ?></td>
                                    <td><?php echo $row2['quantidade']; ?></td>
                                    <td><?php echo $row3['quantidade']; ?></td>
                                    <td><?php echo $row4['quantidade']; ?></td>
                                    <td><?php echo $row5['quantidade']; ?></td>
                                    <td><?php echo $row6['quantidade']; ?></td>
                                    <td><?php echo $row7['quantidade']; ?></td>
                                    <td><?php echo $row8['quantidade']; ?></td>
                                    <td><?php echo $row9['quantidade']; ?></td>
                                    <td><?php echo $row10['quantidade']; ?></td>
                                    <td><?php echo $row11['quantidade']; ?></td>
                                    <td><?php echo $row12['quantidade']; ?></td>
                                    <td><?php echo $row13['quantidade']; ?></td>
                                    <td><?php echo $row14['quantidade']; ?></td>
                                    <td><?php echo $row15['quantidade']; ?></td>
                                    <td><?php echo $row16['quantidade']; ?></td>
                                    <td><?php echo $row17['quantidade']; ?></td>
                                    <td><?php echo $row18['quantidade']; ?></td>
                                    <td><?php echo $row19['quantidade']; ?></td>                     
                                   
                           
                                 
                              
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