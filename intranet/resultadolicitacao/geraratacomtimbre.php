<?php	
	session_start();
	$cnpj = $_GET['cnpj'];
	$codlic=$_SESSION['codlic'];


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
			$html .= '<td align="center">UNIDADE</td>';
			
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
			<BR>
			<h4> ATA DE REGISTRO DE PREÇOS Nº '.$npregao.' <br>
			 PREGÃO ELETRÔNICO Nº '.$npregao.'  <br>
			 PROCESSO Nº '.$nprocesso.'
			 </h4>
<BR>
			<p style="text-align: justify;">
			Aos '.$dia.' dias do mês de '.$mes.' de '.$ano.', o CISA -  Consórcio Intermunicipal do Noroeste do estado do RS, pessoa jurídica de direito público, inscrita no CNPJ sob o n.º 02.231.696/0001-92, com sede na Rua Barão do Rio Branco, 121, Bairro Centro, no Município de Ijuí/RS, representada pelo Presidente Sr. '.$nome.', prefeito de Ijuí/RS, doravante denominado de ÓRGÃO GERENCIADOR e a empresa <b>'.$nomefornecedor.'</b>, pessoa jurídica de direito privado, estabelecida na '.$endereco.', Bairro '.$bairro.', na cidade de '.$cidade.'- '.$estado.', CEP:'.$cep.', inscrita no CNPJ sob nº '.$cnpjm.', neste ato representados(as) pela <b>SR(A). '.$representante.'</b>,
			 doravante denominada DETENTORA DA ATA DE REGISTRO DE PREÇOS resolvem, com integral observância das normas: Lei Geral de Licitações n.º 14.133, de 1º de abril de 2021, Lei Complementar nº 123, de 14 de dezembro de 2006, e alterações, e, ainda, pelas condições estabelecidas pelo edital e suas partes integrantes, FIRMAR A PRESENTE ATA DE REGISTRO DE PREÇOS - ARP REFERENTE AO PREGÃO ELETRÔNICO acima referenciado e PREÇOS REGISTRADOS das respectivas propostas apresentadas, classificadas, aceitas/negociadas no certame, conforme as Cláusulas e condições que seguem:

				</p>
				


				
				<h5 style="background-color:LightGray;">CLÁUSULA PRIMEIRA – DO OBJETO</h5>
			
								<p style="text-align: justify;">
					1.1 A presente ata tem por objeto o Registro de Preços de materiais , produtos e equipamentos odontológicos, em conformidade com as especificações contidas no Edital e seu Termo de Referência.
					</p>
				<p style="text-align: justify;">
				1.2 A GERENCIADORA DA ATA não se obriga a contratar a quantidade total ou parcial do objeto adjudicado constante do Edital e da Ata de Registro de Preços.
				</p>
			
			<h5 style="background-color:LightGray;">CLÁUSULA SEGUNDA – PREÇOS REGISTRADOS</h5>

				<p style="text-align: justify;">
				2.2 Nos valores registrados, incluem-se todos e quaisquer materiais, encargos fiscais, trabalhistas, previdenciários, fretes, seguros e mão de obra.
				</p>
				<p style="text-align: justify;">

				2.2 A empresa detentora da ata, terá os preços registrados da tabela abaixo, tendo sido o referido preço oferecido pela licitante cuja proposta foi classificada em 1º (primeiro) lugar.
				</p>


				'.$html.'
				 
			<h5 style="background-color:LightGray;">CLÁUSULA TERCEIRA – ENTREGA DO OBJETO</h5>
				
