<?php	
	
	include("../conexao.php");

	 if (isset($_GET['cnpj'])and isset($_GET['codlic'])) {             
          $cnpj=$_GET['cnpj'];
          $codlic=$_GET['codlic'];
          $npedido=$_GET['pedido'];

      }     

// TESTE PEDIDO DE FEVEREIRO PREGÃO 03/2023

// VARIAVEL PARA DIFINIR A LICITAÇÃO     
			$licitacaofixa="167";  
			$pedidofixo="2";
			$descricaopedido="Fevereiro/2023";

     $sql ="SELECT *, DATE_FORMAT(licitacao.datahomologacao, '%d/%m/%Y ') AS datahomologacao FROM licitacao WHERE codlic='$licitacaofixa'";
     $query2 = mysql_query($sql);                  
     $row2 = mysql_fetch_assoc($query2);
     $npregao2= $row2['npregao'];
     $nprocesso2=$row2['nprocesso'];
     $datahomologacao2=$row2['datahomologacao'];  

//  ITENS E EMPRESA HOMOLOGADAS  
     $sql ="SELECT COUNT(resultadolicitacao.codprod) as itenshomologados, COUNT(DISTINCT resultadolicitacao.cnpj) as empresashomologadas FROM resultadolicitacao WHERE idlic='$licitacaofixa'"; 
     $query2 = mysql_query($sql);                  
     $row2 = mysql_fetch_assoc($query2);
     $itenshomologados2= $row2['itenshomologados'];
     $empresashomologadas2= $row2['empresashomologadas'];

// ITENS SOLICITADOS E ITENS COMPARADOS
	     $sql = "SELECT COUNT(DISTINCT itensprocesso.codprod) AS itenscomparados, COUNT(DISTINCT pedidodecompra.codprod) AS itenssolicitados
	     FROM pedidodecompra INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
	     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
	     LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$licitacaofixa' AND pedidodecompra.cnpj='$cnpj' 
	     WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$licitacaofixa' and pedidodecompra.pedido='$pedidofixo'  ";
	    
	     $query = mysql_query($sql);  
	     $row = mysql_fetch_assoc($query);
	     $itenscomparados2=$row['itenscomparados'];
	     $itenssolicitados2=$row['itenssolicitados'];
    
    // VALOR DO PEDIDO
     $sql = "SELECT  SUM(pedidodecompra.quantidade * pedidodecompra.vlrunitario)as valordopedido
     FROM pedidodecompra
     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj                     
     WHERE pedidodecompra.pedido='$pedidofixo' and pedidodecompra.idlic='$licitacaofixa' and pedidodecompra.cnpj='$cnpj'";

     $query = mysql_query($sql);  
     $row = mysql_fetch_assoc($query);
     $valorpedido2=$row['valordopedido'];
   		$valorpedido2= number_format($valorpedido2, 2, ',', '.');
    
			// DATA DO PEDIDO
      $sql = "SELECT DATE_FORMAT(pedido.data, '%d/%m/%Y ') AS datapedido FROM pedido WHERE codlic='$licitacaofixa' and npedido='$pedidofixo'";
      $query = mysql_query($sql);  
     	$row = mysql_fetch_assoc($query);
     	$datapedido2=$row['datapedido'];


      // ECONOMIA GERADA EM REAIS
     	 $sql2 = "SELECT pedidodecompra.quantidade,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso
                        FROM pedidodecompra 
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
                        LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$licitacaofixa' AND pedidodecompra.cnpj='$cnpj' 
                        WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$licitacaofixa' and pedidodecompra.pedido='$pedidofixo'
                        GROUP BY pedidodecompra.codprod;";
                       
                          // Executa consulta SQL
                            $query = mysql_query($sql2);  
                          // Enquanto houverem registros no banco de dados
                            
                          while($row = mysql_fetch_array($query)) {
                            if ($row['vlrunitarioprocesso'] != 0) {                                       
                                  $economia=(($row['vlrunitario']* $row['quantidade']) - ($row['vlrunitarioprocesso']*$row['quantidade'])); 
                                        $aux2=$aux2 + $economia; 
                            }; 
                          };
     $aux2= number_format($aux2, 2, ',', '.');

		//PERCENTUAL DE ITENS COMPRARADOS

		 $percentualdositensomparado2=($itenscomparados2*100)/$itenssolicitados2;
     $percentualdositensomparado2= number_format($percentualdositensomparado2, 2, ',', '');

    // PERCENTUAL ECONOMIZADO

     $percentualeconomizado2=($aux2*100)/$valorpedido2;
     $percentualeconomizado2= number_format($percentualeconomizado2, 2, ',', '');



      $html5.='<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">';
		$html5.='	<tr> '; 
		$html5.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%">';    
		$html5.='	<b>Pedido de Compra '.$pedidofixo.' - '.$descricaopedido.'</b><br>';					
		$html5.='</td>';
		$html5.='	</tr>';
			
		$html5.='<tr>'; 
		$html5.='<td colspan="6" width="100%">';
		$html5.='<b>Data do Pedido: </b>'.$datapedido2.'</td>';
		$html5.='</tr>';
		$html5.='<tr>'; 
		$html5.='<td colspan="3" width="50%"><b>Valor Solicitado: </b>R$ '.$valorpedido2.'</td>';  
		$html5.='<td colspan="3" width="50%"><b>Itens Solicitados: </b> '.$itenssolicitados2.'</td>';
		$html5.='</tr>';
