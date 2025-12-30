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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    
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
          <h1 class="h2">Finanças</h1>   
          <div class="btn-group mr-2">                  
                <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>
            </div>    
        </div> 
            
           <div class="row">
            <div class="col-md-5"> 
              <form method="post" action="index.php">                                
                        <div class="form-group">
                          <label for="datainicial">Data da Inicial</label>
                          <input type="date" name="datainicial" id="datainicial" maxlength="10" class="form-control" required value="<?php if(isset($_POST['datainicial'])) {echo $_POST['datainicial']; } ?>"> 
                        </div>
                        <div class="form-group">
                          <label for="datafinal">Data da Final</label>
                          <input type="date" name="datafinal" id="datafinal" maxlength="10" class="form-control" required value="<?php if(isset($_POST['datafinal'])) {echo $_POST['datafinal']; } ?>"> 
                        </div>
                        <div class="form-group">
                      
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="grupo" id="s" value="s" checked>
                          <label class="form-check-label" for="s">
                            Agrupar por Cliente
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="grupo" id="c" value="c">
                          <label class="form-check-label" for="c">
                            Agrupar por Consórcio
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="grupo" id="n" value="n">
                          <label class="form-check-label" for="n">
                            Todas as NFs do Período
                          </label>
                        </div>
                        </div>
                           
                           
                   
                     <button type="submit" class="btn btn-success">Pesquisar</button>
                </form> 
              </div>
