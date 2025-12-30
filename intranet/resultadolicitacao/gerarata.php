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

   		margin-top: 4cm;   
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

		<style type="text/css">

		p, ol, li{
			font-size:14px;
		}

		</style>
			
			<h5> ATA DE REGISTRO DE PREÇOS Nº '.$npregao.' <br>
			 PREGÃO ELETRÔNICO Nº '.$npregao.'  <br>
			 PROCESSO Nº '.$nprocesso.'
			 </h5>

			<p style="text-align: justify;">
			Aos '.$dia.' dias do mês de '.$mes.' de '.$ano.', na sede do CISA, Pessoa Jurídica de Direito Público, CNPJ nº 02.231.696/0001-92, situada na Rua Barão do Rio Branco, 121, em Ijuí/RS, CEP 98700-000, neste ato representado por seu Presidente Sr. '.$nome.', portador da cédula de identidade nº'.$rg.' SSP/RS, CPF nº '.$cpf.', tendo como partícipes o CISA – Consorcio Intermunicipal de Saúde do Noroeste do Estado do Rio Grande do Sul e do COMAJA – Consórcio de Desenvolvimento Intermunicipal dos Municípios do Alto Jacuí e COIS – Consorcio Intermunicipal de Saúde,  tais como: Ajuricaba, Alegria, Augusto Pestana, Barra do Guarita, Boa Vista do Cadeado, Boa Vista Buricá, Bom Progresso, Bozano, Braga, Campo Novo, Catuipe, Chiapetta, Condor, Coronel Barros, Coronel Bicaco, Crissiumal, Derrubadas, Dois Irmãos das Missões, Esperança do Sul, Horizontina, Humaitá, Independência, Inhacorá, Jóia, Miraguai, Nova Ramada, Nova Cancelária, Novo Machado, Palmitinho, Pejuçara, Pinheirinho do Vale, Redentora, Santo Augusto, São Martinho, São Pedro do Butiá, São Valério do Sul, Sede Nova, Senador Salgado Filho, Taquaruçu do Sul, Tenente Portela, Tiradentes do Sul, Tucunduva, Três de Maio, Três Passos, Vista Gaúcha, Vista Alegre, Alto Alegre, Barros Cassal, Boa Vista do Incra, Campos Borges, Colorado, Cruz Alta, Espumoso, Fontoura Xavier, Fortaleza dos Valos, Ibirapuitã, Ibirubá, Jacuizinho, Lagoa dos Três Cantos, Mormaço, Quinze de Novembro, Saldanha Marinho, Salto do Jacuí, Santa Bárbara do Sul, Soledade, Tapera, Tio Hugo, Tunas, Vitor Graeff, Bossoroca, Dezesseis de Novembro, Garruchos, Pirapó, Rolador, Roque Gonzales, Santo Antônio das Missões, São Luiz Gonzaga e São Nicolau; ou ainda a outros entes que venham a se associar no período de vigência do presente certame.</p>
			
			<p style="text-align: justify;">
				RESOLVE REGISTRAR OS PREÇOS DA(S) EMPRESA(S):<b> '.$nomefornecedor.'</b>, CNPJ nº '.$cnpjm.', estabelecida na cidade de '.$cidade.'- '.$estado.', na '.$endereco.', Bairro '.$bairro.', CEP:'.$cep.', que apresentou os documentos exigidos por lei, adiante denominado(s) de Fornecedor(es) Beneficiário(s), neste ato representado(a) pelo(a) <b>SR(A). '.$representante.'</b>, portador do CPF nrº '.$cpfr.' e da célula de identidade nº '.$rgr.', nos termos da Lei nº 11.133/2021, do Decreto nº 10.024/2019, e das demais normas legais aplicáveis, em face da classificação das propostas apresentadas no Pregão para Registro de Preços nº '.$npregao.', conforme Ata de Julgamento de Preços publicado no Site Oficial da Entidade, tendo sido os referidos preços oferecidos pelo(s) Fornecedor(es) Beneficiário(s) classificado(s) no certame acima numerado, em 1º lugar no quadro, conforme abaixo:
			</p>
				'.$html.'
				<h5 style="background-color:LightGray;">CLÁUSULA PRIMEIRA – DO OBJETO</h5>

				<p style="text-align: justify;">
					A presente ATA tem por objeto o REGISTRO DE PREÇOS para o fornecimento de Medicamentos, de acordo com as especificações e quantidades definidas no Termo de Referência do Edital de Pregão Eletrônico nº '.$npregao.', que passa a fazer parte desta Ata, juntamente com a documentação e proposta de preços apresentadas pelas licitantes classificadas em primeiro lugar, por item, conforme consta nos autos do processo anexo.</p>
			
			
				<h5 style="background-color:LightGray;">CLÁUSULA SEGUNDA - DA VALIDADE DOS PREÇOS</h5>

				<p style="text-align: justify;">
					A validade da Ata de Registro de Preços será de 12 (doze) meses, a partir da sua assinatura, durante o qual o CISA não será obrigado a adquirir o material referido na Cláusula Primeira exclusivamente pelo Sistema de Registro de Preços, podendo fazê-lo mediante outra licitação quando julgar conveniente, sem que caiba recursos ou indenização de qualquer espécie às empresas detentoras, ou, cancelar a Ata, na ocorrência de alguma das hipóteses legalmente previstas para tanto, garantidos à detentora, neste caso, o contraditório e a ampla defesa.</p>
			
				

				<h5 style="background-color:LightGray;">CLÁUSULA TERCEIRA - DA UTILIZAÇÃO DA ATA DE REGISTRO DE PREÇOS</h5>
				<p style="text-align: justify;">
					A presente Ata de Registro de Preços poderá ser usada pelo CISA, ou órgãos interessados em participar, em qualquer tempo, desde que autorizados pelo CISA. Em cada fornecimento decorrente desta Ata, serão observadas, quanto ao preço, as cláusulas e condições constantes na proposta apresentada no Pregão Eletrônico nº '.$npregao.'.</p>

				<h5 style="background-color:LightGray;">CLÁUSULA QUARTA – EFETIVAÇÃO DAS COMPRAS - LOCAIS/PRAZO DE ENTREGA/NOTA FISCAL</h5>
				
					<ol type="A" style="text-align: justify;">
	  					<li>   
							A efetivação das compras dos itens constantes no REGISTRO DE PREÇOS junto às empresas fornecedoras serão feitas conforme a necessidade dos municípios consorciados e conveniados, podendo ser retirados em até quatro (4) vezes ou mais, dentro do período previsto de 12 (doze) MESES, mediante expedição de Autorização de Fornecimento emitido pelo Consórcio.
							<br>
							<br>
						
						</li>
					
						<li>
							Os produtos deverão ser entregues conforme Nota de Empenho, sendo recebidos/conferidos pela farmacêutica responsável pelo CISA.
								<br>
							<br>
						
						</li>
					
						<li>
							<b>O prazo de entrega será de 30 (trinta) dias corridos</b>, após a emissão da Autorização de Fornecimento, expedida pela CENTRAL DE MEDICAMENTOS do CISA, para cada pedido efetuado.
								<br>
							<br>
					
						</li>
					
						<li>
					 		Local e Horário de entrega: Os medicamentos deverão ser entregues no seguinte endereço: Rua Barão do Rio Branco, 121– Centro – Ijuí – RS,das 08h00min às 12h00min e das 13h00min às 17h00min.
					 			<br>
							<br>
					 		
						</li>
					
						<li>
					 		Os medicamentos entregues deverão ter validade mínima de 01 (um) ano a contar da data de recebimento da mercadoria. Para os medicamentos cuja a validade geral é menor que 01 (um) ano, deverão possuir no momento da entrega 9 (nove) meses de validade.
					 			<br>
							<br>
					 	
						</li>
							
						<li>
							A entrega e o descarregamento dos produtos é de responsabilidade da licitante vencedora.
								<br>
							<br>
							
						</li>						

						<li>
							O Certificado de Análise de cada MEDICAMENTO/LOTE deverá ser encaminhado via e-mail ou vir anexado na Nota Fiscal. O Certificado de Análise deverá comprovar o atendimento às especificações previstas pela(s) farmacopéia(s) para o princípio ativo e de forma farmacêutica.
								<br>
								<br>							
						</li>
											
						<li>
							As embalagens primárias dos medicamentos (ampolas, blisters, strips e frascos) devem apresentar o número do lote, data de fabricação e prazo de validade e a inscrição explícita da informação: “VENDA PROIBIDA AO COMÉRCIO”, nas referidas embalagens.
								<br>
							<br>
						</li>
					</ol>
				

				<h5 style="background-color:LightGray;">CLÁUSULA QUINTA - DO PAGAMENTO </h5>
				<ol type="A" style="text-align: justify;">
				
						<li> 													
						O pagamento será efetuado em 02 (duas) parcelas, de igual valor, ou seja, a 1ª (primeira) parcela em 30 (trinta) dias e a 2ª (segunda) em 60 dias. <br><br>
						</li>
							
						<li> 			
					Os arquivos eletrônicos da Nota Fiscal (XML e PDF) deverão ser encaminhados obrigatoriamente para o e-mail cisaxml@hotmail.com. Ciente de cumprimento às instruções normativas da Receita Federal do Brasil, em especial à IN RFB nº 1.234/2012, que torna obrigatória a retenção por parte da autoridade licitante do desconto do imposto de renda incidente sobre bens, sendo obrigatória a emissão de notas fiscais contemplando a indicação do valor do imposto de renda retido sobre o montante total da respectiva nota fiscal.<br><br>
						</li>
				
						<li> 
					O pagamento será efetuado mediante crédito em Conta Corrente Bancária em favor do adjudicatário, informados pelo fornecedor na proposta vencedora.<br><br>
					</li>
					
						<li>
						
						No caso de incorreção nos documentos apresentados, inclusive na Nota Fiscal, serão os mesmos restituídos à adjudicatária para as correções necessárias, não respondendo o CISA por quaisquer encargos resultantes de atrasos na liquidação dos pagamentos correspondentes e o prazo de pagamento será contado da data de reapresentação do documento corretamente preenchido.<br><br> 
						</li>
					
				</ol>

				<h5 style="background-color:LightGray;">CLÁUSULA SEXTA - DAS SANÇÕES </h5>

					
					<ol type="A" style="text-align: justify;">

		  				<li> 

						 	Comete infração administrativa, nos termos da Lei nº 14.133/2021, o licitante/adjudicatário que:
						 	<br><br>	
						 	<ol type="I" style="text-align: justify;">
		  					<li> 
		  						Der causa à inexecução parcial ou total do contrato;<br><br>
							</li>
							<li>
								Deixar de entregar os documentos exigidos no certame;<br><br>
							</li>
							<li>
								Não mantiver a proposta, salvo em decorrência de fato superveniente devidamente justificado;<br><br>
							</li>
							<li>
								Não assinar o termo de contrato ou aceitar/retirar o instrumento equivalente, quando convocado dentro do prazo de validade da proposta;<br><br>
							</li>
							<li>
								Ensejar o retardamento da execução ou entrega do objeto da licitação;<br><br>
							</li>
							<li>
								Apresentar declaração ou documentação falsa;<br><br>
							</li>
							<li>
								Fraudar a licitação ou praticar ato fraudulento na execução do contrato;<br><br>
							</li>
							<li>
								Comportar-se de modo inidôneo ou cometer fraude de qualquer natureza;<br><br>
							</li>
							<li>
								Praticar atos ilícitos com vistas a frustrar os objetivos da licitação;<br><br>
		  					</li>

						</li>
						
						<li>
							O licitante/adjudicatário que cometer qualquer das infrações discriminadas nos subitens anteriores ficará sujeito, sem prejuízo da responsabilidade civil e criminal, às seguintes sanções: <br><br>	

							<ol type="I" style="text-align: justify;">		  						
		  						<li> 
									Advertência por escrito;<br><br>
								</li>
								
								<li>
									Esgotado o prazo de entrega dos medicamentos, por INEXECUÇÃO TOTAL, será aplicada Multa de 25 % (vinte e cinco porcento) sobre o valor total do pedido de compra.<br><br>
								</li>
								<li>
									Esgotado o prazo de entrega dos medicamentos, por INEXECUÇÃO PARCIAL, será aplicada Multa de 20 % (vinte porcento) calculada sobre o valor do objeto não entregue.<br><br>
								</li>
								<li>
									Impedimento de licitar e contratar. <br><br>
								</li>
								<li>
									Declaração de inidoneidade para licitar ou contratar.	<br><br>	  						
								</li>
							</ol>	

						</li>
						<li>
					
							A penalidade de multa pode ser aplicada cumulativamente com as demais sanções. <br><br>	
						</li>
						<li>
							Do ato que aplicar a penalidade caberá recurso, no prazo de 15 (quinze) dias úteis, a contar da ciência da intimação, podendo a autoridade que tiver proferido o ato reconsiderar sua decisão ou, no prazo de 05 (cinco) dias encaminhá-lo devidamente informados para a apreciação e decisão superior, no prazo de 20 (vinte) dias úteis. <br><br>	
						</li>						
					</ol>				

					


				<h5 style="background-color:LightGray;">CLÁUSULA SÉTIMA - DO REAJUSTAMENTO DE PREÇOS </h5>
				
				<ol type="A" style="text-align: justify;">
		  				<li>
						 	Na hipótese de o preço registrado tornar-se superior ao preço praticado no mercado, por motivo superveniente, o órgão ou a entidade gerenciadora convocará o fornecedor para negociar a redução do preço registrado. <br><br>	

						 	<ol type="I" style="text-align: justify;">
			  					<li> 
			  						Caso não aceite reduzir seu preço aos valores praticados pelo mercado, o fornecedor será liberado do compromisso assumido quanto ao item registrado, sem aplicação de penalidades administrativas. <br><br>	
			  					</li>
								<li>
								Na hipótese prevista no item anterior, o gerenciador convocará os fornecedores do cadastro de reserva, na ordem de classificação, para verificar se aceitam reduzir seus preços aos valores de mercado.
								<br><br>	
								</li>
								<li>
								Se não obtiver êxito nas negociações, o órgão ou a entidade gerenciadora procederá ao cancelamento da ata de registro de preços, e adotará as medidas cabíveis para a obtenção de contratação mais vantajosa.
								<br><br>	
								</li>
								
							</ol>
						</li>
						<li> 
							Na hipótese de o preço de mercado tornar-se superior ao preço registrado e o fornecedor não poder cumprir as obrigações estabelecidas na ata, será facultado ao fornecedor requerer ao gerenciador a alteração do preço registrado, mediante comprovação de fato superveniente que o impossibilite de cumprir o compromisso.
							<br><br>	
							
							<ol type="I" style="text-align: justify;">
				  					<li> 
				  					A solicitação de alteração de preço, deverá ser solicitada/encaminhada para e-mail centralmedic@cisaijui.com.br. <br><br>	
				  					</li>
				  					<li> 				  				
									O fornecedor encaminhará, juntamente com o pedido de alteração, a documentação comprobatória ou planilha de custos que demonstre a inviabilidade do preço registrado em relação às condições inicialmente pactuadas. <br><br>	
									</li>
				  					<li> 
									O protocolo de requerimento de alteração de preço, não suspende o dever de o Fornecedor entregar os medicamentos. O fornecedor obriga-se a entregar aos municípios pelo valor registrado, todos os itens solicitados anteriormente à solicitação, sob pena de lhe serem aplicadas as sanções administrativas previstas neste Edital. <br><br>	
									</li>
				  					<li> 
									Na hipótese de não comprovação da existência de fato superveniente que inviabilize o preço registrado, o pedido será indeferido pelo órgão ou pela entidade gerenciadora e o fornecedor deverá cumprir as obrigações estabelecidas na ata, sob pena de cancelamento do seu registro, sem prejuízo da aplicação das sanções previstas na Lei nº 14.133, de 2021, e na legislação aplicável. <br><br>	
									</li>
				  					<li> 
									Na hipótese de cancelamento do registro do fornecedor, nos termos do disposto, o gerenciador convocará os fornecedores do cadastro de reserva, na ordem de classificação, para verificar se aceitam manter seus preços registrados. <br><br>	
									</li>
				  					<li> 
									Se não obtiver êxito nas negociações, o órgão ou a entidade gerenciadora procederá ao cancelamento da ata de registro de preços, e adotará as medidas cabíveis para a obtenção da contratação mais vantajosa. <br><br>	
									</li>
				  					<li> 
									Na hipótese de comprovação, o órgão ou a entidade gerenciadora atualizará o preço registrado, de acordo com a realidade dos valores praticados pelo mercado. <br><br>	
				  					</li>
				  			</ol>

			  			</li>		
				</ol>



				<h5 style="background-color:LightGray;">CLÁUSULA OITAVA - DO CANCELAMENTO DA ATA DE REGISTRO DE PREÇOS.</h5>

					
					<ol type="A" style="text-align: justify;">
			  			<li> 
							
							O registro do fornecedor será cancelado pelo órgão, quando o fornecedor: <br><br>	
								</li> 
							<ol type="I" style="text-align: justify;">
								<li> 
								Descumprir as condições da ata de registro de preços sem motivo justificado; <br><br>	
								</li> 
								<li> 
								Não retirar a nota de empenho, ou instrumento equivalente, no prazo estabelecido pela Administração sem justificativa razoável; <br><br>	
								</li> 
								<li>
								Não aceitar manter seu preço registrado; <br><br>	
								</li> 
								<li>
								Sofrer sanção prevista nos incisos III ou IV do art. 156 da Lei nº 14.133, de 2021; <br><br>	
								</li> 
								<li>
								Na hipótese prevista no item 17.1.4, caso a penalidade aplicada ao fornecedor não ultrapasse o prazo de vigência da ata de registro de preços, o órgão ou a entidade gerenciadora poderá, mediante decisão fundamentada, decidir pela manutenção do registro de preços, vedadas novas contratações derivadas da ata enquanto perdurarem os efeitos da sanção. <br><br>	
								</li> 
								<li>
								O cancelamento do registro nas hipóteses previstas será formalizado por despacho do CISA, garantidos os princípios do contraditório e da ampla defesa. <br><br>	
								</li>
								<li> 
								Na hipótese de cancelamento do registro do fornecedor, o CISA poderá convocar os licitantes que compõem o cadastro de reserva, observada a ordem de classificação. <br><br>	
								</li>
							</ol>
						
						</li>	
						<li>
							O cancelamento dos preços registrados poderá ser realizado pelo gerenciador, total ou parcialmente, nas seguintes hipóteses, desde que devidamente comprovadas e justificadas; <br><br>	
							

							<ol type="I" style="text-align: justify;">
								<li> 
									Por razão de interesse público. 
									<br>
									<br>
								</li> 
								<li> 
									A pedido do fornecedor, decorrente de caso fortuito ou força maior; ou
									<br>
							<br>
								</li> 
								<li> 
									Se não houver êxito nas negociações, nos termos do disposto no item 15.1.2 e 15.1.3;
									<br>
							<br>
								</li> 
							</ol>

						</li>	
					
					</ol>

					<h5 style="background-color:LightGray;">CLÁUSULA NONA – DOS INTEGRANTES </h5>
					<p style="text-align: justify;">
					Integram esta Ata, o Edital do Pregão nº '.$npregao.' e a proposta da empresa '.$nomefornecedor.', classificada em 1º lugar.
					</p>


					<h5 style="background-color:LightGray;">CLÁUSULA DÉCIMA - DO FORO</h5>
					<p style="text-align: justify;">
					O foro para dirimir os possíveis litígios que decorrerem da utilização da presente ATA, será o da Comarca de Ijuí - RS. Os casos omissos serão resolvidos de acordo com a Lei nº 14.133/2021, demais normas aplicáveis e ao disposto no edital de Pregão Eletrônico nº '.$npregao.'.
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