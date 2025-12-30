<?php	
	session_start();
	$id=$_GET['id'];
     $ncontrato=$_GET['ncontrato'];
	
   
    include("../conexao.php");

 $sql = "SELECT cliente.id, cliente.nomecliente,cliente.nomeprefeito,cliente.cpf,cliente.cnpj, contratoderateio.id, contratoderateio.taxamedicamentos, contratoderateio.taxacisa, contratoderateio.taxaceo  FROM contratoderateio left JOIN cliente on cliente.id=contratoderateio.id where cliente.id='$id'"; 


$query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados      

while($row = mysql_fetch_array($query)) {
                   
    $cnpj=$row['cnpj']; 
    $cnpjformatado=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5",$row['cnpj']);   
    $nomecliente=$row['nomecliente']; 
    $nomecliente = mb_strtoupper($row['nomecliente'], 'UTF-8');
    $nomeprefeito=$row['nomeprefeito'];
    $cpf=$row['cpf'];
    $taxamedicamentos=$row['taxamedicamentos']; 
    $taxacisa=$row['taxacisa']; 
    $taxaceo=$row['taxaceo']; 
                                                    
             
};


if ($taxamedicamentos > 0) {
    $taxaverificadamedicamentos= '<strong><li>TAXA ADMINISTRATIVA PARA COMPRA DE MEDICAMENTOS (100% PARA DESPESA DE PESSOAL) ATÉ R$ '
           . number_format($taxamedicamentos, 2, ',', '.') . ';</li></strong>';
}



if ($taxacisa > 0) {
    $taxacisaverificada= '<strong><li>TAXA ADMINISTRATIVA CISA (100% PARA DESPESAS DE PESSOAL) ATÉ R$
                    '. number_format($taxacisa, 2, ',', '.') . ';</li></strong>';
}

if ($taxaceo > 0) {
    $taxaceoverificada= '<strong><li>TAXA ADMINISTRATIVA CEO (100% PARA DESPESAS DE MANUTENÇÃO) ATÉ R$ 
    '.number_format($taxaceo, 2, ',', '.') . ', 
    referente a serviços Odontológicos mantidos pelo CONSORCIO, através do Centro de Especialidades Odontológicas – CEO na cidade de Ijuí, na qual o CONSORCIADO enviará pacientes de sua responsabilidade para atendimentos em endodontia, periodontia, biopsias, cirurgias bucais, bem como todo atendimento a paciente especiais, pagando, em contrapartida, uma taxa mensal per capita. 
          ;</li></strong>';
}







use Dompdf\Dompdf;

    // include autoloader
require_once("dompdf/autoload.inc.php"); 




use Dompdf\Options;

// Configurações
$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);




// HTML do contrato
$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    line-height: 1.5;
    text-align: justify;
}
h1, h2 {
    text-align: center;
}
.clausula {
    font-weight: bold;
    margin-top: 12px;
}
.assinatura {
    margin-top: 40px;
    text-align: center;
}


@page {
    margin: 120px 80px 120px 80px;
}

header {
    position: fixed;
    top: -120px;
    left: -80px;
    right: -80px;
    height: 100px;
    text-align: center;
}

footer {
    position: fixed;
    bottom: -120px;
    left: -80px;
    right: -80px;
    height: 100px;
    text-align: center;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    line-height: 1.5;
    text-align: justify;
}
</style>


</style>
</head>

<body>

<header>
    <img src="../../img/header.png" style="width:100%; height:100%;">
</header>

<footer>
    <img src="../../img/footer.png" style="width:100%; height:100%;">
</footer>

<h2>CONTRATO DE RATEIO Nº '.$ncontrato.'/2026</h2>
<p style="text-align:center;"><strong>EXERCÍCIO 2026</strong></p>

<p class="clausula">I – PARTES CONTRATANTES:</p>

<p>
<strong>CONSÓRCIO INTERMUNICIPAL DO NOROESTE DO ESTADO DO RIO GRANDE DO SUL - CISA</strong>,
pessoa jurídica de direito público, com sede à Rua Barão do Rio Branco,
nº 121, na cidade de Ijuí, inscrito no CNPJ sob nº 02.231.696/0001-92,
neste ato representado por seu Presidente, Prefeito
<strong>ANDREI COSSETIN SCZMANSKI</strong>, doravante denominado
<strong>CONSÓRCIO</strong>; e, de outro lado, o
<strong>'.$nomecliente.'</strong>, inscrito no CNPJ sob nº
'.$cnpjformatado.', representado por seu Prefeito Municipal
<strong>'.$nomeprefeito.'</strong>, CPF nº '.$cpf.', doravante denominado
<strong>CONSORCIADO</strong>.
</p>

<p class="clausula">II – DO OBJETO:</p>

<p class="clausula">CLÁUSULA PRIMEIRA</p>

<p>
O presente instrumento tem por objeto ratear as despesas do CONSÓRCIO entre os CONSORCIADOS nos termos do art. 8º da lei nº 11.107/05, bem como estabelecer a gestão associada de serviços públicos na forma do artigo 13 e seguintes do mesmo diploma legal.

</p>
<p>
Parágrafo Único: Consideram-se despesas do CONSÓRCIO a serem rateadas, entre outras:

</p>


<ul>

<li>Custos despendidos na instalação, aquisição de equipamentos e manutenção de sua sede; </li>
<li>Custos despendidos na remuneração de empregados, nela incluída as obrigações trabalhistas (FGTS) e fiscais (INSS) patronais;</li>
<li>Custos despendidos na execução do objeto e nas finalidades do CONSÓRCIO previstos no contrato de consórcio público respectivo, mormente na execução dos programas de gestão pública associada;</li>
<li>Outras despesas administrativas com a utilização do Consórcio.
</li>
</ul>

