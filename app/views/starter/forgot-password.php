<!DOCTYPE html>
<html lang="es-SV">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icon.ico">

  <title><?= APP_NAME ?> | Forgot Password</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">
  <style>
    body {
      background: transparent url("dist/img/index_background.png") no-repeat fixed 0px 0px / cover !important;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="dist/img/logo.png" class="h-75 w-75"><br>
    <a href="<?= URL ?>"><?= APP_NAME ?></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Escribe tu cuenta de correo<br>Te enviaremos una nueva contraseña.</p>

      <form id="forgot-form">
        <div class="input-group mb-3">
          <input type="email" name="forgot-email" id="mail" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-educo btn-block">Recuperar contraseña</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?= URL ?>?action=login">Login</a>
      </p>
    </div>
  </div>
</div>
<!-- /.login-box -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="plugins/sweetalert2/sweetalert2.min.js"></script> -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/forgot-pass.js" type="module"></script>

</body>
</html>
