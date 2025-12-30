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
		list ($data, $mes, $dia) = split ('[T]', $DATA_EMIT);

		$VALOR_TOT = "".$xml->infNFe->total ->ICMSTot->vNF."";//VALOR NF-E
		$CNPJ_DEST = "".$xml->infNFe->dest->CNPJ.""; // CNPJ DESTINATÁRIO
		$RZ_DESTIN = "".$xml->infNFe->dest->xNome.""; // RAZÃO DESTINATÁRIO
	
		$query2 = mysql_query("SELECT * FROM notafiscalfornecedor WHERE chavedeacesso = '$chave'"); 
		$consulta2 = mysql_num_rows($query2);

		if ($consulta2 == 0) {						
			$sql="INSERT INTO notafiscalfornecedor (codlic,pedido,chavedeacesso,numeronf,valornf,cnpj) VALUES ('$codlic','$npedido','$chave','$NUMERO','$VALOR_TOT','$CNPJ_EMIT')";		
		
			if(mysql_query($sql)) {		
				$continsercao++;
				foreach($xml->infNFe->det as $item){			
							$codigo = $item->prod->cProd;
							$xProd = $item->prod->xProd;
							$qCom = $item->prod->qCom;
							$vUnCom = $item->prod->vUnCom;			
							$vProd = $item->prod->vProd;		

					$sql2="INSERT INTO itensnffornecedor (codprod,descricao,quantidade,vlrunt,vlrtotal,chavedeacesso) VALUES ('$codigo','$xProd','$qCom','$vUnCom','$vProd','$chave')";
							mysql_query($sql2);

				}								
			}
					
		}else{
			$nfcadastrada++;		
			
		}	

		$query3 = mysql_query("SELECT * FROM nfentrada WHERE chavedeacesso = '$chave'"); 
		$consulta3 = mysql_num_rows($query3);

		if ($consulta3 == 0) {						
			$sql1="INSERT INTO nfentrada (chavedeacesso,numeronf,data,valornf,cnpj) VALUES ('$chave','$NUMERO','$data','$VALOR_TOT','$CNPJ_EMIT')";		
			mysql_query($sql1);
		}
		

		
	}
}
	


$_SESSION["aux"]='aux';
$_SESSION["msg"]=$continsercao;	
$_SESSION["msg2"]= $conterro;
$_SESSION["msg3"]= $nfcadastrada;

header("Location:importar.php");


?>