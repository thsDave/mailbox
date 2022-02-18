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
            <h1><i class="fas fa-users"></i> <?= LANG['user_list'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item active"><?= LANG['user_list'] ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary card-outline">
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped <?= LANG['datable'] ?>">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th><?= LANG['name'] ?></th>
                      <th><?= LANG['email'] ?></th>
                      <th><?= LANG['position'] ?></th>
                      <th><?= LANG['permission'] ?></th>
                      <th><?= LANG['register_type'] ?></th>
                      <th><?= LANG['status'] ?></th>
                      <th><?= LANG['actions'] ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $users = $model->user_list(); ?>
                    <?php if ($users): ?>
                      <?php $no = 1; ?>
                      <?php foreach ($users['id'] as $i => $val): ?>
                        <?php if ($val != $_SESSION['mailbox_log']['id'] && $val != 1): ?>
                        <tr>
                          <td><?= $no ?></td>
                          <td><?= $users['name'][$i] ?></td>
                          <td><?= $users['email'][$i] ?></td>
                          <td><?= $users['position'][$i] ?></td>
                          <td><?= $users['level'][$i] ?></td>
                          <td><?= $users['registertype'][$i] ?></td>
                          <td><?= $users['status'][$i] ?></td>
                          <td>
                            <a href="<?= URL ?>?req=user_profile&val=<?= $val ?>" class="btn btn-sm btn-primary">
                              Ver perfil
                            </a>
                          </td>
                        </tr>
                        <?php $no++; ?>
                        <?php endif ?>
                      <?php endforeach ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

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

<?php require_once APP."/views/master/footer_end.php"; ?>
