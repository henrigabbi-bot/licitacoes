<?php	
	session_start();
	$cnpj = $_POST['cnpj'];
	$npregao = $_POST['npregao'];
	$noficio = $_POST['noficio'];
	$naf = $_POST['naf'];
	$datanotificacao = $_POST['datanotificacao'];
	list ($noficio2, $ano2) = split ('[/.-]', $noficio);


    list ($ano, $mes, $dia) = split ('[/.-]', $datanotificacao);
    
    //Pega o mes em numeral e retorna em descritivo.
    if ($mes == '01') {
    	$mes='JANEIRO';
    }else if ($mes =='2'){
    	$mes='FEVEREIRO';
    }else if ($mes =='3'){
    	$mes='MARÇO';
    }else if ($mes =='4'){
    	$mes='ABRIL';
    }else if ($mes =='5'){
    	$mes='MAIO';
    }else if ($mes =='6'){
    	$mes='JUNHO';
    }else if ($mes =='7'){
    	$mes='JULHO';
    }else if ($mes =='8'){
    	$mes='AGOSTO';
    }else if ($mes =='9'){
    	$mes='SETEMBRO';
    }else if ($mes =='10'){
    	$mes='OUTUBRO';
    }else if ($mes =='11'){
    	$mes='NOVEMBRO';    
	}else {
		$mes='DEZEMBRO';

	};

	include("../conexao.php");
	
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
	
	$html = '<!DOCTYPE html>';
    $html.= '<html>';
    $html.=' <head>';   
    $html.=' </head>';
    $html.='<body>';
    $html.='<style type="text/css">
	table{
		border-collapse: collapse; 

	} 
	
  	

    @page {   
   		margin-top: 1cm;  
   		margin-left: 2cm; 
   		margin-right: 2cm;  
   		
	}

	body {
		
		background-image: url("../../img/logonovo.png");
		background-repeat: no-repeat;

  				
	}


	</style>';
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

			<br>
			<br>
			<br>
			<br><br>
			<br>


	
			<h4> OF. C. M. Nº  '.$noficio.'      
			 </h4>
			
			 <h4 style="text-align: center;"> INSTRUMENTO DE NOTIFICAÇÃO <br>     
			 EXTRAJUDICIAL</h4>
			
			
			 '.$html.'
			
			<p style="text-align: justify;">
			<b>NOTIFICANTE: CISA - CONSÓRCIO INTERMUNICIPAL DO NOROESTE DO ESTADO DO RIO GRANDE DO SUL</b>, Pessoa Jurídica de Direito Público, CNPJ nº 02.231.696/0001-92, com sede na Rua Barão do Rio Branco, nº 121, em Ijuí/RS.</p>
			<div>
			<p style="text-align: justify;">
				<b>NOTIFICADO:  '.$nomefornecedor.'</b>, Pessoa Jurídica de Direito Privado, CNPJ nº '.$cnpjm.', com sede na '.$endereco.', Bairro '.$bairro.', em '.$cidade.'-'.$estado.' - CEP: '.$cep.'.

			</p>			
				
				<p style="text-align: justify;">
					Por este instrumento, o CISA, vem através do presente, <b>NOTIFICAR</b> a empresa <b>'.$nomefornecedor.'</b>, por conta do atraso na entrega dos medicamentos adjudicados por essa empresa, <b>pedido de compra nº '.$naf.'</b>, do Pregão Eletrônico nº '.$npregao.', de acordo com o dispõe a cláusula 17.1.1 do Edital. Cumpre
registrar que a cláusula quarta, alínea “C”, do contrato, dispõe que o prazo para que as empresas
licitantes possam efetivar a entrega dos medicamentos ao CISA é de até 30 (Trinta) dias, contados
do recebimento da ordem. Após verificação por esta Central de medicamentos do relatório de
entregas efetivadas por essa empresa, constatamos o não cumprimento do prazo estipulado no
edital, o que configura o descumprimento do pactuado, obrigando o CISA a proceder na abertura
de processo administrativo para aplicação das sanções administrativa prevista na lei de Licitações e
disposições análogas (multas, advertências, proibição de contratação com o poder Público, entre
outros). Com base nisso, <b>NOTIFICAMOS</b> essa empresa para que no prazo de <b>72H (Setenta e duas horas)</b> efetue a entrega total dos produtos (medicamentos) faltantes ou justifique a não entrega. O não atendimento da presente notificação acarretará na tomada de providências legais cabíveis</p>
			
			 <h4 style="text-align: right;">IJUÍ, '.$dia.' DE '.$mes.' DE '.$ano.'.</h4>
				
		

<p style="text-align: center;">


<br>
<br>
<br>


__________________________________ <br>
ANDREI COSSETIN SCZMANSKI <BR>
Presidente <BR>





</p>
	 </div>		

	 
<br>
<br>
<br>




		');


	
	$dompdf->setPaper('A4', 'portrait');
	$dompdf->set_option('defaultFont', 'Times New Roman’');

	//Renderizar o html
	$dompdf->render();


	//Exibibir a página
	$dompdf->stream(
		"'.$nomefornecedor.'OF. Nº '$noficio2'.pdf", 
		array(
			"Attachment" => true //Para realizar o download somente alterar para true
		)
	);

	
?>