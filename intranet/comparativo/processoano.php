<?php	
	
	include("../conexao.php");

	 if (isset($_GET['cnpj'])and isset($_GET['codlic'])) {             
          $cnpj=$_GET['cnpj'];
          $codlic=$_GET['codlic'];
          $npedido=$_GET['pedido'];

      }     


// TESTE PEDIDO DE FEVEREIRO PREGÃO 03/2023
// VARIAVEL PARA DIFINIR A LICITAÇÃO     
	 $licitacaofixa="201";			
	 $descricaopedido="FEVEREIRO/2024";

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


// NUMERO DE PEDIDOS DA LICITAÇÃO
     $sql = "SELECT COUNT(pedido.npedido) AS ndepedidos FROM pedido WHERE codlic='$licitacaofixa'";
     $query = mysql_query($sql);  
     $row = mysql_fetch_assoc($query);
     $ndepedidos2=$row['ndepedidos'];

		$html5.='<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">';
		$html5.='<tr>';  
		$html5.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="font-size:16px;">';    
		$html5.='		<b>Informações do Processo Eletrônico</b><br>';
		$html5.='		</td>';
		$html5.='	</tr>';
		$html5.='	<tr>';  
		$html5.='		<td colspan="6" width="100%">';
		$html5.=' 		<b>Registro de Preços Eletrônico Nº </b>'.$npregao2.'</td>';
		$html5.='	 </tr>';
		$html5.='	 <tr> '; 
		$html5.=' 		<td colspan="6" width="100%">';
		$html5.=' 		<b>Processo Nº </b>'.$nprocesso2.'</td>';
		$html5.='	 </tr>';
		$html5.='	 <tr> '; 
		$html5.='			<td colspan="2" width="50%"><b>Data de Homologação: </b>'.$datahomologacao2.'</td>';  
		$html5.='			<td colspan="2" width="50%"><b>Itens Homologados: </b>'.$itenshomologados2.'</td>';
		$html5.='			<td colspan="2" width="50%"><b>Empresas Homologadas: </b>'.$empresashomologadas2.'</td>';
		$html5.='	 </tr>';
		$html5.='	</table>';
		$html5.='<br>';

	$pedidoaux2=2;

     While ( $pedidoaux2 <=$ndepedidos2) {     	
   

	// ITENS SOLICITADOS E ITENS COMPARADOS
	     $sql = "SELECT COUNT(DISTINCT itensprocesso.codprod) AS itenscomparados, COUNT(DISTINCT pedidodecompra.codprod) AS itenssolicitados
	     FROM pedidodecompra INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
	     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
	     LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$licitacaofixa' AND pedidodecompra.cnpj='$cnpj' 
	     WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$licitacaofixa' and pedidodecompra.pedido='$pedidoaux2'  ";
	    
	     $query = mysql_query($sql);  
	     $row = mysql_fetch_assoc($query);
	     $itenscomparados2=$row['itenscomparados'];
	     $itenssolicitados2=$row['itenssolicitados'];
    
  // VALOR DO PEDIDO
     $sql = "SELECT  SUM(pedidodecompra.quantidade * pedidodecompra.vlrunitario)as valordopedido
     FROM pedidodecompra
     INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj                     
     WHERE pedidodecompra.pedido='$pedidoaux2' and pedidodecompra.idlic='$licitacaofixa' and pedidodecompra.cnpj='$cnpj'";

      $query = mysql_query($sql);  
      $row = mysql_fetch_assoc($query);
      $valorpedido2=$row['valordopedido'];
   	  
    
			// DATA DO PEDIDO
      $sql = "SELECT DATE_FORMAT(pedido.data, '%d/%m/%Y ') AS datapedido FROM pedido WHERE codlic='$licitacaofixa' and npedido='$pedidoaux2'";
      $query = mysql_query($sql);  
     	$row = mysql_fetch_assoc($query);
     	$datapedido2=$row['datapedido'];


      // ECONOMIA GERADA EM REAIS
     	 $sql2 = "SELECT pedidodecompra.quantidade,pedidodecompra.vlrunitario, itensprocesso.quantidade AS qtdprocesso,AVG(itensprocesso.vlrunitario) as vlrunitarioprocesso
                        FROM pedidodecompra 
                        INNER JOIN produto on pedidodecompra.codprod=produto.codprod 
                        INNER JOIN cliente on pedidodecompra.cnpj=cliente.cnpj 
                        LEFT JOIN itensprocesso on itensprocesso.codprod = pedidodecompra.codprod AND pedidodecompra.idlic ='$licitacaofixa' AND pedidodecompra.cnpj='$cnpj' 
                        WHERE pedidodecompra.cnpj='$cnpj' and pedidodecompra.idlic='$licitacaofixa' and pedidodecompra.pedido='$pedidoaux2'
                        GROUP BY pedidodecompra.codprod;";
                       
                          // Executa consulta SQL
                            $query = mysql_query($sql2);  
                          // Enquanto houverem registros no banco de dados
                            
                          while($row = mysql_fetch_array($query)) {
                            if ($row['vlrunitarioprocesso'] != 0) {                                       
                                  $economia2=(($row['vlrunitario']* $row['quantidade']) - ($row['vlrunitarioprocesso']*$row['quantidade'])); 
                                        $valoreconomizado2=$valoreconomizado2 + $economia2; 
                            }; 
                          };
    

		//PERCENTUAL DE ITENS COMPRARADOS

	$percentualdositensomparado2=($itenscomparados2*100)/$itenssolicitados2;
    $percentualdositensomparado2= number_format($percentualdositensomparado2, 2, ',', '');

    // PERCENTUAL ECONOMIZADO

     $percentualeconomizado2=($valoreconomizado2*100)/$valorpedido2;
     $percentualeconomizado2= number_format($percentualeconomizado2, 2, ',', '');
    
    // FORMATAÇÃO 


     $valorpedidoformatado2= number_format($valorpedido2, 2, ',', '.');

     $valoreconomizadoformatado2= number_format($valoreconomizado2, 2, ',', '.');


    list ($dia2, $mes2, $ano2) = split ('[/.-]', $datapedido2);  
    if ($mes2 == '01') {
    	$mes2='Janeiro';
    }else if ($mes2 =='2'){
    	$mes2='Fevereiro';
    }else if ($mes2 =='3'){
    	$mes2='Março';
    }else if ($mes2 =='4'){
    	$mes2='Abril';
    }else if ($mes2 =='5'){
    	$mes2='Maio';
    }else if ($mes2 =='6'){
    	$mes2='Junho';
    }else if ($mes2 =='7'){
    	$mes2='Julho';
    }else if ($mes2 =='8'){
    	$mes2='Agosto';
    }else if ($mes2 =='9'){
    	$mes2='Setembro';
    }else if ($mes2 =='10'){
    	$mes2='Outubro';
    }else if ($mes2 =='11'){
    	$mes2='Novembro';    
		}else {
			$mes2='Dezembro';

		};

    $html5.='<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">';
		$html5.='	<tr> '; 
		$html5.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="font-size:16px">';    
		$html5.='	<b>Pedido de Compra '.$pedidoaux2.' - '.$mes2.'/'.$ano2.'</b><br>';					
		$html5.='</td>';
		$html5.='	</tr>';
			
		$html5.='<tr>'; 
		$html5.='<td colspan="6" width="100%">';
		$html5.='<b>Data do Pedido: </b>'.$datapedido2.'</td>';
		$html5.='</tr>';
		$html5.='<tr>'; 
		$html5.='<td colspan="3" width="50%"><b>Valor Solicitado: </b>R$ '.$valorpedidoformatado2.'</td>';  
		$html5.='<td colspan="3" width="50%"><b>Itens Solicitados: </b> '.$itenssolicitados2.'</td>';
		$html5.='</tr>';
		$html5.='<tr>';  
		$html5.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="font-size:16px;">';    
		$html5.='<b>Economia Gerada no Pedido</b><br>'; 
		$html5.='</td>';
		$html5.='</tr>';
		$html5.='<tr>';
		$html5.='<td colspan="6" width="100%">';
		$html5.='	<b>Valor Economizado: </b> R$ '.$valoreconomizadoformatado2.'</td>';
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
	
    
    $pedidoaux2++;
		
		
	   $valortotalpedido2=$valortotalpedido2	+ $valorpedido2;
    $valortotaleconomizado2=$valortotaleconomizado2 + $valoreconomizado2; 
    $valoreconomizado2='0'; 

  	};







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
 
       	$html2.='<table border="0" cellpadding="2" cellspacing="1" width="100%" style="font-famaly: verdana; font-size:12px;">';
		$html2.='<tr>';  
		$html2.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="font-size:16px;">';    
		$html2.='		<b>Informações do Processo Eletrônico</b><br>';
		$html2.='		</td>';
		$html2.='	</tr>';
		$html2.='	<tr>';  
		$html2.='		<td colspan="6" width="100%">';
		$html2.=' 		<b>Registro de Preços Eletrônico Nº </b>'.$npregao.'</td>';
		$html2.='	 </tr>';
		$html2.='	 <tr> '; 
		$html2.=' 		<td colspan="6" width="100%">';
		$html2.=' 		<b>Processo Nº </b>'.$nprocesso.'</td>';
		$html2.='	 </tr>';
		$html2.='	 <tr> '; 
		$html2.='			<td colspan="2" width="50%"><b>Data de Homologação: </b>'.$datahomologacao.'</td>';  
		$html2.='			<td colspan="2" width="50%"><b>Itens Homologados: </b>'.$itenshomologados.'</td>';
		$html2.='			<td colspan="2" width="50%"><b>Empresas Homologadas: </b>'.$empresashomologadas.'</td>';
		$html2.='	 </tr>';
		$html2.='	</table>';
		$html2.='	<br>';

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
                                        $valoreconomizado=$valoreconomizado + $economia; 
                            }; 
                          };
    

	//PERCENTUAL DE ITENS COMPRARADOS

	$percentualdositensomparado=($itenscomparados*100)/$itenssolicitados;
    $percentualdositensomparado= number_format($percentualdositensomparado, 2, ',', '');

    // PERCENTUAL ECONOMIZADO

     $percentualeconomizado=($valoreconomizado*100)/$valorpedido;
     $percentualeconomizado= number_format($percentualeconomizado, 2, ',', '');
    
    // FORMATAÇÃO 


     $valorpedidoformatado= number_format($valorpedido, 2, ',', '.');

     $valoreconomizadoformatado= number_format($valoreconomizado, 2, ',', '.');


    list ($dia, $mes, $ano) = split ('[/.-]', $datapedido);  
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
		$html2.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="font-size:16px";>';    
		$html2.='	<b>Pedido de Compra '.$pedidoaux.' - '.$mes.'/'.$ano.'</b><br>';					
		$html2.='</td>';
		$html2.='	</tr>';
			
		$html2.='<tr>'; 
		$html2.='<td colspan="6" width="100%">';
		$html2.='<b>Data do Pedido: </b>'.$datapedido.'</td>';
		$html2.='</tr>';
		$html2.='<tr>'; 
		$html2.='<td colspan="3" width="50%"><b>Valor Solicitado: </b>R$ '.$valorpedidoformatado.'</td>';  
		$html2.='<td colspan="3" width="50%"><b>Itens Solicitados: </b> '.$itenssolicitados.'</td>';
		$html2.='</tr>';
