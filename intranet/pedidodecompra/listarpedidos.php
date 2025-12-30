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

      if (isset($_GET['npedido']) and isset($_GET['codlic']) ) {             
          $_SESSION['npedido']=$_GET['npedido']; 
          $_SESSION['idlic']=$_GET['codlic'];  
      } 

      

			// Verifica se o usuário está logado
		include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h2">Pedidos de Compras</h1>       
        <div class="btn-group mr-2">
          
          <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
        </div>           
	   </div>  
                    		
			<table class="table table-striped table-sm" id="minhaTabela">              
                <thead>
                    <tr>
                    <th>cnpj</th>  
                        <th>Município</th> 
                        <th>Código</th>                        
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>                  
                   <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");

                       $id_ped =$_SESSION ['npedido'];
                       $id_lic=$_SESSION['idlic'];
                     
                      
                       
                      // Consulta SQL                      
                      $sql = "SELECT pedidodecompra.id, cliente.cnpj,cliente.nomecliente, pedidodecompra.codprod, produto.descricao, quantidade
                        FROM pedidodecompra
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod
                        WHERE pedido='$id_ped' and idlic='$id_lic'";
                       
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr> 
                            <td><?php echo $row['cnpj']; ?></td> 
                            <td><?php echo $row['nomecliente']; ?></td> 
                            <td><?php echo $row['codprod']; ?></td> 
                            <td><?php echo $row['descricao']; ?></td>
                            <td><?php echo $row['quantidade']; ?></td>                           
                            <td>
                                <a title="Editar registro" class="btn btn-warning" style="font-size:10px;" href="editar.php?id=<?php echo $row['id'];?>">
                                <span class="fas fa-edit"></span>
                                </a>
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
  		</main>	
	</body>
</html>