<?php

require_once "../app/config/config.php";
require_once "../app/controllers/HomeController.php";
require_once "../app/controllers/{$_SESSION['mailbox_log']['level']}Controller.php";
require_once '../app/config/languages/'.$_SESSION['lang']['lancode'].'.php';


/*
|--------------------------------------------------------------------------
| Pestañas de perfil personal
|--------------------------------------------------------------------------
|
| Recordatrorio de pestaña seleccionada
|
*/

if (isset($_POST['usrprofileselecttab'])) {
	$_SESSION['tab_selected'] = $_POST['usrprofileselecttab'];
	echo $_POST['usrprofileselecttab'];
}

if (isset($_POST['selecttab'])) {
	$res = (isset($_SESSION['tab_selected'])) ? $_SESSION['tab_selected'] : 'info';
	echo $res;
}


/*
|--------------------------------------------------------------------------
| Actualición de perfil de usuario
|--------------------------------------------------------------------------
|
| Edición de perfil de usuario
|
*/

if (isset($_POST['updtinfousr']))
{
	$name = (isset($_POST['name'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['name'])) : null;
	$position = (isset($_POST['position'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['position'])) : null;
	$region = (isset($_POST['region'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['region'])) : null;
	$level = (isset($_POST['level'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['level'])) : null;
	$status = (isset($_POST['status'])) ? preg_replace('([^A-Za-zÁ-ź0-9 ])', '', trim($_POST['status'])) : null;
	$idlang = (isset($_POST['language'])) ? preg_replace('([^0-9 ])', '', trim($_POST['language'])) : null;

	$res = $objHome->updtusr($name, $position, $level, $status, $idlang, $region);

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Update PicProfile
|--------------------------------------------------------------------------
|
| Actualización de imagen de perfil
|
*/


if (isset($_POST['picprofile']))
	echo $model->update_pic($_POST['id']);


/*
|--------------------------------------------------------------------------
| Actualización de contraseña
|--------------------------------------------------------------------------
|
| Comprobacion y actualización de contraseña
|
*/


if (isset($_POST['updtpwd']))
{
	$iduser = (isset($_SESSION['val'])) ? $_SESSION['val'] : $_SESSION['mailbox_log']['id'];

	if (isset($_POST['currentPass']))
		$res = $objHome->updatePass($_POST['currentPass'], $_POST['pass1'], $_POST['pass2'], $iduser);
	else
		$res = $objHome->updatePass(null, $_POST['pass1'], $_POST['pass2'], $iduser);

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| Validación de eliminación
|--------------------------------------------------------------------------
|
| Comprobaciones de campos en registro local de usuario
|
*/


if (isset($_POST['valphrase']))
{
	$frase = $sudo_c->userDeletePhrase($_SESSION['val']);
	echo (trim($_POST['phrase']) == $frase) ? json_encode(true) : json_encode(false);
}

if (isset($_POST['deluser'])) { echo json_encode($sudo_c->userdel(trim($_POST['phrase']), $_SESSION['val'])); }


/*
|--------------------------------------------------------------------------
| Comentarios del sistema
|--------------------------------------------------------------------------
|
| Control de comentarios al sistema
|
*/


if (isset($_POST['newComment']))
{
	$model->insert_comment(preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['comment'])), $_SESSION['mailbox_log']['id']);

	load_view();
}

if (isset($_GET['delComment']))
{
	$model->del_comment(preg_replace('([^A-Za-z0-9- ])', '', trim($_GET['delComment'])), $_SESSION['mailbox_log']['id']);

	load_view();
}


/*
|--------------------------------------------------------------------------
| Soporte técnico (Cliente)
|--------------------------------------------------------------------------
|
| Obtener Solicitud de soporte técnico
|
*/


if (isset($_POST['newreqsupport'])) {
	$subject = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['subject']));
	$mssg = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['mssg']));
	if (!empty($subject) && !empty($mssg)) {
		echo json_encode($model->new_support_request($subject, $mssg, $_SESSION['mailbox_log']['id']));
	}else {
		echo json_encode(false);
	}
}