<BR>
				
				<p style="text-align: justify;">
					3.1 Os itens serão adquiridos conforme a necessidade do órgão gerenciador, mediante emissão de Nota de Empenho devidamente assinada, com identificação do respectivo servidor público  competente.
				</p>
					<p style="text-align: justify;">
				3.2 Os itens deverão ser adquiridos a partir da assinatura e publicação da Ata de Registro de Preços até findar a vigência da mesma.
				</p>
					<p style="text-align: justify;">
				3.3 A não entrega do objeto será motivo de aplicação das penalidades previstas nesta Ata de Registro de Preços, bem como nas sanções elencadas no Edital do Pregão, e ainda conforme rege o Art. 155 e 156 da Lei Federal n.º 14.133/2021.
				</p>
					<p style="text-align: justify;">
				3.4 O prazo limite para a entrega do objeto não ultrapassará o período de 08 (Oito) dias úteis a partir do momento em que a Nota de Empenho for recebida pela empresa vencedora.
				</p>
				<ol type="a" style="text-align: justify;">
				<li>				
				Caso a empresa necessite prorrogar o prazo, é imprescindível que, antecedendo o fim do mesmo, seja formalizado um requerimento fundamentado apresentando as justificativas pertinentes, as quais passarão por um processo de análise e avaliação.
				</li>
				<li>	
				Compete à empresa contratada assumir as despesas referentes à entrega do objeto, as quais serão consideradas como integrantes do preço apresentado pela respectiva empresa.
				</li>
				<li>	
				A entrega deverá ser realizada no Endereço que segue:  CEO – Centro de Especialidade Odontológica, sito à Rua  João  Perondi , 45- em Frente ao Cacon – Cep: 98.700-000, no Município de Ijuí RS. No horário das 08:30hs às 11:45hs e das 13:00 hs às  17:00 horas.
				</li>
				<li>	
				 No caso de descumprimento dos prazos determinados para entrega do objeto e/ou entrega em desacordo com o solicitado, poderão ser aplicadas as sanções e penalidades constantes no Edital.
				</li>
				<li>	
				Não serão aceitos produtos de marcas e/ou modelos , prazos de validade inferior á 12 meses diferentes daqueles constantes na proposta de preços vencedora  e na Ata de Registro de Preços.
				</li>
				</ol>
			
				

		<h5 style="background-color:LightGray;">CLÁUSULA QUARTA – VIGÊNCIA E PUBLICIDADE DA ATA</h5>
					<p style="text-align: justify;">
					4.1 Esta Ata de Registro de Preços deverá ser assinada por representante legal, diretor, ou sócio da empresa, com apresentação, conforme o caso e respectivamente, de procuração ou contrato social.

					<p style="text-align: justify;">
					4.2 A Ata de Registro de Preços terá validade de 1 (um) ano, a contar da data da assinatura da Ata, podendo ser prorrogada na forma do art. 84º da Lei n. 14.133, de 1º de abril de 2021.
					</p>
					<p style="text-align: justify;">
					4.3 A Ata de Registro de Preços referente ao Pregão Eletrônico supracitado, terá seu extrato publicado no Portal Nacional de Contratações Públicas (PNCP), e a sua íntegra, após assinada e homologada e será disponibilizada no sítio oficial desta Municipalidade.
					</p>
					<p style="text-align: justify;">
					4.4 É vedado efetuar acréscimos nos quantitativos fixados pela ata de registro de preços.
					</p>
				

			<h5 style="background-color:LightGray;">CLÁUSULA QUINTA – PAGAMENTO </h5>
				
					<p style="text-align: justify;">
					5.1 O pagamento das faturas à licitante vencedora será efetuado mediante a apresentação da Nota Fiscal referente ao objeto da presente ata, que será conferida e atestada por responsável da Administração, acompanhado das autorizações formais emitidas, devidamente assinada por servidor identificado e autorizado para tal, desde que, no ato do recebimento sejam atendidas todas as especificações do Termo de Referência, que passa a fazer parte integrante desta Ata de Registro de Preço.
					</p>
				<p style="text-align: justify;">
				5.2 O prazo para a efetivação do pagamento observará a ordem cronológica para cada fonte diferenciada de recursos referente ao objeto e será de até 30 (TRINTA) DIAS após a emissão da Nota Fiscal, acompanhada da(s) respectiva(s) autorizações formais e demais documentação necessária, de acordo com o Termo de Referência, desde que não haja fator impeditivo provocado pela Detentora da Ata, conforme preconiza o Art. 141, da Lei Geral n.º 14.133/2021.
				</p>
				<p style="text-align: justify;">
				5.3 Nenhum pagamento será efetuado à Detentora da Ata enquanto pendente de liquidação, qualquer obrigação financeira que lhe for imposta, em virtude de penalidade ou inadimplência, que poderá ser compensada com o(s) pagamento(s) pendente(s), sem que isso gere direito a acréscimos de qualquer natureza.
				</p>


				<h5 style="background-color:LightGray;">CLÁUSULA SEXTA – ALTERAÇÕES DA ATA DE REGISTRO DE PREÇOS </h5>

					<p style="text-align: justify;">
					6.1 A Ata de Registro de Preços poderá sofrer alterações, obedecidas as disposições contidas na Lei nº 14.133, de 1 de abril de 2021.
					</p>
				<p style="text-align: justify;">
				6.2 Os valores registrados na Ata de Registro de Preços são fixos e irreajustáveis, salvo com a condição de restabelecer o equilíbrio econômico-financeiro desta Ata, mediante requerimento e justificativa expressos do Detentor e comprovação documental, decorrência de eventual redução dos preços praticados no mercado ou de fato que eleve o custo dos serviços ou bens registrados, cabendo ao órgão gerenciador promover as negociações junto aos fornecedores, observadas as disposições contidas na legislação.
					</p>
				<p style="text-align: justify;">
				6.3 O gerenciador da ata de registro de preços acompanhará a evolução dos preços de mercado, com a finalidade de verificar sua compatibilidade com aqueles registrados na ata.
					</p>
				<p style="text-align: justify;">
				6.4 Quando o valor registrado se tornar inferior ao preço praticado no mercado por motivo superveniente, o órgão gerenciador convocará os fornecedores para negociarem a redução dos preços aos valores praticados pelo mercado.
					</p>
				<p style="text-align: justify;">
				6.4.1. Os fornecedores que não aceitarem readequar seus valores propostos aos valores praticados pelo mercado serão liberados do compromisso assumido, sem aplicação de penalidade.
					</p>
				<p style="text-align: justify;">
				6.5. Se ocorrer de o preço de mercado tornar-se inferior aos preços registrados e o fornecedor não puder cumprir o compromisso, o Órgão gerenciador poderá:
					</p>

				<ol type="a" style="text-align: justify;">
				<li>
				Liberar o fornecedor do compromisso assumido, caso a comunicação ocorra antes do pedido de execução, e sem aplicação da penalidade se confirmada a veracidade dos motivos e comprovantes apresentados;
				</li>
				<li>
			   Convocar os demais fornecedores para assegurar igual oportunidade de negociação.
				</li>
				</ol>

				<p style="text-align: justify;">
				6.6. Não havendo êxito nas negociações, o Órgão gerenciador deverá proceder à revogação da ata de registro de preços, adotando as medidas cabíveis para obtenção da contratação mais vantajosa.
				</p>
				<p style="text-align: justify;">
				6.7. O registro do fornecedor será cancelado mediante formalização por despacho do órgão gerenciador, assegurado o contraditório e a ampla defesa, quando o fornecedor:
				</p>

				<ol type="a" style="text-align: justify;">
				<li>			
				 Descumprir as condições da ata de registro de preços;
				</li>
								<li>
				 Não retirar a nota de empenho ou instrumento equivalente no prazo estabelecido pela Administração, sem justificativa aceitável;
				</li>
								<li>
				Não aceitar aumentar o valor registrado na hipótese deste se tornar inferior àqueles praticados no mercado;
				</li>
								<li>
				Sofrer sanção prevista no art. 156 incisos I ao IV da Lei nº 14.133, de 1 de abril de 2021.
				</li>
								
				</ol>
				<p style="text-align: justify;">

				6.8 O cancelamento do registro de preços poderá ocorrer por fato superveniente, decorrente de caso fortuito ou força maior, que prejudique o cumprimento da ata, devidamente comprovados e justificados:
				</p>

				<ol type="a" style="text-align: justify;">
				<li>	
				Por razão de interesse público;
				</li>
				<li>
				A pedido do fornecedor.;
				</li>

				</ol>					


				<h5 style="background-color:LightGray;">CLÁUSULA SÉTIMA – OBRIGAÇÕES DAS PARTES</h5>

				<p style="text-align: justify;">
				Além das obrigações resultantes da observância da Lei nº 14.133, de 1 de abril de 2021, são obrigações:
				</p>


				<p style="text-align: justify;">
				7.1 Da Fornecedora/Beneficiária:
				</p>
				
				<ol type="a" style="text-align: justify;">
		  				<li>
							Executar com pontualidade o objeto contratado conforme solicitação/requisição emitida pelo Município, devidamente assinada por servidor competente para tal;
						</li>
						<li>
							Comunicar imediatamente e por escrito aos fiscais técnicos e administrativos deste procedimento administrativo, qualquer anormalidade verificada, para que sejam adotadas as providências de regularização necessárias;
						</li>
						<li>
							Atender com prontidão às reclamações por parte do recebedor, objeto da presente Ata;
						</li>
						<li>
							Manter todas as condições de habilitação exigidas na presente licitação;
						</li>
						<li>
							Comunicar a esta Administração qualquer modificação em seu endereço ou informações de contato, sob pena de se considerar perfeita a notificação realizada no endereço constante nesta Ata;
						</li>
						<li>
						Cumprir todas as obrigações de execução dos serviços/fornecimento dos produtos descritas no Termo de Referência, que passa a fazer parte desta Ata de Registro de Preço;

						</li>								
				</ol>

				<p style="text-align: justify;">
				7.1.1 Todos os materiais, mão de obra, impostos, taxas, fretes, seguros e encargos sociais e trabalhistas, que incidam ou venham a incidir sobre a presente Ata de Registro de Preços ou decorrentes de sua execução serão de exclusiva responsabilidade da empresa Fornecedora.
				</p>

				<p style="text-align: justify;">
				7.1.2 Executar os serviços de acordo com as especificações contidas no TERMO DE REFERÊNCIA.
				</p>

				<p style="text-align: justify;">
				7.2. Do Órgão Gerenciador:
				</p>

				<ol type="a" style="text-align: justify;">
				<li> 
				 Cumprir todos os compromissos financeiros assumidos com a Fornecedora/Detentora desde que não haja impedimento legal para o fato;
				</li>
				<li> 
			 Gerenciar e fiscalizar a execução desta Ata de Registro de Preços, nos termos da Lei nº 14.133, de 1 de abril de 2021;
				</li>
				<li> 
			 Notificar, formal e tempestivamente a Fornecedora/Detentora sobre as irregularidades observadas no cumprimento desta Ata;
				</li>
				<li> 
			Notificar a Fornecedora/Detentora por escrito e com antecedência, sobre multas, penalidades e quaisquer débitos de sua responsabilidade;
				</li>
				<li> 
				 Aplicar as sanções administrativas contratuais pertinentes, em caso de inadimplemento;
				</li>
				<li> 
			 Prestar à contratada todos os esclarecimentos necessários à execução da Ata de Registro de Preço;
				</li>
				<li> 
			Arcar com as despesas de publicação do extrato desta Ata;
				</li>
				<li> 
				Emitir requisição interna.
				</li>
				</ol>
	


		<h5 style="background-color:LightGray;">CLÁUSULA OITAVA – RESCISÃO DA ATA DE REGISTRO DE PREÇOS</h5>

				<p style="text-align: justify;">
				8.1 A Ata de Registro de Preço poderá ser rescindida de pleno direito:
				</p>
				<p style="text-align: justify;">
				8.2. Pela Administração independentemente de interpelação judicial, precedido de processo administrativo com ampla defesa, quando:
				</p>
					
					<ol type="a" style="text-align: justify;">
			  			<li> 
							A Detentora não cumprir as obrigações constantes da Ata de Registro de Preços;
						</li> 
						<li> 
							A Detentora não formalizar Ata de Registro de Preços decorrente ou não retirar o instrumento equivalente no prazo estabelecido, sem justificativa aceita pela Administração;
						</li> 
						<li> 
							A Detentora der causa a rescisão administrativa da Ata de Registro de Preços;
						</li> 
						<li> 
							Em qualquer das hipóteses de inexecução total ou parcial da Ata de Registro de Preços;
						</li> 
						<li> 
							Por razões de interesse público, devidamente justificado pela administração;
						</li> 
						<li> 
							No caso de falência ou instauração de insolvência e dissolução da sociedade da empresa Detentora;
						</li> 
						<li> 
							Caso ocorra transferência a terceiros, ainda que em parte, das obrigações assumidas pela empresa detentora;
						</li> 
						<li>  
						Caso não seja assinada a Ata de Registro de Preço no prazo de 05 (cinco) dias úteis contados do recebimento da convocação, podendo ser prorrogado uma vez, desde que solicitado por escrito, antes do término previsto, e com exposição de motivo justo que poderá ser aceito ou não pela Administração;
						</li> 
						<li>  
						A Licitante que convocada para assinar o documento deixar de fazê-lo no prazo fixado acima será excluída;
							
						</li>


					</ol>

					<p style="text-align: justify;">
						8.3 Pela Detentora quando:
					</p>
						
		<ol type="a" style="text-align: justify;">
			  			<li> 
							 Mediante solicitação escrita, comprovar a ocorrência de caso fortuito ou força maior;
					</li>
					<li>
					 A solicitação da Detentora para cancelamento do desconto registrado deverá ocorrer antes do pedido de execução dos serviços/ entrega dos produtos por esta Consórcio;
					</li>
					<li>
					A inexecução total ou parcial das obrigações pactuadas na presente Ata de Registro de Preços enseja a rescisão do objeto, unilateralmente pela Administração, ou bilateralmente, com as consequências contratuais e as previstas em lei ou no Ato Convocatório, mediante formalização e assegurados o contraditório e ampla defesa, com fundamento na Lei nº 14.133/2021, contudo, sempre atendida a conveniência administrativa.
					</li>
					<li>
					Poderá ainda ser rescindido por mútuo consentimento, ou unilateralmente pela Administração, a qualquer tempo, mediante notificação prévia de 30 (trinta) dias à DETENTORA, por motivo de interesse público e demais hipóteses previstas na Lei, ou ainda, judicialmente, nos termos da legislação pertinente. Da rescisão procedida com base nesta cláusula não incidirá multa ou indenização de qualquer natureza.
					</li>
					
			</ol>

					<p style="text-align: justify;">
						8.4 A comunicação do cancelamento do desconto registrado, nos casos previstos em Lei, será feita por correspondência com aviso de recebimento, juntando-se o comprovante aos autos que deram origem ao Registro de Preços;
					</p>

					<p style="text-align: justify;">
						8.4.1 No caso de ser ignorado, incerto ou inacessível o endereço da Detentora, a comunicação será feita por publicação na imprensa oficial, por 01 (uma) vez, considerando-se cancelado o preço registrado a partir da última publicação.
					</p>

					<h5 style="background-color:LightGray;">CLÁUSULA NONA – PENALIDADES </h5>
					
					<p style="text-align: justify;">
					9.1 Sem prejuízo da cobrança de perdas e danos, o órgão gerenciador poderá sujeitar a Detentora/Contratada as penalidades previstas na Lei 14.133, de 1º de abril de 2021.
					</p>
					<p style="text-align: justify;">
					9.2. A Detentora/Contratada será notificada por escrito para recolhimento da multa aplicada, o que deverá ocorrer no prazo de 15 (quinze) dias úteis dessa notificação.
					</p>
					<p style="text-align: justify;">
					9.2.1 Se não ocorrer o recolhimento da multa no prazo fixado, o seu valor será deduzido das faturas remanescentes.
					<p style="text-align: justify;">
					9.3 A recusa injustificada da adjudicatária em assinar a Ata de Registro de Preços, aceitar ou retirar o instrumento equivalente dentro do prazo estabelecido pela Administração, caracteriza o descumprimento total da obrigação assumida, podendo a Administração aplicar as penalidades cabíveis.

					</p>


		<h5 style="background-color:LightGray;">CLÁUSULA DÉCIMA – GERENCIAMENTO E OBRIGAÇÕES DO ÓRGÃO GERENCIADOR</h5>
					<p style="text-align: justify;">


					10.1 O Órgão Gerenciador desta Ata de Registro de preços será o CISA/RS.

					</p>
					<p style="text-align: justify;">
					10.2 São obrigações do Órgão Gerenciador da Ata de Registro de Preços, dentre a prática de todos os atos de controle e administração da ARP, as seguintes obrigações:
					</p>
					<ol type="a" style="text-align: justify;">
				<li> 
				Gerenciar a presente ata, indicando sempre que solicitado, o nome do detentor da ata, o preço e as especificações dos materiais registrados, observada a ordem de classificação indicada na licitação.
				</li>
				<li> 
				Observar que, durante a vigência da presente ata, sejam mantidas todas as condições de habilitação e qualificação exigidas na licitação, bem assim, a compatibilidade com as obrigações assumidas.
				 </li>
				<li> 
				Conduzir eventuais procedimentos administrativos de renegociação de preços registrados, para fins de adequação as novas condições de mercado, e de aplicação de penalidades.
				</li>
				<li> 
				Acompanhar a evolução dos preços de mercado, com a finalidade de verificar sua compatibilidade com aqueles registrados na ata.
				 </li>
				<li> 
				Acompanhar e fiscalizar o cumprimento das condições ajustadas na presente Ata.
				</li>
				<li> 
				 Consultar o detentor da ata registrada (observando a ordem de classificação) quanto ao interesse em fornecer os materiais a outro(s) órgão da Administração Pública que externem a intenção de utilizar a presente Ata.
				</li>
				<li> 
				Fiscalizar o bom atendimento do objeto contratado através de Servidor designado para tal.
				</li>
				</ol>

