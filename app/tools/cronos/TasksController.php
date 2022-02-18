<?php

// namespace Controllers;

// use Models\Model;

require 'Model.php';
require_once 'PHPMailer.php';

class TasksController extends Model
{
	public function autotasks($task)
	{
		$this->$task();
	}

	public function sendRecordMail()
	{
		$records = parent::pendingRecordMails();

		if ($records)
		{
			foreach ($records['id'] as $i => $id)
			{
				$html = '
				<!DOCTYPE html>
				<html lang="es">
				    <head>
				        <meta charset="utf-8">
				        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
				        <title>'.APP_NAME.'</title>
				    </head>
				    <body>
				        <div class="container-fluid">
				            <div class="row">
				                <div class="col-12">
				                    <div class="container">
				                        <div class="row">
				                            <div class="col-12">
				                                <h3>Gracias por realizar tu '.$records['casename'][$i].' en '.APP_NAME.'</h3>
				                            </div>
				                        </div>
				                        <div class="row mt-3">
				                            <div class="col-12">
				                                <p>
				                                   A continuación te presentamos la información de tu registro:
				                                </p>
				                                <p><strong>Nombre: </strong>'.$records['name'][$i].'<p>
				                                <p><strong>Oficina local: </strong>'.$records['region'][$i].'</p>
				                                <p><strong>Asunto: </strong>'.$records['subject'][$i].'</p>
				                                <p><strong>Descripción del caso: </strong>'.$records['message'][$i].'</p>
				                            </div>
				                        </div>
				                        <div class="row mt-3">
				                        	<div class="col-12">
				                        		<hr />
				                        	</div>
				                        </div>
				                        <div class="row mt-3">
											<div class="col-12">
												<p><strong>Si tu no has realizado este registro:</strong></p>
												<p>
													Es posible que hayan intentado utilizar tu cuenta de correo. Haz clic en el siguiente enlace para
													solicitar la eliminación del registro de nuestro sistema.
												</p>
												<p>
													<a href="mailto:'.SUPPORT_MAIL.'?Subject=Eliminar%20'.$records['casename'][$i].'%20en%20buzón%20educo">Solicitar eliminación de registro</a>
												</p>
												<p>
													Gracias por confiar en nosotros.
												</p>
												<p>
													Atentamente:<br>
													<strong>Administradores de '.APP_NAME.' El Salvador</strong>
												</p>
											</div>
										</div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </body>
				</html>
				';

				if ($this->sendMail($records['email'][$i], 'Tu registro en buzón educo', $html))
				{
					if (parent::updt_record_sndmail($id))
						parent::savelog(5, "Registro de {$records['casename'][$i]} enviado a {$records['email'][$i]}, sendmail actualizado.");
					else
						parent::savelog(6, "Registro de {$records['casename'][$i]} enviado a {$records['email'][$i]}, sendmail actualizado.");
				}
				else
				{
					parent::savelog(6, "El registro de {$records['casename'][$i]} no fue enviado a {$records['email'][$i]}, sendmail desactualizado.");
				}
			}
		}
	}

