
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
      
      <script language="javascript">
      function confirma() {
         var resposta = confirm("Deseja deletar esse registro?");
         if(resposta == true) {
            window.open("deletar.php","_self");
         }
      }
    </script>
  </head>
  <body>
    <?php include("cabecalho.php"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Cadastrar Usuário</h1>  
        <div class="btn-toolbar mb-2 mb-md-0">                 
            <div class="btn-group mr-2">                  
              <a class="btn btn-primary" href="index.php" role="button">Voltar</a> 
                                
            </div>       
          </div>    
      </div>       
         <div class="col-md-5"> 
            <?php
                // Verifica se o formulário foi enviado
                if($_POST) {
                  // Atribui às variáveis os valores preenchidos
                  $email  = $_POST['email'];
                  $senha  = $_POST['senha'];
                  $senha2 = $_POST['senha2'];
                  // Carrega o arquivo
                  include("../conexao.php");
                  // Executa a SQL
                  if($senha != $senha2) {
                    $msg = 3;
                  } else {
                    $sql = "INSERT INTO admin
                        (email,senha)
                        VALUES
                        ('$email',MD5('$senha'));";
                    if(mysql_query($sql)) {
                      // Mensagem de sucesso
                      $msg = 1;
                      // Limpa os valores armazenados
                      unset($_POST);
                    } else {
                      // Mensagem de erro
                      $msg = 2;
                    }
                  }
                }
                ?>
            
            <?php
                      if(isset($msg) and ($msg==1)) {
                        ?>
                        <div class="alert alert-success">
                          <span class="glyphicon glyphicon-ok"></span> 
                          Operação realizada com sucesso!
                        </div>
                        <?php
                      } elseif(isset($msg) and ($msg==2)) {
                        ?>
                        <div class="alert alert-danger">
                          <span class="glyphicon glyphicon-remove"></span> 
                          Ocorreu um erro ao realizar a operação!
                        </div>
                        <?php
                      } elseif(isset($msg) and ($msg==3)) {
                        ?>
                        <div class="alert alert-danger">
                          <span class="glyphicon glyphicon-remove"></span> 
                          Senhas não conferem. Redigite as senhas!
                        </div>
                        <?php
                      }
                    ?>
                  </div>
                  <div class="col-md-12">
                    <form method="post" action="cadastrar.php">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" maxlength="60" class="form-control" required value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
                      </div>
                      <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" maxlength="60" class="form-control" required value="<?php if(isset($_POST['senha'])) { echo $_POST['senha']; } ?>">
                      </div>
                      <div class="form-group">
                        <label for="senha2">Redigite a senha</label>
                        <input type="password" name="senha2" id="senha2" maxlength="60" class="form-control" required value="<?php if(isset($_POST['senha2'])) { echo $_POST['senha2']; } ?>">
                      </div>
                      <input class="btn btn-success" type="submit">
                    </form>
                </div>   
             
         
        </main>   
    
   
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/feather.min.js"></script>
        <script src="js/Chart.min.js"></script>
        <script src="js/dashboard.js"></script>

  </body>
</html>