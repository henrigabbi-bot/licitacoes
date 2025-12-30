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

        if ($_POST) {
            $_SESSION['codprod']=$_POST['codprod']; 
            $_SESSION['validade']=$_POST['validade'];  
        }
             
        $codprod=$_SESSION['codprod'];
        $validade=$_SESSION['validade'];
       
        $id_ped =$_SESSION ['npedido'];
        $id_lic=$_SESSION['idlic'];


			include("cabecalho.php");
      include("../conexao.php"); 
       ?>

		  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
          <h1 class="h2">Enviar e-mail de autorização de validade</h1>   
          <div class="btn-group mr-2">                  
                <a class="btn btn-primary" href="pesquisalistarprodutosporcliente.php" role="button">Voltar</a>
            </div>    
        </div> 
            
           <div class="row">
          
               

                 <div class="col-md-6"> 
      <?php
          if(isset($_SESSION['msg']) AND ($_SESSION['msg']==2)){
                              $erro=$_SESSION['msgerro'];
              ?>
                <div class="alert alert-danger">
                  <?php echo $erro; ?>
                          
                </div>
                  <?php
            
            unset($_SESSION['msg']);
              unset($_SESSION['msgerro']);
          } elseif (isset($_SESSION['msg']) and ($_SESSION['msg']==1)) {
                  $nomecliente=$_SESSION['nomecliente'];
                  $email=$_SESSION['email'];

             ?>  
            <div class="alert alert-success">
            E-mail enviado com sucesso!<br>
            <b>Destinatário: <?php echo $nomecliente; ?></b><br>
            <b>E-mail: <?php echo $email; ?></b>
                 
                          
            </div> 
          <?php
            unset($_SESSION['msg']);
          }           
          
          
          ?>
     </div>                           
                       
                           
                        
                   
                 
            </div>

   
    
         <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        
          <h3>Clientes que Solicitarem o Medicamento</h3>
        
          </div>
          

          <table class="table table-striped table-sm" id="minhaTabela1">
                <thead>
                    <tr>
                     
                      <th>Cliente</th> 
                      <th>Codprod</th>
                       <th>Descrição</th>                       
                      <th>Quantidade</th>                  
                      <th>Ações</th> 
                                     
                    </tr>
                </thead>  
                <tbody>
                  <?php                 
                 
                    $sql = "SELECT  cliente.nomecliente,cliente.cnpj,pedidodecompra.codprod,pedidodecompra.quantidade,produto.descricao  FROM pedidodecompra
INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj    
INNER JOIN produto on pedidodecompra.codprod=produto.codprod                 
WHERE pedidodecompra.pedido='$id_ped' and pedidodecompra.idlic='$id_lic' and pedidodecompra.codprod='$codprod';";
                        // Executa consulta SQL

                          $query = mysql_query($sql);  
                        // Enquanto houverem registros no banco de dados
                            while($row = mysql_fetch_array($query)) {
                              ?>
                              <tr> 
                                <td><?php echo $row['nomecliente']; ?></td> 
                                <td><?php echo $row['codprod']; ?></td>
                                <td><?php echo $row['descricao']; ?></td>
                                <td><?php echo $row['quantidade']; ?></td>  
                              
                                <td> 
                               <a title="Enviar E-mail" class="btn btn-warning" style="font-size:10px;" href="testeemail2.php?quantidade=<?php echo $row['quantidade'];?>&amp;validade= <?php echo $validade?>&amp;cnpj=<?php echo $row['cnpj'];?>&amp;codprod= <?php echo $codprod?>&amp;descricao=<?php echo $row['descricao'];?>"">
                                <span class="fas fa-paper-plane"></span>
                                </a>                                           
                                </td>
                              </tr>
                          <?php
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