	public function sendRegisterMail()
	{
		$mails_pendientes = parent::pendingRegisterMails();

		if ($mails_pendientes)
		{
			foreach ($mails_pendientes['id'] as $i => $id)
			{
				$token = $this->getKey(50);

				if (parent::setResetToken($mails_pendientes['email'][$i], $token))
				{
					$html = '
					<!DOCTYPE html>
					<html lang="es-SV">
						<head>
							<meta charset="utf-8">
							<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
							<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
							<title>'.APP_NAME.'</title>
						</head>
						<body>
							<div class="container-fluid">
								<div class="row mt-3">
									<div class="col-3"></div>
									<div class="col-6 border border-dark">
										<div class="container">
											<div class="row mt-3">
												<div class="col-12 text-center">
													<h3 class="display-4">Confirmación de registro</h3>
												</div>
											</div>
											<div class="row">
												<div class="col-12 text-center">
													<p>Hola '.$mails_pendientes['name'][$i].', te damos la bienvenida a '.APP_NAME.'.<p>
													<p>Para finalizar tu registro haz clic sobre el siguiente enlace:</p>
												</div>
											</div>
											<div class="row">
												<div class="col-12 text-center">
													<a href="'.URL.'?action=reset&value='.$token.'" class="btn btn-success" target="_blank">Confirmar correo electrónico</a>
												</div>
											</div>
											<div class="row mt-3">
												<div class="col-12 text-center">
													<p><strong>Si no has sido tú:</strong></p>
													<p>
														Es posible que hayan intentado utilizar tu cuenta de correo. Deberías tomar ciertas medidas para asegurarte de que tu cuenta no ha sido vulnerada. Haz clic en el siguiente botón para eliminar la solicitud de registro de nuestro sistema.
													</p>
													<p>
														<a href="'.URL.'?action=delRegister&value='.$token.'" class="btn btn-danger" target="_blank">Eliminar registro</a>
													</p>
													<p>
														Gracias por confiar en nosotros.
													</p>
													<p>
														Atentamente:<br>
														<strong>'.APP_NAME.'</strong>
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="col-3"></div>
								</div>
							</div>
						</body>
					</html>
					';

					if ($this->sendMail($mails_pendientes['email'][$i], 'Confirmación de registro', $html))
					{
						if (parent::mails_sent($id, $token))
							parent::savelog(5, "Confirmación de registro enviado a {$mails_pendientes['email'][$i]}, mailRegister actualizado.");
						else
							parent::savelog(6, "Confirmación de registro enviado a {$mails_pendientes['email'][$i]}, mailRegister desactualizado.");
					}
					else
					{
						parent::savelog(6, "Confirmación de registro no enviado a {$mails_pendientes['email'][$i]}, mailRegister desactualizado.");
					}
				}
				else
				{
					parent::savelog(6, "Confirmación de registro no enviado a {$mails_pendientes['email'][$i]}, token y mailRegister desactualizados.");
				}
			}
		}
	}

	public function sendSupportMail()
	{
		$supports = parent::pendingSupportMails();

		if ($supports)
		{
			foreach ($supports['idsupport'] as $i => $id)
			{
				$html = '
				<!DOCTYPE html>
				<html lang="es">
				    <head>
				        <meta charset="utf-8">
				        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
				        <title>'.APP_NAME.'</title>
				    </head>
				    <body>
				        <div class="container-fluid">
				            <div class="row">
				                <div class="col-12">
				                    <div class="container">
				                        <div class="row">
				                            <div class="col-12">
				                                <h3>Has recibido una solicitud de soporte de '.APP_NAME.'</h3>
				                            </div>
				                        </div>
				                        <div class="row mt-3">
				                            <div class="col-12">
				                                <p>
				                                   A continuación te presentamos los datos del usuario:
				                                </p>
				                                <p><strong>Datos del usuario: </strong>'.$supports['name'][$i].' | '.$supports['email'][$i].'<p>
				                                <p><strong>Asunto: </strong>'.$supports['subject'][$i].'</p>
				                                <p><strong>Mensaje: </strong>'.$supports['mssg'][$i].'</p>
				                                <p>
				                                    Atentamente: <strong>'.APP_NAME.'</strong>
				                                </p>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </body>
				</html>
				';

				if ($this->sendMail(SUPPORT_MAIL, 'Confirmación de registro', $html))
				{
					if (parent::updatesupportreq($id))
						parent::savelog(5, "Solicitud de soporte por {$supports['email'][$i]} enviada.");
					else
						parent::savelog(6, "No se pudo actualizar el registro de envío en tbl_supports... Solicitud de soporte por {$supports['email'][$i]} enviada.");
				}
				else
				{
					parent::savelog(6, "No se pudo enviar la solicitud de soporte hecha por {$supports['email'][$i]}.");
				}
			}
		}
	}

