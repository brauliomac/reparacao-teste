<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
$tecnico_id = $_SESSION['user_id'];

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
            <a href="tecnico_dashboard.php" class="logo">
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
                <a href="" class="collapsed" aria-expanded="false">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="tecnico_dashboard.php">
                        <span class="sub-item">Dashboard</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Funções</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-clipboard-list"></i>
                  <p>Solicitações</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    
                    <li>
                      <a href="tecnico_solicitacao_pendente.php">
                        <span class="sub-item">Pendentes</span>
                      </a>
                    </li>

                    <li>
                      <a href="tecnico_solicitacao_finalizada.php">
                        <span class="sub-item">Finalizadas</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                  <i class="fas fa-wrench"></i>
                  <p>Montagem</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="tecnico_montagem_pendente.php">
                        <span class="sub-item">Pendente</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              

              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                <i class="fas fa-sign-out-alt"></i>
                  <p>Sair</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="forms">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="../../logout.php">
                        <span class="sub-item"> Sair</span>
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
              <a href="index.html" class="logo">
                <img
                  src="../../assets/img/icon.png"
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
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>              

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
                      <span class="op-7">Ola, </span>
                      <span class="fw-bold"><?php echo $_SESSION['name']; ?></span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                      <a  href="tecnico_editar_perfil.php" class="dropdown-item">Perfil</a>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        <a  href="../../logout.php" class="dropdown-item">Sair</a>
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
                            $sql = "SELECT COUNT(*) AS total FROM pedidos WHERE tecnico_id = ? AND status = 'atribuido'";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $tecnico_id);
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
                          <p class="card-category">Montagens Pendentes</p>
                          <?php
                            $sql = "SELECT COUNT(*) AS total FROM pedidos WHERE tecnico_id = ? AND status = 'diagnosticado'";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $tecnico_id);
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
                          <i class="far fa-check-circle"></i>
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Montagens Finalizadas</p>
                          <?php
                            $sql = "SELECT COUNT(*) AS total FROM pedidos WHERE tecnico_id = ? AND status = 'montado'";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $tecnico_id);
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
                    <div class="card-title">Meu Desenpenho </div>
                  </div>
                  <div class="card-body" style="height: 300px;">
                    
                    <canvas id="tecnicoChart1"></canvas>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            
            <div class="copyright">
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
              WHERE tecnico_id = ? 
              AND (status != 'montado' OR status != 'rejeitado')) AS solicitacoes_recebidas, 
            
            (SELECT COUNT(*) 
              FROM pedidos 
              WHERE tecnico_id = ? 
              AND status = 'montado') AS montagens_finalizadas;
        ";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $tecnico_id, $tecnico_id); 
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    
        $solicitacoesRecebidas = $data['solicitacoes_recebidas'];
        $montagensFinalizadas = $data['montagens_finalizadas'];
      
      ?>
    var solicitacoesRecebidas = <?php echo $solicitacoesRecebidas; ?> ;  
    var montagensTerminadas = <?php echo $montagensFinalizadas; ?>;
    
    var ctx = document.getElementById('tecnicoChart1').getContext('2d');
    var tecnicoChart1 = new Chart(ctx, {
      type: 'bar',  
      data: {
        labels: ['Solicitações Recebidas', 'Montagens Finalizadas'],  
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
