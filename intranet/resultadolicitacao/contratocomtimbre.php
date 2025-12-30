<?php	
	session_start();
	$cnpj = $_GET['cnpj'];
	$codlic=$_SESSION['codlic'];
	$ncontrato=$_GET['aux'];


	include("../conexao.php");

	// DADOS DA LICITACAO
	$sql1 = "SELECT npregao,nprocesso,datahomologacao, pessoas.nome, pessoas.cpf, pessoas.rg 
	FROM licitacao
	INNER JOIN pessoas on licitacao.cpf=pessoas.cpf 
	where codlic='$codlic'";  
	        
    $query1 = mysql_query($sql1);    
    $row1 = mysql_fetch_assoc($query1);	

    $npregao=$row1['npregao'];
    $nprocesso=$row1['nprocesso'];
    $datahomologacao=$row1['datahomologacao'];    
    list ($ano, $mes, $dia) = split ('[/.-]', $datahomologacao);
    
    //Pega o mes em numeral e retorna em descritivo.
    if ($mes == '01') {
    	$mes='janeiro';
    }else if ($mes =='2'){
    	$mes='fevereiro';
    }else if ($mes =='3'){
    	$mes='março';
    }else if ($mes =='4'){
    	$mes='abril';
    }else if ($mes =='5'){
    	$mes='maio';
    }else if ($mes =='6'){
    	$mes='junho';
    }else if ($mes =='7'){
    	$mes='julho';
    }else if ($mes =='8'){
    	$mes='agosto';
    }else if ($mes =='9'){
    	$mes='setembro';
    }else if ($mes =='10'){
    	$mes='outubro';
    }else if ($mes =='11'){
    	$mes='novembro';    
	}else {
		$mes='dezembro';

	};
    $nome = $row1['nome'];
    $cpf=preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4",$row1['cpf']);
    $rg=  $row1['rg'];

   


    // DADOS DO FORNECEDOR
    $sql = "SELECT * FROM fornecedor where cnpj='$cnpj'";                   
    $query = mysql_query($sql);    
    $row = mysql_fetch_assoc($query);	
	
	$cnpjm=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5",$row['cnpj']); 		
	$nomefornecedor=$row['nomefornecedor'];	
	$endereco=$row['endereco'];
	$cidade=$row['cidade'];	
	$estado=$row['estado'];	
	$bairro=$row['bairro'];	
	$cep=preg_replace("/(\d{2})(\d{3})(\d{2})/", "\$1.\$2-\$3",$row['cep']);
	$cpfr=$row['cpf'];

	$sqlpessoa = "SELECT * FROM pessoas where cpf='$cpfr'";                   
    $querypessoa = mysql_query($sqlpessoa);    
    $rowpessoa = mysql_fetch_assoc($querypessoa);	
    $representante=$rowpessoa['nome'];
    $rgr=  $rowpessoa['rg'];		
	
	$cpfr= preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['cpf']);
    

    

	// ITENS DO FORNECEDOR
    $html ='<!DOCTYPE html>';
    $html.='<html>';
   
    $html.='<body>';
    $html.='<style type="text/css">

