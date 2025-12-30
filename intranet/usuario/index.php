
<!DOCTYPE html>

<html lang="en">
  <head>
      <meta charset="utf-8"> 
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">      
      <title>Central de Medicamentos</title>     
      <link rel="stylesheet" href="../../css/bootstrap.min.css">
      <link rel="stylesheet" href="../../css/dashboard.css">        
     
      <script src="../../js/jquery-1.11.3.min.js"></script>
      <script src="../../js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
     
  </head>
  <body>
    <?php include("cabecalho.php"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Usuários Cadastrados</h1> 
        <div class="btn-toolbar mb-2 mb-md-0">                 
            <div class="btn-group mr-2">                  
              <a class="btn btn-primary" href="cadastrar.php" role="button">Cadastrar Usuário</a> 
                                
            </div>       
          </div>      
      </div>   
      <div class="table-responsive">
               <table class="table table-striped table-sm">                  
                  <thead>
                    <tr>
                      <th>#ID</th>
                      <th>Email</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL
                      $sql = "SELECT * FROM admin ORDER BY email ASC;";
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr>
                          <td><?php echo $row['id']; ?></td>
                          <td><?php echo $row['email']; ?></td>
                          <td>
                            
                               <a title="Deletar registro" class="btn btn-danger" style="font-size:10px;" href="deletar.php?id=<?php echo $row['id'];?>">
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
    
   
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/feather.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/dashboard.js"></script>

  </body>
</html>