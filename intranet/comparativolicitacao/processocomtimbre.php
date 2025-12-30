<?php	
	
	include("../conexao.php");

	 if (isset($_GET['cnpj'])and isset($_GET['codlic'])) {             
          $cnpj=$_GET['cnpj'];
          $codlic=$_GET['codlic'];
          $npedido=$_GET['pedido'];

      }     


	// DADOS DA LICITACAO
	  $sql ="SELECT *, DATE_FORMAT(licitacao.datahomologacao, '%d/%m/%Y ') AS datahomologacao FROM licitacao WHERE codlic='$codlic'";
     $query2 = mysql_query($sql);                  
     $row2 = mysql_fetch_assoc($query2);
     $npregao= $row2['npregao'];
     $nprocesso=$row2['nprocesso'];
     $datahomologacao=$row2['datahomologacao'];  

  //    
     $sql ="SELECT COUNT(resultadolicitacao.codprod) as itenshomologados, COUNT(DISTINCT resultadolicitacao.cnpj) as empresashomologadas FROM resultadolicitacao WHERE idlic='$codlic'"; 
     $query2 = mysql_query($sql);                  
     $row2 = mysql_fetch_assoc($query2);
     $itenshomologados= $row2['itenshomologados'];
     $empresashomologadas= $row2['empresashomologadas'];
   
    
     $sql1 ="SELECT * FROM cliente WHERE CNPJ='$cnpj'";
     $query1 = mysql_query($sql1);                  
     $row1 = mysql_fetch_assoc($query1);
     $nomecliente= $row1['nomecliente'];
     $cnpjm=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5",$row1['cnpj']); 


     $sql = "SELECT COUNT(DISTINCT itensprocesso.codprod) AS itenscomparados, COUNT(DISTINCT pedidodecompra.codprod) AS itenssolicitados
     FROM pedidodecompra INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
     LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
     WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$npedido'  ";
            // Executa consulta SQL
     $query = mysql_query($sql);  
     $row = mysql_fetch_assoc($query);
     $itenscomparados=$row['itenscomparados'];
     $itenssolicitados=$row['itenssolicitados'];
    
     $sql = "SELECT  SUM(pedidodecompra.quantidade * pedidodecompra.vlrunitario)as valordopedido
     FROM pedidodecompra
     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj                     
     WHERE pedidodecompra.pedido='$npedido' and pedidodecompra.idlic='$codlic' and pedidodecompra.cnpj='$cnpj'";

     $query = mysql_query($sql);  
     $row = mysql_fetch_assoc($query);
     $valorpedido=$row['valordopedido'];
   	$valorpedido= number_format($valorpedido, 2, ',', '.');
    

      $sql = "SELECT DATE_FORMAT(pedido.data, '%d/%m/%Y ') AS datapedido FROM pedido WHERE codlic='$codlic' and npedido='$npedido'";
      $query = mysql_query($sql);  
     	$row = mysql_fetch_assoc($query);
     	$datapedido=$row['datapedido'];



     	 $sql2 = "SELECT pedidodecompra.quantidade,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso
                        FROM pedidodecompra 
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
                        LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
                        WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$npedido'
                        GROUP BY pedidodecompra.codprod;";
                       
                          // Executa consulta SQL
                            $query = mysql_query($sql2);  
                          // Enquanto houverem registros no banco de dados
                            
                          while($row = mysql_fetch_array($query)) {
                            if ($row['vlrunitarioprocesso'] != 0) {                                       
                                  $economia=(($row['vlrunitario']* $row['quantidade']) - ($row['vlrunitarioprocesso']*$row['quantidade'])); 
                                        $aux=$aux + $economia; 
                            }; 
                          };
     $aux= number_format($aux, 2, ',', '.');
    	
    $html ='<!DOCTYPE html>';
    $html.='<html>';
   
    $html.='<body style="font-family: verdana; font-size:12px;">';
    $html.='<style type="text/css">


			table, th, td{					  
							  border: 1px solid black;
							 	border-collapse: collapse;
							 	tyle="font-famaly: verdana; 
							 	font-size:12px;
							 	
			}

			
  
     @page {
                margin: 0cm 0cm;
            }

       body {
                margin-top: 3cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 2cm;
                background-image: url("../../img/timbre.png");

            }

	 header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 3cm;
            }

             footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }

	</style>';

		$html .='<header>';
      $html .= '<img src="../../img/header.png" width="100%" height="100%"/>';
      $html .= '</header>';
      $html .= '<footer>';
     	$html .= '<img src="../../img/footer.png" width="100%" height="100%"/>';
      $html .= '</footer>';
 
      $html .= '<table id="table1" align="center" width="100%">';
      $html .= '<thead>';
      $html .= '<tr width="100%">';	
      $html .= '<th align="center">Cód.</th>';
      $html .= '<th align="center">Descrição</th>';
      $html .= '<th align="center">Quant.</th>';;
      $html .= '<th align="center">Vlr. CISA</th>';
      $html .= '<th align="center">Vlr. Unitário</th>';
      $html .= '<th align="center">Economia %</th>';
      $html .= '<th align="center">Economia R$</th>';
      $html .= '</tr>';
      $html .= '</thead>';
      $html .= '<tbody>';	

      $sql = "SELECT pedidodecompra.codprod,produto.descricao,pedidodecompra.quantidade, pedidodecompra.idlic,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso FROM pedidodecompra 
      INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
      INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
      LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
      WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$npedido'
      GROUP BY pedidodecompra.codprod";

                          // Executa consulta SQL
      $query = mysql_query($sql);  
                          // Enquanto houverem registros no banco de dados
      while($row = mysql_fetch_array($query)) {                

      	$html .= '<tr><td align="center">'.$row['codprod']. "</td>";
      	$html .= '<td>'.$row['descricao'].'</td>';
      	$html .= '<td align="center">'.number_format($row['quantidade'], 0, ',', '.')."</td>";                            
      	$html .= '<td WIDTH="50" align="right"> R$ '.number_format($row['vlrunitario'], 4, ',', '.')."</td>";
      	$html .= '<td WIDTH="60" align="right">';
	      	if ($row['vlrunitarioprocesso'] != 0) {
	      		$html .='R$ ';
	      		$html .=number_format($row['vlrunitarioprocesso'], 4, ',', '.');
	     		};
				$html .= "</td>";

      	$html .= '<td align="right">';
      	if ($row['vlrunitarioprocesso'] != 0) {
      		$porcentagem=((($row['vlrunitario']-$row['vlrunitarioprocesso'])/ $row['vlrunitario'])*100); 
      		$porcentagem= number_format($porcentagem, 2, ',', '');
      		$html .=$porcentagem;
      		$html .=' %';
      	}
      	$html .= '</td>';

      	$html .= '<td align="right">';                                
      	if ($row['vlrunitarioprocesso'] != 0) { 
      		$html .='R$ ';                                   
      		$economia=(($row['vlrunitario']* $row['quantidade']) - ($row['vlrunitarioprocesso']*$row['quantidade'])); 
      		$economia= number_format($economia, 2, ',', '.');      		      		
      		$html .=$economia;

      		$valor1=($row['vlrunitario']* $row['quantidade']); 
      		$valor2=($row['vlrunitarioprocesso']* $row['quantidade']); 

      		$aux1= $aux1 + $valor1;
      		$aux2= $aux2 + $valor2;

      		
      	} 

      	$html .= '</td>';
      	$html .= '</tr>';
      } ; 



    //  $percentual= (($aux2 - $aux1)/$aux1) * 100;
  //    $percentual= number_format($percentual, 2, ',', '');

      $percentual=($aux*100)/$valorpedido;
     	$percentual= number_format($percentual, 2, ',', '');

      
      $percentualdositensomparado=($itenscomparados*100)/$itenssolicitados;
      $percentualdositensomparado= number_format($percentualdositensomparado, 2, ',', '');

      

      $html .= '</tbody>';
      $html .= '</table>';

      $html.= '</body>';
      $html.='</html>';
        
