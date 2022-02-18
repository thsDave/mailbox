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
            <?php $name = explode(' ', $_SESSION['mailbox_log']['name']); ?>
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
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="far fa-angry"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Quejas</span>
                <span class="info-box-number"><span id="total_bqj"></span></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 bg-educo">
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="fas fa-comment-exclamation"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sugerencias</span>
                <span class="info-box-number"><span id="total_bsg"></span></span>
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
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="far fa-smile-wink"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Felicitaciones</span>
                <span class="info-box-number"><span id="total_bfl"></span></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 bg-educo">
              <span class="info-box-icon bg-turquesa elevation-1 text-light"><i class="fas fa-exclamation-triangle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Denuncias</span>
                <span class="info-box-number"><span id="total_denuncias"></span></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Reporte mensual de casos</h5>

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
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Actualizado al: <span id="current_date"></span></strong>
                    </p>

                    <div class="chart">
                      <canvas id="dashChart" height="180" style="height: 180px;"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Total de casos en <span id="current_year"></span></strong>
                    </p>

                    <div class="progress-group">
                      <span class="progress-text">Casos registrados</span>
                      <span class="float-right"><span id="total_registros"></span></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      <span class="progress-text">Casos pendientes</span>
                      <span class="float-right"><span id="total_pendientes"></span></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-danger" id="porc_pendientes"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">Casos cerrados</span>
                      <span class="float-right"><span id="total_cerrados"></span></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-success" id="porc_cerrados" style="width: 60%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">Casos abiertos</span>
                      <span class="float-right"><span id="total_abiertos"></span></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" id="porc_abiertos" style="width: 50%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
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
<script src="plugins/chart.js/Chart.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/datatable.js"></script>

<script src="dist/js/dashchart.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>
