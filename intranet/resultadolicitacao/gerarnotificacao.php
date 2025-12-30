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
	$representante=$row['representante'];	
	$cpfr= preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $row['cpf']);
    $rgr=  $row['rg'];


	// ITENS DO FORNECEDOR
    $html = '<!DOCTYPE html>';
    $html.= '<html>';
    $html.='  <head>';
    $html.=' </head>';
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
  	
	}

    @page {   
   		margin-top: 5cm;   
   		border: 1px solid blue;
	}
</style>';
    

    $html .= '<table>';	
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
		if ($row['unidade'] == 'Comprimido') {
			$html .= '<td align="center">CP</td>';
		} else if ($row['unidade']=='Frasco') {
			$html .= '<td align="center">FR</td>';
		}else if ($row['unidade']=='Ampola') {
			$html .= '<td align="center">AMP</td>';
		}else if ($row['unidade']=='Cartela') {
			$html .= '<td align="center">CT</td>';
		}else if ($row['unidade']=='Bisnaga') {
			$html .= '<td align="center">BNG</td>';
		}else if ($row['unidade']=='Caixa') {
			$html .= '<td align="center">CX</td>';
		}else if ($row['unidade']=='Unidade') {
			$html .= '<td align="center">UN</td>';
		}else if ($row['unidade']=='Dragea') {
			$html .= '<td align="center">DG</td>';
		}else if ($row['unidade']=='Lata') {
			$html .= '<td align="center">LT</td>';
		}else if ($row['unidade']=='C?psula') {
			$html .= '<td align="center">CAPS</td>';
		}else if($row['unidade']=='Vidro') {
			$html .= '<td align="center">VD</td>'; 
		}else if($row['unidade']=='Envelope') {
			$html .= '<td align="center">EV</td>'; 
		}else {
			$html .= '<td align="center">ARRUMAR UNIDADE</td>';
			
		};	
		

		$html .= '<td align="center">'.number_format($row['quantidade'], 0, ',', '.')."</td>";
		$html .= '<td align="center">'.mb_strtoupper($row['marca'],'UTF-8'). "</td>";
		$html .= '<td align="center"> R$ '.number_format($row['vlrunitario'], 4, ',', '.')."</td>";
		$html .= '<td align="center"> R$ '.number_format($row['vlrtotal'], 2, ',', '.')."</td></tr>";
		
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
			
			<h3> ATA DE REGISTRO DE PREÇOS Nº '.$npregao.' <br>
			 PREGÃO ELETRÔNICO Nº '.$npregao.'  <br>
			 PROCESSO Nº '.$nprocesso.'
			 </h3>

			<p style="text-align: justify;">
			Aos '.$dia.' dias do mês de '.$mes.' de '.$ano.', na sede do CISA, Pessoa Jurídica de Direito Público, CNPJ nº 02.231.696/0001-92, situada na Rua Barão do Rio Branco, 121, em Ijuí/RS, CEP 98700-000, neste ato representado por seu Presidente Sr. '.$nome.', portador da cédula de identidade nº'.$rg.' /SSP/PC RS, CPF nº '.$cpf.', tendo como partícipes o CISA – Consórcio Intermunicipal de Saúde do Noroeste do Estado do Rio Grande do Sul,  COMAJA – Consórcio de Desenvolvimento Intermunicipal dos Municípios do Alto Jacaui e COIS – Consórico Intermunicipal de Saúde, compreendendo os Municípios de Ajuricaba, Augusto Pestana, Barra do Guarita, Boa Vista do Cadeado, Bom Progresso, Bozano, Braga, Campo Novo, Catuipe, Chiapeta, Condor, Coronel Barros, Coronel Bicaco, Crissiumal, Derrubadas, Dois Irmãos das Missões, Esperança do Sul, Humaitá, Ijui, Inhacorá, Jóia, Miraguai, Nova Ramada, Panambi, Pejuçara, Pinheirinho do Vale, Redentora, Santo Augusto, São Martinho, São Valério do Sul, Sede Nova, Taquaruçu do Sul, Tenente Portela, Tiradentes do Sul, Tucunduva, Três Passos, Vista Alegre, Vista Gaúcha, Alto Alegre, Arvorezinha, Barros Cassal, Boa Vista do Incra, Campos Borges, Colorado, Cruz Alta, Espumoso, Fontoura Xavier, Fortaleza dos Valos, Ibirapuitã, Ibirubá, Itapuca, Jacuizinho, Lagoa dos Tres Cantos, Lagoão, Mormaço, Não-me-Toque, Quinze de Novembro, Saldanha Marinho, Salto do Jacuí, Santa Bárbara do Sul,  São José do Herval, Selbach, Soledade, Tapera, Tio Hugo, Tupanciretã, Vitor Graeff, Bossoroca, Dezesseis de Novembro, Garruchos, Pirapó, Roque Gonzáles, Rolador, Santo Antônio das Missões, São Luiz Gonzaga  e São Nicolau.</p>
			
			<p style="text-align: justify;">
				RESOLVE REGISTRAR OS PREÇOS DA(S) EMPRESA(S):<b> '.$nomefornecedor.'</b>, CNPJ nº '.$cnpjm.', estabelecida na cidade de '.$cidade.'- '.$estado.', na '.$endereco.', Bairro '.$bairro.'- CEP:'.$cep.', que apresentou os documentos exigidos por lei, adiante denominado(s) de Fornecedor(es) Beneficiário(s), neste ato representado(a) pelo(a) <b>SR(A). '.$representante.'</b>, portador do CPF nrº '.$cpfr.' e da célula de identidade nº '.$rgr.',nos termos da Lei nº 10.520/02, do Decreto nº 5.450/05, do Decreto nº 3.931/01, e suas alterações e, subsidiariamente, da Lei nº 8.666/93, e suas alterações, e das demais normas legais aplicáveis, em face da classificação das propostas apresentadas no Pregão para Registro de Preços nº '.$npregao.', conforme Ata de Julgamento de Preços publicado no Site Oficial da Entidade, tendo sido os referidos preços oferecidos pelo(s) Fornecedor(es) Beneficiário(s) classificado(s) no certame acima numerado, em 1º lugar no quadro, conforme abaixo:
				'.$html.'

			</p>
			
				<h3>CLÁUSULA PRIMEIRA – DO OBJETO</h3>
				<p style="text-align: justify;">
					A presente ATA tem por objeto o REGISTRO DE PREÇOS para o fornecimento de Medicamentos, de acordo com as especificações e quantidades definidas no Termo de Referência do Edital de Pregão Eletrônico nº '.$npregao.', que passa a fazer parte desta Ata, juntamente com a documentação e proposta de preços apresentadas pelas licitantes classificadas em primeiro lugar, por item, conforme consta nos autos do processo anexo.</p>
			
			
				<h3>CLÁUSULA SEGUNDA - DA VALIDADE DOS PREÇOS</h3>
				<p style="text-align: justify;">
					A validade da Ata de Registro de Preços será de <b>06 (SEIS) meses</b>, a partir da sua assinatura, durante o qual o CISA não será obrigado a adquirir o material referido na Cláusula Primeira exclusivamente pelo Sistema de Registro de Preços, podendo fazê-lo mediante outra licitação quando julgar conveniente, sem que caiba recursos ou indenização de qualquer espécie às empresas detentoras, ou, cancelar a Ata, na ocorrência de alguma das hipóteses legalmente previstas para tanto, garantidos à detentora, neste caso, o contraditório e a ampla defesa.</p>
			
				

				<h3>CLÁUSULA TERCEIRA - DA UTILIZAÇÃO DA ATA DE REGISTRO DE PREÇOS</h3>
				<p style="text-align: justify;">
					A presente Ata de Registro de Preços poderá ser usada pelo CISA, ou órgãos interessados em participar, em qualquer tempo, desde que autorizados pelo CISA. Em cada fornecimento decorrente desta Ata, serão observadas, quanto ao preço, as cláusulas e condições constantes na proposta apresentada no Pregão Eletrônico nº '.$npregao.'.</p>

				<h3>CLÁUSULA QUARTA – EFETIVAÇÃO DAS COMPRAS - LOCAIS/PRAZO DE ENTREGA/NOTA FISCAL</h3>
				
					<ol type="A" style="text-align: justify;">
	  					<li> 
						A efetivação das compras dos itens constantes no REGISTRO DE PREÇOS junto às empresas fornecedoras serão feitas conforme a necessidade dos municípios consorciados e conveniados, podendo ser retirados em até DUAS (2) vezes, dentro do período previsto de SEIS (06) MESES, mediante expedição de Autorização de Fornecimento emitido pelo Consórcio devidamente assinados pela Diretora Executiva e pelo Coordenador de Pregão Eletrônico do CISA.
						
						</li>
						<li>
							Os produtos deverão ser entregues conforme Nota de Empenho, sendo recebidos/conferidos pela farmacêutica responsável pelo CISA:
							
						</li>
						<li>
							<b>PRAZO DE ENTREGA:</b> no máximo <b>30 (TRINTA) DIAS CORRIDOS</b> após o recebimento do pedido de autorização de fornecimento de medicamento devidamente numerado.
							
						</li>
						<li>
					 		Local e Horário de entrega: Os medicamentos deverão ser entregues no seguinte endereço: Rua Barão do Rio Branco, 121– Centro – Ijuí – RS,das 08h30min às 11h30min e das 13h00min às 17h00min, a critério da Contratante – CISA;
					 		
						</li>
						<li>
					 		Os produtos entregues deverão apresentar <b>PRAZO DE VALIDADE</b> de no mínimo <b>DOZE MESES </b> a partir da data da entrega.Para aqueles medicamentos cuja validade geral é menor que 12 meses, deverão possuir, a contar do momento da entrega, no mínimo 75% (setenta e cinco por cento) de seu prazo de validade tota
					 		
						</li>
						
						<li>
							A entrega e o descarregamento dos produtos é de responsabilidade da licitante vencedora.
							
						</li>
						
						<li>
							Aceitar-se-á no máximo três (3) lotes por produto, tendo em vista a facilitar o controle por lote, no recebimento, armazenamento e distribuição. Os números dos lotes com as respectivas quantidades data de fabricação, data de validade e o código da nomenclatura comum no MERCOSUL (NCM/SH), deverão estar especificadas na Nota Fiscal Eletrônica, bem como, cada medicamento deverá vir acompanhado do Laudo Técnico de Análise (Certificado de Análise) e transmitir os arquivos das Notas Fiscais em formato XML, quando solicitado a Ordem de Compra, para o e-mail: centralmedic@cisaijui.com.br, emitidos pelo fabricante seja empresafornecedora indústria farmacêutica ou distribuidora. O laudo analítico deverá comprovar o atendimento às especificações previstas pela farmacopeia, para o princípio ativo e de forma farmacêutica. Não serão aceitos laudos emitidos via fax. 
							<br>
						</li>
					</ol>
				

				<h3>CLÁUSULA QUINTA - DO PAGAMENTO </h3>

					<p style="text-align: justify;">
					<b>O pagamento será efetuado em 02 (duas) parcelas, de igual valor, ou seja, a 1ª (Primeira) parcela em 30 (Trinta) dias e a 2ª (Segunda) parcela em 60 (Sessenta) dias,</b> contando a partir da DATA DO RECEBIMENTO da Mercadoria, conforme Nota Fiscal. O pagamento será efetuado mediante Crédito em Conta Corrente Bancária, indicados pelo fornecedor na proposta vencedora ajustada ao lance, contendo a descrição dos produtos, quantidades, banco, código da agência e o número da conta corrente da empresa, para efeito de pagamento preços unitários e o valor total e nota de entrega atestada. 
					</P>
					<p style="text-align: justify;">
					No caso de incorreção nos documentos apresentados, inclusive na Nota Fiscal, serão os mesmos restituídos à adjudicatária para as correções necessárias, não respondendo o CISA por quaisquer encargos resultantes de atrasos na liquidação dos pagamentos correspondentes e o prazo de pagamento será contado da data de reapresentação do documento corretamente preenchido. </p>

				<h3>CLÁUSULA SEXTA - DAS SANÇÕES </h3>
					<p style="text-align: justify;">
					As penalidades contratuais são as previstas no artigo 7º da Lei 10.520/2002 e artigo 28 do Decreto n. 5.450/2005. Além do previsto no caput desta cláusula, pelo descumprimento total ou parcial das obrigações assumidas na Ata de Registro de Preços e pela verificação de quaisquer das situações prevista no art. 78, incisos I a XI e XVIII da Lei nº 8.666/93, garantida a defesa prévia ao contratado, a administração poderá aplicar as seguintes penalidades:</p>
					<ol type="A" style="text-align: justify;">
		  				<li> 

						 	Advertência, por escrito, inclusive registrada no cadastro específico (SICAF);
						</li>
						<li>
							Esgotado o prazo de entrega dos medicamentos, por inexecução total, será aplicada multa de 25%(Vinte e Cinco por cento) sobre o valor total do pedido de compra.
						</li>
						<li>
							Pela inexecução parcial do ajuste, multa de 15 % (Quinze por cento), calculada sobre a soma dos valores dos objetos não entregues;
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

					


				<h3>CLÁUSULA SÉTIMA - DO REAJUSTAMENTO DE PREÇOS </h3>
				<p style="text-align: justify;">
				Considerando o prazo de validade estabelecido na Cláusula II, da presente Ata, e, em atendimento ao §1º, art. 28, da Lei nº 9.069, de 29.6.1995 e Legislação pertinente, é vedado qualquer reajustamento de preços, exceto nas hipóteses, devidamente comprovadas, de ocorrência de situação prevista na alínea “d” do inciso II do art. 65 da Lei n.º 8.666/93, ou de redução dos preços praticados no mercado. Mesmo comprovada a ocorrência de situação prevista na alínea “d” do inciso II do art. 65 da Lei n.º 8.666/93, a Administração, se julgar conveniente, poderá optar por cancelar a Ata e iniciar outro procedimento licitatório. Comprovada a redução dos preços praticados no mercado nas mesmas condições do Registro, e, definido o novo preço máximo a ser pago pela Administração, os fornecedores registrados serão convocados pelo CISA para alteração, por aditamento, do preço da Ata. Caso haja solicitações de Reajustes durante o prazo de vigência da Presente Ata, os mesmos somente serão aceitos desde que haja confirmação expressa do respectivo Laboratório fabricante. </p>


				<h3>CLÁUSULA OITAVA - DO CANCELAMENTO DA ATA DE REGISTRO DE PREÇOS.</h3>
					<p style="text-align: justify;">
					A Ata de Registro de Preços será cancelada por decurso de prazo de vigência ou quando não restarem fornecedores registrados e por iniciativa da administração quando caracterizado o interesse público.</p>
					<p style="text-align: justify;">
					O fornecedor terá seu registro na Ata de Registro de Preços cancelado:
					</p>
					<ol type="I" style="text-align: justify;">
			  			<li> 
							A pedido, quando comprovar estar impossibilitado de cumprir com as suas exigências por ocorrência de casos fortuitos ou de força maior;
						</li>
						<li>
							Por iniciativa do órgão ou entidade usuário, quando:
						</li>
						<ol type="A" style="text-align: justify;">
			  			<li> 
							Não cumprir as obrigações decorrentes da Ata de Registro de Preço;
						</li>
						<li>
							Não comparecer ou se recusar a retirar, no prazo estabelecido, os pedidos de compra decorrentes da Ata de Registro de Preço, sem justificativa aceitável.
						</li>
						</ol>
						<li>
						 Por iniciativa do órgão ou entidade responsável, quando:
						</li>
						<ol type="A" style="text-align: justify;">
				  			<li> 
								Não aceitar reduzir o preço registrado, na hipótese deste se tornar superior àqueles praticados no mercado;
							</li>
							<li>
							 Por razões de interesse público, devidamente motivadas e justificadas.
							</li>
						</ol>
						<p style="text-align: justify;>
						O cancelamento do registro do fornecedor será devidamente autuado no respectivo processo administrativo e ensejará aditamento da Ata pelo órgão ou entidade responsável, que deverá informar aos demais fornecedores registrados a nova ordem de registro.
						</p>
						<p style="text-align: justify;>
						Em qualquer hipótese de cancelamento de registro é assegurado o contraditório e a ampla defesa
						</p>
					</ol>

					<h3>CLÁUSULA NONA – DOS INTEGRANTES </h3>
					<p style="text-align: justify;">
					Integram esta Ata, o Edital do Pregão nº '.$npregao.' e a proposta da empresa '.$nomefornecedor.', classificada em 1º lugar.
					</p>


					<h3>CLÁUSULA DÉCIMA - DO FORO</h3>
					<p style="text-align: justify;">
					O foro para dirimir os possíveis litígios que decorrerem da utilização da presente ATA, será o da Comarca de Ijuí/ RS. Os casos omissos serão resolvidos de acordo com a Lei nº 8.666/93, demais normas aplicáveis e ao disposto no edital de Pregão Eletrônico nº '.$npregao.'.
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
		"relatorio_celke.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);


	
?>