;
		$html2.='<tr>';  
		$html2.='<td align="center" bgcolor="#CCCCCC" colspan="6" width="100%" style="font-size:16px;">';    
		$html2.='<b>Economia Gerada no Pedido</b><br>'; 
		$html2.='</td>';
		$html2.='</tr>';
		$html2.='<tr>';
		$html2.='<td colspan="6" width="100%">';
		$html2.='	<b>Valor Economizado: </b> R$ '.$valoreconomizadoformatado.'</td>';
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
		
		
	$valortotalpedido=$valortotalpedido	+ $valorpedido;
    $valortotaleconomizado=$valortotaleconomizado + $valoreconomizado; 
    $valoreconomizado='0'; 

  	};

   
 
	
	// SOMA AS DUAS LICITAÇÕES
	$valortotalpedido=$valortotalpedido+$valortotalpedido2;
	$valortotaleconomizado=$valortotaleconomizado+$valortotaleconomizado2;

	$percentualtotaleconomizado=($valortotaleconomizado*100)/$valortotalpedido;

    //FORMATAÇÃO 
    $valortotalpedido= number_format($valortotalpedido, 2, ',', '.');
    $valortotaleconomizado= number_format($valortotaleconomizado, 2, ',', '.');

    $percentualtotaleconomizado= number_format($percentualtotaleconomizado, 2, ',', '');
   
        
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
      
      <p style="text-align: justify;">
      O presente relatório apresenta a economia gerada no período de <b>JANEIRO de 2024</b> a <b>DEZEMBRO de 2024</b>. Nesse
      período foram realizados os Pregões Eletrônicos '.$npregao2.' e '.$npregao.' e quatro pedidos de medicamentos
      (FEVEREIRO/24, MAIO/24, AGOSTO/24, NOVEMBRO/24).
      </p>		

      <table border="0" cellpadding="10" cellspacing="10" width="100%" style="font-famaly: verdana; font-size:30px;">
    <tr>  
          <td align="center" bgcolor="#CCCCCC" width="50%" style="font-size:18px;">    
            <b>VALOR TOTAL DOS PEDIDOS</b><br>
          </td>
          <td align="center" bgcolor="#CCCCCC" width="50%" style="font-size:18px;" >    
            <b> R$ '.$valortotalpedido.'</b><br>
          </td>
        </tr>
        <tr>  
          <td align="center" bgcolor="#CCCCCC" width="50%" style="font-size:18x;">    
            <b>VALOR TOTAL ECONOMIZADO</b><br>
          </td>
          <td align="center" bgcolor="#CCCCCC" width="50%" style="font-size:18px;">    
            <b> R$ '.$valortotaleconomizado.'</b><br>
          </td>
    </tr>
      <tr>  
          <td align="center" bgcolor="#CCCCCC" width="50%" style="font-size:18px;">    
            <b>PERCENTUAL TOTAL ECONOMIZADO</b><br>
          </td>
          <td align="center" bgcolor="#CCCCCC" width="50%" style="font-size:18px;">    
            <b>'.$percentualtotaleconomizado.' %</b><br>
          </td>
    </tr>
        
         
</table>
    <br>
    <br>

			'.$html3.' 


			'.$html5.'
			<br>
			

			'.$html2.'


			<br>		
								
			
			

			<br>		
	


	


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