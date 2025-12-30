<!DOCTYPE>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Central de Medicamentos</title>    
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">    
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery-1.11.3.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
    </head>
  <body>




    
    <?php
      // Abre a sessão
      session_start();
      // Verifica se o usuário está logado
      if (isset($_SESSION['login'])) {
      ?>
      
    <?php include("cabecalho.php"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2 >Painel Principal</h2>
       </div>
        <div class="col-md-12">

         <!-- <canvas class="my-4 w-100" id="myChart" width="1500" height="380"></canvas> -->

          <div class= "album py-5 bg-light ">
            <div class="row">
            
               <?php 
                  include("conexao.php"); 

                  $sql = "SELECT * FROM licitacao ORDER BY datahomologacao DESC LIMIT 6"; 

                  $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                  while($row = mysql_fetch_array($query)) {
                      $codlic=$row['codlic'];
                       $sql2="SELECT sum(quantidade * vlrunitario) as valortotal FROM resultadolicitacao where idlic=$codlic";
                        $query2 = mysql_query($sql2);    
                        $row2 = mysql_fetch_assoc($query2);  
                        $valortotal=number_format($row2['valortotal'], 2, ',', '.');
                    ?>
                        <div align="center"  class="col-md-4">
                          <h5> Pregão <?php echo $row['npregao']; ?></h5> 
                           
                          <h6>Valor do pregão: R$ <?php echo $valortotal ?></h6>
                          <?php 
                          
                          $sql3="SELECT * FROM pedido where codlic=$codlic";
                          $query3 = mysql_query($sql3);    
                         
                          
                          while($row3 = mysql_fetch_array($query3)) {
                            $npedido=$row3['npedido'];

                            $sql4="SELECT sum(valornf) as valortotalnfs  FROM notafiscal WHERE codlic=$codlic and pedido=$npedido";
                            $query4 = mysql_query($sql4); 
                            $row4 = mysql_fetch_assoc($query4);
                            $valortotalnfs=$row4['valortotalnfs'];

                            $sql5="SELECT sum(valornf) as valortotalnfe  FROM notafiscalfornecedor WHERE codlic=$codlic and pedido=$npedido";
                            $query5 = mysql_query($sql5); 
                            $row5 = mysql_fetch_assoc($query5);
                            $valortotalnfe=$row5['valortotalnfe'];

                            $sql6="SELECT  SUM(pedidodecompra.quantidade * pedidodecompra.vlrunitario) as valortotalpedido FROM pedidodecompra
                            WHERE pedidodecompra.idlic=$codlic and pedidodecompra.idlic=$codlic AND pedidodecompra.pedido=$npedido AND pedidodecompra.pedido=$npedido AND pedidodecompra.codprod=pedidodecompra.codprod";
                            $query6 = mysql_query($sql6); 
                            $row6 = mysql_fetch_assoc($query6);
                            $valortotalpedido=0;

                            $valortotalpedido=$row6['valortotalpedido'];

                            $porcentagem=0;
                            $porcentagemfaturada=0;

                             if ($valortotalpedido==0){
                              $valortotalpedido=$valortotalpedido;
                            }

                            if ($valortotalnfe !=0 AND $valortotalpedido !=0)  {
                                $porcentagem=($valortotalnfe*100)/ $valortotalpedido;
                               
                            } 

                            if ($valortotalnfe !=0 AND $valortotalnfs!=0)  {                            
                                $porcentagemfaturada=($valortotalnfs*100)/$valortotalnfe;
                                                              
                            } 
                            ?>

                            <h7>Pedido <?php echo $row3['npedido']; ?></h7><br>

                            <?PHP 
                            $valortotalpedido=number_format($valortotalpedido, 2, ',', '.');

                            ?>

                         <h7>Valor do Pedido: R$<?php echo $valortotalpedido ?></h7><br>                                               
                              <div class="progress" style="margin-top:10px">
                                <div class="progress-bar" role="progressbar" style="width:<?php echo $porcentagem?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo $porcentagem= number_format($porcentagem, 2, ',', '');?> % Recebido</div>
                              </div>
                         <!-- -->
                            <h7>Valor recebido: R$<?php echo $valortotalnfe=number_format($valortotalnfe, 2, ',', '.')?></h7><br>
                            <h7>Valor faturado: R$<?php echo $valortotalnfs=number_format($valortotalnfs, 2, ',', '.')?></h7><br> 
                       
                             <div class="progress" style="margin-top:10px">
                                <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo $porcentagemfaturada?>%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?php echo $porcentagemfaturada=number_format($porcentagemfaturada, 2, ',', '');?> % Faturado do valor recebido</div>
                              </div>
                          <?php
                          }
                          ?>
                         <a href="relatorios/estatistica.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>" class="nav-link" align="right">Mais Detalhes</a>         
                        </div>   
                            
                <?php
                      
                  }
                ?>
                
            </div>
          </div>  
        </div> 
        
     
        <h2>Licitações Cadastradas</h2> 
       
       <table class="table table-striped table-sm">                  
                <thead align="center">
                    <tr>                    
                      <th>Cód. Licitação</th>
                      <th>Descrição</th>
                      <th>Data Homologação</th>
                      <th>Ações</th>
                    </tr>
                </thead>                  
                  <tbody align="center">
                    <?php
                    // Inclui o arquivo
                      include("conexao.php");
                      // Consulta SQL
                      $sql = "SELECT * FROM licitacao ORDER BY codlic desc;";
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
                      while($row = mysql_fetch_array($query)) {
                        ?>
                        <tr>                                              
                          <td><?php echo $row['codlic']; ?></td>
                          <td><?php echo $row['npregao']; ?></td>
                          <td><?php echo $row['datahomologacao']; ?></td>
                          <td>
                             
                             <a title="Visualizar Consumo" class="btn btn-success" style="font-size:10px;"
                             href="relatorios/listarprodutoxconsumoxempresa.php?id=<?php echo $row['codlic'];?>&amp;npregao=<?php echo $row['npregao']?>">
                                <span class="fas fa-search"></span>
                              </a> 
                               <a title="Visualizar Consumo por Empresa" class="btn btn-warning" style="font-size:10px;"
                             href="relatorios/listarempresa.php?id=<?php echo $row['codlic'];?>&amp;descricao=<?php echo $row['npregao']?>">
                                <span class="far fa-building"></span>

                              </a> 
                               <a title="Visualizar Consumo por Município" class="btn btn-primary" style="font-size:10px;"
                             href="relatorios/listarmunicipio.php?id=<?php echo $row['codlic'];?>&amp;descricao=<?php echo $row['npregao']?>">
                                <span class="fas fa-home"></span>
                                
                              </a>                          
                          </td>
                        </tr>                         

                      <?php
                    }
                    ?>
                  </tbody>
            </table>
      </main>
 
    <?php
        }else {
          header("Location: 403.php");
        } 
        
        ?>

  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="../js/dashboard2.js"></script>

</html>