//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();

	// Carrega seu HTML
	$dompdf->load_html('
			
			<h2 align="center"> Central de Medicamentos</h2>	
			<h3> Relatório Econômico Financeiro</h3>
		

			<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">
				<tr>  
					<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%">    
						<b>Dados do Processo</b><br>
					</td>
				</tr>
				<tr>  
				 		<td colspan="6" width="100%">
				 		<b>Pregão Eletrônico Nº </b>'.$npregao.'</td>
				 </tr>
				 <tr>  
				 		<td colspan="6" width="100%">
				 		<b>Processo Nº </b>'.$nprocesso.'</td>
				 </tr>
				 <tr>  
				 				<td colspan="2" width="50%"><b>Data de Homologação: </b>'.$datahomologacao.'</td>  
				 				<td colspan="2" width="50%"><b>Itens Homologados: </b>'.$itenshomologados.'</td>
				 				<td colspan="2" width="50%"><b>Empresas Homologadas: </b>'.$empresashomologadas.'</td>
				 </tr>
			</table>
	
		<br>

			<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">
				<tr>  
					<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%">    
						<b>Dados do Cliente</b><br>					
					</td>
				</tr>
			<tr>  
				 		<td colspan="6" width="100%">
				 		<b>Nome: </b>'.$nomecliente.'</td>
				 </tr>
				 <tr>  
				 		<td colspan="6" width="100%">
				 		<b>CNPJ: </b>'.$cnpjm.'</td>
				 </tr>
				 <tr>  
				 		<td colspan="6" width="100%">
				 		<b>Data do Pedido: </b>'.$datapedido.'</td>
				 </tr>
				  <tr>  
				 				<td colspan="3" width="50%"><b>Valor Solicitado: </b>R$ '.$valorpedido.'</td>  
				 				<td colspan="3" width="50%"><b>Itens Solicitados: </b> '.$itenssolicitados.'</td>
				 </tr>
			</table>

<br>		

			<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">
				<tr>  
					<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%">    
						<b>Economia Gerada</b><br>  
						
					</td>
				</tr>
				 <tr>  	
				 				<td colspan="3" width="50%"><b>Itens Comparados: </b> '.$itenscomparados.'</td>	
				 				<td colspan="3" width="50%"><b>Percentual dos Itens Comparado: </b> '.$percentualdositensomparado.' %</td>				 				 
	 </tr>
					<tr>  
				 		<td colspan="6" width="100%">
				 		<b>Valor Economizado: </b> R$ '.$aux.'</td>
				 </tr>
				 <tr>  				 				 
				 			
				 				<td colspan="6" width="50%"><b> Percentual Economizado: </b> '.$percentual.' %</td>  
				 </tr>

			
			</table>

			<br><br>
			<h3> Valor Economizado: R$ '.$aux.'</h3>

			<h3> Percentual Economizado: '.$percentual.' %</h3>
			
'.$html.'
			
		
		


<p style="text-align: center;">
<br>
<br>
<br>


__________________________________ <br>
Central de Medicamentos <br>
2023 <br>

</p>
		


		');


	
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->set_option('defaultFont', 'Times New Roman’');

	//Renderizar o html
	$dompdf->render();


	//Exibibir a página
	$dompdf->stream(
		"'.$nomecliente.'", 
		array(
			"Attachment" =>  true//Para realizar o download somente alterar para true
		)
	);
	
?>