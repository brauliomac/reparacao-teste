<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'funcionario'){
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    
    <style>
.card-list .item-list {
    padding: 15px 0;
    border-bottom: 1px solid #eee;
    display: flex;
    align-items: center;
}

.card-list .item-list:last-child {
    border-bottom: none;
}

.avatar-title {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}

.info-user {
    flex: 1;
}

.card-head-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}
</style>
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="funcionario_dashboard.php" class="logo">
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
                  href="#dashboard"
                  class="collapsed"
                  aria-expanded="false"
                >
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="dashboard">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="funcionario_dashboard.php">
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
                <a data-bs-toggle="collapse" href="#solic">
                  <i class="fas fa-layer-group"></i>
                  <p>Solicitações</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="solic">
                  <ul class="nav nav-collapse">
                    
                    <li>
                      <a href="funcionario_soli_pendente.php">
                        <span class="sub-item">Pendentes</span>
                      </a>
                    </li>
                    <li>
                      <a href="funcionario_soli_aprovada.php">
                        <span class="sub-item">Em Andamento</span>
                      </a>
                    </li>
                    <li>
                      <a href="funcionario_soli_finalizada.php">
                        <span class="sub-item">Finalizadas</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#base">
                  <i class="fas fa-layer-group"></i>
                  <p>Gerir Clientes</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    
                    <li>
                      <a href="funcionario_add_cliente.php">
                        <span class="sub-item">Adicionar Cliente</span>
                      </a>
                    </li>
                    <li>
                      <a href="funcionario_ver_clientes.php">
                        <span class="sub-item">Ver Clientes</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sidebarLayouts">
                  <i class="fas fa-th-list"></i>
                  <p>Gerir Tecnicos</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="funcionario_add_tecnico.php">
                        <span class="sub-item">Adicionar Tecnico</span>
                      </a>
                    </li>
                    <li>
                      <a href="funcionario_ver_tecnicos.php">
                        <span class="sub-item">Ver Tecnicos</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              

              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#forms">
                  <i class="fas fa-pen-square"></i>
                  <p>Gerir Funcionarios</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="forms">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="funcionario_add_funcionario.php">
                        <span class="sub-item"> Adicionar Funcionario</span>
                      </a>
                    </li>

                    <li>
                      <a href="funcionario_ver_funcionario.php">
                        <span class="sub-item"> Ver Funcionarios</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tables">
                  <i class="fas fa-table"></i>
                  <p>Estoque de Peças</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tables">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="registo.php">
                        <span class="sub-item">Ver Estoque</span>
                      </a>
                    </li>
                    
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#maps">
                  <i class="fas fa-map-marker-alt"></i>
                  <p>Departamento de Compras</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="maps">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="pedidos_compra.php">
                        <span class="sub-item">Lista de Compras</span>
                      </a>
                    </li>
                    
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#charts">
                  <i class="far fa-chart-bar"></i>
                  <p>Relatorio</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="charts">
                  <ul class="nav nav-collapse">
                  <li>
                      <a href="relatorio_simples.php">
                        <span class="sub-item"> Simples</span>
                      </a>
                    </li>  
                  <li>
                    <li>
                      <a href="relatorio_detalhado.php">
                        <span class="sub-item"> Detalhado</span>
                      </a>
                    </li>
                    <li>
                      <a href="tecnico_performance.php">
                        <span class="sub-item">Desempnho dos Tecnicos</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sair">
                  <i class="far fa-chart-bar"></i>
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
                          <a href="funcionario_editar_perfil.php" class="dropdown-item" >  Perfil</a>
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
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
              </div>
              
            </div>
            <div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-icon">
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Clientes</p>
                            <?php
                            $sql = "SELECT COUNT(*) as total FROM users WHERE papel = 'cliente'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
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
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-user-cog text-info"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Tecnicos</p>
                            <?php
                            $sql = "SELECT COUNT(*) as total FROM users WHERE papel = 'tecnico'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
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
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-user-tie text-dark"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Funcionarios</p>
                            <?php
                            $sql = "SELECT COUNT(*) as total FROM users WHERE papel = 'funcionario'";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
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
                        <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-tasks text-warning"></i>
                        </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                            <p class="card-category">Solicitações</p>
                            <?php
                            $sql = "SELECT COUNT(*) as total FROM pedidos";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            echo "<h4 class='card-title'>".(int)$row['total']."</h4>";
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Status das Solicitações</div>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Desempenho dos Técnicos</div>
            </div>
            <div class="card-body" style="height: 300px;">
                <canvas id="tecnicoChart"></canvas>
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
document.addEventListener('DOMContentLoaded', function() {
    // Status das Solicitações
    <?php
    $statusQuery = "SELECT 
        status,
        COUNT(*) as total 
        FROM pedidos 
        GROUP BY status";
    $result = $conn->query($statusQuery);
    
    $labels = [];
    $data = [];
    $colors = [
        'pendente' => '#FF6384',
        'atribuido' => '#36A2EB',
        'diagnosticado' => '#FFCD56',
        'montado' => '#4BC0C0',
        'rejeitado' => '#9966FF'
    ];
    
    while($row = $result->fetch_assoc()) {
        $labels[] = ucfirst($row['status']);
        $data[] = (int)$row['total'];
    }
    ?>
    
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                data: <?= json_encode($data) ?>,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCD56', 
                    '#4BC0C0', '#9966FF'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Desempenho dos Técnicos
    <?php
    $tecnicoQuery = "SELECT 
        u.name,
        COUNT(DISTINCT p.id) as total_pedidos,
        SUM(CASE WHEN p.status = 'montado' THEN 1 ELSE 0 END) as concluidos
        FROM users u
        LEFT JOIN pedidos p ON u.id = p.tecnico_id
        WHERE u.papel = 'tecnico'
        GROUP BY u.id, u.name
        ORDER BY total_pedidos DESC
        LIMIT 5";
    $result = $conn->query($tecnicoQuery);
    
    $tecLabels = [];
    $totalPedidos = [];
    $pedidosConcluidos = [];
    
    while($row = $result->fetch_assoc()) {
        $tecLabels[] = $row['name'];
        $totalPedidos[] = (int)$row['total_pedidos'];
        $pedidosConcluidos[] = (int)$row['concluidos'];
    }
    ?>

    new Chart(document.getElementById('tecnicoChart'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($tecLabels) ?>,
            datasets: [{
                label: 'Total de Pedidos',
                data: <?= json_encode($totalPedidos) ?>,
                backgroundColor: '#36A2EB'
            }, {
                label: 'Concluídos',
                data: <?= json_encode($pedidosConcluidos) ?>,
                backgroundColor: '#4BC0C0'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

    <?php
    function getInitials($name) {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $w) {
            $initials .= strtoupper($w[0]);
        }
        return substr($initials, 0, 2);
    }
    ?>
  </body>
</html>
