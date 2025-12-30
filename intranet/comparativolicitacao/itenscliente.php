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
      include("../conexao.php");

       if (isset($_GET['cnpj'])and isset($_GET['codlic'])) {             
          $cnpj=$_GET['cnpj'];
          $id_lic=$_GET['codlic'];
          $npedido=$_GET['pedido'];

      } 
     
    
      
     

      $sql1 ="SELECT * FROM cliente WHERE CNPJ='$cnpj'";
      $query1 = mysql_query($sql1);                  
      $row1 = mysql_fetch_assoc($query1);
      $nomecliente= $row1['nomecliente'];

      $sql2 ="SELECT * FROM licitacao WHERE codlic='$id_lic'";
      $query2 = mysql_query($sql2);                  
      $row2 = mysql_fetch_assoc($query2);
      $npregao= $row2['npregao'];

			// Verifica se o usuário está logado
		include("cabecalho.php"); ?>

		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h2>Pedido de Compra - Cliente: <?php echo $nomecliente?> - Pregão <?php echo $npregao ?> - Pedido <?php echo $npedido ?></h2>  

        <div class="btn-group mr-2">          
          <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
        </div>           
	   </div> 
    
             		
			<table class="table table-striped table-sm" id="minhaTabela">              
                <thead>
                     <tr align="center" style="font-size:12px">  
                        
                        <th>Cod</th> 
                        <th>Produto</th> 
                        <th>Quantidade</th>
                        <th>Vlr. Unit.</th>
                        <th>Vlr. Total.</th>
                         
                      </tr>
                </thead>                  
                   <tbody>
                    <?php
                    // Inclui o arquivo
                      
                        
                      // Consulta SQL                      
                      $sql = "SELECT  pedidodecompra.id,cliente.cnpj ,pedidodecompra.codprod,produto.descricao,pedidodecompra.quantidade ,pedidodecompra.vlrunitario, (pedidodecompra.quantidade * pedidodecompra.vlrunitario) as valor
                        FROM pedidodecompra
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod
                        
                        WHERE pedidodecompra.pedido='$npedido' and pedidodecompra.idlic='$id_lic' AND pedidodecompra.cnpj='$cnpj' order by pedidodecompra.codprod asc";
                       
                      
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                         <tr align="center" style="font-size:12px">   
                              
                            <td><?php echo $row['codprod']; ?></td>  
                             <td><?php echo $row['descricao']; ?></td>
                             <td><?php echo $row['quantidade']; ?></td>                           
                                                         
                            <td>R$ <?php echo number_format($row['vlrunitario'], 4, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($row['valor'], 2, ',', ''); ?></td>
                        </tr>
                      <?php
                    }
                    ?>
                  </tbody>
            </table>
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
                          "infoFiltered": "(filtrado de _MAX_ registros no total)",
                          "search":         "Procurar:"   
                    
                      }, 
                       dom: 'Bfrtip',
              buttons: [
                  'csv', 'excel', 'pdf'
                      ]
                    });
              });
                </script>
  		</main>	
	</body>
</html>