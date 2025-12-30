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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.0/css/all.css">
    
  </head>
  <body>
    <?php
      // Abre a sessão
      session_start();
      // Verifica se o usuário está logado
      include("cabecalho.php");
      include("../conexao.php"); 
       ?>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
          <h1 class="h2">Comparativo de Economicidade</h1>   
          <div class="btn-group mr-2">                  
                <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>
            </div>    
        </div> 
            
           <div class="row">
            <div class="col-md-5"> 
              <form method="post" action="index.php">                           
                 <div class="form-group">    
                      <label for="codlic">Licitacação</label>  
                        <select id="codlic" name="codlic" class="form-control">             
                          <option>Selecione...</option>
                          <?php
                            include("../conexao.php");
                            $sql_cli = "SELECT * FROM licitacao ORDER BY codlic desc" ;

                            $query_cli = mysql_query($sql_cli);
                            if(mysql_num_rows($query_cli)>0) {
                              while($row_cli = mysql_fetch_array($query_cli)) {
                                ?>

                                
                                <option value="<?php echo $row_cli['codlic'];?>">
                                Pregão
                                <?php echo $row_cli['npregao'];?> -- Processo <?php echo $row_cli['nprocesso'];?>
                                </option>
                      <?php
                      }
                          }
                      ?>
                       </select>
                    </div>              
                 
                     <button type="submit" class="btn btn-success">Pesquisar</button>
                </form> 
              </div>
               </div>
              

<?php
         
            // Verifica se o formulário foi enviado
        if($_POST) {
          $licitacao=$_POST['codlic'];
                 

          $sql = "SELECT * FROM licitacao where codlic='$licitacao'";  
                          
          $query = mysql_query($sql);    
          $row = mysql_fetch_assoc($query); 
          $npregao=$row['npregao'];
          $nprocesso=$row['nprocesso'];
         

          ?>

          
        
       
      
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        
          <h4 class="h2">Licitações Cadastradas</h4>  
        
          </div>
          

        <table class="table table-striped table-sm" id="minhaTabela">                   
                <thead>
                    <tr align="center"> 
                    <th>ID</th>                   
                      <th>Município</th>
                      <th>Nº Pregão</th>
                      <th>Nº Processo</th>
                      <th>Data de Homologação</th>
                      <th>Nº Itens</th>
                      <th>Vlr. Licitação</th> 
                      <th>Ativo</th>                      
                      <th>Ações</th>
                    </tr>
                </thead>                  
                  <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL
                      $sql = "SELECT comparativo.codlic,comparativo.npregao, comparativo.nprocesso, DATE_FORMAT(comparativo.datahomologacao, '%d/%m/%Y ') AS data_formatada, comparativo.municipio, COUNT(itensprocesso.codprod) as itens ,SUM(itensprocesso.quantidade * itensprocesso.vlrunitario) as valortotal, comparativo.ativo FROM comparativo LEFT JOIN itensprocesso on itensprocesso.codlic=comparativo.codlic GROUP BY comparativo.codlic;";

                                          // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                         $valortotal =number_format($row['valortotal'], 2, ',', '.');
                        ?>
                        <tr align="center" style="font-size:13px">

                                                                     

                          <td><?php echo $row['codlic']; ?></td>
                          <td><?php echo $row['municipio']; ?></td>
                          <td><?php echo $row['npregao']; ?></td>
                          <td><?php echo $row['nprocesso']; ?></td>                          
                          <td><?php echo $row['data_formatada'];?></td>                         
                          <td><?php echo $row['itens']; ?></td>
                          <td>R$ <?php echo $valortotal; ?></td>
                          <td><?php echo $row['ativo']; ?></td>                          
                          <td>
                              <a title="Visualizar Itens da Licitação" class="btn btn-success" style="font-size:10px;" href="itenslicitacao.php?codlic=<?php echo $row['codlic'];?>">
                                <span class="fas fa-search"></span>
                            </a>
                                   <a title="Economicidade" class="btn btn-primary" style="font-size:12px;" href="economicidade.php?liccomparativo=<?php echo $row['codlic']; ?>&amp;municipio=<?php echo $row['municipio'];?>&amp;codlic=<?php echo $licitacao ?>">
                                <span class="fa-solid fa-money-bill-transfer"></span>

                                
                                </a>
                                  <a title="Gerar Relatório de Economicidade" class="btn btn-warning" style="font-size:12px;" href="processocomtimbre.php?cnpj=<?php echo $row['cnpj'];?>&amp;codlic=<?php echo $licitacao ?>&amp;pedido=<?php echo $row['pedido'] ?>">
                                <span class="fas fa-copy"></span>
                                </a>
                                                         
                          </td>
                        </tr>
                      <?php
                    }
                    ?>
                  </tbody>
            </table> 
     
      <?php

    }
      ?> 
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
      $('#minhaTabela1').DataTable({        
           "language": {    
           "search":         "Procurar:"    
           },   
        paging: false,
        ordering: false,
        info: false,
          
        });
      });
    </script>
  </body>
</html>