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
	
	$cpfr= $row['cpf'];
    

    

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


			
			<h3> PROCESSO LICITATÓRIO Nº '.$nprocesso.' <br>
			 PREGÃO ELETRÔNICO Nº '.$npregao.'  <br>
			 CONTRATO Nº '.$ncontrato.'
			 </h3>

			<p style="text-align: justify;">
			Contrato celebrado entre o <b>CISA – CONSÓRCIO INTERMUNICIPAL DE SAÚDE DO NOROESTE DO ESTADO DO RIO GRANDE DO SUL</b>, Pessoa Jurídica de Direito Público, de natureza autárquica, CNPJ nº 02.231.696/0001-92, com sede na Rua Barão do Rio Branco, nº 121, em Ijuí/RS, neste ato representado por seu Presidente, Sr. '.$nome.', brasileiro, casado, identidade nº. '.$rg.'- SSP/RS e do CPF nº.'.$cpf.', doravante denominado de CONSÓRCIO/CONTRATANTE, e do outro lado a empresa		
			
			
		 <b>'.$nomefornecedor.'</b>, CNPJ nº '.$cnpjm.', estabelecida na cidade de '.$cidade.'- '.$estado.', na '.$endereco.', Bairro '.$bairro.'- CEP:'.$cep.', que apresentou os documentos exigidos por lei, adiante denominado(s) de Fornecedor(es) Beneficiário(s), neste ato representado(a) pelo(a) <b>SR(A). '.$representante.'</b>, portador do CPF nrº '.$cpfr.' e da célula de identidade nº '.$rgr.', doravante denominado(a) CONTRATADO(A), para a execução do objeto descrito na Cláusula Primeira do contrato. 

			</p>
			
				<h3>CLÁUSULA PRIMEIRA - DO OBJETO</h3>
				<p style="text-align: justify;">			
				
					O presente contrato tem como objeto a aquisição de Medicamentos Humanos, especificados no
quadro abaixo:
					'.$html.'

					</p>
			
<h3>CLÁUSULA SEGUNDA - DO VALOR</h3>
<p style="text-align: justify;">

O valor do presente Termo de Contrato é de R$ <b>'.number_format($valortotal, 2, ',', '.').'</b>.
</p>

<p style="text-align: justify;">
No valor acima estão incluídas todas as despesas ordinárias diretas e indiretas decorrentes da execução contratual, inclusive tributos e/ou impostos, encargos sociais, trabalhistas, previdenciários, fiscais e comerciais incidentes, taxa de administração, frete, seguro e outros necessários ao cumprimento integral do objeto da contratação.</p>
			
</p>				

				<h3>CLÁUSULA TERCEIRA - DO RECURSO FINANCEIRO</h3>
				<p style="text-align: justify;">
					As despesas decorrentes do presente contrato correrão à conta das dotações
orçamentárias próprias.

				
				<h3>CLÁUSULA QUARTA - DO REAJUSTAMENTO DOS PREÇOS</h3>
				<p style="text-align: justify;">
				
					O valor do contrato não sofrerá reajuste, ressalvada a hipótese mencionada no Art. 65, Inciso II, alínea “d” da Lei Federal 8.666/93, isto é, a manutenção do equilíbrio econômico-financeiro inicial.
				</p>

				<h3>CLÁUSULA QUINTA - DO PAGAMENTO </h3>

					<p style="text-align: justify;">
					O pagamento será efetuado em 02 (duas) parcelas, de igual valor, ou seja, a 1ª (Primeira)
parcela em 30 (Trinta) dias e a 2ª (Segunda) parcela em 60 (Sessenta) dias, contando a partir da DATA
DO RECEBIMENTO da Mercadoria, conforme Nota Fiscal. O pagamento será efetuado mediante Crédito
em Conta Corrente Bancária, indicados pelo fornecedor na proposta vencedora ajustada ao lance, contendo
a descrição dos produtos, quantidades, banco, código da agência e o número da conta corrente da empresa,
para efeito de pagamento preços unitários e o valor total e nota de entrega atestada.
</p>
<p style="text-align: justify;">
No caso de incorreção nos documentos apresentados, inclusive na Nota Fiscal, serão os mesmos
restituídos à adjudicatária para as correções necessárias, não respondendo o CISA por quaisquer encargos
resultantes de atrasos na liquidação dos pagamentos correspondentes e o prazo de pagamento será contado
da data de reapresentação do documento corretamente preenchido.		

					</P>

				
	
