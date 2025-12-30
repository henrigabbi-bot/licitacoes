<?php
session_start();
include("../conexao.php");

$codlic=2020;

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
		$NCAIXAS="".$xml->infNFe->transp->vol->qVol.""; // QUANTIDADE DE VOLUMES
		$PESO="".$xml->infNFe->transp->vol->pesoB.""; // PESO
	
		$query1 = mysql_query("SELECT * FROM fornecedor WHERE cnpj = '$CNPJ_EMIT'"); 
		$consulta1 = mysql_num_rows($query1);
		

		$query2 = mysql_query("SELECT * FROM notasano WHERE chavedeacesso = '$chave'"); 
		$consulta2 = mysql_num_rows($query2);
		
		//verifica se o cliente existe
		if ($consulta1 == 0) {
			$conterro++;
			//verifica se a NF ja foi cadastrada
			}else if ($consulta2 == 0) {
						
				$sql="INSERT INTO notasano (chavedeacesso,numeronf,valornf,cnpj,dataemissao) VALUES ('$chave','$NUMERO','$VALOR_TOT','$CNPJ_EMIT','$data')";	
				ECHO $sql;
				
				if(mysql_query($sql)) {		
					$continsercao++;				
				

				}
				
				
					
			} else{
				$nfcadastrada++;
			}

			
			

			
					
												
			
	}
}

$_SESSION["aux"]='aux';
$_SESSION["msg"]=$continsercao;	
$_SESSION["msg2"]= $conterro;
$_SESSION["msg3"]= $nfcadastrada;

//header("Location:importar.php");

?>