<p class="clausula">III – DAS OBRIGAÇÕES:</p>

<p class="clausula">CLÁUSULA SEGUNDA</p>

<p>
Fica estabelecido que a título de rateio das despesas o CONSORCIADO repassará ao CONSÓRCIO no exercício de 2026, conforme previsão orçamentária, os seguintes valores: 
</p>



<ul>

'.$taxaverificadamedicamentos.'
'.$taxacisaverificada.'
'.$taxaceoverificada.'

</ul>

<p>
§1º – O valor da quota de contribuição e rateio estabelecido nesta cláusula poderá ser alterado por decisão fundamentada do Conselho de Prefeitos para fins de restabelecimento do equilíbrio econômico-financeiro do presente instrumento, nos termos do art. 17, inc. VIII, do Estatuto do CONSÓRCIO.
</p>
<p>
§2º - Com relação as taxas administrativas (CISA, CEO e CENTRAL DE MEDICAMENTOS), os valores serão descontados pelo CONSÓRCIO da cota parte do ICMS mediante encaminhamento de solicitação ao Banrisul/POA-RS.

</p>

<p class="clausula">CLÁUSULA TERCEIRA</p>

<p>
O montante do valor a ser repassado pelo CONSORCIADO, relativo as despesas de rateio, com exceção do previsto no parágrafo segundo da clausula retro, deverá ser pago através de boletos bancários os quais serão enviados juntamente com a fatura do período considerado pelo CISA e no caso dos demais, juntamente com a fatura de insumos, cujos vencimentos serão sempre em 15 dias posterior a emissão destes. 
</p>
<p>
Parágrafo único: Havendo atraso superior a 30 (trinta) dias da data do vencimento, os valores poderão ser descontados pelo CONSÓRCIO da cota parte do ICMS mediante encaminhamento de solicitação ao Banrisul/POA-RS.

</p>

<p class="clausula">IV – DAS PENALIDADES:</p>

<p class="clausula">CLÁUSULA QUARTA</p>

<p>
O inadimplemento das obrigações financeiras estabelecidas neste instrumento sujeita o CONSORCIADO faltoso às penalidades previstas no Contrato de Consórcio, Estatuto do CONSÓRCIO e Art. 8º, § 5º, da Lei Federal nº 11.107/05 (Lei Geral dos consórcios Públicos), sem prejuízo de cobranças judiciais.
</p>

<p class="clausula">V – DISPOSIÇÕES GERAIS:</p>

<p class="clausula">CLÁUSULA QUINTA</p>

<p>
O presente instrumento terá vigência por 12 (doze) meses, iniciando em 02 de janeiro de 2026 e encerrando-se em 31 de dezembro de 2026.
</p>

<p class="clausula">CLÁUSULA SEXTA</p>

<p>
As despesas decorrentes do presente instrumento correrão por conta das dotações orçamentárias previstas no orçamento do CONSORCIADO.
</p>
<p>
Parágrafo Único – A celebração do presente contrato de rateio de consórcio público sem suficiente e prévia dotação orçamentária ou sem observar as formalidades legais previstas configurará ato de improbidade administrativa insculpido no art. 10, inc. XV, da Lei Federal nº 8.429/92 e lei modificativa (Lei dos Atos de Improbidade Administrativa).

</p>

<p class="clausula">CLÁUSULA SÉTIMA</p>

<p>
A eventual retirada do CONSÓRCIO de qualquer de um dos demais CONSORCIADOS não implicará a extinção do presente instrumento, ficando assegurado ao CONSÓRCIO, na superveniência de tal hipótese, o direito de aditar, a qualquer tempo, o presente instrumento para restabelecer seu equilíbrio econômico-financeiro, nos termos do art. 124, Inciso II, letra “d” -  da lei nº 14.133/21.
</p>

<p class="clausula">CLÁUSULA OITAVA</p>

<p>
O presente instrumento poderá ser rescindido por qualquer uma das partes, com aviso prévio de 60 (sessenta) dias, permanecendo em vigor as obrigações assumidas até sua quitação total.  
</p>

<p class="clausula">CLÁUSULA NONA – DO FORO:</p>

<p>
As partes elegem de comum acordo o Foro da Comarca de Ijuí, para dirimir dúvidas emergentes do presente acordo. 
</p>
<p>
E, por estarem justas e acordadas, assinam o presente instrumento particular em duas vias de igual teor e forma na presença de duas testemunhas. 

</p>

<p style="text-align: right;">
Ijuí, 02 de janeiro de 2026.
</p>

<div class="assinatura">
<p><strong>CONSÓRCIO INTERMUNICIPAL DO NOROESTE DO ESTADO DO RS – CISA</strong><br>
CNPJ nº 02.231.696/0001-92<br>
<strong>Andrei Cossetin Sczmanski</strong><br>
Presidente</p>
</div>

<div class="assinatura">
<p><strong>Gilberto Fernando Scapini</strong><br>
Assessor Jurídico - CISA <br>
OAB/RS  28.440 </p>
</div>

<div class="assinatura">
<p><strong>'.$nomecliente.'</strong><br>
CNPJ nº '.$cnpjformatado.'<br>
<strong>'.$nomeprefeito.'</strong><br>
Prefeito</p>
</div>

</body>
</html>
';

// Gera o PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Exibe no navegador
$dompdf->stream("'.$nomecliente'", [
    "Attachment" => true
]);




    
?>