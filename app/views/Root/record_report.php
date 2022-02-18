<?php require_once APP."/views/master/header.php"; ?>

<?php require_once APP."/views/master/{$_SESSION['mailbox_log']['level']}_nav.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #fff;">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-4 mt-3">
          <div class="col-8">
            <h1 class="display-4">Buzón Educo El Salvador</h1>
          </div>
          <div class="col-4">
            <img src="<?= URL ?>dist/img/logo.png" class="float-right" width="120" height="83">
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-12">
            <h2> Perfil de registro</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Fecha de registro</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-recorddate"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Nombre completo</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-name"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Correo institucional</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-email"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Oficina</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-region"></span></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Asunto del mensaje</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-subject"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Tipo de caso</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-casename"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Tipo de registro</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-type"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Estado</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-status"></span></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Mensaje</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-message"></span></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12 col-sm-6 col-md-3" id="open_case_name">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Caso abierto por:</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-useropen"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3" id="close_case_name">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Caso cerrado por:</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-userclose"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3" id="open_case_name">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Fecha de apertura:</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-opendate"></span></span>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-3" id="close_case_name">
            <div class="info-box mb-3">
              <div class="info-box-content">
                <span class="info-box-text"><strong>Fecha de cierre:</strong></span>
                <span class="info-box-number" style="font-weight: 400 !important;"><span id="profile-closedate"></span></span>
              </div>
            </div>
          </div>
        </div>

        <div class="row mb-4">
          <div class="col-12">
            <h2>Detalle de entradas</h2>
          </div>
        </div>

        <!-- Entradas registradas cuando el caso está abierto -->

        <?= $objHome->entry_records($_SESSION['val'], 'report') ?>

      </div>
    </section>

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php require_once APP."/views/master/footer_js.php"; ?>

<script src="dist/js/record-report.js"></script>

<script>
  window.print();
  setTimeout(function(){
    window.open("<?= URL ?>?req=record_profile&val=<?= $_SESSION['val'] ?>", "_self");
  },1000);
</script>

<?php require_once APP."/views/master/footer_end.php"; ?>