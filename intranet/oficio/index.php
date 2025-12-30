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
          <h1 class="h2">Emitir Notificação Extrajudicial</h1>   
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
                            $sql_cli = "SELECT * FROM licitacao";

                            $query_cli = mysql_query($sql_cli);
                            if(mysql_num_rows($query_cli)>0) {
                              while($row_cli = mysql_fetch_array($query_cli)) {
                                ?>
                                <option value="<?php echo $row_cli['codlic'];?>">
                                Pregão
                                <?php echo $row_cli['npregao'];?> -- Processo
                                <?php echo $row_cli['nprocesso'];?>
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
         
                        
          ?>

       
     
       
      
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        
          <h3>Fornecedores do Pregão <?php echo $licitacao; ?>
          </h3>
        
          </div>
          

          <table class="table table-striped table-sm" id="minhaTabela1">
                <thead>
                    <tr>
                     
                                           
                      <th>Cnpj</th> 
                      <th>Fornecedor</th> 
                      <th>Ações</th> 
                                     
                    </tr>
                </thead>  
                <tbody>
                  <?php                 
                 
                    $sql = "SELECT fornecedor.nomefornecedor,fornecedor.cnpj  FROM resultadolicitacao
                  INNER JOIN fornecedor on resultadolicitacao.cnpj=fornecedor.cnpj
                  WHERE idlic = '$licitacao'
                   GROUP BY fornecedor.cnpj;
                    ;";
                        // Executa consulta SQL
                          $query = mysql_query($sql);  
                        // Enquanto houverem registros no banco de dados
                            while($row = mysql_fetch_array($query)) {
                              ?>
                              <tr> 
                          
                                <td><?php echo $row['cnpj']; ?></td>  
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