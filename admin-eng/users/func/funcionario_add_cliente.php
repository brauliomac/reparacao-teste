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
            <a href="index.html" class="logo">
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
                      <a href="../demo1/index.html">
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
                  <p>Gerir Clientes</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="base">
                  <ul class="nav nav-collapse">
                    
                    <li>
                      <a href="">
                        <span class="sub-item">Adicionar Cliente</span>
                      </a>
                    </li>
                    <li>
                      <a href="components/gridsystem.html">
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
                      <a href="sidebar-style-2.html">
                        <span class="sub-item">Adicionar Tecnico</span>
                      </a>
                    </li>
                    <li>
                      <a href="icon-menu.html">
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
                      <a href="forms/forms.html">
                        <span class="sub-item"> Adicionar Funcionario</span>
                      </a>
                    </li>

                    <li>
                      <a href="forms/forms.html">
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
                      <a href="tables/tables.html">
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
                      <a href="maps/googlemaps.html">
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
                      <a href="charts/charts.html">
                        <span class="sub-item">Relatorio Detalhado</span>
                      </a>
                    </li>
                    <li>
                      <a href="charts/sparkline.html">
                        <span class="sub-item">Desempnho dos Tecnicos</span>
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

      <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Buttons</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Base</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Buttons</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Button Original</h4>
                  </div>
                  <div class="card-body">
                    <p class="demo">
                      <button class="btn btn-black">Default</button>

                      <button class="btn btn-primary">Primary</button>

                      <button class="btn btn-secondary">Secondary</button>

                      <button class="btn btn-info">Info</button>

                      <button class="btn btn-success">Success</button>

                      <button class="btn btn-warning">Warning</button>

                      <button class="btn btn-danger">Danger</button>

                      <button class="btn btn-link">Link</button>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Button with Label</h4>
                  </div>
                  <div class="card-body">
                    <p class="demo">
                      <button class="btn btn-black">
                        <span class="btn-label">
                          <i class="fa fa-archive"></i>
                        </span>
                        Default
                      </button>

                      <button class="btn btn-primary">
                        <span class="btn-label">
                          <i class="fa fa-bookmark"></i>
                        </span>
                        Primary
                      </button>

                      <button class="btn btn-secondary">
                        <span class="btn-label">
                          <i class="fa fa-plus"></i>
                        </span>
                        Secondary
                      </button>

                      <button class="btn btn-info">
                        <span class="btn-label">
                          <i class="fa fa-info"></i>
                        </span>
                        Info
                      </button>

                      <button class="btn btn-success">
                        <span class="btn-label">
                          <i class="fa fa-check"></i>
                        </span>
                        Success
                      </button>

                      <button class="btn btn-warning">
                        <span class="btn-label">
                          <i class="fa fa-exclamation-circle"></i>
                        </span>
                        Warning
                      </button>

                      <button class="btn btn-danger">
                        <span class="btn-label">
                          <i class="fa fa-heart"></i>
                        </span>
                        Danger
                      </button>

                      <button class="btn btn-link">
                        <span class="btn-label">
                          <i class="fa fa-link"></i>
                        </span>
                        Link
                      </button>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Button Icon</h4>
                  </div>
                  <div class="card-body">
                    <p class="demo">
                      <button
                        type="button"
                        class="btn btn-icon btn-round btn-black"
                      >
                        <i class="fa fa-align-left"></i>
                      </button>

                      <button
                        type="button"
                        class="btn btn-icon btn-round btn-primary"
                      >
                        <i class="fab fa-twitter"></i>
                      </button>

                      <button
                        type="button"
                        class="btn btn-icon btn-round btn-secondary"
                      >
                        <i class="fa fa-bookmark"></i>
                      </button>

                      <button
                        type="button"
                        class="btn btn-icon btn-round btn-info"
                      >
                        <i class="fa fa-info"></i>
                      </button>

                      <button
                        type="button"
                        class="btn btn-icon btn-round btn-success"
                      >
                        <i class="fa fa-check"></i>
                      </button>

                      <button
                        type="button"
                        class="btn btn-icon btn-round btn-warning"
                      >
                        <i class="fa fa-exclamation-circle"></i>
                      </button>

                      <button
                        type="button"
                        class="btn btn-icon btn-round btn-danger"
                      >
                        <i class="fa fa-heart"></i>
                      </button>

                      <button type="button" class="btn btn-icon btn-link">
                        <i class="fa fa-link"></i>
                      </button>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Disabled Button</h4>
                  </div>
                  <div class="card-body">
                    <p class="demo">
                      <button class="btn btn-black" disabled="disabled">
                        Default
                      </button>

                      <button class="btn btn-primary" disabled="disabled">
                        Primary
                      </button>

                      <button class="btn btn-secondary" disabled="disabled">
                        Secondary
                      </button>

                      <button class="btn btn-info" disabled="disabled">
                        Info
                      </button>

                      <button class="btn btn-success" disabled="disabled">
                        Success
                      </button>

                      <button class="btn btn-warning" disabled="disabled">
                        Warning
                      </button>

                      <button class="btn btn-danger" disabled="disabled">
                        Danger
                      </button>

                      <button class="btn btn-link" disabled>Link</button>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Button Size</h4>
                  </div>
                  <div class="card-body">
                    <p class="demo">
                      <button class="btn btn-primary btn-lg">Large</button>

                      <button class="btn btn-primary">Normal</button>

                      <button class="btn btn-primary btn-sm">Small</button>

                      <button class="btn btn-primary btn-xs">
                        Extra Small
                      </button>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Button Type</h4>
                  </div>
                  <div class="card-body">
                    <p class="demo">
                      <button class="btn btn-primary">Normal</button>
                      <button class="btn btn-primary btn-border">Border</button>

                      <button class="btn btn-primary btn-round">Round</button>

                      <button class="btn btn-primary btn-border btn-round">
                        Round
                      </button>

                      <button class="btn btn-primary btn-link">Link</button>
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Bootstrap Dropdown</h4>
                  </div>
                  <div class="card-body">
                    <div class="demo">
                      <div class="btn-group dropdown">
                        <button
                          class="btn btn-primary dropdown-toggle"
                          type="button"
                          data-bs-toggle="dropdown"
                        >
                          DropDown
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                              >Something else here</a
                            >
                          </li>
                        </ul>
                      </div>

                      <div class="btn-group dropup">
                        <button
                          class="btn btn-info dropdown-toggle"
                          type="button"
                          data-bs-toggle="dropdown"
                        >
                          DropUp
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                              >Something else here</a
                            >
                          </li>
                        </ul>
                      </div>

                      <div class="btn-group dropend">
                        <button
                          type="button"
                          class="btn btn-success btn-round dropdown-toggle"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          DropRight
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                              >Something else here</a
                            >
                          </li>
                        </ul>
                      </div>

                      <div class="btn-group dropstart">
                        <button
                          type="button"
                          class="btn btn-black btn-border dropdown-toggle"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false"
                        >
                          DropLeft
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"
                              >Something else here</a
                            >
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Badge</h4>
                  </div>
                  <div class="card-body">
                    <span class="badge badge-count">Count</span>
                    <span class="badge badge-black">Default</span>
                    <span class="badge badge-primary">Primary</span>
                    <span class="badge badge-info">Info</span>
                    <span class="badge badge-success">Success</span>
                    <span class="badge badge-warning">Warning</span>
                    <span class="badge badge-danger">Danger</span>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Nav Pills</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-pills nav-primary">
                      <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">Pagination</h4>
                  </div>
                  <div class="card-body">
                    <div class="demo">
                      <ul class="pagination pg-primary">
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                        <li class="page-item active">
                          <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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
