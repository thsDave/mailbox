<?php require_once APP."/views/master/header.php"; ?>

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<?php require_once APP."/views/master/{$_SESSION['mailbox_log']['level']}_nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-books"></i> Registro de casos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active">Casos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#records" data-toggle="tab">Registros</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="records">
                    <table class="table table-bordered table-striped <?= LANG['datable'] ?>">
                      <thead>
                        <tr>
                          <th>no</th>
                          <th>categoría</th>
                          <th>caso</th>
                          <th>persona</th>
                          <th>oficina</th>
                          <th>asunto</th>
                          <th>estado</th>
                          <th>acciones</th>
                        </tr>
                      </thead>
                      <?php $records = $model->records_list(date('Y-m-d'), $_SESSION['mailbox_log']['idcountry']); ?>
                      <tbody>
                        <?php if ($records): ?>
                        <?php $n = 1; ?>
                        <?php foreach ($records['idrecord'] as $i => $val): ?>
                        <tr>
                          <td><?= $n ?></td>
                          <td>
                            <?php if ($records['idcase'][$i] >= 1 && $records['idcase'][$i] <= 3): ?>
                              <span class="badge badge-pill badge-educo"><i class="far fa-mailbox"></i> Buzón de QSF</span>
                            <?php else: ?>
                              <span class="badge badge-pill badge-educodanger"><i class="far fa-exclamation-triangle"></i>Denuncia</span>
                            <?php endif ?>
                          </td>
                          <td><?= $records['casename'][$i] ?></td>
                          <td><?= $records['name'][$i] ?></td>
                          <td><?= $records['region'][$i] ?></td>
                          <td><?= $records['subject'][$i] ?></td>
                          <td>
                            <?php
                            switch ($records['idstatus'][$i]) {
                              case 3:
                                ?><span class="badge badge-pill badge-educodanger"><?= $records['status'][$i] ?></span><?php
                              break;

                              case 4:
                                ?><span class="badge badge-pill badge-educowarning"><?= $records['status'][$i] ?></span><?php
                              break;

                              case 5:
                                ?><span class="badge badge-pill badge-educo"><?= $records['status'][$i] ?></span><?php
                              break;
                            }
                            ?>
                          </td>
                          <td>
                            <button type="button" class="btn btn-link text-blue" onclick="getrecord(<?= $val ?>, 'info');" data-toggle="tooltip" data-bs-placement="top" title="Ver información">
                              <i class="fas fa-eye"></i>
                            </button>
                            <a href="<?= URL ?>?req=record_profile&val=<?= $val ?>" class="btn btn-link text-primary" data-toggle="tooltip" data-bs-placement="top" title="Abrir caso">
                              <i class="fas fa-folder-open"></i>
                            </a>
                          </td>
                        </tr>
                        <?php $n++; ?>
                        <?php endforeach ?>
                        <?php endif ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="info-record">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">Información de registro</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="card card-primary card-outline">
              <div class="card-body">
                <div class="form-row mt-3">
                  <div class="form-group col-12 col-md-4">
                    <label for="name">Nombre completo:</label>
                    <input type="text" class="form-control" id="info-name" disabled>
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="office">Oficina local:</label>
                    <input type="text" class="form-control" id="info-region" disabled>
                  </div>
                  <div class="form-group col-12 col-md-4">
                    <label for="email">Correo institucional:</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="info-email" disabled>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-12 col-md-7">
                    <label for="subject">Asunto:</label>
                    <input type="text" class="form-control" id="info-subject" disabled>
                  </div>
                  <div class="form-group col-12 col-md-5">
                    <label for="type">Tipo de caso:</label>
                    <input type="text" class="form-control" id="info-caso" disabled>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-12">
                    <label for="mnsj">Describe brevemente el caso:</label>
                    <textarea class="form-control" id="info-mnsj" wrap="soft" rows="5" disabled></textarea>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-black" data-dismiss="modal"><?= LANG['close'] ?></button>
              </div>
            </div>
          </div>
          <div class="modal-footer bg-primary">
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="dist/js/datatable.js"></script>
<script src="dist/js/records.js"></script>

<?php require_once APP."/views/master/footer_end.php"; ?>