<!DOCTYPE>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Central de Medicamentos</title>
    
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/dashboard.css">	
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">	
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/jquery-1.11.3.min.js"></script>
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
		    	<h1 class="h2">Licitações Cadastradas</h1>	            
		        <div class="btn-group mr-2">		              
			        <a class="btn btn-primary" href="cadastrar.php" role="button">Cadastrar Licitação</a>
			    </div>    
			 </div>        		
			 <table class="table table-striped table-sm" id="minhaTabela">                   
                <thead>
                    <tr align="center"> 
                    <th>ID</th>                   
                      <th>Município</th>
                      <th>Nº Pregão</th>
                      <th>Nº Processo</th>
                      <th>Data de Homologação</th>
                      <th>Nº Itens</th>
                      <th>Vlr. Licitação</th> 
                      <th>Ativo</th>                      
                      <th>Ações</th>
                    </tr>
                </thead>                  
                  <tbody>
                    <?php
                    // Inclui o arquivo
                      include("../conexao.php");
                      // Consulta SQL
                      $sql = "SELECT comparativo.codlic,comparativo.npregao, comparativo.nprocesso, DATE_FORMAT(comparativo.datahomologacao, '%d/%m/%Y ') AS data_formatada, comparativo.municipio, COUNT(itensprocesso.codprod) as itens ,SUM(itensprocesso.quantidade * itensprocesso.vlrunitario) as valortotal, comparativo.ativo FROM comparativo LEFT JOIN itensprocesso on itensprocesso.codlic=comparativo.codlic GROUP BY comparativo.codlic;";

                                          // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                         $valortotal =number_format($row['valortotal'], 2, ',', '.');
                        ?>
                        <tr align="center" style="font-size:13px"> 
                          <td><?php echo $row['codlic']; ?></td>
                          <td><?php echo $row['municipio']; ?></td>
                          <td><?php echo $row['npregao']; ?></td>
                          <td><?php echo $row['nprocesso']; ?></td>                          
                          <td><?php echo $row['data_formatada'];?></td>                         
                          <td><?php echo $row['itens']; ?></td>
                          <td>R$ <?php echo $valortotal; ?></td>
                          <td><?php echo $row['ativo']; ?></td>                          
                          <td>
                            <a title="Visualizar Itens da Licitação" class="btn btn-success" style="font-size:10px;" href="itenslicitacao.php?codlic=<?php echo $row['codlic'];?>">
                                <span class="fas fa-search"></span>
                            </a>
                            <a title="Incluir item" class="btn btn-primary" style="font-size:10px;" href="cadastraritemlicitacao.php?codlic=<?php echo $row['codlic'];?>">
                                <span class="fas fa-plus"></span>
                            </a>
                            <a title="Editar registro" class="btn btn-warning" style="font-size:10px;" href="editar.php?id=<?php echo $row['codlic'];?>">
                              <span class="fas fa-edit"></span>
                            </a>                               
                            <a title="Deletar registro" class="btn btn-danger" style="font-size:10px;" href="deletar.php?id=<?php echo $row['codlic'];?>">
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
              
                }

            });
      });
    </script>
	</body>
</html>