;
		$html5.='<tr>';  
		$html5.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%">';    
		$html5.='<b>Economia Gerada no Pedido</b><br>'; 
		$html5.='</td>';
		$html5.='</tr>';
		$html5.='<tr>';
		$html5.='<td colspan="6" width="100%">';
		$html5.='	<b>Valor Economizado: </b> R$ '.$aux2.'</td>';
		$html5.='</tr>';
		$html5.='<tr>'; 
		$html5.='<td colspan="6" width="50%"><b> Percentual Economizado: </b> '.$percentualeconomizado2.' %</td>'; 
		$html5.='</tr>';
		$html5.='<tr>'; 	
		$html5.='<td colspan="3" width="50%"><b>Itens Comparados: </b>'.$itenscomparados2.'</td>';	
		$html5.='<td colspan="3" width="50%"><b>Percentual dos Itens Comparado: </b> '.$percentualdositensomparado2.' %</td>';				 				 
		$html5.=' </tr>';
		
		$html5.='</table>';
		$html5.='<br>';
		




/// AQUI TERMINA TESTE DO PREGÃO 03/2022


/////////
////
///


	// DADOS DA LICITACAO
	  $sql ="SELECT *, DATE_FORMAT(licitacao.datahomologacao, '%d/%m/%Y ') AS datahomologacao FROM licitacao WHERE codlic='$codlic'";
     $query2 = mysql_query($sql);                  
     $row2 = mysql_fetch_assoc($query2);
     $npregao= $row2['npregao'];
     $nprocesso=$row2['nprocesso'];
     $datahomologacao=$row2['datahomologacao'];  

  //  ITENS E EMPRESA HOMOLOGADAS  
     $sql ="SELECT COUNT(resultadolicitacao.codprod) as itenshomologados, COUNT(DISTINCT resultadolicitacao.cnpj) as empresashomologadas FROM resultadolicitacao WHERE idlic='$codlic'"; 
     $query2 = mysql_query($sql);                  
     $row2 = mysql_fetch_assoc($query2);
     $itenshomologados= $row2['itenshomologados'];
     $empresashomologadas= $row2['empresashomologadas'];
   
  // DADOS DO CLIENTE  
     $sql1 ="SELECT * FROM cliente WHERE CNPJ='$cnpj'";
     $query1 = mysql_query($sql1);                  
     $row1 = mysql_fetch_assoc($query1);
     $nomecliente= $row1['nomecliente'];
     $cnpjm=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5",$row1['cnpj']); 

   // NUMERO DE PEDIDOS DA LICITAÇÃO
     $sql = "SELECT COUNT(pedido.npedido) AS ndepedidos FROM pedido WHERE codlic='$codlic'";
     $query = mysql_query($sql);  
     $row = mysql_fetch_assoc($query);
     $ndepedidos=$row['ndepedidos'];


    $html ='<!DOCTYPE html>';
    $html.='<html>';   
    $html.='<body style="font-family: verdana; font-size:12px;">';
    $html3.='<style type="text/css">


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

	  	$html3 .='<header>';
      $html3 .= '<img src="../../img/header.png" width="100%" height="100%"/>';
      $html3 .= '</header>';
      $html3 .= '<footer>';
     	$html3 .= '<img src="../../img/footer.png" width="100%" height="100%"/>';
      $html3 .= '</footer>';
 
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

