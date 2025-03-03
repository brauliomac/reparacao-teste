<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica se o usuário está logado e se sua função é 'tecnico'
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}

include '../../db/db.php';

$error = "";
$success = "";
$tecnico_id = $_SESSION['user_id'];

// Processa o formulário quando for submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['name'], $_POST['username'])) {
      $name = $conn->real_escape_string(trim($_POST['name']));
      $username = $conn->real_escape_string(trim($_POST['username']));
      
      if (empty($name) || empty($username)) {
          $error = "Preencha todos os campos obrigatórios.";
      } else {
          // Se uma nova senha for informada, atualize-a; caso contrário, mantenha a senha atual
          if (!empty($_POST['password'])) {
              $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
              $sql = "UPDATE users SET name='$name', username='$username', password='$password' WHERE id=$tecnico_id AND papel='tecnico'";
          } else {
              $sql = "UPDATE users SET name='$name', username='$username' WHERE id=$tecnico_id AND papel='tecnico'";
          }
          
          if ($conn->query($sql) === TRUE) {
              $success = "Dados atualizados com sucesso.";
              // Atualiza a variável de sessão, se necessário
              $_SESSION['name'] = $name;
          } else {
              $error = "Erro ao atualizar os dados: " . $conn->error;
          }
      }
  } else {
      $error = "Dados inválidos.";
  }
}

// Busca os dados atuais do cliente para preencher o formulário
$sql = "SELECT * FROM users WHERE id = $tecnico_id AND papel='tecnico'";
$result = $conn->query($sql);
if (!$result || $result->num_rows != 1) {
    die("Técnico não encontrado.");
}
$tecnico = $result->fetch_assoc();
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
                    <div class="card-title">Actualizar Dados Pessoais </div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                      
                      <?php if ($error != ""): ?>
                          <div class="alert alert-danger"><?php echo $error; ?></div>
                      <?php endif; ?>
                      
                      <?php if ($success != ""): ?>
                          <div class="alert alert-success"><?php echo $success; ?></div>
                      <?php endif; ?>
                      
                      <form method="post" action="tecnico_editar_perfil.php">
                          <div class="form-group">
                              <label for="name">Nome Completo:</label>
                              <input type="text" name="name" id="name" class="form-control" required value="<?php echo htmlspecialchars($tecnico['name']); ?>">
                          </div>
                          <div class="form-group">
                              <label for="username">Usuário:</label>
                              <input type="text" name="username" id="username" class="form-control" required value="<?php echo htmlspecialchars($tecnico['username']); ?>">
                          </div>
                          <div class="form-group">
                              <label for="password">Senha (deixe em branco para manter a atual):</label>
                              <input type="password" name="password" id="password" class="form-control">
                          </div>
                          <button type="submit" class="btn btn-primary mx-3">Actualizar</button>
                      </form>

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