/*
|--------------------------------------------------------------------------
| Soporte técnico (Sudo)
|--------------------------------------------------------------------------
|
| Obtener Solicitud de soporte técnico
|
*/


if (isset($_POST['getsupportreq'])) {
	$info = $sudo_m->getsupportreq($_POST['id']);
	echo json_encode($info);
}


if (isset($_POST['savesupportres'])) {
	$id = $_POST['id'];
	$response = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['response']));

	unset($_SESSION['suport']);

	if (!empty($response))
		echo json_encode($sudo_m->savesupportres($id, $response));
	else
		echo json_encode(false);
}


/*
|--------------------------------------------------------------------------
| Personalización de reportes
|--------------------------------------------------------------------------
|
| Manejo de campos y presentación de tablas
|
|--------------------------------------------------------------------------
| Para usuarios
|--------------------------------------------------------------------------
*/

if (isset($_POST['custom_table_users']))
{
	if (!isset($_SESSION['custom_users_fields']))
		$table = "<div class='alert alert-dismissible alert-dark'>".LANG['no_fields_selected']."</div>";
	else
		$table = $objHome->show_table_report('custom_users_fields', $sudo_m->datareport('users'));

	echo $table;
}

if (isset($_POST['add_field_users']))
{
	$_SESSION['custom_users_fields'][] = $_POST['add_field_users'];

	echo json_encode(true);
}

if (isset($_POST['remove_field_users']))
{
	$key = array_search($_POST['remove_field_users'], $_SESSION['custom_users_fields']);

	if ($key === 0 || $key) {
		unset($_SESSION['custom_users_fields'][$key]);
		echo json_encode(true);
	}else {
		echo json_encode(false);
	}
}

if (isset($_POST['print_users']))
{
	if (isset($_SESSION['custom_users_fields']) && count($_SESSION['custom_users_fields']) > 0)
		echo true;
	else
		echo false;
}

/*
|--------------------------------------------------------------------------
| Personalización de reportes
|--------------------------------------------------------------------------
|
| Manejo de campos y presentación de tablas
|
|--------------------------------------------------------------------------
| Para soportes
|--------------------------------------------------------------------------
*/

if (isset($_POST['custom_table_supports']))
{
	if (!isset($_SESSION['custom_supports_fields']))
		$table = "<div class='alert alert-dismissible alert-dark'>".LANG['no_fields_selected']."</div>";
	else
		$table = $objHome->show_table_report('custom_supports_fields', $sudo_m->datareport('supports'));

	echo $table;
}

if (isset($_POST['add_field_supports']))
{
	$_SESSION['custom_supports_fields'][] = $_POST['add_field_supports'];

	echo json_encode(true);
}

if (isset($_POST['remove_field_supports']))
{
	$key = array_search($_POST['remove_field_supports'], $_SESSION['custom_supports_fields']);

	if ($key === 0 || $key) {
		unset($_SESSION['custom_supports_fields'][$key]);
		echo json_encode(true);
	}else {
		echo json_encode(false);
	}
}

if (isset($_POST['print_supports']))
{
	if (isset($_SESSION['custom_supports_fields']) && count($_SESSION['custom_supports_fields']) > 0)
		echo true;
	else
		echo false;
}

// ************************************************************************************
// ************************************************************************************
// ************************************************************************************

/*
|--------------------------------------------------------------------------
| Dashboard chart
|--------------------------------------------------------------------------
|
| Presentación de gráfica en dashboard
|
*/

