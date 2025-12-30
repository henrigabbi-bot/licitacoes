<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Central de Medicamentos</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.2/css/all.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body {
      background-color: #f8f9fa;
      font-family: "Segoe UI", sans-serif;
    }

    h2 {
      color: #2c3e50;
      font-weight: 600;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 14px rgba(0,0,0,0.15);
    }

    .progress {
      height: 20px;
      border-radius: 10px;
      background-color: #e9ecef;
    }

    .progress-bar {
      font-size: 12px;
      font-weight: bold;
    }

    .table th {
      background-color: #007bff;
      color: white;
    }

    .album {
      background: #ffffff;
      border-radius: 10px;
      padding: 20px;
    }

    .chart-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      margin-bottom: 30px;
    }
  </style>
</head>

<body>
<?php
session_start();
if (isset($_SESSION['login'])) {
  include("cabecalho.php");
  include("conexao.php");

  // Busca últimas 6 licitações com valor total
  $sql = "SELECT l.npregao, SUM(r.quantidade * r.vlrunitario) AS total
          FROM licitacao l
          LEFT JOIN resultadolicitacao r ON l.codlic = r.idlic
          GROUP BY l.codlic
          ORDER BY l.datahomologacao DESC
          LIMIT 6;";
  $query = mysql_query($sql);

  $labels = [];
  $valores = [];

  while($row = mysql_fetch_assoc($query)) {
    $labels[] = $row['npregao'];
    $valores[] = round($row['total'], 2);
  }

  // Converte PHP → JSON para o Chart.js
  $labels_json = json_encode($labels);
  $valores_json = json_encode($valores);
?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2><i class="fa-solid fa-pills text-primary"></i> Painel Principal</h2>
  </div>

 

  <div class="album py-5">
    <div class="row">
      <?php 
      // Exibe cards das 3 licitações mais recentes
      $sql = "SELECT * FROM licitacao ORDER BY datahomologacao DESC LIMIT 3"; 
      $query = mysql_query($sql);

      while($row = mysql_fetch_array($query)) {
        $codlic = $row['codlic'];
        $sql2 = "SELECT sum(quantidade * vlrunitario) as valortotal FROM resultadolicitacao where idlic=$codlic";
        $query2 = mysql_query($sql2);
        $row2 = mysql_fetch_assoc($query2);
        $valortotal = number_format($row2['valortotal'], 2, ',', '.');
      ?>
        <div class="col-md-4 mb-4">
          <div class="card p-3 text-center">
            <h5 class="text-primary">Pregão <?php echo $row['npregao']; ?></h5>
            <h6>Valor Total: <strong>R$ <?php echo $valortotal; ?></strong></h6>
            <hr>
            <?php 
              $sql3="SELECT * FROM pedido where codlic=$codlic";
              $query3 = mysql_query($sql3);
              while($row3 = mysql_fetch_array($query3)) {
                $npedido=$row3['npedido'];

                $sql4="SELECT sum(valornf) as valortotalnfs FROM notafiscal WHERE codlic=$codlic and pedido=$npedido";
                $query4 = mysql_query($sql4); 
                $row4 = mysql_fetch_assoc($query4);
                $valortotalnfs=$row4['valortotalnfs'];

                $sql5="SELECT sum(valornf) as valortotalnfe FROM notafiscalfornecedor WHERE codlic=$codlic and pedido=$npedido";
                $query5 = mysql_query($sql5); 
                $row5 = mysql_fetch_assoc($query5);
                $valortotalnfe=$row5['valortotalnfe'];

                $sql6="SELECT SUM(pedidodecompra.quantidade * pedidodecompra.vlrunitario) as valortotalpedido 
                        FROM pedidodecompra WHERE pedidodecompra.idlic=$codlic and pedidodecompra.pedido=$npedido";
                $query6 = mysql_query($sql6); 
                $row6 = mysql_fetch_assoc($query6);
                $valortotalpedido = $row6['valortotalpedido'];

                $porcentagem = ($valortotalnfe && $valortotalpedido) ? ($valortotalnfe*100)/$valortotalpedido : 0;
                $porcentagemfaturada = ($valortotalnfe && $valortotalnfs) ? ($valortotalnfs*100)/$valortotalnfe : 0;
            ?>

            <p><strong>Pedido <?php echo $npedido; ?></strong></p>
            <p>Valor Pedido: R$ <?php echo number_format($valortotalpedido,2,',','.'); ?></p>
            
            <div class="progress mb-2">
              <div class="progress-bar bg-info" style="width:<?php echo $porcentagem; ?>%">
                <?php echo number_format($porcentagem,1,',','.'); ?>% Recebido
              </div>
            </div>

            <div class="progress mb-2">
              <div class="progress-bar bg-success" style="width:<?php echo $porcentagemfaturada; ?>%">
                <?php echo number_format($porcentagemfaturada,1,',','.'); ?>% Faturado
              </div>
            </div>

            <p>Recebido: R$ <?php echo number_format($valortotalnfe,2,',','.'); ?><br>
               Faturado: R$ <?php echo number_format($valortotalnfs,2,',','.'); ?></p>

            <a href="relatorios/estatistica.php?id=<?php echo $row['codlic'];?>&npregao=<?php echo $row['npregao']?>" 
               class="btn btn-outline-primary btn-sm mt-2">
               <i class="fa-solid fa-circle-info"></i> Detalhes
            </a>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <h4 class="mt-5"><i class="fa-solid fa-file-contract text-secondary"></i> Licitações Cadastradas</h4>
  <table class="table table-striped table-sm mt-3">
    <thead align="center">
      <tr>
        <th>Cód.</th>
        <th>Descrição</th>
        <th>Data Homologação</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody align="center">
      <?php
        $sql = "SELECT * FROM licitacao ORDER BY codlic DESC;";
        $query = mysql_query($sql);
        while($row = mysql_fetch_array($query)) {
      ?>
      <tr>
        <td><?php echo $row['codlic']; ?></td>
        <td><?php echo $row['npregao']; ?></td>
        <td><?php echo $row['datahomologacao']; ?></td>
        <td>
          <a title="Consumo" class="btn btn-success btn-sm" href="relatorios/listarprodutoxconsumoxempresa.php?id=<?php echo $row['codlic'];?>&npregao=<?php echo $row['npregao']?>">
            <i class="fas fa-search"></i>
          </a>
          <a title="Empresas" class="btn btn-warning btn-sm" href="relatorios/listarempresa.php?id=<?php echo $row['codlic'];?>&descricao=<?php echo $row['npregao']?>">
            <i class="far fa-building"></i>
          </a>
          <a title="Municípios" class="btn btn-primary btn-sm" href="relatorios/listarmunicipio.php?id=<?php echo $row['codlic'];?>&descricao=<?php echo $row['npregao']?>">
            <i class="fas fa-home"></i>
          </a>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</main>




<?php } else { header("Location: 403.php"); } ?>
</body>
</html>
