<?php

                  if (isset($_GET['id'])) {             
                    $codlic=$_GET['id']; 
                    $npregao=$_GET['npregao']; 
                  
                  }    

?>

<!DOCTYPE>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Central de Medicamentos</title>
    
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/dashboard.css">    
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
  </head>
  <body>
    <?php
      // Abre a sessão
      session_start();
      // Verifica se o usuário está logado
    include("cabecalho.php"); ?>
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
       <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2>Estatística do Pregão <?php echo  $npregao ?> </h2>
          <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group mr-2">                  
                  <a class="btn btn-primary" href="index.php" role="button">Voltar</a>                                
              </div> 
                        
              </div> 
        </div>
               <?php 
                include("../conexao.php"); 
                 $sql2="SELECT sum(quantidade * vlrunitario) as valortotal FROM resultadolicitacao where idlic=$codlic";
                        $query2 = mysql_query($sql2);    
                        $row2 = mysql_fetch_assoc($query2);  
                        $valortotal=0;
                        $valortotal=number_format($row2['valortotal'], 2, ',', '.');
                 $sql6="SELECT  SUM(pedidodecompra.quantidade * resultadolicitacao.vlrunitario) as valortotalpedido FROM pedidodecompra, resultadolicitacao WHERE pedidodecompra.idlic=$codlic and resultadolicitacao.idlic=$codlic AND pedidodecompra.codprod=resultadolicitacao.codprod";
                            $query6 = mysql_query($sql6); 
                            $row6 = mysql_fetch_assoc($query6);
                            $valortotalpedido=0;
                            $valortotalpedido=number_format($row6['valortotalpedido'], 2, ',', '.');
                  
                ?>

 
        
        <div  class="col-md-12">
        
                <div class="card mb-4 shadow-sm">        

                    <div class="card-header">
                      <h3 class="card-title pricing-card-title">Valor do Pregão R$ <?php echo   $valortotal ?> -- Valor Pedido R$ <?php echo $valortotalpedido ?></h3>
                    </div>

                  </div>
                  <div class="card-deck mb-3 text-center">
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


                            $sql6="SELECT  SUM(pedidodecompra.quantidade * resultadolicitacao.vlrunitario) as valortotalpedido FROM pedidodecompra, resultadolicitacao WHERE pedidodecompra.idlic=$codlic and resultadolicitacao.idlic=$codlic AND pedidodecompra.pedido=$npedido AND pedidodecompra.codprod=resultadolicitacao.codprod";
                            $query6 = mysql_query($sql6); 
                            $row6 = mysql_fetch_assoc($query6);
                            $valortotalpedido=0;
                            $valortotalpedido=$row6['valortotalpedido'];

                            $aux= $valortotalpedido-$valortotalnfe;
                 ?>  
                <div  class="col-md-6">
                  <div class="card mb-4 shadow-sm">        

                <div class="card-header">
                  <h4 class="my-0 font-weight-normal">Pedido <?php echo  $npedido ?></h4>
                </div>
                <div class="card-body">
                  <h1 class="card-title pricing-card-title">R$ <?php echo $valortotalpedido=number_format($valortotalpedido, 2, ',', '.'); ?></h1>
                  <ul class="list-unstyled mt-3 mb-4">
                    <li>R$<?php echo $valortotalnfe=number_format($valortotalnfe, 2, ',', '.'); ?> Valor recebido</li>
                    <li>R$<?php echo $valortotalnfs=number_format($valortotalnfs, 2, ',', '.'); ?> Valor faturado</li>
                    <li>Email support</li>
                    <li>Help center access</li>
                  </ul>       
                </div>

                     
            
               </div>
                    </div>
          <?php

                            }
                          ?> 
          </div>
        </div>
       </div> 
      </main>
  </body>
</html>