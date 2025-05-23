<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
} else {
    die("ID da solicitação não informado.");
}

// Busca os detalhes da solicitação (apenas se o status for 'diagnosticado')
$sql = "SELECT r.*, u.name AS cliente_name FROM pedidos r 
        JOIN users u ON r.cliente_id = u.id 
        WHERE r.id = $pedido_id AND r.status = 'diagnosticado'";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Solicitação não encontrada ou não está pronta para montagem.");
}
$pedido = $result->fetch_assoc();

// Verifica se existem peças faltantes para essa solicitação
$sqlParts = "SELECT SUM(quantidade_em_falta) AS total_missing FROM pedido_partes WHERE pedido_id = $pedido_id";
$partsResult = $conn->query($sqlParts);
$total_missing = 0;
if ($partsResult && $row = $partsResult->fetch_assoc()) {
    $total_missing = intval($row['total_missing']);
}
$can_montar = ($total_missing == 0);
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
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Montagem da Solicitação #<?php echo $pedido_id; ?></div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      
                        <p><strong>cliente:</strong> <?php echo htmlspecialchars($pedido['cliente_name']); ?></p>
                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($pedido['descricao']); ?></p>
                        <p><strong>Status:</strong> <?php echo $pedido['status']; ?></p>
                        <h4>Peças Utilizadas no Diagnóstico</h4>
                        <?php
                        // Lista as peças utilizadas no diagnóstico
                        $sqlList = "SELECT rp.*, i.componente FROM pedido_partes rp JOIN registo i ON rp.part_id = i.id WHERE rp.pedido_id = $pedido_id";
                        $listResult = $conn->query($sqlList);
                        if ($listResult && $listResult->num_rows > 0) {
                            echo "<table class='table table-hover'>
                                    <tr>
                                        <th>Peça</th>
                                        <th>Quantidade Utilizada</th>
                                        <th>Quantidade Faltante</th>
                                    </tr>";
                            while ($part = $listResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($part['componente']) . "</td>
                                        <td>{$part['quantidade_usada']}</td>
                                        <td>{$part['quantidade_em_falta']}</td>
                                    </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p>Nenhuma peça registrada.</p>";
                        }
                        ?>
                        <?php if ($can_montar): ?>
                            <form action="montar.php" method="post">
                                <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
                                <button type="submit" class="btn btn-success">Montar</button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Montar (Aguardando peças)</button>
                            <p class="text-danger">Não é possível montar: faltam <?php echo $total_missing; ?> peças.</p>
                        <?php endif; ?>

                    </div>
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

  </body>
</html>
