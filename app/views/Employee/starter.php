<?php require_once APP."/views/master/header.php"; ?>

<!-- overlayScrollbars -->
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['mailbox_log']['level']}_nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php $name = explode(' ', $_SESSION['log']['name']); ?>
            <h1 class="m-0 text-dark"><?= LANG['starter_message'] ?> <?= $name[0] ?>!</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['starter_page'] ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 bg-educo">
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="fas fa-door-open"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Último inicio de sesión</span>
                <span class="info-box-number">
                  09/08/2021 <i class="far fa-clock"></i> 11:25:00
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 bg-educo">
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="fas fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Bitácoras registradas</span>
                <span class="info-box-number">41</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 bg-educo">
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="fas fa-map-marked-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Último destino</span>
                <span class="info-box-number">
                  San Salvador
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 bg-educo">
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="fas fa-truck-pickup"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Último Vehículo</span>
                <span class="info-box-number">P-692922</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-12">
            <div class="card card-primary card-outline">
              <div class="card-header border-transparent">
                <h3 class="card-title">Historial de registros</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table class="table table-bordered table-striped <?= LANG['datable'] ?>">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Color</th>
                        <th>Region</th>
                        <th>Hora Salida</th>
                        <th>Km Salida</th>
                        <th>Hora Entrada</th>
                        <th>Km Entrada</th>
                        <th>Destino</th>
                        <th>Estado</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>P-101408</td>
                        <td>Nissan</td>
                        <td>Rojo</td>
                        <td>Central San Salvador</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 07:00:00</td>
                        <td>314575</td>
                        <td>29-Jul-2021 <i class="fas fa-clock fa-sm text-educo"></i> 14:45:00</td>
                        <td>318542</td>
                        <td>San Miguel</td>
                        <td><span class="badge badge-success">Finalizado</span></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-educo">Ver bitácora</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/datatable.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
