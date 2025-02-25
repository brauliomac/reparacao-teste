<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['papel'] != 'tecnico') {
    header("Location: ../../login.php");
    exit;
}
include '../../db/db.php';

// Obtém o ID da solicitação via GET ou via POST (caso o formulário seja submetido)
if (isset($_GET['id'])) {
    $pedido_id = intval($_GET['id']);
} elseif (isset($_POST['pedido_id'])) {
    $pedido_id = intval($_POST['pedido_id']);
} else {
    die("Solicitação inválida.");
}

// Processamento dos formulários
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        // Atualização do status da solicitação
        if ($action == 'update_status') {
            if (isset($_POST['new_status'])) {
                $new_status = $_POST['new_status'];
                $allowed_status = array('pendente', 'diagnosticado'); 
                if (in_array($new_status, $allowed_status)) {
                    $sql = "UPDATE pedidos SET status = '$new_status' WHERE id = $pedido_id";
                    if (!$conn->query($sql)) {
                        $error_status = "Erro ao atualizar status: " . $conn->error;
                    } else {
                        $success_status = "Status atualizado com sucesso.";
                    }
                } else {
                    $error_status = "Status inválido.";
                }
            }
        }
        // Adição de peça necessária
        elseif ($action == 'add_part') {
            if (isset($_POST['part_id']) && isset($_POST['quantity_required'])) {
                $part_id = intval($_POST['part_id']);
                $quantity_required = intval($_POST['quantity_required']);
                if ($quantity_required <= 0) {
                    $error_part = "A quantidade deve ser maior que zero.";
                } else {
                    // Consulta a quantidade disponível em estoque para a peça selecionada
                    $sql = "SELECT quantidade FROM registo WHERE id = $part_id";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $available = intval($row['quantidade']);
                        if ($quantity_required <= $available) {
                            // Há estoque suficiente: usa a quantidade solicitada
                            $quantidade_usada = $quantity_required;
                            $quantidade_em_falta = 0;
                            $new_stock = $available - $quantity_required;
                        } else {
                            // Estoque insuficiente: usa o que está disponível e calcula a quantidade faltante
                            $quantidade_usada = $available;
                            $quantidade_em_falta = $quantity_required - $available;
                            $new_stock = 0;
                        }
                        // Atualiza o estoque para a peça
                        $updateInv = "UPDATE registo SET quantidade = $new_stock WHERE id = $part_id";
                        $conn->query($updateInv);
                        
                        // Registra a utilização da peça na solicitação
                        $insertPart = "INSERT INTO pedido_partes (pedido_id, part_id, quantidade_usada, quantidade_em_falta) VALUES ($pedido_id, $part_id, $quantidade_usada, $quantidade_em_falta)";
                        if ($conn->query($insertPart)) {
                            $success_part = "Peça adicionada ao diagnóstico.";
                            // Se houver quantidade faltante, gera um pedido de compra para o departamento de compras
                            if ($quantidade_em_falta > 0) {
                                $insertPurchase = "INSERT INTO pedidos_compra (componente_id, quantidade_necessaria) VALUES ($part_id, $quantidade_em_falta)";
                                $conn->query($insertPurchase);
                                $warning_part = "Estoque insuficiente. Pedido de compra gerado para $quantidade_em_falta unidades.";
                            }
                        } else {
                            $error_part = "Erro ao registrar a peça: " . $conn->error;
                        }
                    } else {
                        $error_part = "Peça não encontrada no estoque.";
                    }
                }
            } else {
                $error_part = "Dados da peça inválidos.";
            }
        }
    }
}

// Obtém os dados da solicitação
$sql = "SELECT r.*, u.name AS cliente_name FROM pedidos r JOIN users u ON r.cliente_id = u.id WHERE r.id = $pedido_id";
$pedidoResult = $conn->query($sql);
if (!$pedidoResult || $pedidoResult->num_rows != 1) {
    die("Solicitação não encontrada.");
}
$pedidoData = $pedidoResult->fetch_assoc();

// Obtém as peças já adicionadas para essa solicitação
$sqlParts = "SELECT rp.*, i.componente FROM pedido_partes rp JOIN registo i ON rp.part_id = i.id WHERE rp.pedido_id = $pedido_id";
$partsResult = $conn->query($sqlParts);

// Obtém todas as peças do estoque para popular o select do formulário
$sqlAllParts = "SELECT * FROM registo ORDER BY componente ASC";
$allPartsResult = $conn->query($sqlAllParts);
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
                  <i class="fas fa-layer-group"></i>
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
                  <i class="fas fa-th-list"></i>
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
                  <i class="fas fa-pen-square"></i>
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
                    <div class="avatar-sm">
                      <img
                        src="../../assets/img/profile.jpg"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
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
                    <div class="card-title">Diagnóstico da Solicitação #<?php echo $pedido_id; ?></div>
                  </div>
                  <div class="card-body">
                    <div class="chart-container">
                        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($pedidoData['cliente_name']); ?></p>
                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($pedidoData['descricao']); ?></p>
                        <p><strong>Status Atual:</strong> <?php echo $pedidoData['status']; ?></p>

                        <?php if (isset($error_status)) echo "<div class='alert alert-danger'>$error_status</div>"; ?>
                        <?php if (isset($success_status)) echo "<div class='alert alert-success'>$success_status</div>"; ?>
   
                        <br>
                        <h4>Adicionar Peças Necessárias para Montagem</h4>
                        <?php if (isset($error_part)) echo "<div class='alert alert-danger'>$error_part</div>"; ?>
                        <?php if (isset($success_part)) echo "<div class='alert alert-success'>$success_part</div>"; ?>
                        <?php if (isset($warning_part)) echo "<div class='alert alert-warning'>$warning_part</div>"; ?>
                        <form method="post" action="diagnostico.php">
                            <input type="hidden" name="action" value="add_part">
                            <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
                            <div class="form-group">
                                <label for="part_id">Selecione a Peça</label>
                                <select name="part_id" id="part_id" class="form-control" required>
                                    <?php
                                    if ($allPartsResult && $allPartsResult->num_rows > 0) {
                                        while ($part = $allPartsResult->fetch_assoc()) {
                                            echo "<option value='{$part['id']}'>".htmlspecialchars($part['componente'])." (Disponível: {$part['quantidade']})</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Nenhuma peça encontrada</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity_required">Quantidade Necessária</label>
                                <input type="number" name="quantity_required" id="quantity_required" class="form-control" required min="1">
                            </div>
                            <button type="submit" class="btn btn-primary">Adicionar Peça</button>
                        </form>

                        <br> <br>

                        <!-- Lista das peças já adicionadas para essa solicitação -->
                        <h4>Peças Adicionadas para esta Solicitação</h4>
                        <?php
                        if ($partsResult && $partsResult->num_rows > 0) {
                            echo "<table class='table table-bordered'>
                                    <tr>
                                        <th>Peça</th>
                                        <th>Quantidade Utilizada</th>
                                        <th>Quantidade em Falta</th>
                                    </tr>";
                            while ($rp = $partsResult->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($rp['componente']) . "</td>
                                        <td>{$rp['quantidade_usada']}</td>
                                        <td>{$rp['quantidade_em_falta']}</td>
                                    </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p>Nenhuma peça adicionada até o momento.</p>";
                        }
                        ?>
                        <form action="diagnostico_complete.php" method="post">
                            <input type="hidden" name="pedido_id" value="<?php echo $pedido_id; ?>">
                            <button type="submit" class="btn btn-success">Concluído</button>
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
