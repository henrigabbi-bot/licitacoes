<?php   
    session_start();
    $id=$_GET['id'];
    $ncontrato=$_GET['ncontrato'];
    
   
    include("../conexao.php");

 $sql = "SELECT cliente.id, cliente.nomecliente,cliente.nomeprefeito, cliente.cpf, cliente.cnpj, contratodeprograma.id, contratodeprograma.programamedicamentos, contratodeprograma.programacisa, contratodeprograma.programaceo  FROM contratodeprograma left JOIN cliente on cliente.id=contratodeprograma.id where cliente.id='$id'"; 


$query = mysql_query($sql);
                      // Enquanto houverem registros no banco de dados      

while($row = mysql_fetch_array($query)) {
                   
    $cnpj=$row['cnpj']; 
    $cnpjformatado=preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5",$row['cnpj']);   
    $nomecliente=$row['nomecliente']; 
    $nomecliente = mb_strtoupper($row['nomecliente'], 'UTF-8');
    $nomeprefeito=$row['nomeprefeito'];
    $cpf=$row['cpf'];
    $programamedicamentos=$row['programamedicamentos']; 
    $programacisa=$row['programacisa']; 
    $programaceo=$row['programaceo']; 
                                                    
             
};


if ($programacisa > 0) {
    $taxaverificadamedicamentos= '<strong><li>O valor de R$ '
           . number_format($programacisa, 2, ',', '.') . ' para compras de exames e consultas especializadas;</li></strong>';
}



if ($programamedicamentos > 0) {
    $taxacisaverificada= '<strong><li> O valor de R$
                    '. number_format($programamedicamentos, 2, ',', '.') . ' para compra compartilhada de medicamentos e insumos, através de licitação na modalidade Pregão Eletrônico tipo registro de Preços, conforme dotação orçamentária específica. </li></strong>';
}