if (isset($_POST['get_dash_chart']))
{
	$date = preg_replace('([^0-9-])', '', trim($_POST['date']));

	$chart = $model->charts('dashboard', $date);

	$totals = $objHome->dash_totals($date);

	$res = ['chart' => $chart, 'totals' => $totals];

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| info record
|--------------------------------------------------------------------------
|
| informacion completa de un registro
|
*/

if (isset($_POST['get_info_record']))
{
	$id = (isset($_POST['id'])) ? $_POST['id'] : $_SESSION['val'];

	$id = preg_replace('([^0-9])', '', trim($id));

	echo json_encode($model->info_record($id));
}


/*
|--------------------------------------------------------------------------
| open record
|--------------------------------------------------------------------------
|
| solicitud para abrir un caso
|
*/

if (isset($_POST['open_record']))
{
	$id = preg_replace('([^0-9])', '', trim($_SESSION['val']));

	$date = preg_replace('([^0-9-])', '', trim($_POST['date']));

	echo json_encode($model->open_record($id, $_SESSION['mailbox_log']['id'], $date));
}


/*
|--------------------------------------------------------------------------
| close record
|--------------------------------------------------------------------------
|
| solicitud para cerrar un caso
|
*/

if (isset($_POST['close_record']))
{
	$id = preg_replace('([^0-9])', '', trim($_SESSION['val']));

	$date = preg_replace('([^0-9-])', '', trim($_POST['date']));

	$entries = $model->entries_list($id);

	if ($entries)
	{
		$close = $model->close_record($id, $_SESSION['mailbox_log']['id'], $date);

		if ($close)
			$res = ['mnsj' => 'El caso se ha cerrado exitosamente!', 'icon' => 'success'];
		else
			$res = ['mnsj' => 'El caso no pudo ser cerrado, intenta nuevamente.', 'icon' => 'error'];
	}else {
		$res = ['mnsj' => 'El caso debe tener al menos una entrada de registro!', 'icon' => 'error'];
	}

	echo json_encode($res);
}


/*
|--------------------------------------------------------------------------
| get entries
|--------------------------------------------------------------------------
|
| solicitud para obtener información de entradas
|
*/

if (isset($_POST['get_entries']))
{
	$id = preg_replace('([^0-9])', '', trim($_SESSION['val']));

	echo json_encode($objHome->entry_records($id, 'profile'));
}


/*
|--------------------------------------------------------------------------
| get entries for report
|--------------------------------------------------------------------------
|
| solicitud para obtener información de entradas
|
*/

if (isset($_POST['get_entries_report']))
{
	$id = preg_replace('([^0-9])', '', trim($_SESSION['val']));

	echo json_encode($objHome->entry_records($id, 'report'));
}


/*
|--------------------------------------------------------------------------
| get entry
|--------------------------------------------------------------------------
|
| solicitud para obtener información de una entrada
|
*/

if (isset($_POST['get_entry']))
{
	$id = preg_replace('([^0-9])', '', trim($_POST['id']));

	echo json_encode($model->entry_info($id));
}


/*
|--------------------------------------------------------------------------
| new entry
|--------------------------------------------------------------------------
|
| ingresa las entradas de un caso específico
|
*/

if (isset($_POST['new_entry']))
{
	$title = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['title']));
	$desc = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['desc']));

	$idrecord = preg_replace('([^0-9])', '', trim($_SESSION['val']));
	$date = preg_replace('([^0-9-])', '', trim($_POST['date']));

	$data = [
		'title' => $title,
		'desc' => $desc,
		'idrecord' => $idrecord,
		'date' => $date,
		'iduser' => $_SESSION['mailbox_log']['id']
	];

	echo json_encode($model->new_entry($data));
}


/*
|--------------------------------------------------------------------------
| edit entry
|--------------------------------------------------------------------------
|
| edita las entradas de un caso específico
|
*/

if (isset($_POST['edit_entry']))
{
	$title = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['title']));
	$desc = preg_replace('([^A-Za-zÁ-ź0-9-.¡!:\) ])', '', trim($_POST['desc']));

	$identry = preg_replace('([^0-9])', '', trim($_POST['identry']));
	$date = preg_replace('([^0-9-])', '', trim($_POST['date']));

	$data = [
		'title' => $title,
		'desc' => $desc,
		'iduser' => $_SESSION['mailbox_log']['id'],
		'date' => $date,
		'identry' => $identry
	];

	$_SESSION['qq'] = $data;

	echo json_encode($model->update_entry($data));
}


/*
|--------------------------------------------------------------------------
| del entry
|--------------------------------------------------------------------------
|
| Eliminar una entrada
|
*/

if (isset($_POST['del_entry']))
{
	$id = preg_replace('([^0-9])', '', trim($_POST['id']));

	echo json_encode($model->delete_entry($id));
}