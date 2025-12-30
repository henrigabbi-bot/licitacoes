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
          <h1 class="h2"> Gerar Notificação </h1>   
          <div class="btn-group mr-2">                  
                <a class="btn btn-primary" href="../index.php" role="button">Voltar</a>
            </div>    
        </div> 
            
           <div class="row">
            <div class="col-md-5"> 
              <form method="post" action="index2.php">                                
                      <div class="form-group">
                          <label for="codlic">Licitação</label>  
                          <select id="codlic" name="codlic" class="form-control">             
                            <option>Selecione...</option>
                            <?php
                              
                              $sql_cli = "SELECT * FROM licitacao ORDER BY datahomologacao DESC";

                              $query_cli = mysql_query($sql_cli);
                              if(mysql_num_rows($query_cli)>0) {
                                while($row_cli = mysql_fetch_array($query_cli)) {
                                  ?>
                                  <option value="<?php if(isset($_POST['codlic'])) { echo $_POST['codlic'];}?> ">
                                   <?php echo $row_cli['codlic'];                                   
                                  
                                  ?>
                                  </option>
                              <?php
                              }
                                  }
                              ?>
                          </select>
                        </div>
                       
                      <div class="form-group">
                        <label for="noficio">Número do Ofício</label>
                        <input type="text" name="noficio" id="noficio" maxlength="60" class="form-control" required value="<?php if(isset($_POST['noficio'])) { echo $_POST['noficio']; } ?>">
                      </div>


                           
                           
                   
                     <button type="submit" class="btn btn-success">Pesquisar</button>
                </form> 
              </div>
            </div>
<?php
         
            // Verifica se o formulário foi enviado
        if($_POST) {
       
          $codlic=$_POST['codlic'];    

          echo $codlic;
          ?>
                   
     
          
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        
          <h3>Fornecedores do Pregão</h3>
        
          </div>
          
          <button id="button">Delete selected row</button>
          <table class="table table-striped table-sm" id="minhaTabela1">
                <thead>
                    <tr>
                                           
                      <th>Fornecedor</th> 
                      <th>CNPJ</th> 
                      <th> Nº Oficio </th>
                      <th>Nº AF </th>
                      <th>Ações</th> 
                      
                                     
                    </tr>
                </thead>  
                <tbody>
                  <?php                 
                 
                    $sql = "SELECT fornecedor.nomefornecedor,fornecedor.cnpj FROM resultadolicitacao
                  INNER JOIN fornecedor on resultadolicitacao.cnpj=fornecedor.cnpj
                  WHERE idlic = '162'
                   GROUP BY fornecedor.nomefornecedor
                    ;";

                 
                        // Executa consulta SQL
                          $query = mysql_query($sql);  
                        // Enquanto houverem registros no banco de dados
                            while($row = mysql_fetch_array($query)) {
                              ?>
                              <tr>                          
                              
                                <td><?php echo $row['nomefornecedor']; ?></td> 
                                <td><?php echo $row['cnpj']; ?></td> 
                                <td><input type="text" id="Nof" name="Nof" value=""></td> 
                                <td><input type="text" id="Naf" name="Naf" value=""></td>                                
                                <td> 
                                                                        
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
    <script src="//code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> 
    
   <script src="//cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>  
    
    <script>      
     $(document).ready(function() {
    var table = $('#minhaTabela1').DataTable();
 
    $('#minhaTabela1 tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );
    </script>

			
  </body>
</html>