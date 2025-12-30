<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
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
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
		        <h1 class="h2">Emitir Notificações</h1>	            
		            
      </div>  
       <div class="col-md-12">
    	 <form method="post" action="gerarata2.php">
         <div class="row">           
           <div class="col-md-6">
             <div class="form-group">
                <label for="npregao">Licitação</label>  
                <select id="npregao" name="npregao" class="form-control">             
                  <option>Selecione...</option>
                  <?php
                    
                    $sql_cli = "SELECT * FROM licitacao ORDER BY datahomologacao DESC";

                    $query_cli = mysql_query($sql_cli);
                    if(mysql_num_rows($query_cli)>0) {
                      while($row_cli = mysql_fetch_array($query_cli)) {
                        ?>
                        <option value="<?php echo $row_cli['npregao'];?>">
                        <?php echo $row_cli['npregao'];?>
                        </option>
                    <?php
                    }
                        }
                    ?>
                </select>
              </div>
              <div class="form-group">
                <label for="cnpj">Fornecedor</label>  
                <select id="cnpj" name="cnpj" class="form-control">             
                  <option>Selecione...</option>
                  <?php
                    
                    $sql_cli = "SELECT * FROM fornecedor ORDER BY nomefornecedor ASC";

                    $query_cli = mysql_query($sql_cli);
                    if(mysql_num_rows($query_cli)>0) {
                      while($row_cli = mysql_fetch_array($query_cli)) {
                        ?>
                        <option value="<?php echo $row_cli['cnpj'];?>">
                        <?php echo $row_cli['nomefornecedor'];?> -
                        <?php echo $row_cli['cnpj'];?>
                        </option>
                    <?php
                    }
                        }
                    ?>
                </select>
              </div>
                  <div class="form-group">
                      <label for="naf">Número da Autorização de Fornecimento</label>
                      <input type="text" name="naf" id="naf" maxlength="60" class="form-control" required value="<?php if(isset($_POST['naf"'])) { echo $_POST['naf']; } ?>">
                  </div>
                </div>
                 <div class="col-md-6"> 
                    <div class="form-group">
                      <label for="noficio">Número do Ofício</label>
                      <input type="text" name="noficio" id="noficio" maxlength="60" class="form-control" required value="<?php if(isset($_POST['noficio'])) { echo $_POST['noficio']; } ?>">
                    </div>
                    <div class="form-group">
                      <label for="datanotificacao">Data da Notificação</label>
                      <input type="date" name="datanotificacao" id="datanotificacao" maxlength="10" class="form-control" required value="<?php if(isset($_POST['datanotificacao'])) {echo $_POST['datanotificacao']; } ?>">                       
                    </div>
                  </div>
                </div>
              <input class="btn btn-success" type="submit">
        </form>               
      </div>
    
    </main>	
  </body>
</html>