<h3>CLÁUSULA SEXTA - DA VIGÊNCIA DO CONTRATO </h3>
<p style="text-align: justify;">
O prazo de vigência do presente contrato será de até 60 (sessenta dias) podendo ser prorrogado
por igual(is) período(s), sucessivas vezes, se acordado entre as partes, até o limite disposto no artigo 57, II,
da Lei Federal nº 8.666/93.
</p>


<h3>CLÁUSULA SÉTIMA – LOCAIS/PRAZO DE ENTREGA/NOTA FISCAL </h3>
<p style="text-align: justify;">

<ol type="a" style="text-align: justify;">
<li>

Os produtos deverão ser entregues conforme Nota de Empenho, sendo recebidos/conferidos pela
farmacêutica responsável pelo CISA.
</li>
<li>
PRAZO DE ENTREGA: no máximo QUINZE (15) DIAS CORRIDOS após o recebimento do
pedido de autorização de fornecimento de medicamento devidamente numerado.
</li>
<li>
Local e Horário de entrega: Os medicamentos deverão ser entregues no seguinte endereço: Rua Barão
do Rio Branco, 121– Centro – Ijuí – RS,das 08h30min às 11h30min e das 13h00min às 17h00min, a
critério da Contratante – CISA;
</li>
<li>
Somente serão aceitos os medicamentos que apresentarem, no mínimo, 12 (doze) meses de validade,
contados a partir da data de entrega na sede do CISA. Para aqueles medicamentos cuja validade geral
é menor que 12 meses, deverão possuir, a contar do momento da entrega, no mínimo 75% (setenta e
cinco por cento) de seu prazo de validade total;
</li>
<li>
A entrega e o descarregamento dos produtos é de responsabilidade da licitante vencedora.
</li>
<li>
O Certificado de Análise de cada MEDICAMENTO/LOTE deverá ser encaminhado via e-mail ou
vir anexado na Nota Fiscal. O Certificado de Análise deverá comprovar o atendimento às
especificações previstas pela(s) farmacopéia(s) para o princípio ativo e de forma farmacêutica.
</li>
<li>
Transmitir os arquivos das Notas Fiscais em formato XML, para o e-mail: cisaxml@hotmail.com.
</li>
<li>
As embalagens primárias dos medicamentos (ampolas, blisters, strips e frascos) devem apresentar o
número do lote, data de fabricação e prazo de validade e a inscrição explícita da informação:“VENDA
PROIBIDA AO COMÉRCIO”, nas referidas
</ol>

</p>


<h3>CLÁUSULA OITAVA – DA GARANTIA DA EXECUÇÃO DO CONTRATO </h3>

<p style="text-align: justify;">
Somente serão realizados os pagamentos, após a devida liquidação da despesa, conferindo
previamente se os objetos estão de acordo com o presente contrato e o edital.
<p>


	<h3>CLÁUSULA NONA - DO RECEBIMENTO DO OBJETO</h3>

<p style="text-align: justify;">
Entregando os materiais licitados de acordo com a proposta homologada pela autoridade
contratante, e estando de acordo com o previsto no edital de licitação e nas cláusulas contratuais e, ainda,
observada a legislação em vigor, serão recebidos pela CONTRATANTE.

	</p>


<h3>CLÁUSULA DÉCIMA - DOS DIREITOS E DAS OBRIGAÇÕES </h3>

<p style="text-align: justify;">
<b>Dos Direitos </b>
</p>

<p style="text-align: justify;">
Dá CONTRATANTE: receber o objeto deste contrato nas condições avençadas; e
</p>
<p style="text-align: justify;">

Do(a) CONTRATADO(A):
</p>
<p style="text-align: justify;">
a) perceber o valor ajustado na forma e no prazo convencionados; e

</p>
<b>Das Obrigações </b>
<p style="text-align: justify;">
Dá CONTRATANTE:

</p>
<ol type="a" style="text-align: justify;">
<li>
efetuar o pagamento ajustado; e
</li>
<li>
 dar a(o) CONTRATADO(A) as condições necessárias à regular execução do contrato.
</li>
</ol>
<p style="text-align: justify;">
Do(a) CONTRATADO(A):
</p>
<ol type="a" style="text-align: justify;">
<li>
entregar os materiais licitados na forma ajustada;
</li>
<li>
 manter durante toda a execução do contrato, em compatibilidade com as obrigações por ele assumidas, todas as condições de habilitação e qualificação exigidas na licitação;
</li>
<li>
apresentar durante a execução do contrato, se solicitado, documentos que comprovem estar cumprindo a legislação em vigor;
</li>
<li>
 repor ou efetuar a substituição, às suas expensas, no total ou em parte, os materiais em que se verificarem vícios ou defeitos, independentemente das penalidades aplicáveis ou cabíveis;
