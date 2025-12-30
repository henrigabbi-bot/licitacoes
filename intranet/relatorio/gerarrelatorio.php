<?php	



	include("../conexao.php");

	$sql="SELECT desagio.cnpj, fornecedor.nomefornecedor  FROM desagio                 
                  INNER join fornecedor on fornecedor.cnpj=desagio.cnpj
                   GROUP BY fornecedor.nomefornecedor"               

    $query = mysql_query($sql);    
    $row = mysql_fetch_assoc($query);	
	
	
	$nomefornecedor=$row['nomefornecedor'];
	$cnpj=$row['cnpj'];	
	

	$sql="SELECT *, produto.descricao FROM desagio 
                  INNER join produto on produto.codprod=desagio.codprod 
                  INNER join fornecedor on fornecedor.cnpj=desagio.cnpj
                  WHERE  desagio.cnpj='$cnpj' "
    


      $sql = "SELECT desagio.cnpj, fornecedor.nomefornecedor  FROM desagio                 
                  INNER join fornecedor on fornecedor.cnpj=desagio.cnpj
                   GROUP BY fornecedor.nomefornecedor"; 
                    $query = mysql_query($sql);
                    $aux=0;
                    while($row = mysql_fetch_array($query)) {
                      $nomefornecedor=$row['nomefornecedor'];
					  $cnpj=$row['cnpj'];	

                    
                      $codlic[$aux]=$row['codlic'];
                      $npedido[$aux]=$row['npedido']; 
                      $cont++;
                      $aux++;
                  
                     
                  ?>   
                      <th>Qtd. Lic. <?php echo $pregao; ?> Ped. <?php echo $pedido; ?></th>
                  <?php
                    }  







	// ITENS DO FORNECEDOR
    $html ='<!DOCTYPE html>';
    $html.='<html>';
    $html.='<head>';
    $html.='</head>';
    $html.='<body>';
    $html.='<style type="text/css">
	table{
		border-collapse: collapse; 


	} 
	table, td, th {
  	border: 1px solid black;
	}   
    th, td {
  	padding: 3px;
  	font-size: 12px;
  	
	}

    @page {   
   		margin-top: 5cm;   
   		border: 1px solid blue;
	}
	</style>';
    

    $html .= '<table align="center">';	
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<th align="center">Item</th>';
	$html .= '<th align="center">Cód.</th>';
	$html .= '<th align="center">Descrição</th>';
	$html .= '<th align="center">Unid.</th>';
	$html .= '<th align="center">Quant.</th>';
	$html .= '<th align="center">Marca</th>';
	$html .= '<th align="center">Vlr. Unitário</th>';
	$html .= '<th align="center">Vlr. Total</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';	
	
	$sql2 = "SELECT resultadolicitacao.id,resultadolicitacao.item, resultadolicitacao.codprod,produto.unidade, produto.descricao,quantidade,resultadolicitacao.marca ,resultadolicitacao.vlrunitario, (quantidade * resultadolicitacao.vlrunitario) as vlrtotal
                        FROM resultadolicitacao                        
                        INNER JOIN produto on resultadolicitacao.codprod=produto.codprod              
                        WHERE idlic ='$codlic' and cnpj='$cnpj'";

                
	$query2 = mysql_query($sql2);  
                      // Enquanto houverem registros no banco de dados
     while($row = mysql_fetch_array($query2)){
		$html .= '<tr><td align="center">'.$row['item'] . "</td>";		
	    $html .= '<td align="center">'.$row['codprod']. "</td>";
		$html .= '<td>'.$row['descricao'] . "</td>";		
		if ($row['unidade'] == 'Comprimido' or $row['unidade']=='COMPRIMIDO') {
			$html .= '<td align="center">CP</td>';
		} else if ($row['unidade']=='Frasco' or $row['unidade']=='FRASCO') {
			$html .= '<td align="center">FR</td>';
		}else if ($row['unidade']=='Ampola' OR $row['unidade']=='AMPOLA') {
			$html .= '<td align="center">AMP</td>';
		}else if ($row['unidade']=='Cartela' OR $row['unidade']=='CARTELA') {
			$html .= '<td align="center">CT</td>';
		}else if ($row['unidade']=='Bisnaga' or $row['unidade']=='BISNAGA') {
			$html .= '<td align="center">BNG</td>';
		}else if ($row['unidade']=='Caixa' OR $row['unidade']=='CAIXA') {
			$html .= '<td align="center">CX</td>';		
		}else if ($row['unidade']=='Unidade' or $row['unidade']=='UNIDADE') {
			$html .= '<td align="center">UN</td>';
		}else if ($row['unidade']=='Dragea' or $row['unidade']=='DRAGEA' or $row['unidade']=='DRÁGEA') {
			$html .= '<td align="center">DG</td>';
		}else if ($row['unidade']=='Lata' or $row['unidade']=='LATA') {
			$html .= '<td align="center">LT</td>';
		}else if ($row['unidade']=='CAPSULA' or $row['unidade']=='Capsula' or $row['unidade']=='Cápsula') {
			$html .= '<td align="center">CAPS</td>';
		}else if($row['unidade']=='Vidro') {
			$html .= '<td align="center">VD</td>'; 
		}else if($row['unidade']=='Envelope') {
			$html .= '<td align="center">ENV</td>'; 
		}else {
			$html .= '<td align="center">ARRUMAR UNIDADE</td>';
			
		};	
		

		$html .= '<td align="center">'.number_format($row['quantidade'], 0, ',', '.')."</td>";
		$html .= '<td align="center">'.mb_strtoupper($row['marca'],'UTF-8'). "</td>";
		$html .= '<td WIDTH="50" align="right"> R$ '.number_format($row['vlrunitario'], 4, ',', '.')."</td>";
		$html .= '<td WIDTH="60" align="right"> R$ '.number_format($row['vlrtotal'], 2, ',', '.')."</td></tr>";
		
		$valortotal = $valortotal+$row['vlrtotal'];
				
	}
	$html .= '<tr><td colspan="7" align="center">Total</td><td> R$ '.number_format($valortotal, 2, ',', '.').'</td></tr>"';
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
			
			
				'.$html.'

		
		');


	
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->set_option('defaultFont', 'Times New Roman’');

	//Renderizar o html
	$dompdf->render();


	//Exibibir a página
	$dompdf->stream(
		"'.$nomefornecedor.'", 
		array(
			"Attachment" => true //Para realizar o download somente alterar para true
		)
	);


	
?>