//
      $sql = "SELECT pedidodecompra.codprod,produto.descricao,pedidodecompra.quantidade, pedidodecompra.idlic,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso FROM pedidodecompra 
      INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
      INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
      LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
      WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$npedido'
      GROUP BY pedidodecompra.codprod";

      $query = mysql_query($sql);  
                         
      while($row = mysql_fetch_array($query)) {                

      	$html.= '<tr><td align="center">'.$row['codprod']. "</td>";
      	$html.= '<td>'.$row['descricao'].'</td>';
      	$html.= '<td align="center">'.number_format($row['quantidade'], 0, ',', '.')."</td>";                            
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

      		//$aux1= $aux1 + $valor1;
      		//$aux2= $aux2 + $valor2;

      	} 

      	$html.= '</td>';
      	$html.= '</tr>';
      } ; 

     // $percentual= (($aux2 - $aux1)/$aux1) * 100;
      //$percentual= number_format($percentual, 2, ',', '');  
 
      $html .= '</tbody>';
      $html .= '</table>';
      $html.= '</body>';
      $html.='</html>';

     $pedidoaux=1;
     While ( $pedidoaux <=$ndepedidos) {     	
   

	// ITENS SOLICITADOS E ITENS COMPARADOS
	     $sql = "SELECT COUNT(DISTINCT itensprocesso.codprod) AS itenscomparados, COUNT(DISTINCT pedidodecompra.codprod) AS itenssolicitados
	     FROM pedidodecompra INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
	     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
	     LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
	     WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$pedidoaux'  ";
	    
	     $query = mysql_query($sql);  
	     $row = mysql_fetch_assoc($query);
	     $itenscomparados=$row['itenscomparados'];
	     $itenssolicitados=$row['itenssolicitados'];
    
  // VALOR DO PEDIDO
     $sql = "SELECT  SUM(pedidodecompra.quantidade * pedidodecompra.vlrunitario)as valordopedido
     FROM pedidodecompra
     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj                     
     WHERE pedidodecompra.pedido='$pedidoaux' and pedidodecompra.idlic='$codlic' and pedidodecompra.cnpj='$cnpj'";

     $query = mysql_query($sql);  
     $row = mysql_fetch_assoc($query);
     $valorpedido=$row['valordopedido'];
   		$valorpedido= number_format($valorpedido, 2, ',', '.');
    
			// DATA DO PEDIDO
      $sql = "SELECT DATE_FORMAT(pedido.data, '%d/%m/%Y ') AS datapedido FROM pedido WHERE codlic='$codlic' and npedido='$pedidoaux'";
      $query = mysql_query($sql);  
     	$row = mysql_fetch_assoc($query);
     	$datapedido=$row['datapedido'];


      // ECONOMIA GERADA EM REAIS
     	 $sql2 = "SELECT pedidodecompra.quantidade,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso
                        FROM pedidodecompra 
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
                        LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$codlic' AND pedidodecompra.cnpj='$cnpj' 
                        WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$codlic' and pedidodecompra.pedido='$pedidoaux'
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
     //$aux= number_format($aux, 2, ',', '.');

		//PERCENTUAL DE ITENS COMPRARADOS

		 $percentualdositensomparado=($itenscomparados*100)/$itenssolicitados;
     $percentualdositensomparado= number_format($percentualdositensomparado, 2, ',', '');

    // PERCENTUAL ECONOMIZADO

     $percentualeconomizado=($aux*100)/$valorpedido;
     $percentualeconomizado= number_format($percentualeconomizado, 2, ',', '');


    list ($dia, $mes, $ano) = split ('[/.-]', $datapedido);



    //Pega o mes em numeral e retorna em descritivo.
    if ($mes == '01') {
    	$mes='Janeiro';
    }else if ($mes =='2'){
    	$mes='Fevereiro';
    }else if ($mes =='3'){
    	$mes='Março';
    }else if ($mes =='4'){
    	$mes='Abril';
    }else if ($mes =='5'){
    	$mes='Maio';
    }else if ($mes =='6'){
    	$mes='Junho';
    }else if ($mes =='7'){
    	$mes='Julho';
    }else if ($mes =='8'){
    	$mes='Agosto';
    }else if ($mes =='9'){
    	$mes='Setembro';
    }else if ($mes =='10'){
    	$mes='Outubro';
    }else if ($mes =='11'){
    	$mes='Novembro';    
		}else {
			$mes='Dezembro';

		};

    $html2.='<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">';
		$html2.='	<tr> '; 
		$html2.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%">';    
		$html2.='	<b>Pedido de Compra '.$pedidoaux.' - '.$mes.'/'.$ano.'</b><br>';					
		$html2.='</td>';
		$html2.='	</tr>';
			
		$html2.='<tr>'; 
		$html2.='<td colspan="6" width="100%">';
		$html2.='<b>Data do Pedido: </b>'.$datapedido.'</td>';
		$html2.='</tr>';
		$html2.='<tr>'; 
		$html2.='<td colspan="3" width="50%"><b>Valor Solicitado: </b>R$ '.$valorpedido.'</td>';  
		$html2.='<td colspan="3" width="50%"><b>Itens Solicitados: </b> '.$itenssolicitados.'</td>';
		$html2.='</tr>';
;
		$html2.='<tr>';  
		$html2.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%">';    
		$html2.='<b>Economia Gerada no Pedido</b><br>'; 
		$html2.='</td>';
		$html2.='</tr>';
		$html2.='<tr>';
		$html2.='<td colspan="6" width="100%">';
		$html2.='	<b>Valor Economizado: </b> R$ '.$aux.'</td>';
		$html2.='</tr>';
		$html2.='<tr>'; 
		$html2.='<td colspan="6" width="50%"><b> Percentual Economizado: </b> '.$percentualeconomizado.' %</td>'; 
		$html2.='</tr>';
		$html2.='<tr>'; 	
		$html2.='<td colspan="3" width="50%"><b>Itens Comparados: </b>'.$itenscomparados.'</td>';	
		$html2.='<td colspan="3" width="50%"><b>Percentual dos Itens Comparado: </b> '.$percentualdositensomparado.' %</td>';				 				 
		$html2.=' </tr>';
		
		$html2.='</table>';
		$html2.='<br>';
	
    
    $pedidoaux++;
		
		$valortotal=$valortotal + $aux;  
		$valortotalpedido=$valortotalpedido	+ $valorpedido;

  	};

 // SOMA O VALOR ECONOMIZADO NOS PEDIDO MAIS O PEDIDO TESTE
  $valortotaleconomizado=$valortotal+$aux2;

   // SOMA O VALOR DOS PEDIDOS MAIS O PEDIDO TESTE
  $valortotalpedido=$valortotalpedido	+ $valorpedido2;
        
