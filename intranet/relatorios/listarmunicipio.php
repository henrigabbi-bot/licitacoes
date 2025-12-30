<?php  session_start();

 if (isset($_GET['descricao'])  ) {       
                 

$_SESSION['descricao']=$_GET['descricao'];
}
$lic_descricao =$_SESSION['descricao'];

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
    <?php include("cabecalho.php"); 
       

    ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Clientes da Licitação <?php echo  $lic_descricao ?></h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div>        

          <h2></h2>
        

          <div class="table-responsive">
            <table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr> 
                    <th>Cliente</th>
                    <th>Valor Registrado</th>
                    <th>Valor Pedido</th>  
                     <th>% Utilizado</th>    
                    <th>Ações</th>                       
                  </tr>
              </thead>  
              <tbody>
                <?php                      
                  include("../conexao.php"); 

                  if (isset($_GET['id'])  ) {         
                    $_SESSION['codlic']=$_GET['id'];
                                    
                  } 

                  $id_lic = $_SESSION['codlic']; 

                      $sql2 = "SELECT  cliente.nomecliente,cliente.cnpj ,SUM(pedidodecompra.quantidade * resultadolicitacao.vlrunitario)as valordopedido
                      FROM pedidodecompra
                      INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj
                      LEFT JOIN resultadolicitacao on resultadolicitacao.codprod=pedidodecompra.codprod and resultadolicitacao.idlic='$id_lic'
                      WHERE pedidodecompra.idlic='$id_lic' 
                      GROUP BY cliente.nomecliente"; 

                    
                      // Executa consulta SQL
                          $query = mysql_query($sql2);  
                           
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                              $cnpj=$row['cnpj'];
                              $sql="SELECT  SUM(previsaodeconsumo.quantidade * resultadolicitacao.vlrunitario)as valortotal
                                FROM previsaodeconsumo INNER JOIN cliente on previsaodeconsumo.cnpj=cliente.cnpj LEFT JOIN resultadolicitacao on resultadolicitacao.codprod=previsaodeconsumo.codprod AND resultadolicitacao.idlic='$id_lic'
                                WHERE previsaodeconsumo.idlic='$id_lic' and cliente.cnpj='$cnpj'";
                                $query1 = mysql_query($sql);  
                                $row2 = mysql_fetch_assoc($query1);
                                $valortotal=$row2['valortotal'];
                                $valortotalformatado=number_format($row2['valortotal'], 2, ',', '.');  
                            ?>
                            <tr>
                              <td><?php echo $row['nomecliente']; ?></td> 
                              <td>R$ <?php echo $valortotalformatado ?></td> 
                              <td>R$ <?php echo number_format($row['valordopedido'], 2, ',', '.'); ?></td>
                              <?php  
                              if ($valortotal>0 ) {
                                $porcentagem=($row['valordopedido']*100)/ $valortotal;
                              }
                               ?> 
                                <td>  <?php echo $porcentagem=number_format($porcentagem, 2, ',', '.');
                                $porcentagem=0;?> % 
                                </td> 
                                <td> 
                                <a title="Visualizar Consumo" class="btn btn-primary" style="font-size:10px;" href="listarconsumomunicipio.php?cnpj=<?php echo $row['cnpj'];?>&amp;nomecliente=<?php echo $row['nomecliente']?>"">
                                  <span class="fas fa-search"></span>
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