<?php
         
            // Verifica se o formulário foi enviado
        if($_POST) {
          $datainicial=$_POST['datainicial'];
          $datafinal=$_POST['datafinal'];
          $grupo=$_POST['grupo'];
              
          ?>


              <div class="col-md-5"> 
                <?php
                $sql1 = "SELECT sum(valornf) as valornf FROM nfsaida WHERE data BETWEEN '$datainicial' AND '$datafinal';";              
                $query1 = mysql_query($sql1);    
                $row1 = mysql_fetch_assoc($query1); 
                $valorfaturado=$row1['valornf'];
                $valorfaturado=number_format($valorfaturado, 2, ',', '.');
              
                $sql2 = "SELECT sum(valornf) as valornf FROM nfentrada  WHERE data BETWEEN '$datainicial' AND '$datafinal';";              
                $query2 = mysql_query($sql2);    
                $row2 = mysql_fetch_assoc($query2); 
                $valorrecebido=$row2['valornf'];
                $valorrecebido=number_format($valorrecebido, 2, ',', '.');

                $sql3 = "SELECT sum(valornf) as valornf FROM nfdevolucao  WHERE data BETWEEN '$datainicial' AND '$datafinal';";              
                $query3 = mysql_query($sql3);    
                $row3 = mysql_fetch_assoc($query3); 
                $valordevolvido=$row3['valornf'];
                $valordevolvido=number_format($valordevolvido, 2, ',', '.');

                ?>
                <h4>Valor Faturado: R$ <?php echo $valorfaturado ?></h4>
                <h4>Valor Recebido: R$ <?php echo $valorrecebido ?></h4>
                <h4>Valor Devolvido: R$ <?php echo $valordevolvido ?></h4>
              </div> 
            </div>      

        
     
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
            <h3>Notas Fiscais de Saída</h3>       
              
          </div> 
      <table class="table table-striped table-sm" id="minhaTabela">
             
              
                <?php 

                  if ($grupo=='s') {
                    $sql = " SELECT cliente.nomecliente, sum(nfsaida.valornf) as valornf,cliente.consorcio FROM nfsaida 
                    INNER JOIN cliente on nfsaida.cnpj=cliente.cnpj 
                    WHERE data BETWEEN '$datainicial' AND '$datafinal'
                    GROUP BY cliente.nomecliente;";
                    ?>
                        <thead>
                            <tr> 
                              <th>Cliente</th> 
                              <th>Valor</th>
                              <th>Consórcio</th>
                            
                            </tr>
                        </thead>  
                  <?php
                } else if ($grupo=='c') {
                  $sql = " SELECT cliente.consorcio, sum(nfsaida.valornf) as valornf FROM nfsaida 
                    INNER JOIN cliente on nfsaida.cnpj=cliente.cnpj 
                    WHERE data BETWEEN '$datainicial' AND '$datafinal'
                    GROUP BY cliente.consorcio;";
                    ?>                  
                
                   <thead>
                            <tr> 
                              <th>Consórcio</th> 
                              <th>Valor</th> 
                             
                            </tr>
                        </thead>  
                   <?php


                }  else  {
                    $sql = "SELECT *, cliente.nomecliente FROM nfsaida 
                    INNER JOIN cliente on nfsaida.cnpj=cliente.cnpj 
                    WHERE data BETWEEN '$datainicial' AND '$datafinal';";
                    ?>
                     <thead>
                        <tr> 
                         <th>Cliente</th> 
                          <th>Vlr. NF</th>                     
                          <th>Numero</th> 
                                             
                          <th>Data</th> 
                          
                          <th>Ações</th> 
                        </tr>
                  </thead>  
                    <?php

                    }
                  
                  ?>
                    <?php                 
                      // Executa consulta SQL
                        $query = mysql_query($sql);  
                      // Enquanto houverem registros no banco de dados
                          while($row = mysql_fetch_array($query)) {
                            if ($grupo=='s') {
                            ?>
                            <tr>
                              <td><?php echo $row['nomecliente']; ?></td> 
                              <td>R$ <?php echo number_format($row['valornf'], 2, ',', '.');?>
                                 <td><?php echo $row['consorcio']; ?></td> 
                              </td>
                            </tr>
                           <?php                                                        
                            } else if ($grupo=='c') {
                              ?>
                              <tr>
                                <td><?php echo $row['consorcio']; ?></td> 
                                <td>R$ <?php echo number_format($row['valornf'], 2, ',', '.');?></td>
                              </tr>
                              <?php
                            }else { 
                           ?>
                              <tr>
                                <td><?php echo $row['nomecliente']; ?></td> 
                                <td>R$ <?php echo number_format($row['valornf'], 2, ',', '.');?>
                                <td><?php echo $row['numeronf']; ?></td>                       
                                <td><?php echo $row['data']; ?></td>
                                <td>
                                  <a title="Excluir Nota Fiscal" class="btn btn-danger" style="font-size:10px;" href="lerxml/deletarnf.php?id=<?php echo $row['chavedeacesso'];?>">
                                  <span class="fas fa-trash-alt"></span>
                                  </a>
                                </td> 
                            </tr>
                        <?php
                        }
                    }
                      ?>
            </tbody>
        </table> 
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        
          <h3>Notas Fiscais de Entrada</h3>
        
          </div>
          

          <table class="table table-striped table-sm" id="minhaTabela1">
                <thead>
                    <tr>
                     
                      <th>Numero</th> 
                      <th>Vlr. NF</th>                      
                      <th>Data</th> 
                      <th>Fornecedor</th> 
                      <th>Ações</th> 
                                     
                    </tr>
                </thead>  
                <tbody>
                  <?php                 
                 
                    $sql = "SELECT *, fornecedor.nomefornecedor FROM nfentrada 
                    INNER JOIN fornecedor on nfentrada.cnpj=fornecedor.cnpj
                     WHERE data BETWEEN '$datainicial' AND '$datafinal'
                    ;";
                        // Executa consulta SQL
                          $query = mysql_query($sql);  
                        // Enquanto houverem registros no banco de dados
                            while($row = mysql_fetch_array($query)) {
                              ?>
                              <tr> 
                                <td><?php echo $row['numeronf']; ?></td> 
                                <td><?php echo $row['valornf']; ?></td>
                                <td><?php echo $row['data']; ?></td>  
                                <td><?php echo $row['nomefornecedor']; ?></td> 
                                <td> 
                                <a title="Excluir Nota Fiscal" class="btn btn-danger" style="font-size:10px;" href="lerxmlfornecedor/deletarnf.php?id=<?php echo $row['chavedeacesso'];?>">
                                 <span class="fas fa-trash-alt"></span>
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
       <script>      
      $(document).ready(function(){
          $('#minhaTabela1').DataTable({
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