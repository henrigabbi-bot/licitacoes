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

      if (isset($_GET['npedido']) and isset($_GET['codlic']) ) {             
          $_SESSION['npedido']=$_GET['npedido']; 
          $_SESSION['idlic']=$_GET['codlic'];  
      } 

        $id_ped =$_SESSION ['npedido'];
        $id_lic=$_SESSION['idlic'];

      $sql2 ="SELECT * FROM licitacao WHERE codlic='$id_lic'";
      $query2 = mysql_query($sql2);                  
      $row2 = mysql_fetch_assoc($query2);
      $npregao= $row2['npregao'];

		// Verifica se o usuário está logado
		include("cabecalho.php"); ?>
		<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 ">
        <h1 class="h2">Clientes da Previsão de Consumo <?php echo $npregao ?> </h1>       
        <div class="btn-group mr-2">
          
          <a class="btn btn-primary" href="index.php" role="button">Voltar</a>
        </div>           
	   </div>  
                    		
			<table class="table table-striped table-sm" id="minhaTabela">              
                <thead>
                    <tr> 
                        
                         <th>Município</th> 
                         <th>CNPJ</th>                        
                         <th>Valor do Pedido</th>
                        <th>Ações</th>
                      </tr>
                </thead>                  
                   <tbody>
                    <?php
                    // Inclui o arquivo
                     

                     
                     
                    
                       
                      // Consulta SQL                      
                      $sql = "SELECT  cliente.nomecliente,cliente.cnpj, sum(resultadolicitacao.vlrunitario * previsaodeconsumo.quantidade) as valortotal
                      FROM previsaodeconsumo

                      INNER JOIN cliente on previsaodeconsumo.cnpj=cliente.cnpj
                      INNER JOIN resultadolicitacao on resultadolicitacao.codprod=previsaodeconsumo.codprod  
                      WHERE previsaodeconsumo.idlic= '$id_lic' and resultadolicitacao.idlic='$id_lic'
                      GROUP by cliente.nomecliente";
                       
              
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr>  
                            
                            <td><?php echo $row['nomecliente']; ?></td>  
                             <td><?php echo $row['cnpj']; ?></td>                               
                            <td>R$ <?php echo number_format($row['valortotal'], 2, ',', ''); ?></td>                           
                            <td>
                                <a title="Visualizar Itens do Cliente" class="btn btn-success" style="font-size:10px;" href="listarprevisaodocliente.php?cnpj=<?php echo $row['cnpj'];?>">
                                <span class="fas fa-search"></span>
                                </a>
                                 <a title="Incluir item" class="btn btn-primary" style="font-size:10px;" href="cadastraritemdocliente.php?cnpj=<?php echo $row['cnpj'];?>">
                                <span class="fas fa-plus"></span>
                                </a>
                                <a title="Deletar Pedido" class="btn btn-danger" style="font-size:10px;" href="deletar.php?cnpj=<?php echo $row['cnpj'];?>">
                                <span class="fas fa-trash-alt"></span>
                                </a>                         
                            </td>
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