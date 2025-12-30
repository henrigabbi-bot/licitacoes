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
     
      <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">

     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
  </head>
  <body>
    <?php include("cabecalho.php"); 
      

    ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2" >Fornecedores da Licitação <?php echo  $lic_descricao ?></h1>
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
                    <th>Contrato</th>
                    <th>Fornecedor</th>
                    <th>CNPJ</th>  
                    <th>Nº Itens</th>  
                    <th>Valor</th> 
                    <th>Representante</th>
                    <th>CPF</th>
                    <th>RG</th>
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

                  $sql = " SELECT fornecedor.nomefornecedor,fornecedor.cnpj, COUNT(resultadolicitacao.codprod) as itens, SUM(resultadolicitacao.quantidade * resultadolicitacao.vlrunitario)as valorempresa, pessoas.nome,fornecedor.cpf, pessoas.rg  FROM  fornecedor
                  LEFT JOIN  resultadolicitacao on fornecedor.cnpj=resultadolicitacao.cnpj
                  LEFT JOIN pessoas on fornecedor.cpf=pessoas.cpf
                 
                  WHERE idlic = '$id_lic'
                   GROUP BY fornecedor.cnpj";

                   $contrato=116;
                 

                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                            $cnpj2=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5",$row['cnpj']);   
                           $valorempresa =number_format($row['valorempresa'], 2, ',', '.');
                            ?>
                             <tr style="font-size:11px">  
                              <td><?php echo $contrato; ?></td>  
                              <td><?php echo $row['nomefornecedor']; ?></td> 
                              <td><?php echo  $cnpj2; ?></td> 
                              <td><?php echo $row['itens']; ?></td> 
                              <td>R$ <?php echo $valorempresa;?></td>  
                              <td><?php echo $row['nome']; ?></td> 
                              <td><?php echo $row['cpf']; ?></td> 
                               <td><?php echo $row['rg']; ?></td> 
                             
                                                    
                              <td> 
                                <a title="Visualizar Itens" class="btn btn-success" style="font-size:5px;" href="empresaitens.php?cnpj=<?php echo $row['cnpj'];?>&amp;nomefornecedor=<?php echo $row['nomefornecedor']?>">
                                  <span class="fas fa-search"></span>
                                </a> 
                                <a title="Gerar Ata" class="btn btn-primary" style="font-size:5px;" href="gerarata.php?cnpj=<?php echo $row['cnpj'];?>&amp;aux=<?php echo $contrato ?>">
                                  <span class="far fa-copy"></span>
                                </a>    
                                   <a title="Resultado" class="btn btn-info" style="font-size:5px;"
                             href="resultadolicitacao.php?cnpj=<?php echo $row['cnpj'];?>&amp;nomefornecedor=<?php echo $row['nomefornecedor']?>">
                              <span class="fa-solid fa-square-poll-horizontal"></span>
                                </a>

                                 <a title="Gerar Ata Com Timbre" class="btn btn-secondary" style="font-size:5px;" href="geraratacomtimbre.php?cnpj=<?php echo $row['cnpj'];?>&amp;aux=<?php echo $contrato ?>">
                                  <span class="far fa-copy"></span>
                                </a>   

                                 <a title="Contrato" class="btn btn-warning" style="font-size:5px;" href="contratocomtimbre.php?cnpj=<?php echo $row['cnpj'];?>&amp;aux=<?php echo $contrato ?>">
                                  <span class="far fa-copy"></span>
                                </a>                                                            
                              </td> 
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