//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();

	// Carrega seu HTML
	$dompdf->load_html('
			
			<h2 align="center"> Central de Medicamentos</h2>	
			<h3 align="center"> '.$nomecliente.' - Relatório Econômico Financeiro</h3>
			
				
<br>		<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">
				<tr>  
					<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="14"; font-size:14px;">    
						<b>Informações do Processo Eletrônico</b><br>
					</td>
				</tr>
				<tr>  
				 		<td colspan="6" width="100%">
				 		<b>Registro de Preços Eletrônico Nº </b>'.$npregao2.'</td>
				 </tr>
				 <tr>  
				 		<td colspan="6" width="100%">
				 		<b>Processo Nº </b>'.$nprocesso2.'</td>
				 </tr>
				 <tr>  
				 				<td colspan="2" width="50%"><b>Data de Homologação: </b>'.$datahomologacao2.'</td>  
				 				<td colspan="2" width="50%"><b>Itens Homologados: </b>'.$itenshomologados2.'</td>
				 				<td colspan="2" width="50%"><b>Empresas Homologadas: </b>'.$empresashomologadas2.'</td>
				 </tr>
			</table>
	
	<br>

'.$html5.'

			<br>

			<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">
				<tr>  
					<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="14"; font-size:14px;">    
						<b>Informações do Processo Eletrônico</b><br>
					</td>
				</tr>
				<tr>  
				 		<td colspan="6" width="100%">
				 		<b>Registro de Preços Eletrônico Nº </b>'.$npregao.'</td>
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
	

'.$html2.'


<br>		
						
			
'.$html3.'

<br>		
	
<table border="0" cellpadding="10" cellspacing="10" width="100%" style="font-famaly: verdana; font-size:30px;">
		<tr>  
					<td align="center" bgcolor="#CCCCCC" width="50%">    
						<b>Valor Total dos Pedidos</b><br>
					</td>
					<td align="center" bgcolor="#CCCCCC" width="50%">    
						<b> R$ '.$valortotalpedido.'</b><br>
					</td>
				</tr>
				<tr>  
					<td align="center" bgcolor="#CCCCCC" width="50%">    
						<b>Valor Total Economizado</b><br>
					</td>
					<td align="center" bgcolor="#CCCCCC" width="50%">    
						<b> R$ '.$valortotaleconomizado.'</b><br>
					</td>
		</tr>
				
				 
</table>

	


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


	
?>