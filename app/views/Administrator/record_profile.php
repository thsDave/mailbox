<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['mailbox_log']['level']}_nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><i class="fas fa-book"></i> Perfil de registro</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?request=home"><?= LANG['home'] ?></a></li>
              <li class="breadcrumb-item"><a href="<?= URL ?>?req=records">Casos</a></li>
              <li class="breadcrumb-item active">Perfil de registro</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Datos generales</h3>
            <div class='card-tools'>
              <button type='button' class='btn btn-tool' data-card-widget='collapse'>
                <i class='fas fa-minus'></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-secondary text-white elevation-1">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Fecha de registro</span>
                    <span class="info-box-number"><span id="profile-recorddate"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-info text-white elevation-1">
                    <i class="fas fa-portrait"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Nombre completo</span>
                    <span class="info-box-number"><span id="profile-name"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-blue text-white elevation-1">
                    <i class="fas fa-at"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Correo institucional</span>
                    <span class="info-box-number"><span id="profile-email"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-turquesa text-white elevation-1">
                    <i class="far fa-car-building"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Oficina</span>
                    <span class="info-box-number"><span id="profile-region"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-blue text-white elevation-1">
                    <i class="fas fa-edit"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Asunto del mensaje</span>
                    <span class="info-box-number"><span id="profile-subject"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-secondary text-white elevation-1">
                    <i class="fas fa-tag"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tipo de caso</span>
                    <span class="info-box-number"><span id="profile-casename"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-info text-white elevation-1">
                    <i class="fas fa-tag"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Tipo de registro</span>
                    <span class="info-box-number"><span id="profile-type"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon elevation-1" id="status-box-color">
                    <i class="fas fa-traffic-light"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Estado</span>
                    <span class="info-box-number"><span id="profile-status"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-black text-white elevation-1">
                    <i class="fas fa-envelope-open-text"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text"><strong>Mensaje</strong></span>
                    <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-message"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-6 col-md-3" id="open_case_name">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-blue text-white elevation-1">
                    <i class="fas fa-book-open"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Caso abierto por:</span>
                    <span class="info-box-number"><span id="profile-useropen"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3" id="close_case_name">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-secondary text-white elevation-1">
                    <i class="fas fa-book-spells"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Caso cerrado por:</span>
                    <span class="info-box-number"><span id="profile-userclose"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3" id="open_case_name">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-blue text-white elevation-1">
                    <i class="fas fa-book-open"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Fecha de apertura:</span>
                    <span class="info-box-number"><span id="profile-opendate"></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-3" id="close_case_name">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-secondary text-white elevation-1">
                    <i class="fas fa-book-spells"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text">Fecha de cierre:</span>
                    <span class="info-box-number"><span id="profile-closedate"></span></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <a href="<?= URL ?>?req=records" class="btn btn-link text-secondary">
                  <i class="fas fa-backward"></i> Volver
                </a>
                <button type="button" class="btn btn-link text-blue" id="open_record">
                  <i class="fas fa-folder-open"></i> Abrir caso
                </button>
                <button type="button" class="btn btn-link text-blue" id="add_entry" data-toggle="modal" data-target="#add_entry_modal">
                  <i class="fas fa-file-alt"></i> Agregar entrada
                </button>
                <button type="button" class="btn btn-link text-danger" id="close_record">
                  <i class="fas fa-folder"></i> Cerrar caso
                </button>
                <button type="button" class="btn btn-link text-danger" id="print_record">
                  <i class="fas fa-file-pdf"></i> Imprimir reporte
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Entradas registradas cuando el caso está abierto -->

        <div id="entries"></div>

        <!-- agregar entrada -->

        <div class="modal fade" id="add_entry_modal" tabindex="-1" role="dialog" aria-labelledby="AgregarEntrada" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><i class="fas fa-money-check-edit"></i> Agregar nueva entrada</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="new_entry">
                  <div class="form-group">
                    <label for="titulo"><strong>Título de la entrada:</strong></label>
                    <input type="text" class="form-control" name="title" id="titulo" placeholder="Título" autocomplete="off" required>
                  </div>
                  <div class="form-group">
                    <label for="descripcion"><strong>Descripción:</strong></label>
                    <textarea class="form-control" id="descripcion" wrap="soft" name="desc" rows="5" placeholder="Cantidad de caracteres permitidos: 1,000" maxlength="10000" required></textarea>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-educo">
                      <i class="fas fa-check"></i> Ingresar entrada
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                      <i class="fas fa-times"></i> Cerrar
                    </button>
                  </div>
                </form>
              </div>
              <div class="modal-footer bg-primary"></div>
            </div>
          </div>
        </div>

        <!-- editar entrada -->

        <div class="modal fade" id="edit-entry-modal" tabindex="-1" role="dialog" aria-labelledby="EditarEntrada" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><i class="fas fa-money-check-edit"></i> Edición de entrada</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="edit-entry">
                  <div class="form-group">
                    <label for="entry-title"><strong>Título de la entrada:</strong></label>
                    <input type="text" class="form-control" name="title" id="entry-title" placeholder="Título" autocomplete="off" required>
                    <input type="hidden" name="identry" id="entry-id">
                  </div>
                  <div class="form-group">
                    <label for="entry-desc"><strong>Descripción:</strong></label>
                    <textarea class="form-control" id="entry-desc" wrap="soft" name="desc" rows="5" placeholder="Cantidad de caracteres permitidos: 1,000" maxlength="10000" required></textarea>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-blue">
                      <i class="fas fa-check"></i> Editar entrada
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">
                      <i class="fas fa-times"></i> Cerrar
                    </button>
                  </div>
                </form>
              </div>
              <div class="modal-footer bg-primary"></div>
            </div>
          </div>
        </div>

      </div>
    </section>

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/record_profile.js"></script>

<script>
  $('#print_record').click(()=>{
    window.open("<?= URL ?>?req=record_report&val=<?= $_SESSION['val'] ?>", "_self");
  });
</script>

<?php require_once APP."/views/master/footer_end.php"; ?>