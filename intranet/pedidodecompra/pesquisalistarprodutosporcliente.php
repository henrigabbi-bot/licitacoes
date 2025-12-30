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


      if (isset($_GET['npedido']) and isset($_GET['codlic']) ) {             
          $_SESSION['npedido']=$_GET['npedido']; 
          $_SESSION['idlic']=$_GET['codlic'];  
      } 

        $id_ped =$_SESSION ['npedido'];
        $id_lic=$_SESSION['idlic'];


			include("cabecalho.php");
      include("../conexao.php"); 
       ?>

		  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
          <h1 class="h2">Enviar e-mail de autorização de validade</h1>   
         
        </div> 
            
           <div class="row">
            <div class="col-md-5"> 
              <form method="post" action="listarprodutosporcliente.php">        
                        <div class="form-group">
                          <label for="codprod">Selecione o Medicamento</label>  
                          <select id="codprod" name="codprod" class="form-control">             
                            <option>Selecione...</option>
                            <?php
                            
                              $sql_cli = "SELECT produto.codprod,produto.descricao FROM produto";
                              echo $sql_cli;
                              $query_cli = mysql_query($sql_cli);
                              if(mysql_num_rows($query_cli)>0) {
                                while($row_cli = mysql_fetch_array($query_cli)) {
                                  ?>
                                  <option value="<?php echo $row_cli['codprod'];?>">
                                  <?PHP echo $row_cli['codprod'];?> - <?php echo $row_cli['descricao'];?>
                                  </option>
                              <?php
                              }
                                  }
                              ?>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="validade">Validade do medicamento</label>
                          <input type="date" name="validade" id="validade" maxlength="10" class="form-control" required value="<?php if(isset($_POST['validade'])) {echo $_POST['validade']; } ?>">
                        </div>
                      
                   
                     <button type="submit" class="btn btn-success">Listar Clientes</button>
                </form> 


              </div>


            
            </div>      
   
     
          
    
       
     

 </main>

			
  </body>
</html>