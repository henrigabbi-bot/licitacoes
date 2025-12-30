<?php  session_start();

 if (isset($_GET['npregao'])  ) {       
                 

$_SESSION['npregao']=$_GET['npregao'];
}
$lic_descricao =$_SESSION['npregao'];

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
            <h3 class="h3">Planilha de Importação para Registro de Compras no BPS</h3>
            <h3>Licitação <?php echo  $lic_descricao ?></h3>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
               <a class="btn btn-primary" href="index.php" role="button">Voltar</a>         
              </div>              
            </div>
          </div>  

          <div class="table-responsive">
            <table class="table table-striped table-sm" id="minhaTabela">
              <thead>
                  <tr>
                    <th>Fornecedor</th>
                    <th>CNPJ</th>  
                    <th>Codprod</th>  
                    <th>Código BR</th>   
                    <th>Código Unidade</th>  
                     <th>Cnpj Fabricante</th> 
                      <th>Registro da Anvisa</th> 
                    <th>Quantidade</th>  
                    <th>Valor Unitário</th>       
                  </tr>
              </thead>  
              <tbody>
                <?php                      
                  include("../conexao.php");
                  if (isset($_GET['id'])  ) {        
                    
                    $_SESSION['codlic']=$_GET['id'];
                                    
                  } 

                  $id_lic = $_SESSION['codlic']; 

                  $sql = " SELECT fornecedor.nomefornecedor,fornecedor.cnpj, produto.codprod,produto.codigobr, produto.codigounidade, resultadolicitacao.cnpjfabricante,resultadolicitacao.registroanvisa,resultadolicitacao.quantidade, resultadolicitacao.vlrunitario FROM  resultadolicitacao
                INNER JOIN fornecedor on resultadolicitacao.cnpj=fornecedor.cnpj
                INNER JOIN produto on resultadolicitacao.codprod=produto.codprod
                 
                  WHERE idlic = '$id_lic'";

                   $contrato=140;
                 

                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                            $cnpj2=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5",$row['cnpj']);   
                          
                            ?>
                             <tr style="font-size:12px">   
                              <td><?php echo $row['nomefornecedor']; ?></td> 
                              <td><?php echo $cnpj2; ?></td> 
                              <td><?php echo $row['codprod']; ?></td> 
                              <td><?php echo $row['codigobr']; ?></td> 
                              <td><?php echo $row['codigounidade']; ?></td> 
                                <td><?php echo $row['cnpjfabricante']; ?></td> 
                                  <td><?php echo $row['registroanvisa']; ?></td> 
                              <td><?php echo $row['quantidade']; ?></td> 
                              <td><?php echo $row['vlrunitario']; ?></td> 
                           
                            </tr>

                            
                        <?php
                          $contrato++;
                      
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