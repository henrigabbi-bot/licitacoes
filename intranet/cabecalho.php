<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Central de Medicamentos</a>
       <ul class="navbar-nav px-3">
          <li class="nav-item text-nowrap">
           <a class="btn btn-danger" href="logout.php" title="Fazer logout">
            <span class="glyphicon glyphicon-off">Sair</span>
           </a>              
         </li>
      </ul>
</nav>
<div class="container-fluid" >
  <div class="row" style="background-color:#047857;">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar" >
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="index.php">
                  <span class="fa-solid fa-house" data-feather="home"> </span>
                Home 
                </a>

              </li>

               <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Cadastros</span>
              
            </h6>
             <li class="nav-item" style="background-color:#0e7490;">
                <a class="nav-link" href="processoadministrativo/index.php" style="color:white;">
                   <span class="far fa-city"></span>
                
                  Processos Administrativos
                </a>
              </li>
              <li class="nav-item" style="background-color:#047857;">
                <a class="nav-link" href="clientes/index.php" style="color:white;">
                   <span class="far fa-address-book"></span>
                  Clientes
                </a>
              </li>
              <li class="nav-item" style="background-color:#0e7490;">
                <a class="nav-link" href="fornecedor/index.php" style="color:white;">
                  <span class="far fa-building" data-feather="bar-chart-2"></span>
                  Fornecedor
                </a>
              </li>
              <li class="nav-item" style="background-color:#c2410c;">
                <a class="nav-link" href="licitacao/index.php" style="color:white;">
                  <span class="fas fa-gavel" data-feather="layers"></span>
                  Licitação
                </a>
              </li>

              <li class="nav-item" style="background-color:#6d28d9;">
                <a class="nav-link" href="produto/index.php" style="color:white;">
                  <span class="fab fa-codepen"></span>
                  Produtos
                </a>              
              </li> 
               <li class="nav-item" >
                <a class="nav-link" href="pessoas/index.php">
                  <span class="far fa-address-card"></span>
                  Pessoas
                </a>
              </li>                     
                

              <li class="nav-item">
                <a class="nav-link" href="usuario/index.php">
                  <span class="fas fa-user"></span>
                  Usuários
                </a>
              </li>
               
              
              
            </ul>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Contratos</span>              
              </h6>
                <ul class="nav flex-column mb-2">
                  <li class="nav-item">
                      <a class="nav-link" href="contratoderateio/index.php">
                        <span data-feather="file-text"></span>
                        Contrato de Rateio
                      </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="contratodeprograma/index.php">
                        <span data-feather="file-text"></span>
                        Contrato de Programa
                      </a>
                  </li>
                   
                </ul>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Importação Contrato de Rateiro</span>
              
            </h6>
            <ul class="nav flex-column mb-2">
              <li class="nav-item">
                <a class="nav-link" href="importartaxaceo/importar.php">
                  <span data-feather="file-text"></span>
                  Importar Valores Contrato de Rateio
                </a>
              </li>
             
              </ul>
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Importação Contrato de Programa</span>              
            </h6>

              <ul class="nav flex-column mb-2">
              
              <li class="nav-item">
                <a class="nav-link" href="importarcontratodeprograma/importar.php">
                  <span data-feather="file-text"></span>
                   Importar Valores Contrato de Programa
                </a>
              </li>
             
               </ul>

             <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
              <span>Importação </span>              
            </h6>

              <ul class="nav flex-column mb-2">
             <li class="nav-item">
                <a class="nav-link" href="resultadolicitacao/index.php">
                  <span data-feather="file-text"></span>
                  Vencedores da Licitação
                </a>
              </li>
             
             
              
              
            </ul>
     </nav>
  </div>
</div> 