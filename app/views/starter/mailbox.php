<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="dist/img/icono.ico">

  <title><?= APP_NAME ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="dist/css/thistyle.css">
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <div class="content-wrapper bgimg">
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <img src="dist/img/logo.png" alt="Educo Logo" class="brand-image w-25">
            <h1 class="m-0 text-dark"> Buzón Educo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= URL ?>?action=login"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row" id="init-btns">
                  <div class="col-12">
                    <div class="btn-group">
                      <button type="button" class="btn btn-educo"><i class="fas fa-envelope-open-text"></i> Buzón</button>
                      <button type="button" class="btn btn-educo dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="" id="qvc"><i class="fas fa-align-right"></i> Version completa</a>
                        <a class="dropdown-item" href="" id="qva"><i class="far fa-user-secret"></i> Verisón anónima</a>
                      </div>
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-educodanger"><i class="far fa-hand-point-right"></i> Denuncias</button>
                      <button type="button" class="btn btn-educodanger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="" id="dvc"><i class="fas fa-align-right"></i> Version completa</a>
                        <a class="dropdown-item" href="" id="dva"><i class="far fa-user-secret"></i> Verisón anónima</a>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ************************ -->
                <!-- Buzón de quejas completa -->
                <!-- ************************ -->

                <div class="row" id="qcomplete">
                  <div class="col-12">
                    <form id="qcompleteform">
                      <div class="form-row">
                        <div class="col-12">
                          <h4>Buzón de quejas, sugerencias y felicitaciones</h4>
                          <span class="badge badge-pill badge-educo"><i class="fas fa-align-right"></i> Versión completa</span>
                        </div>
                      </div>
                      <div class="form-row mt-3">
                        <div class="form-group col-12 col-md-4">
                          <label for="name">Nombre completo:</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="nombres y apellidos" autocomplete="off" required>
                        </div>
                        <div class="form-group col-12 col-md-4">
                          <label for="office">Oficina local:</label>
                          <select name="office" id="office" class="form-control" required>
                            <option value="1">Central San Salvador</option>
                            <option value="2">Región San Vicente</option>
                            <option value="3">Región San Miguel</option>
                          </select>
                        </div>
                        <div class="form-group col-12 col-md-4">
                          <label for="email">Correo institucional:</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ejemplo: isaac.ramos@educo.org" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-row" style="margin-top: -15px;">
                        <div class="form-group col-12">
                          <small id="emailHelp" class="form-text text-muted">Por seguridad la información de tu correo institucional será utilizada de manera confidencial, estarémos comunicandonos contigo más adelante.</small>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12 col-md-7">
                          <label for="subject">Asunto:</label>
                          <input type="text" class="form-control" id="subject" name="subject" aria-describedby="sbdescription" placeholder="Escribe el asunto de tu mensaje" autocomplete="off" required>
                          <small id="sbdescription" class="form-text text-muted">Escribe brevemente el asunto de tu queja, sugerencia o reconocimiento.</small>
                        </div>
                        <div class="form-group col-12 col-md-5">
                          <label for="type">Tipo de caso:</label>
                          <select name="type" id="type" class="form-control" required>
                            <option value="1">Queja</option>
                            <option value="2">Sugerencia</option>
                            <option value="3">Felicitaciones</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12">
                          <label for="mnsj">Describe brevemente el caso:</label>
                          <textarea class="form-control" id="mnsj" wrap="soft" name="mnsj" rows="5" placeholder="Cantidad de caracteres permitidos: 1,000" maxlength="10000" required></textarea>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-educo">
                        <i class="fas fa-edit"></i> Enviar Caso
                      </button>
                      <a class="btn btn-black float-right form-back" href="#">
                        <i class="fas fa-backward"></i> Volver
                      </a>
                    </form>
                  </div>
                </div>

                <!-- ************************ -->
                <!-- Buzón de quejas anonima -->
                <!-- ************************ -->

                <div class="row" id="qanonimo">
                  <div class="col-12">
                    <form id="qanonimoform">
                      <div class="form-row">
                        <div class="col-12">
                          <h4>Buzón de quejas, sugerencias y felicitaciones</h4>
                          <span class="badge badge-pill badge-black"><i class="far fa-user-secret"></i> Versión anónima</span>
                        </div>
                      </div>
                      <div class="form-row mt-3">
                        <div class="form-group col-12">
                          <label for="office">Oficina local:</label>
                          <select name="office" id="office" class="form-control" required>
                            <option value="1">Central San Salvador</option>
                            <option value="2">Región San Vicente</option>
                            <option value="3">Región San Miguel</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12 col-md-7">
                          <label for="subject">Asunto:</label>
                          <input type="text" class="form-control" id="subject" name="subject" aria-describedby="asuntoHelp" placeholder="Escribe el asunto de tu mensaje" autocomplete="off" required>
                          <small id="asuntoHelp" class="form-text text-muted">Escribe brevemente el asunto de tu Denuncia.</small>
                        </div>
                        <div class="form-group col-12 col-md-5">
                          <label for="type">Tipo de caso:</label>
                          <select name="type" id="type" class="form-control" required>
                            <option value="1">Queja</option>
                            <option value="2">Sugerencia</option>
                            <option value="3">Felicitaciones</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12">
                          <label for="mnsj">Describe brevemente tu caso:</label>
                          <textarea class="form-control" id="mnsj" wrap="soft" name="mnsj" rows="5" placeholder="Cantidad de caracteres permitidos: 1,000" maxlength="10000" required></textarea>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-educo">
                        <i class="fas fa-edit"></i> Enviar caso
                      </button>
                      <a class="btn btn-black float-right form-back" href="#">
                        <i class="fas fa-backward"></i> Volver
                      </a>
                    </form>
                  </div>
                </div>

                <!-- *************************** -->
                <!-- Buzón de denuncias completa -->
                <!-- *************************** -->

                <div class="row" id="dcomplete">
                  <div class="col-12">
                    <form id="dcompleteform">
                      <div class="form-row">
                        <div class="col-12">
                          <h4>Buzón de denuncias</h4>
                          <span class="badge badge-pill badge-educo"><i class="fas fa-align-right"></i> Versión completa</span>
                        </div>
                      </div>
                      <div class="form-row mt-3">
                        <div class="form-group col-12 col-md-4">
                          <label for="name">Nombre completo:</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="nombres y apellidos" autocomplete="off" required>
                        </div>
                        <div class="form-group col-12 col-md-4">
                          <label for="office">Oficina local:</label>
                          <select name="office" id="office" class="form-control" required>
                            <option value="1">Central San Salvador</option>
                            <option value="2">Región San Vicente</option>
                            <option value="3">Región San Miguel</option>
                          </select>
                        </div>
                        <div class="form-group col-12 col-md-4">
                          <label for="email">Correo institucional:</label>
                          <div class="input-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ejemplo: isaac.ramos@educo.org" autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-row" style="margin-top: -15px;">
                        <div class="form-group col-12">
                          <small id="emailHelp" class="form-text text-muted">Por seguridad la información de tu correo institucional será utilizada de manera confidencial, estarémos comunicandonos contigo más adelante.</small>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12 col-md-7">
                          <label for="subject">Asunto:</label>
                          <input type="text" class="form-control" id="subject" name="subject" aria-describedby="sbdescription" placeholder="Escribe el asunto de tu mensaje" autocomplete="off" required>
                          <small id="sbdescription" class="form-text text-muted">Escribe brevemente el asunto de tu denuncia.</small>
                        </div>
                        <div class="form-group col-12 col-md-5">
                          <label for="type">Tipo de caso:</label>
                          <select name="type" id="type" class="form-control" required>
                            <option value="4">Política de buen trato</option>
                            <option value="5">Política de Abuso, acoso y explotación sexual</option>
                            <option value="6">Código de conducta</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12">
                          <label for="mnsj">Describe brevemente el caso:</label>
                          <textarea class="form-control" id="mnsj" wrap="soft" name="mnsj" rows="5" placeholder="Cantidad de caracteres permitidos: 1,000" maxlength="10000" required></textarea>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-educodanger">
                        <i class="fas fa-edit"></i> Enviar denuncia
                      </button>
                      <a class="btn btn-black float-right form-back" href="#">
                        <i class="fas fa-backward"></i> Volver
                      </a>
                    </form>
                  </div>
                </div>

                <!-- ************************ -->
                <!-- Buzón de quejas anonima -->
                <!-- ************************ -->

                <div class="row" id="danonimo">
                  <div class="col-12">
                    <form id="danonimoform">
                      <div class="form-row">
                        <div class="col-12">
                          <h4>Buzón de denuncias</h4>
                          <span class="badge badge-pill badge-black"><i class="far fa-user-secret"></i> Versión anónima</span>
                        </div>
                      </div>
                      <div class="form-row mt-3">
                        <div class="form-group col-12">
                          <label for="office">Oficina local:</label>
                          <select name="office" id="office" class="form-control" required>
                            <option value="1">Central San Salvador</option>
                            <option value="2">Región San Vicente</option>
                            <option value="3">Región San Miguel</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12 col-md-7">
                          <label for="subject">Asunto:</label>
                          <input type="text" class="form-control" id="subject" name="subject" aria-describedby="asuntoHelp" placeholder="Escribe el asunto de tu mensaje" autocomplete="off" required>
                          <small id="asuntoHelp" class="form-text text-muted">Escribe brevemente el asunto de tu Denuncia.</small>
                        </div>
                        <div class="form-group col-12 col-md-5">
                          <label for="type">Tipo de caso:</label>
                          <select name="type" id="type" class="form-control" required>
                            <option value="4">Política de buen trato</option>
                            <option value="5">Política de Abuso, acoso y explotación sexual</option>
                            <option value="6">Código de conducta</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-12">
                          <label for="mnsj">Describe brevemente tu caso:</label>
                          <textarea class="form-control" id="mnsj" wrap="soft" name="mnsj" rows="5" placeholder="Cantidad de caracteres permitidos: 1,000" maxlength="10000" required></textarea>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-educodanger">
                        <i class="fas fa-edit"></i> Enviar denuncia
                      </button>
                      <a class="btn btn-black float-right form-back" href="#">
                        <i class="fas fa-backward"></i> Volver
                      </a>
                    </form>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="plugins/sweetalert2/sweetalert2.min.js"></script> -->
<script src="dist/js/mailbox.js"></script>
</body>
</html>