</li>
</ol>




				<h3>CLÁUSULA DÉCIMA PRIMEIRA - DA INEXECUÇÃO DO CONTRATO </h3>
					<p style="text-align: justify;">
					
					O(A) CONTRATADO(A) reconhece os direitos da Administração, em caso de rescisão administrativa, previstos no art. 77 da Lei Federal n° 8.666/93.
					
					</p>

				<h3>CLÁUSULA DÉCIMA SEGUNDA - DA RESCISÃO</h3>
				<p style="text-align: justify;">
				Este contrato poderá ser rescindido de acordo com art. 77, 78, 79 e 80 da Lei Federal n° 8.666/93.
				</P>
				<p style="text-align: justify;">
				A rescisão deste contrato implicará retenção de créditos decorrentes da contratação, até o limite dos prejuízos causados à CONTRATANTE, bem como na assunção do objeto do contrato pela CONTRATANTE na forma que a mesma determinar.</p>


				<h3>CLÁUSULA DÉCIMA TERCEIRA - DAS PENALIDADES E DAS MULTAS</h3>

					<p style="text-align: justify;">
					As penalidades contratuais são as previstas no artigo 7º da Lei 10.520/2002 e artigo 28 do Decreto n. 5.450/2005. Além do previsto no caput desta cláusula, pelo descumprimento total ou parcial das obrigações assumidas na Ata de Registro de Preços e pela verificação de quaisquer das situações prevista no art. 78, incisos I a XI e XVIII da Lei nº 8.666/93, garantida a defesa prévia ao contratado, a administração poderá aplicar as seguintes penalidades:.</p>
					
					<ol type="A" style="text-align: justify;">
			  			<li> 
							Advertência, por escrito, inclusive registrada no cadastro específico (SICAF);
						</li>
						<li>
							Esgotado o prazo de entrega dos medicamentos, por inexecução total, será aplicada multa de
25%(Vinte e Cinco por cento) sobre o valor total do pedido de compra.
						</li>
						<li>
						Pela inexecução parcial do ajuste, multa de 15 % (Quinze por cento), calculada sobre a soma
dos valores dos objetos não entregues;
						</li>
						<li>
						Suspensão temporária do direito de licitar e impedimento de contratar com a Administração Pública, pelo prazo de até 02 (dois) anos, quando da inexecução ocasionar prejuízos à Administração;
						</li>

						
				  		<li> 
								Declaração de inidoneidade para licitar ou contratar com a Administração Pública, enquanto perdurarem os motivos determinantes da punição ou até que seja promovida a reabilitação;
						</li>
						<li>
							 Se o licitante deixar de entregar a documentação ou apresentá-la falsamente, ensejar o retardamento da execução de seu objeto, não mantiver a proposta, falhar ou fraudar no processo licitatório, comportar-se de modo inidôneo ou cometer fraude fiscal, ficará pelo prazo de até 05 (cinco) anos, impedido de contratar com a Administração Pública, sem prejuízos das multas previstas neste Edital e das demais cominações legais;
						</li>
						<li>
						A sanção de advertência poderá ser aplicada nos seguintes casos:
							<ol type="I" style="text-align: justify;">

							<li>
							Descumprimento das determinações necessárias à regularização das faltas ou defeitos observados na entrega dos produtos;

							</li>
							<li>

							Outras ocorrências que possam acarretar transtornos no desenvolvimento dos serviços das Secretarias Municipais de Saúde, desde que não caiba aplicação de sanção mais grave;
							</li>

							</ol>

						</li>
						<li>
						A penalidade de suspensão será cabível quando o licitante participar do certame e for verificada a existência de fatos que o impeçam de contratar com a Administração Pública.
						</li>

						<li>
						Se o valor da multa não for pago, ou depositada, será automaticamente descontado do pagamento a que a Contratada fizer jus. Em caso de inexistência ou insuficiência de crédito da Contratada o valor devido será cobrado administrativamente e/ou judicialmente.
						</li>
						
					</ol>

				


					<h3>CLÁUSULA DÉCIMA QUARTA - DAS DISPOSIÇÕES GERAIS</h3>
					<p style="text-align: justify;">
					Fica eleito o Foro da Comarca de Ijuí/RS para dirimir dúvidas ou questões oriundas do presente contrato.
					E por estarem as partes justas e contratadas, assinam o presente Contrato em duas vias, de igual teor, na presença das testemunhas abaixo assinadas.
					</p>

<p style="text-align: right;">
Ijuí/RS,'.$dia.' de '.$mes.' de '.$ano.'.
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