H5{
  border: 5px; 
}

  
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
		}else if($row['unidade']=='Envelope' or $row['unidade']=='ENVELOPE') {
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
			
			<p style="text-align: left;">
			<b>

			 PREGÃO ELETRÔNICO Nº '.$npregao.'  <br>
			 PROCESSO Nº '.$nprocesso.'<br>
			CONTRATO Nº '.$ncontrato.'/2025
			</b>
			 </p>

			<p style="text-align: justify;">
				O CONSÓRCIO INTERMUNICIPAL DO NOROESTE DO ESTADO DO RIO GRANDE DO SUL - CISA inscrito no CNPJ sob n° 02.231.696/0001-92, situada na Rua do Barão do Rio Branco, 121, em Ijuí/RS, CEP 98700-000, neste ato representado por seu Presidente  <b>SR. '.$nome.'</b>, portador da cédula de identidade nº '.$rg.' SSP/RS, CPF nº '.$cpf.', e a empresa <b>'.$nomefornecedor.'</b>, CNPJ nº '.$cnpjm.', estabelecida na cidade de '.$cidade.'-'.$estado.', na '.$endereco.', Bairro '.$bairro.', CEP:'.$cep.', neste ato representados(as) pelos(as) <b>SR(A). '.$representante.'</b>, portador(a) do CPF nrº '.$cpfr.' e da célula de identidade nº '.$rgr.', resolvem firmar o presente <b>CONTRATO</b>, decorrente do Pregão Eletrônico nrº '.$npregao.', que se regerá pelas normas da Lei nº 14.133/2021 e pelas cláusulas a seguir estipulados.

			</p>



 
			<h5 style="background-color:LightGray;""> 1. CLÁUSULA PRIMEIRA – DO OBJETO</h5>
					
					<p style="text-align: justify;">
					  			
									1.1. O objeto do presente contrato é a contratação de empresa para o fornecimento de medicamentos humanos, em consonância com a descrição abaixo:
						


						
												'.$html.'
					</p>
					 
			<h5 style="background-color:LightGray;">2. CLÁUSULA SEGUNDA - DA VIGÊNCIA</h5>	
			
				<p style="text-align: justify;">
					2.1. O prazo de vigência deste contrato é de 60 dias, prorrogável na forma do art. 107 da Lei nº 14.133/2021.</p>
			
				

			<h5 style="background-color:LightGray;">3. CLÁUSULA TERCEIRA – DO VALOR</h5>
				
				<p style="text-align: justify;">
					3.1. O valor do presente contrato é de R$ '.number_format($valortotal, 2, ',', '.').'</p>

						<p style="text-align: justify;">
					3.2. No valor acima estão incluídas todas as despesas ordinárias diretas e indiretas decorrentes da execução contratual, inclusive tributos, impostos, encargos sociais, trabalhista, previdenciários, fiscais e comerciais incidentes, taxas, frete, seguro e outros necessários ao cumprimento integral do objeto da contratação.</p>


			<h5 style="background-color:LightGray;">4. CLÁUSULA QUARTA – DA COMPRA - LOCAIS/PRAZO DE ENTREGA/NOTA FISCAL</h5>

				<p style="text-align: justify;">

				4.1. A efetivação da compra será mediante emissão da Autorização de Fornecimento expedida pela CENTRAL DE MEDICAMENTOS do CISA.

				</p>

				<p style="text-align: justify;">

				4.2. Os produtos deverão ser entregues conforme Autorização de Fornecimento, sendo recebidos/conferidos pela farmacêutica responsável pelo CISA.
				</p>

				<p style="text-align: justify;">				
				4.3. O prazo de entrega será de 30 (trinta) dias corridos, após a emissão da Autorização de Fornecimento.
				</p>
				<p style="text-align: justify;">
				4.4. Local e Horário de entrega: Os medicamentos deverão ser entregues no seguinte endereço: Rua Barão do Rio Branco, 121 – Centro – Ijuí – RS, das 08h00min às 12h00min e das 13h00min às 17h00min.
				</p>
				<p style="text-align: justify;">
				4.5. Os medicamentos entregues deverão ter validade mínima de 01 (um) ano a contar da data de recebimento da mercadoria. Para os medicamentos cuja a validade geral é menor que 01 (um) ano, deverão possuir no momento da entrega 9 (nove) meses de validade.
				</p>
				<p style="text-align: justify;">
				4.6. A entrega e o descarregamento dos produtos são de responsabilidade da licitante vencedora;
				</p>
				<p style="text-align: justify;">
				4.7. O Certificado de Análise de cada MEDICAMENTO/LOTE deverá ser encaminhado via e-mail ou vir anexado na Nota Fiscal. O Certificado de Análise deverá comprovar o atendimento às especificações previstas pela(s) farmacopéia(s) para o princípio ativo e de forma farmacêutica.
				</p>
				<p style="text-align: justify;">
				4.8. As embalagens primárias dos medicamentos (ampolas, blisters, strips e frascos) devem apresentar o número do lote, data de fabricação e prazo de validade e a inscrição explícita da informação: “VENDA PROIBIDA AO COMÉRCIO”, nas referidas embalagens;
				</p>
				<p style="text-align: justify;">
				4.9. O recebimento do medicamento será feito inicialmente em caráter provisório. O aceite definitivo com a liberação da Nota Fiscal para pagamento está acondicionado ao atendimento das exigências contidas no Edital de Licitação;
				</p>
				<p style="text-align: justify;">
				4.10. Caso não cumprido as exigências deste Edital, o fornecedor será comunicado a retirar o produto no local de entrega e substituí-lo por outro que atenda as especificações constantes neste Edital, sem nenhum ônus para o consórcio;

				</p>


			<h5 style="background-color:LightGray;">5. CLÁUSULA QUINTA - DO PAGAMENTO</h5>
			<p style="text-align: justify;">

			5.1. O pagamento será efetuado em 02 (duas) parcelas, de igual valor, ou seja, a 1ª (primeira) parcela em 30 (trinta) dias e a 2ª (segunda) em 60 dias.
			</p>
				<p style="text-align: justify;">
			5.2. Os arquivos eletrônicos da Nota Fiscal (XML e PDF) deverão ser encaminhados obrigatoriamente para o e-mail cisaxml@hotmail.com. Ciente de cumprimento às instruções normativas da Receita Federal do Brasil, em especial à IN RFB nº 1.234/2012, que torna obrigatória a retenção por parte da autoridade licitante do desconto do imposto de renda incidente sobre bens, sendo obrigatória a emissão de notas fiscais contemplando a indicação do valor do imposto de renda retido sobre o montante total da respectiva nota fiscal.
			</p>
				<p style="text-align: justify;">
			5.3. O pagamento será efetuado mediante crédito em Conta Corrente Bancária em favor do adjudicatário, informados pelo fornecedor na proposta vencedora.
				</p>
				<p style="text-align: justify;">
			5.4. No caso de incorreção nos documentos apresentados, inclusive na Nota Fiscal, serão os mesmos restituídos à adjudicatária para as correções necessárias, não respondendo o CISA por quaisquer encargos resultantes de atrasos na liquidação dos pagamentos correspondentes e o prazo de pagamento será contado da data de reapresentação do documento corretamente preenchido.
			</p>

			<h5 style="background-color:LightGray;">6. CLÁUSULA SEXTA - DAS SANÇÕES</h5>	
			<p style="text-align: justify;">	
			6.1. Comete infração administrativa, nos termos da Lei nº 14.133/2021, o licitante/adjudicatário que:
6.1.1. Der causa à inexecução parcial ou total do contrato;
	</p>	
<p style="text-align: justify;">
6.1.2. Deixar de entregar os documentos exigidos no certame;
	</p>	
<p style="text-align: justify;">
6.1.3. Não mantiver a proposta, salvo em decorrência de fato superveniente devidamente justificado;
	</p>	
<p style="text-align: justify;">
6.1.4. Não assinar o termo de contrato ou aceitar/retirar o instrumento equivalente, quando convocado dentro do prazo de validade da proposta;
6.1.5. Ensejar o retardamento da execução ou entrega do objeto da licitação;
	</p>	
<p style="text-align: justify;">
6.1.6. Apresentar declaração ou documentação falsa;
	</p>	
<p style="text-align: justify;">
6.1.7. Fraudar a licitação ou praticar ato fraudulento na execução do contrato;
	</p>	
<p style="text-align: justify;">
6.1.8. Comportar-se de modo inidôneo ou cometer fraude de qualquer natureza;
	</p>	
<p style="text-align: justify;">
6.1.9. Praticar atos ilícitos com vistas a frustrar os objetivos da licitação;
	</p>	
<p style="text-align: justify;">
6.2. O licitante/adjudicatário que cometer qualquer das infrações discriminadas nos subitens anteriores ficará sujeito, sem prejuízo da responsabilidade civil e criminal, às seguintes sanções:
6.2.1. Advertência por escrito;
	</p>	
<p style="text-align: justify;">
6.2.2. Esgotado o prazo de entrega dos medicamentos, por INEXECUÇÃO TOTAL, será aplicada Multa de 25 % (vinte e cinco porcento) sobre o valor total do pedido de compra
	</p>	
<p style="text-align: justify;">
6.2.3. Esgotado o prazo de entrega dos medicamentos, por INEXECUÇÃO PARCIAL, será aplicada Multa de 20 % (vinte porcento) calculada sobre o valor do objeto não entregue;
	</p>	
<p style="text-align: justify;">
6.2.4. Impedimento de licitar e contratar;
	</p>	
<p style="text-align: justify;">
6.2.5. Declaração de inidoneidade para licitar ou contratar.
	</p>	
<p style="text-align: justify;">
6.3. A penalidade de multa pode ser aplicada cumulativamente com as demais sanções.
	</p>	
<p style="text-align: justify;">
6.4. Do ato que aplicar a penalidade caberá recurso, no prazo de 15 (quinze) dias úteis, a contar da ciência da intimação, podendo a autoridade que tiver proferido o ato reconsiderar sua decisão ou, no prazo de 05 (cinco) dias encaminhá-lo devidamente informados para a apreciação e decisão superior, no prazo de 20 (vinte) dias úteis.
	</p>	
<p style="text-align: justify;">
6.5. As multas devidas e/ou prejuízos causados à Contratante serão deduzidos dos valores a serem pagos, ou recolhidos em favor do órgão, ou ainda, quando for o caso, serão inscritos na Dívida Ativa e cobrados judicialmente.
	</p>	
			</p>			

<h5 style="background-color:LightGray;">7. CLÁUSULA SÉTIMA – DOTAÇÃO ORÇAMENTARIA</h5>	
			<p style="text-align: justify;">	
			7.1. As despesas decorrentes desta contratação estão programadas em dotação orçamentaria própria, prevista no orçamento para o exercício de 2024.

			</p>	


			<h5 style="background-color:LightGray;">8. CLÁUSULA OITAVA – DA EXTINÇÃO</h5>	
				<p style="text-align: justify;">
				8.1. O presente termo de contrato poderá ser extinto:
				</p>	
				<p style="text-align: justify;">
				8.1.1. Por ato unilateral e escrito da Administração, nas situações previstas no inciso I do art. 138 da Lei nº 14.133/2021, e com as consequências indicadas no art. 139 da mesma Lei, sem prejuízo da aplicação das sanções previstas no Termo de Referência, anexo ao Edital;
					</p>	
				<p style="text-align: justify;">
				8.1.2. Amigavelmente, nos termos do art. 138, inciso II, da Lei nº 14.133/2021.
					</p>	
				<p style="text-align: justify;">
				8.2. A extinção contratual deverá ser formalmente motivada nos autos de processo administrativo assegurado à CONTRATADA o direito à prévia e ampla defesa, verificada a ocorrência de um dos motivos previstos no art. 137 da Lei nº 14.133/2021.
				</p>	
				<p style="text-align: justify;">
				8.3. A CONTRATADA reconhece os direitos da CONTRATANTE em caso de rescisão administrativa prevista no art. 115 da Lei nº 14.133/2021.

				</p>	


				<h5 style="background-color:LightGray;">9. CLÁUSULA NONA – FISCALIZAÇÃO</h5>	
					<p style="text-align: justify;">	
					9.1. A fiscalização da execução do objeto será efetuada por representante designado pelo CISA.

					</p>	

				<h5 style="background-color:LightGray;">10. CLÁUSULA DÉCIMA – ALTERAÇÕES</h5>	
						<p style="text-align: justify;">	
						10.1. Eventuais alterações contratuais reger-se-ão pela disciplina do art. 124 da Lei nº 14.133/2021.
						</p>	
						<p style="text-align: justify;">	
						10.2. A CONTRATADA é obrigada a aceitar, nas mesmas condições contratuais, os acréscimos ou supressões que se fizerem necessários, até o limite de 25% (vinte e cinco por cento) do valor inicial atualizado do contrato.	
						</p>	

				<h5 style="background-color:LightGray;">11. CLÁUSULA DÉCIMA PRIMEIRA - DO FORO</h5>	
						<p style="text-align: justify;">	
							11.1. O foro para dirimir os possíveis litígios que decorrerem da utilização do presente contrato, será o da Comarca de Ijuí - RS. Os casos omissos serão resolvidos de acordo com a Lei nº 14.133/2021, demais normas aplicáveis e ao disposto no edital de Pregão Eletrônico nº '.$npregao.'.
						</p>	


<p style="text-align: right;">
Ijuí, '.$dia.' de '.$mes.' de '.$ano.'.
</p>	

<p style="text-align: center;">


<br>
<br>
<br>
________________________________________<br>
'.$nome.'<br>
Presidente do CISA<br>

<br>
<br>
<br>



______________________________________ <br>
'.$nomefornecedor.' <br>
Representante Legal <br>

<br>
<br>
<br>



__________________________________ <br>
GILBERTO FERNANDO SCAPINI <br>
Assessor Juridico – CISA <br>
OAB/RS 28.440 


</p>

		


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