<h5 style="background-color:LightGray;">CLÁUSULA DÉCIMA PRIMEIRA – DISPOSIÇÕES GERAIS</h5>
					<p style="text-align: justify;">
		<p style="text-align: justify;">

		11.1 As despesas correrão por conta da Dotação Orçamentária consignada no Orçamento deste Consórcio, podendo haver apostilamentos justificáveis das mesmas.
</p>
					<p style="text-align: justify;">


11.2 Reger-se-á a presente Ata de Registro de Preços, no que for omisso, pelas disposições constantes na Lei 14.133, de 1º de abril de 2021 e pelas condições estabelecidas pelo no Edital do Pregão Eletrônico do qual ela se originou.

</p>
					<p style="text-align: justify;">
11.3 Para dirimir quaisquer dúvidas decorrentes do presente instrumento, fica eleito o Foro da Comarca de Ijuí/RS com renúncia expressa de qualquer outro, por mais privilegiado que seja.
</p>
					<p style="text-align: justify;">

11.4 Justos e acordados firmam o presente, em três vias de igual teor e forma na presença de duas testemunhas, para que produza os efeitos legais.
</p>

<p style="text-align: right;">
Ijui/RS, 05 de Dezembro de 2025.
</p>

<BR>
<BR>



<table style="width:100% ; border: none; font-size: 12px">

  
  <tr Style="border: none">
  <td style="text-align: center; border: none">
  ____________________________________________<br>
  CONSÓRCIO INTERMUNICIPAL DO NOROESTE DO ESTADO DO RS<BR>
	CNPJ nº 02.231.696/0001-92 <br>
'.$nome.'<br>
	CPF nº '.$cpf.' <br>
	Presidente <br>
	Contratante<br>

  </td>
    <td style="text-align: center ; border: none">
_______________________________________________<br>
    '.$nomefornecedor.'<br>
    CNPJ nº '.$cnpjm.'<br>
    '.$representante.'<br>
    CPF nº '.$cpfr.' <br>
	Representante Legal<br>
	Contratada

	</td>
 
  </tr>
 
</table>

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