	public function sendForgetMail()
	{
		$mails_pendientes = parent::pendingForgetMails();

		if ($mails_pendientes)
		{
			foreach ($mails_pendientes['id'] as $i => $id)
			{
				$token = $this->getKey(50);

				if (parent::setResetToken($mails_pendientes['email'][$i], $token))
				{
					$html = '
					<!DOCTYPE html>
					<html lang="es-SV">
						<head>
							<meta charset="utf-8">
							<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
							<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
							<title>'.APP_NAME.'</title>
						</head>
						<body>
							<div class="container-fluid">
								<div class="row mt-3">
									<div class="col-3"></div>
									<div class="col-6 border border-dark">
										<div class="container">
											<div class="row mt-2">
					 							<div class="col-12 text-center">
													<img src="'.URL.'dist/img/logo-mail.png">
												</div>
											</div>
											<div class="row mt-2">
												<div class="col-12 text-center">
													<h3 class="display-4">Restablecer contraseña</h3>
												</div>
											</div>
											<div class="row">
												<div class="col-12 text-center">
													<p>Recibimos una solicitud para restablecer tu contraseña, si fuiste tú, haz clic sobre el siguiente enlace:</p>
												</div>
											</div>
											<div class="row">
												<div class="col-12 text-center">
													<a href="'.URL.'?action=reset&value='.$token.'" class="btn btn-primary" target="_blank">RESTABLECER CONTRASEÑA</a>
												</div>
											</div>
											<div class="row mt-3">
												<div class="col-12 text-center">
													<p>
														Si no quieres restablecer tu contraseña, ignora este mensaje y continua ingresando con tu contraseña actual.
													</p>
													<p>
														Gracias por confiar en nosotros.
													</p>
													<p>
														Atentamente:<br>
														<strong>'.APP_NAME.'</strong>
													</p>
												</div>
											</div>
										</div>
									</div>
									<div class="col-3"></div>
								</div>
							</div>
						</body>
					</html>
					';

					if ($this->sendMail($mails_pendientes['email'][$i], 'Restablecer contraseña', $html))
					{
						if (parent::mails_sent($id, $token))
							parent::savelog(5, "Restablecimiento de contraseña enviado a {$mails_pendientes['email'][$i]}, forgetpass actualizado.");
						else
							parent::savelog(6, "Restablecimiento de contraseña enviado a {$mails_pendientes['email'][$i]}, forgetpass desactualizado.");
					}
					else
					{
						parent::savelog(6, "Restablecimiento de contraseña no enviado a {$mails_pendientes['email'][$i]}, forgetpass desactualizado.");
					}
				}
				else
				{
					parent::savelog(6, "Restablecimiento de contraseña no enviado a {$mails_pendientes['email'][$i]}, token y forgetpass desactualizados.");
				}
			}
		}
	}

	private function sendMail($email, $asunto, $html)
	{
		$mensaje = $html;
		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = MAIL_SMTP_SECURE;
		$mail->Host = MAIL_HOST;
		$mail->Port = MAIL_PORT;
		$mail->Username = MAIL_USERNAME;
		$mail->Password = MAIL_PASSWORD;
		$mail->CharSet = MAIL_ENCRYPTION;
		$mail->From = MAIL_FROM_ADDRESS;
		$mail->FromName = MAIL_FROM_NAME;
		$mail->Subject = $asunto;
		$mail->addAddress($email);
		$mail->MsgHTML($mensaje);

		if($mail->Send()){
			return true;
		}else{
			return false;
		}
	}

	private function getKey($length)
	{
	    $cadena = "ABCDFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	    $longitudCadena = strlen($cadena);
	    $pass = "";
	    for($i=1 ; $i<=$length ; $i++){
	        $pos=rand(0,$longitudCadena-1);
	        $pass .= substr($cadena,$pos,1);
	    }
	    return $pass;
	}
}