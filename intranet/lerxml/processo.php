<?php
session_start();
include("../conexao.php");

$codlic=$_SESSION['codlic'];
$npedido=$_SESSION['npedido'];

$arquivo_tmp=$_FILES['arquivo']['tmp_name'];
$numFile	= count(array_filter($arquivo_tmp));

$conterro=0;
$nfcadastrada=0;
$continsercao=0;
      

for ($i=0; $i < $numFile ; $i++) { 

	$arquivo = simplexml_load_file($arquivo_tmp[$i]);

	foreach($arquivo->NFe as $key => $xml){
		$chave = $xml->infNFe->attributes()->Id;
		$chave = strtr(strtoupper($chave), array("NFE" => NULL));
		$NUMERO = "".$xml->infNFe->ide->nNF.""; //NUMERO NFE
		$RZ_EMITENTE = "".$xml->infNFe->emit->xNome.""; //RAZÃO EMITENTE
		$CNPJ_EMIT = "".$xml->infNFe->emit->CNPJ.""; // CNPJ EMITENTE
		$DATA_EMIT = "".$xml->infNFe->ide->dhEmi.""; // DATA EMISSÃO
		$DATA_EMIT = "".$xml->infNFe->ide->dhEmi.""; // DATA EMISSÃO		
		list ($data, $mes, $dia) = split ('[T]', $DATA_EMIT);
		
		$VALOR_TOT = "".$xml->infNFe->total ->ICMSTot->vNF."";//VALOR NF-E
		$CNPJ_DEST = "".$xml->infNFe->dest->CNPJ.""; // CNPJ DESTINATÁRIO
		$RZ_DESTIN = "".$xml->infNFe->dest->xNome.""; // RAZÃO DESTINATÁRIO
	
		$query1 = mysql_query("SELECT * FROM cliente WHERE cnpj = '$CNPJ_DEST'"); 
		$consulta1 = mysql_num_rows($query1);
		

		$query2 = mysql_query("SELECT * FROM notafiscal WHERE chavedeacesso = '$chave'"); 
		$consulta2 = mysql_num_rows($query2);
		
		//verifica se o cliente existe
		if ($consulta1 == 0) {
			$conterro++;
			//verifica se a NF ja foi cadastrada
			}else if ($consulta2 == 0) {
						
				$sql="INSERT INTO notafiscal (codlic,pedido,chavedeacesso,numeronf,valornf,cnpj) VALUES ('$codlic',$npedido,'$chave','$NUMERO','$VALOR_TOT','$CNPJ_DEST')";	
				if(mysql_query($sql)) {		
					$continsercao++;					
				

				}
				foreach($xml->infNFe->det as $item){			
						$codigo = $item->prod->cProd;
						$xProd = $item->prod->xProd;
						$qCom = $item->prod->qCom;
						$vUnCom = $item->prod->vUnCom;			
						$vProd = $item->prod->vProd;		

				// cadastra os produtos da NF
				$sql2="INSERT INTO itensnf (codprod,quantidade,vlrunt,vlrtotal,chavedeacesso) VALUES ('$codigo','$qCom','$vUnCom','$vProd','$chave')";
						mysql_query($sql2);
							
				}
					
			} else{
				$nfcadastrada++;
			}

			
			$query5 = mysql_query("SELECT * FROM cliente WHERE cnpj = '$CNPJ_DEST'"); 
			$consulta5 = mysql_num_rows($query5);	

			$query3 = mysql_query("SELECT * FROM nfsaida WHERE chavedeacesso = '$chave'"); 
			$consulta3 = mysql_num_rows($query3);	

			if ($consulta5 == 0) {				
				// NF DE DEVOLUÇÃO NÃO PODEM SER CADASTRADAS FAZER 

				}else if ($consulta3 == 0) {	
					
					$sql3="INSERT INTO nfsaida (chavedeacesso,numeronf,data,valornf,cnpj) VALUES ('$chave','$NUMERO','$data','$VALOR_TOT','$CNPJ_DEST')";	
						
					mysql_query($sql3);		
			} 
			

			$query6 = mysql_query("SELECT * FROM fornecedor WHERE cnpj = '$CNPJ_DEST'"); 
			$consulta6 = mysql_num_rows($query6);

			$query7 = mysql_query("SELECT * FROM nfdevolucao WHERE chavedeacesso = '$chave'"); 
			$consulta7 = mysql_num_rows($query7);	

			if ($consulta6 == 1) {				
						
				if ($consulta7 == 0) {
					$sql7="INSERT INTO nfdevolucao (chavedeacesso,numeronf,data,valornf,cnpj) VALUES ('$chave','$NUMERO','$data','$VALOR_TOT','$CNPJ_DEST')";	
						
					if(mysql_query($sql7)) {		
					$continsercao++;
					}

				}else{
					$nfcadastrada++;
				}	
			}
					
												
			
	}
}

$_SESSION["aux"]='aux';
$_SESSION["msg"]=$continsercao;	
$_SESSION["msg2"]= $conterro;
$_SESSION["msg3"]= $nfcadastrada;

header("Location:importar.php");

?>