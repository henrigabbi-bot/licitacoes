
<?php
session_start();


?>

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
			

			
			include("cabecalho.php"); ?>
		  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
          <h1 class="h2">Motoristas Cadastrados</h1>              
          <div class="btn-group mr-2">                  
              <a class="btn btn-primary" href="cadastrar.php" role="button">Cadastrar Mororista</a>
          </div>    
       </div> 
       <div class="col-md-6"> 
      <?php
          if(isset($_SESSION['msg']) AND ($_SESSION['msg']==2)){
          
              ?>
                <div class="alert alert-danger">
                  Usuario não pode ser deletado!
                          
                </div>
                  <?php
            
            unset($_SESSION['msg']);

          } elseif (isset($_SESSION['msg']) and ($_SESSION['msg']==1)) {
             ?>  
            <div class="alert alert-success">
                  Operação realizada com sucesso!
                          
            </div> 
          <?php
            unset($_SESSION['msg']);
          }           
          
          
          ?>
     </div>     
        <table class="table table-striped table-sm" id="minhaTabela">                  
                <thead>
                    <tr>
                      <th>Nome</th>
                      <th>CPF</th>                      
                      <th>RG</th>
                      <th>Município</th>
                      <th>Ações</th>

                    </tr>
                </thead>                  
                  <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL
                      $sql = "SELECT motorista.nome, motorista.cpf, motorista.rg, cliente.nomecliente FROM motorista
                        INNER JOIN cliente on motorista.cnpj=cliente.cnpj
                      ORDER BY nome ASC;";
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados                     
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr>                        	
                          <td><?php echo $row['nome']; ?></td>
                          <td><?php echo $row['cpf']; ?></td>  
                          <td><?php echo $row['rg']; ?></td>                   
                         
                          <td><?php echo $row['nomecliente']; ?></td>                          
                          <td>
                             <a title="Editar registro" class="btn btn-warning" style="font-size:10px;" href="editar.php?cpf=<?php echo $row['cpf'];?>">
                              <span class="fas fa-edit"></span>
                              </a>
                             <a title="Deletar registro" class="btn btn-danger" style="font-size:10px;" href="deletar.php?cpf=<?php echo $row['cpf'];?>">
                                <span class="fas fa-trash-alt"></span>
                             </a>                         
                          </td>
                        </tr>
                      <?php
                    }
                    ?>
                   
                  </tbody>
            </table> 
              
      </main> 
      <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
      <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    
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
              
                }

            });
      });
    </script>
  </body>
</html>