if ($programaceo > 0) {
    $taxaceoverificada= '<strong><li>O valor de R$ 
    '.number_format($programaceo, 2, ',', '.') . ', 
    para Programa de Próteses Dentárias – Brasil Sorridente;</li></strong>';
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

<h2>CONTRATO DE PROGRAMA Nº '.$ncontrato.'/2026</h2>
<p style="text-align:center;"><strong>EXERCÍCIO 2026</strong></p>

<p class="clausula">I – PARTES CONTRATANTES:</p>

<p>
<strong>CONSÓRCIO INTERMUNICIPAL DO NOROESTE DO ESTADO DO RIO GRANDE DO SUL- CISA</strong>, pessoa jurídica de direito público, com sede à Rua Barão do Rio Branco,
nº 121, na cidade de Ijuí, inscrito no CNPJ sob nº 02.231.696/0001-92,
neste ato representado por seu Presidente, Prefeito
<strong>ANDREI COSSETIN SCZMANSKI</strong>, doravante denominado
<strong>CONSÓRCIO</strong>; e, de outro lado, o
<strong>'.$nomecliente.'</strong>, pessoa jurídica de direito público, inscrito no CNPJ sob nº
'.$cnpjformatado.', neste ato representado por seu Prefeito Municipal, Sr.
<strong>'.$nomeprefeito.'</strong>, CPF nº '.$cpf.', doravante denominado
<strong>CONSORCIADO</strong>, têm entre si ajustado o que segue:
</p>

<p class="clausula">II – DO OBJETO:</p>

<p class="clausula">CLÁUSULA PRIMEIRA</p>

<p>

O presente instrumento tem por objeto prever as despesas de programas a serem executados sob forma de contratação conjugada entre CONSÓRCIO e o município CONSORCIADO nos termos do art. 13º da lei nº 11.107/05.
</P>
<p>
Consideram-se programas a serem executados pelo CONSÓRCIO e transferidos ao MUNICÍPIO, ás aquisições de materiais e serviços de:

</P>

<ol type="a" style="text-align: justify;">
<li>
  Compra compartilhada de medicamentos e insumos via processo de licitação na modalidade Pregão Eletrônico tipo Registro de Preços, mediante estimativa prévia de consumo deste ente federativo para formação de registro de preços e encaminhamentos posteriores de compra atendendo a quantidades anuais de pedidos ofertados pelo Consórcio;
</li>
<li>
Compra de exames e consultas especializados precedidas de autorizações da Secretaria municipal da Saúde, conforme relação e preços ofertados pelo Consórcio através de convênios com prestadores de serviços, está devidamente aprovada em resolução do CONSÓRCIO;
</li>
<li>
Compra de serviços e material para execução do Programa Brasil Sorridente;
</li>
<li>
Compras de serviços inseridas no relatório de itens dos processos de chamamento público realizados anualmente e ofertados pelo CONSÓRCIO.

</li>
</ol>






<p class="clausula">III – DAS OBRIGAÇÕES:</p>

<p class="clausula">CLÁUSULA SEGUNDA</p>

<p>
O CONSORCIADO repassará ao CONSÓRCIO, para fins de gestão associada dos serviços públicos: 
</p>



<ul>

'.$taxaverificadamedicamentos.'
'.$taxacisaverificada.'
'.$taxaceoverificada.'

</ul>



<p class="clausula">CLÁUSULA TERCEIRA</p>

<p>
    O montante do valor a ser repassado pelo CONSORCIADO, deverá ser pago através de boletos bancários os quais serão enviados juntamente com a fatura do período considerado pelo CISA e no caso dos demais, juntamente com fatura de insumos, cujos vencimentos serão sempre em 15 dias, posterior a emissão destes.  </p>




<p class="clausula">IV – DAS PENALIDADES:</p>

<p class="clausula">CLÁUSULA QUARTA</p>

<p>
O inadimplemento das obrigações financeiras estabelecidas neste instrumento sujeita o CONSORCIADO faltoso às penalidades previstas no Contrato de Consórcio, Estatuto do CONSÓRCIO e Art. 8º, § 5º, da Lei Federal nº 11.107/05 (Lei Geral dos consórcios Públicos), sem prejuízo de cobranças judiciais e bloqueio administrativo dos serviços aderidos.
</p>

<p class="clausula">V – DISPOSIÇÕES GERAIS:</p>

<p class="clausula">CLÁUSULA QUINTA</p>

<p>
O presente instrumento terá vigência por 12 (doze) meses, iniciando em 02 de janeiro de 2026 e encerrando-se em 31 de dezembro de 2026, sendo que o CONSORCIADO autoriza expressamente o CONSÓRCIO a efetuar a compra compartilha de medicamentos através de licitação na modalidade pregão eletrônico tipo registro de preços, bem como autoriza a compra pelo menor preço, através de chamamento público, de consultas e exames especializados.
</p>

<p class="clausula">CLÁUSULA SEXTA</p>

<p>
As despesas decorrentes do presente instrumento correrão por conta das dotações orçamentárias previstas no orçamento do CONSORCIADO.
</P>
<p>
Parágrafo Único – A celebração do presente contrato de Programa de consórcio público sem suficiente e prévia dotação orçamentária ou sem observar as formalidades legais previstas configurará ato de improbidade administrativa insculpido no art. 10, inc. XV, da Lei Federal nº 8.429/92 e legislação modificativa (Lei dos Atos de Improbidade Administrativa).

</p>

<p class="clausula">CLÁUSULA SÉTIMA</p>

<p>
A eventual retirada do CONSÓRCIO de qualquer de um dos demais CONSORCIADOS não implicará a extinção do presente instrumento, ficando assegurado ao CONSÓRCIO, na superveniência de tal hipótese, o direito de aditar, a qualquer tempo, o presente instrumento para restabelecer seu equilíbrio econômico-financeiro, nos termos do art. 124, Inciso II, letra “d” da lei nº 14.133/21.
</p>

<p class="clausula">CLÁUSULA OITAVA</p>

<p>
O presente instrumento poderá ser rescindido por qualquer uma das partes, com aviso prévio de 60 (sessenta) dias, permanecendo em vigor as obrigações assumidas até sua quitação total.  
</p>

<p class="clausula">VI – DO FORO:</p>

<p>
As partes elegem de comum acordo o Foro da Comarca de Ijui, para dirimir dúvidas emergentes do presente acordo. 

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