<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Produtos com restrições</title>		
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<script src="../../js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
		
    	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    	<link rel="stylesheet" href="../../css/dashboard.css">

    </head>
	<body>
		<?php include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
	        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
		        <h1 class="h2">Produtos com restrições</h1>	
		       <div class="btn-toolbar mb-2 mb-md-0">
		       	 	<div class="btn-group mr-2">		              
			            <a class="btn btn-warning" href="listar.php" role="button">Relatório dos itens para Adquação</a> 			                          
			        </div> 
		            <div class="btn-group mr-2">		              
			            <a class="btn btn-success" href="importar.php" role="button">Processar Pedido</a> 			                          
			        </div> 
			               	
	                       
		        
		            <div class="btn-group mr-2">		              
			            <a class="btn btn-primary" href="cadastrar.php" role="button">Cadastrar Produto</a> 			                          
			        </div> 
			               	
	            </div>  
			</div> 
			   		
				<table class="table table-striped table-sm" id="minhaTabela">
					<thead>
	                    <tr>                    
	                      <th>Código</th>
	                      <th>Descrição</th> 
	                      <th>Embalagem</th>                        
	                      <th>Ações</th>
	                    </tr>
	                </thead>  
						<tbody>
						<?php
	                    // Inclui o arquivo
	                    	include("../conexao.php");	                    
	                    // Consulta SQL
	                    	$sql = "select fracionamento.id,fracionamento.codprod,fracionamento.embalagem,produto.descricao from fracionamento inner join produto on produto.codprod=fracionamento.codprod ";
	                    // Executa consulta SQL
	                    	$query = mysql_query($sql);  
	                      // Enquanto houverem registros no banco de dados
	                      	while($row = mysql_fetch_array($query)) {
		                        ?>
		                        <tr>                                            	
		                          <td><?php echo $row['codprod']; ?></td>
		                          <td><?php echo $row['descricao']; ?></td> 
		                          <td><?php echo $row['embalagem']; ?></td>                          
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