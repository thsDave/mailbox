<?php

require_once "../app/config/config.php";
require_once "../app/controllers/Controller.php";

/*
|--------------------------------------------------------------------------
| Login with Firebase
|--------------------------------------------------------------------------
|
| Login de usuarios con firebase
|
*/


if (isset($_POST['localogin']))
{
	if (isset($_POST['remember']))
		$res = $objController->login($_POST['user'], 'local', $_POST['pwd'], $_POST['remember']);
	else
		$res = $objController->login($_POST['user'], 'local', $_POST['pwd']);

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Login with Firebase
|--------------------------------------------------------------------------
|
| Login de usuarios con firebase
|
*/


if (isset($_POST['firelogin'])) {
	echo json_encode($objController->login($_POST['email'], 'social'));
}


/*
|--------------------------------------------------------------------------
| Register with Firebase
|--------------------------------------------------------------------------
|
| Registro de usuarios con firebase
|
*/

if (isset($_POST['fireregister']))
{
	$name = (isset($_POST['name'])) ? $_POST['name'] : 'Name empty';
	$email = (isset($_POST['email'])) ? $_POST['email'] : false;

	echo json_encode($objController->newregister($name, $email, '', 1, 1, 3, 'social'));
}

/*
|--------------------------------------------------------------------------
| Registro de usuario
|--------------------------------------------------------------------------
|
| Comprobaciones de campos en registro local de usuario
|
*/

if (isset($_POST['newregister']))
{
	$name = (isset($_POST['name']) && !empty($_POST['name'])) ? $_POST['name'] : false;
	$position = (isset($_POST['position']) && !empty($_POST['position'])) ? $_POST['position'] : 'Empty';
	$region = (isset($_POST['region']) && !empty($_POST['region'])) ? $_POST['region'] : 'Empty';
	$language = (isset($_POST['language']) && !empty($_POST['language'])) ? $_POST['language'] : 'Empty';
	$level = (isset($_POST['level']) && !empty($_POST['level'])) ? $_POST['level'] : 'Empty';
	$email = (isset($_POST['email']) && !empty($_POST['email'])) ? $_POST['email'] : false;
	$email2 = (isset($_POST['email2']) && !empty($_POST['email2'])) ? $_POST['email2'] : false;

	if ($email == $email2) {
		if ($name && $position && $region && $language && $email && $email2) {
			$res = $objController->newregister($name, $email, $position, $region, $language, $level);
		}else {
			$res = false;
		}
	}else {
		$res = false;
	}

	echo json_encode($res);
}

/*
|--------------------------------------------------------------------------
| Activación de restablecimiento de contraseña
|--------------------------------------------------------------------------
|
| Ingreso de nueva contraseña
|
*/

if (isset($_POST['forgot-email']))
{
	echo json_encode($objController->resetPass($_POST['forgot-email']));
}


/*
|--------------------------------------------------------------------------
| Restablecer contraseña de usuario
|--------------------------------------------------------------------------
|
| Ingreso de nueva contraseña
|
*/


if (isset($_POST['restorepwd']))
{
	if (strlen($_POST['pass1']) >= 8 && strlen($_POST['pass2']) >= 8) {
		if ($_POST['pass1'] == $_POST['pass2']) {
			echo json_encode($objController->resetPassword($_POST['pass1']));
		}else {
			echo json_encode(false);
		}
	}else {
		echo json_encode(false);
	}
}


// ************************************************************************************
// ************************************************************************************
// ************************************************************************************


/*
|--------------------------------------------------------------------------
| Formulario: buzon de quejas completo
|--------------------------------------------------------------------------
|
| Ingreso de nuevo caso en el buzon de quejas y sugerencias
|
*/


if (isset($_POST['qcompleteform']))
{
	$name = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['name'])) : null;
	$email = (isset($_POST['email'])) ? preg_replace('([^a-z0-9@-_.])', '', trim($_POST['email'])) : null;
	$office = (isset($_POST['office'])) ? preg_replace('([^0-9])', '', trim($_POST['office'])) : null;
	$subject = (isset($_POST['subject'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['subject'])) : null;
	$type = (isset($_POST['type'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['type'])) : null;
	$mnsj = (isset($_POST['mnsj'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['mnsj'])) : null;
	$date = (isset($_POST['date'])) ? preg_replace('([^0-9-])', '', trim($_POST['date'])) : null;

	$email = ((explode('@', $email)[1]) == 'educo.org') ? $email : null;

	$array = [$name, $office, $email, $subject, $type, $mnsj, $date, 1, 0];

	$centinel = true;

	foreach ($array as $val) { if (is_null($val)) { $centinel = false; break; } }

	if ($centinel)
		$res = $model->new_record($array);
	else
		$res = false;

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Formulario: buzon de quejas anonimo
|--------------------------------------------------------------------------
|
| Ingreso de nuevo caso en el buzon de quejas y sugerencias
|
*/


if (isset($_POST['qanonimoform']))
{
	$name = (isset($_POST['name'])) ? 'N/A' : null;
	$email = (isset($_POST['email'])) ? 'N/A' : null;
	$office = (isset($_POST['office'])) ? preg_replace('([^0-9])', '', trim($_POST['office'])) : null;
	$subject = (isset($_POST['subject'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['subject'])) : null;
	$type = (isset($_POST['type'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['type'])) : null;
	$mnsj = (isset($_POST['mnsj'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['mnsj'])) : null;
	$date = (isset($_POST['date'])) ? preg_replace('([^0-9-])', '', trim($_POST['date'])) : null;

	$array = [$name, $office, $email, $subject, $type, $mnsj, $date, 2, 1];

	$centinel = true;

	foreach ($array as $val) { if (is_null($val)) { $centinel = false; break; } }

	if ($centinel)
		$res = $model->new_record($array);
	else
		$res = false;

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Formulario: buzon de denuncias completo
|--------------------------------------------------------------------------
|
| Ingreso de nuevo caso en el buzon de denuncias
|
*/


if (isset($_POST['dcompleteform']))
{
	$name = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['name'])) : null;
	$email = (isset($_POST['email'])) ? preg_replace('([^a-z0-9@-_.])', '', trim($_POST['email'])) : null;
	$office = (isset($_POST['office'])) ? preg_replace('([^0-9])', '', trim($_POST['office'])) : null;
	$subject = (isset($_POST['subject'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['subject'])) : null;
	$type = (isset($_POST['type'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['type'])) : null;
	$mnsj = (isset($_POST['mnsj'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['mnsj'])) : null;
	$date = (isset($_POST['date'])) ? preg_replace('([^0-9-])', '', trim($_POST['date'])) : null;

	$email = ((explode('@', $email)[1]) == 'educo.org') ? $email : null;

	$array = [$name, $office, $email, $subject, $type, $mnsj, $date, 1, 0];

	$centinel = true;

	foreach ($array as $val) { if (is_null($val)) { $centinel = false; break; } }

	if ($centinel)
		$res = $model->new_record($array);
	else
		$res = false;

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Formulario: buzon de denuncias anonimo
|--------------------------------------------------------------------------
|
| Ingreso de nuevo caso en el buzon de denuncias
|
*/


if (isset($_POST['danonimoform']))
{
	$name = (isset($_POST['name'])) ? 'N/A' : null;
	$email = (isset($_POST['email'])) ? 'N/A' : null;
	$office = (isset($_POST['office'])) ? preg_replace('([^0-9])', '', trim($_POST['office'])) : null;
	$subject = (isset($_POST['subject'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['subject'])) : null;
	$type = (isset($_POST['type'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['type'])) : null;
	$mnsj = (isset($_POST['mnsj'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['mnsj'])) : null;
	$date = (isset($_POST['date'])) ? preg_replace('([^0-9-])', '', trim($_POST['date'])) : null;

	$array = [$name, $office, $email, $subject, $type, $mnsj, $date, 2, 1];

	$centinel = true;

	foreach ($array as $val) { if (is_null($val)) { $centinel = false; break; } }

	if ($centinel)
		$res = $model->new_record($array);
	else
		$res = false;

	echo json_encode($res);
}