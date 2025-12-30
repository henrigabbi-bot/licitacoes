
 <?php

	session_start();
	if (isset($_GET['cnpj'])) {             
         $_SESSION['cnpj']=$_GET['cnpj'];

     }
     $cnpj= $_SESSION['cnpj']; 
	 $npedido =$_SESSION ['npedido'];
     $id_lic=$_SESSION['idlic'];


	?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>



<?php
	include("../../conexao.php");

	$sql1 = "SELECT npregao,nprocesso,datahomologacao, pessoas.nome, pessoas.cpf, pessoas.rg 
	FROM licitacao
	INNER JOIN pessoas on licitacao.cpf=pessoas.cpf 
	where codlic='$id_lic'";  
	        
    $query1 = mysql_query($sql1);    
    $row1 = mysql_fetch_assoc($query1);	

    $npregao=$row1['npregao'];
    $nprocesso=$row1['nprocesso'];
    $datahomologacao=$row1['datahomologacao'];    
    list ($ano, $mes, $dia) = split ('[/.-]', $datahomologacao);
     //Pega o mes em numeral e retorna em descritivo.
   	

		$sql1 ="SELECT * FROM cliente WHERE CNPJ='$cnpj'";
      	$query1 = mysql_query($sql1);                  
      	$row1 = mysql_fetch_assoc($query1);
      	$nomecliente= $row1['nomecliente'];



		// Definimos o nome do arquivo que será exportado
		$arquivo = $nomecliente.'.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="6">Registro de Preço Eletrônico nº '. $npregao.'</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td colspan="6">Data de Homologação:'.$dia.'/' .$mes. '/'.$ano.'</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td colspan="6">'.$nomecliente.'</tr>';
		$html .= '</tr>';

		
		
		
		$html .= '<tr>';
		$html .= '<td align="center"><b>Codigo</b></td>';
		$html .= '<td align="center"><b>Descrição do produto</b></td>';
		$html .= '<td align="center"><b>Unidade</b></td>';
		$html .= '<td align="center"><b>Quantidade</b></td>';
		$html .= '<td align="center"><b>Vlr. Unitario</b></td>';
		$html .= '<td align="center"><b>Valor Total</b></td>';
		$html .= '</tr>';


		$sql = "SELECT  pedidodecompra2.id,cliente.cnpj ,pedidodecompra2.codprod,produto.descricao,produto.unidade,pedidodecompra2.quantidade ,pedidodecompra2.vlrunitario, (pedidodecompra2.quantidade * pedidodecompra2.vlrunitario) as valor
                        FROM pedidodecompra2
                        INNER JOIN cliente on pedidodecompra2.cnpj=cliente.cnpj
                        INNER JOIN produto on pedidodecompra2.codprod=produto.codprod                         
                        WHERE pedido='$npedido' and pedidodecompra2.idlic='$id_lic' AND pedidodecompra2.cnpj='$cnpj' order by pedidodecompra2.codprod asc";
                     
                      // Executa consulta SQL
                      $query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados
        while($row = mysql_fetch_array($query)) {                      
            $html .= '<tr>'; 
            $html .= '<td align="center">'.$row['codprod'].'</td>'; 
            $html .= '<td>'.$row['descricao'].'</td>';
            $html .= '<td align="center">'.$row['unidade'].'</td>';
            $html .= '<td align="center">'.$row['quantidade'].'</td>';
            $html .= '<td WIDTH="70" align="right"> '.number_format($row['vlrunitario'], 4, ',', '.').'</td>';
            $html .= '<td WIDTH="70" align="right">R$ '.number_format($row['valor'], 2, ',', '').'</td>';
            $html .= '</tr>';
            $valortotal = $valortotal+$row['valor'];
		}
				
					
			$html .= '<tr><td colspan="4" align="center">Valor Total</td><td colspan="2" align="center"> R$ '.number_format($valortotal, 2, ',', '.').'</td></tr>';
						
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		echo $html;
		exit; ?>
	</body>
</html>