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
		include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	     <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
		    <h1 class="h2">Pedidos de Compras</h1> 
        <div class="btn-group mr-2">
         <a class="btn btn-primary" href="cadastrar.php" role="button">Novo Pedido de Compra</a> 
         
        </div>            
	      </div>        		
			      <table class="table table-striped table-sm" id="minhaTabela">                     
                <thead>
                    <tr>                      
                      <th>Código da Licitação</th>                      
                      <th>Nº Pregão</th>
                      <th>Nº Pedido</th> 
                      <th>Data</th>                       
                      <th>Valor Prog. Ext.</th>          
                      <th>Ações</th>
                    </tr>
                </thead>                  
                   <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");

                      $sql = "SELECT pedido.codlic,pedido.npedido,licitacao.npregao, DATE_FORMAT(pedido.data, '%d/%m/%Y ') AS data_formatada FROM pedido
                      INNER JOIN licitacao on pedido.codlic=licitacao.codlic ORDER BY codlic DESC";

                        // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                          $codlic=$row['codlic'];                         
                          $npregao=$row['npregao']; 
                          $npedido=$row['npedido']; 
                          $data_formatada=$row['data_formatada']; 


                     //  $sql6="SELECT SUM(pedidodecompra.quantidade * valordositensnopedido.vlrunitario) as valortotalpedido FROM pedidodecompra, valordositensnopedido 
                        //    WHERE pedidodecompra.idlic=$codlic and valordositensnopedido.idlic=$codlic AND pedidodecompra.pedido=$npedido AND valordositensnopedido.pedido=$npedido AND pedidodecompra.codprod=valordositensnopedido.codprod";
                        
                     //   $query6 = mysql_query($sql6); 
                     //   $row6 = mysql_fetch_assoc($query6);
                    //    $valortotalpedido=0;

                    //    $valortotalpedido=$row6['valortotalpedido'];     
                      // Consulta SQL                      
                     
                         $sql7="SELECT SUM(pedidodecompra.quantidade * pedidodecompra.vlrunitario) as vlrexterno FROM pedidodecompra  WHERE pedidodecompra.idlic=$codlic AND pedidodecompra.pedido=$npedido";
                        
                        $query7 = mysql_query($sql7); 
                        $row7 = mysql_fetch_assoc($query7);
                        $vlrexterno=0;

                        $vlrexterno=$row7['vlrexterno'];     

                        ?>
                        <tr>                                               
                          <td><?php echo $codlic; ?></td>                         
                          <td><?php echo $npregao; ?></td>
                          <td><?php echo $npedido; ?></td>
                          <td><?php echo $data_formatada; ?></td>                          
                          <td>R$<?php echo $vlrexterno=number_format($vlrexterno, 2, ',', '.'); ?>
                          </td>
                          <td>                            
                              
                               <a title="Visualizar Somatório do Pedido" class="btn btn-success" style="font-size:10px;" href="listarsomatoriodopedido.php?npedido=<?php echo $row['npedido'];?>&amp;codlic=<?php echo $row['codlic']?>">
                                  <span class="fas fas fa-search"></span>
                              </a>
                              <a title="Visualizar Pedido por Cliente" class="btn btn-info" style="font-size:10px;" href="listarclientesdopedido.php?npedido=<?php echo $row['npedido'];?>&amp;codlic=<?php echo $row['codlic']?>">
                                  <span class="fas fa-home"></span>
                              </a>

                            
                               <a title="Enviar e-mail de Validade" class="btn btn-warning" style="font-size:10px;" href="pesquisalistarprodutosporcliente.php?npedido=<?php echo $row['npedido'];?>&amp;codlic=<?php echo $row['codlic']?>">
                                  <span class="far fa-envelope"></span>
                              </a>
                              
                               <a title="Importar Pedido" class="btn btn-primary" style="font-size:10px;"  href="importarpedidodecompra/importar.php?codlic=<?php echo $row['codlic'];?>&amp;npedido=<?php echo $row['npedido']?>">
                                <span class="fas fa-file-import"></span>
                              </a>
                          
                               <a title="Excluir Pedido" class="btn btn-danger" style="font-size:10px;"  href="deletar.php?codlic=<?php echo $row['codlic'];?>&amp;npedido=<?php echo $row['npedido']?>">
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
	</body>
</html>