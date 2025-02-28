<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'cliente'){
  header("Location: ../../login.php");
  exit;
}
include '../../db/db.php';
$cliente_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>System ReparAqui</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <link rel="icon" href="../../assets/img/icon.png"  type="image/x-icon"  />

    <!-- Fonts and icons -->
    <script src="../../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["../../assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../../assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="../../assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="cliente_dashboard.php" class="logo">
              <img
                src="../../assets/img/icon.png"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
              <h5>System ReparAqui</h5>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a
                  data-bs-toggle="collapse"
                  href="cliente_dashboard.php"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Funções</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>Solicitação</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    
                    <li>
                      <a href="cliente_novo_pedido.php">
                        <span class="sub-item">Adicionar </span>
                      </a>
                    </li>
                    <li>
                      <a href="cliente_ver_pedidos.php">
                        <span class="sub-item">Histórico</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
             
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sair">
                  <i class="fas fa-layer-group"></i>
                  <p>Sair</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sair">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../../logout.php">
                        <span class="sub-item">Sair</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              
            </ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="../../index.html" class="logo">
                <img
                  src="../../assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
             

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                     <div class="avatar-md">
                      <i class="fa fa-user"></i>
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Ola,</span>
                      <span class="fw-bold"> <?php echo $_SESSION['name']; ?> </span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      
                      <li>
                        <a class="dropdown-item" href="cliente_editar_perfil.php">Perfil</a>
                        <a class="dropdown-item" href="../../logout.php">Sair</a>
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">  
            
          <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                        <i class="fas fa-hourglass-half"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Solitações Pendentes</p>
                          <?php
                            $sql = "SELECT COUNT(*) AS total FROM pedidos WHERE cliente_id = ? AND status = 'pendente'";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $cliente_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            $total = $row['total']; 
                            echo "<h4 class='card-title'>".(int)$row['total']."</h4>";
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                        <i class="fas fa-times-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Solicitações Rejeitadas</p>
                          <?php
                            $sql = "SELECT COUNT(*) AS total FROM pedidos WHERE cliente_id = ? AND status = 'rejeitado'";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $cliente_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            $total = $row['total']; 
                            echo "<h4 class='card-title'>".(int)$row['total']."</h4>";
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div
                          class="icon-big text-center icon-secondary bubble-shadow-small"
                        >
                        <i class="fas fa-hourglass-half"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Solicitações Feitas</p>
                          <?php
                            $sql = "SELECT COUNT(*) AS total FROM pedidos WHERE cliente_id = ? ";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $cliente_id);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            $total = $row['total']; 
                            echo "<h4 class='card-title'>".(int)$row['total']."</h4>";
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                         
            </div>
          
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Solicitações Realizadas </div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      <canvas id="clienteChart1"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            
            <div class="copyright ">
              <p>System ReparAqui @ 2025</p>
            </div>
          </div>
          </div>
        </footer>
      </div>
    </div>

    <!--   Core JS Files   -->
    <script src="../../assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/core/popper.min.js"></script>
    <script src="../../assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="../../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="../../assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="../../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="../../assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="../../assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="../../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="../../assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="../../assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="../../assets/js/kaiadmin.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

      <?php
        $sql = "
          SELECT 
          (SELECT COUNT(*) 
          FROM pedidos 
          WHERE cliente_id = ?) AS solicitacoes_totais,
          
          (SELECT COUNT(*) 
          FROM pedidos 
          WHERE cliente_id = ? 
          AND status = 'pendente') AS solicitacoes_pendentes;"
        ;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cliente_id, $cliente_id); 
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $solicitacoesTotais = $data['solicitacoes_totais'];
        $solicitacoesPendentes = $data['solicitacoes_pendentes'];
      
      ?>
    var solicitacoesRecebidas = <?php echo $solicitacoesTotais; ?> ;  
    var montagensTerminadas = <?php echo $solicitacoesPendentes; ?>;

    var ctx = document.getElementById('clienteChart1').getContext('2d');
    var tecnicoChart1 = new Chart(ctx, {
      type: 'bar',  
      data: {
        labels: ['Solicitações Feitas', 'Solicitações Pendentes'],  
        datasets: [{
          label: 'Total', 
          data: [solicitacoesRecebidas, montagensTerminadas],  
          backgroundColor: [
            'rgb(54, 162, 235)', 
            'rgb(75, 192, 192)' 
          ],
          borderColor: [
            'rgba(54, 162, 235, 1)', 
            'rgba(75, 192, 192, 1)'  
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,  
        scales: {
          y: {
            beginAtZero: true  
          }
        }
      }
    });
    </script>


  </body>
</html>
