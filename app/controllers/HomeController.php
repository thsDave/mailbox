<?php

require_once 'Controller.php';

class HomeController extends Controller
{
	public function reqviews($req, $val = null)
	{
		$_SESSION['view'] = $req;

		switch ($req)
		{
			case 'home':
				unset($_SESSION['view']);
			break;

			case 'logout':
				parent::outputs($_SESSION['mailbox_log']['id']);
				session_destroy();
			break;

			default:
				if (is_null($val))
					unset($_SESSION['val']);
				else
					$_SESSION['val'] = $val;
			break;
		}

		load_view();
	}

	private function get_thumbnail_binary($pictures)
	{
		$binarios = [];

		foreach ($pictures['tempName'] as $key => $value)
		{
			require_once "tools/Resize/Resize.php";

			/******* Extraemos el valor binario de la imagen original *******/

	        $fp = fopen($pictures['tempName'][$key], "r");
	        $picture_binary = addslashes(fread($fp, $pictures['fileSize'][$key]));
	        fclose($fp);

	        /******* Guardamos la img temporalmente *******/

	        $folder = "picTemp/";

	        if (!is_dir($folder)) { mkdir($folder, 0777, true); }

            $extension = explode('.', $pictures['fileName'][$key]);
            $pictures['fileName'][$key] = $this->getKey(5).".".$extension[1];

	        $destino = $folder.$pictures['fileName'][$key];
	        opendir($folder);
	        move_uploaded_file($pictures['tempName'][$key], $destino);

	        /******* Creamos el thumbnail de la img *******/

	        $resizeObj = new Resize("picTemp/".$pictures['fileName'][$key]);
	        $resizeObj -> resizeImage(128, 128, 'crop');
	        $location = 'picTemp/thumbnail_'.$this->getKey(5).'.jpg';
	        $resizeObj -> saveImage($location, 100);
	        $thumbnail_binary = addslashes(file_get_contents($location));

	        /******* Eliminamos las imagenes y el directorio temporal *******/

	        unlink($destino);
	        unlink($location);
	        rmdir($folder);

	        $binarios['picture_binary'][] = $picture_binary;
	        $binarios['picture_type'][] = $pictures['fileType'][$key];
	        $binarios['thumbnail_binary'][] = $thumbnail_binary;
		}

		return $binarios;
	}

	private function get_binary($pictures)
	{
		$binarios = [];

		foreach ($pictures['tempName'] as $key => $value)
		{
			/******* Extraemos el valor binario de la imagen original *******/

	        $fp = fopen($pictures['tempName'][$key], "r");
	        $picture_binary = addslashes(fread($fp, $pictures['fileSize'][$key]));
	        fclose($fp);

	        /******* Guardamos el binario y su tipo *******/

	        $binarios['picture_binary'][] = $picture_binary;
	        $binarios['picture_type'][] = $pictures['fileType'][$key];
		}

		return $binarios;
	}

	private function save_file($folder, $files)
	{
		//Armamos la carpeta destino
		$dir = "files/{$folder}/";

		//Verificamos si la ruta existe
		if (!is_dir($dir)) { mkdir($dir, 0777, true); }

		//Extraemos la extensión del archivo
		$extension = explode('.', $files['file']['name']);

		//Cambiamos el nombre del archivo
		$files['file']['name'] = "file.".$extension[1];

		//Verificamos si el archivo existe en la ruta establecida
		if (file_exists($dir.$files['file']['name'])) { unlink($dir.$files['file']['name']); }

		//Guardamos la ruta completa de la imagen
		$route = $dir.$files['file']['name'];

		//Abrimos el directorio
		opendir($dir);

		//Subimos la imagen y retornamos su resultado
		return (move_uploaded_file($files['file']['tmp_name'], $route)) ? true : false;
	}

	public function updtusr($name, $position, $level, $status, $lang, $region)
	{
		$data = [$name, $position, $level, $status, $lang, $region];

		$flag = true; foreach ($data as $val) { if (is_null($val)) { $flag = false; break; } }

		return (parent::update_user($data)) ? true : false;
	}

	public function profilepics()
	{
		$fotos = parent::thumbnail_profile();
		$modal = '
		<div class="modal fade" id="picProfile">
			<div class="modal-dialog modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title"><i class="fas fa-users"></i> '.LANG['select_image'].' </h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<table class="table table-borderless">
							<tbody>';
							$r = round(count($fotos['id']) / 4); $y = 3; $x = 0;
							for ($i = 0; $i <= $r; $i++)
							{
								$modal .= '<tr>';
								for ($j = $x; $j <= $y; $j++)
								{
									if ($j != count($fotos['id']))
									{
										$modal .= '
										<td>
											<a href="'.URL.'?event=updtpic&val='.$fotos['id'][$j].'">
												<img src="data:'.$fotos['format'][$j].';base64,'.$fotos['pic'][$j].'" class="w-75 imgProfile">
											</a>
										</td>';
									}
									else
									{
										break;
									}
								}
								$modal .= '</tr>';
								$x = $j; $y += ($i == $r) ? 3 : 4;
							}
							$modal .= '
							</tbody>
						</table>
					</div>
					<div class="modal-footer bg-dark justify-content-between"></div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->';
		return $modal;
	}

	public function updtpic($id)
	{
		if (parent::update_pic($id))
		{
			$info = parent::user_info($_SESSION['mailbox_log']['id']);
        	$_SESSION['mailbox_log']['pic'] = $info['pic'];
		}

		load_view();
	}

	public function updatePass($current_pass = null, $pass, $password, $iduser)
	{
		$validation = (!is_null($current_pass)) ? parent::pass_validator($current_pass, $iduser) : true;

		if ($validation)
		{
			if (strlen($pass) >= 8 && strlen($password) >= 8)
			{
				if ($pass == $password)
				{
					$arr_pass = str_split($pass);

					$banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyz_@-$!';

					$arr_banco = str_split($banco);

					$x = true;

					foreach ($arr_pass as $valor_pass) { $x = (!in_array($valor_pass, $arr_banco)) ? false : true; }

					if ($x)
					{
						$password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);

						return (parent::update_password($password, $iduser)) ? true : false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}

	}

	public function historysupportreq($iduser)
	{
		$body = "";
		$list = parent::history_request($iduser);
		if ($list) {
			foreach ($list['subject'] as $index => $value) {
				$class = ($list['idstatus'][$index] == 3) ? 'badge-danger' : 'badge-success';
				$body .= "
				<div class='card-body p-0'>
					<div class='mailbox-read-info'>
						<div class='row'>
							<div class='col-8'>
								<h5>". LANG['subject'].": {$value}</h5>
								<h6 class='mt-2'>From: {$_SESSION['mailbox_log']['email']}</h6>
							</div>
							<div class='col-4'>
								<span class='badge {$class} float-right'>{$list['status'][$index]}</span>
							</div>
						</div>
					</div>
					<div class='mailbox-read-message'>
						<p><strong>".LANG['body_msg'].":</strong></p>
						<p>{$list['mssg'][$index]}</p>
						<hr>
						<p><strong>".LANG['answer'].":</strong></p>
						<p>{$list['response'][$index]}</p>
					</div>
				</div>
				<div class='card-footer bg-dark'></div>
				";
			}
		}

		return $body;
	}

	public function menu_active_class($view)
	{
		if (isset($_SESSION['view'])) {
			if ($_SESSION['view'] == $view)
				return 'active';
			else
				return '';
		}else {
			return '';
		}
	}

	public function menu_treeview_class()
	{
		if (isset($_SESSION['view']))
		{
			$views = func_get_args();
			$class = '';
			foreach ($views as $view) {
				if ($_SESSION['view'] == $view) {
					$class = 'menu-open';
					break;
				}
			}
			return $class;
		}
		else
		{
			return '';
		}
	}

	public function show_table_report($custom_name, $array_fields)
	{
		$users_indexes = [];

		if ($array_fields)
		{
			foreach ($array_fields as $key => $value) { $users_indexes[] = $key; }

			$datable = [];

			foreach ($_SESSION[$custom_name] as $field)
			{
				if (in_array($field, $users_indexes))
				{
					$datable['fields'][] = $field;
					$datable[$field] = $array_fields[$field];
				}
			}

			if (!empty($datable))
			{
				$content = '<table class="table table-bordered table-striped table-responsive">';
				$content .= '<thead><tr>';
				foreach ($datable['fields'] as $val)
				{
					switch ($val) {
						case 'nombre':
							$field = LANG['name'];
							break;

						case 'email':
							$field = LANG['email'];
							break;

						case 'cargo':
							$field = LANG['position'];
							break;

						case 'permiso':
							$field = LANG['permission'];
							break;

						case 'tipo_registro':
							$field = LANG['register_type'];
							break;

						case 'idioma':
							$field = LANG['language'];
							break;

						case 'imagen':
							$field = LANG['image'];
							break;

						case 'estado':
							$field = LANG['status'];
							break;

						case 'asunto':
							$field = LANG['subject'];
							break;

						case 'mensaje':
							$field = LANG['message'];
							break;

						case 'respuesta':
							$field = LANG['response'];
							break;

						default:
							$field = $val;
							break;
					}
				    $content .= "<th>{$field}</th>";
				}
				$content .= '</tr></thead><tbody>';
				foreach ($datable[$datable['fields'][0]] as $key => $value)
				{
					$content .= '<tr>';
					foreach ($datable['fields'] as $field)
					{
					    if ($field != 'fields')
					    {
					    	if ($field == 'imagen')
					    		$content .= "<td><img src='data:image/png;base64,".base64_encode($datable[$field][$key])."' width='50' alt='User profile picture'></td>";
					    	else
					    		$content .= "<td>{$datable[$field][$key]}</td>";
					    }
					}
					$content .= '</tr>';
				}
				$content .= '</tbody></table>';
			}
			else
			{
				$content = "<div class='alert alert-dismissible alert-dark'>".LANG['no_fields_selected']."</div>";
			}
		}
		else
		{
			$content = "<div class='alert alert-dismissible alert-danger'>".LANG['empty_table']."</div>";
		}

		return $content;
	}

	public function showComments()
	{
		$comments = parent::get_comments();

		if ($comments)
		{
			foreach ($comments['id'] as $key => $value)
			{
				echo '
				<div class="direct-chat-msg">
					<div class="direct-chat-infos clearfix">
						<span class="direct-chat-name float-left">
						'.$_SESSION['mailbox_log']['name'].'
						</span>
						<span class="direct-chat-timestamp float-right">
						'.date_format(date_create($comments['date'][$key]), 'd-M-Y').'
						'.$comments['time'][$key].'
						</span>
					</div>
					<img class="direct-chat-img" src="data:image/png;base64,'.$_SESSION['mailbox_log']['pic'].'">
					<div class="direct-chat-text">
						'.$comments['comment'][$key].'
					</div>';

				if ($_SESSION['mailbox_log']['id'] == $comments['idUser'][$key])
				{
					echo '
					<a href="'.URL.'internal_data?delComment='.$value.'" class="text-sm text-danger">'.LANG['delete'].'</a>';
				}
				echo '</div>';
			}
		}
	}

	public function upInfo($val)
	{
		if ($val === 'on')
			$_SESSION['updateInfoUser'] = true;
		else
			unset($_SESSION['updateInfoUser']);

		load_view();
	}

	public function logout()
	{
		parent::pst("INSERT INTO tbl_outputs(iduser) VALUES (:iduser)", ['iduser' => $_SESSION['mailbox_log']['id']], false);
		session_destroy();
		load_view();
	}

	// ************************
    // **********************************
    // ********************************************
    // **********************************
    // ************************

    public function dash_totals($date)
    {
    	$date = preg_replace('([^0-9-])', '', trim($date));

    	$sqldata = parent::records_list($date, $_SESSION['mailbox_log']['idcountry']);

    	$total = count($sqldata['idrecord']);

    	$estados = array_count_values($sqldata['statuscod']);

    	//Fórmula para calcular porcentajes: (100 / total ) * valor

    	$porc_pendientes = (isset($estados['pndt'])) ? (100 / $total ) * $estados['pndt'] : 0;
    	$porc_abiertos = (isset($estados['open'])) ? (100 / $total ) * $estados['open'] : 0;
    	$porc_cerrados = (isset($estados['close'])) ? (100 / $total ) * $estados['close'] : 0;

    	$casos = array_count_values($sqldata['casecod']);

    	$casos['bqj'] = (isset($casos['bqj'])) ? $casos['bqj'] : 0;
    	$casos['bsg'] = (isset($casos['bsg'])) ? $casos['bsg'] : 0;
    	$casos['bfl'] = (isset($casos['bfl'])) ? $casos['bfl'] : 0;
    	$casos['pbt'] = (isset($casos['pbt'])) ? $casos['pbt'] : 0;
    	$casos['pseah'] = (isset($casos['pseah'])) ? $casos['pseah'] : 0;
    	$casos['bcdc'] = (isset($casos['bcdc'])) ? $casos['bcdc'] : 0;
    	$casos['tdenuncias'] = $casos['pbt'] + $casos['pseah'] + $casos['bcdc'];

    	$estados['pndt'] = (isset($estados['pndt'])) ? $estados['pndt'] : 0;
    	$estados['open'] = (isset($estados['open'])) ? $estados['open'] : 0;
    	$estados['close'] = (isset($estados['close'])) ? $estados['close'] : 0;

    	$data = [
    		'total_general' => $total,
    		'casos' => $casos,
    		'regiones' => array_count_values($sqldata['regioncod']),
    		'tipos' => array_count_values($sqldata['type']),
    		'estados' => $estados,
    		'porc_pendientes' => $porc_pendientes.'%',
    		'porc_abiertos' => $porc_abiertos.'%',
    		'porc_cerrados' => $porc_cerrados.'%'
    	];

    	return $data;
    }

    public function entry_history($iduser)
	{
		$body = "";
		$list = parent::history_request($iduser);
		if ($list) {
			foreach ($list['subject'] as $index => $value) {
				$class = ($list['idstatus'][$index] == 5) ? 'badge-warning' : 'badge-success';
				$body .= "
				<div class='card-body p-0'>
					<div class='mailbox-read-info'>
						<div class='row'>
							<div class='col-8'>
								<h5>". LANG['subject'].": {$value}</h5>
								<h6 class='mt-2'>From: {$_SESSION['mailbox_log']['email']}</h6>
							</div>
							<div class='col-4'>
								<span class='badge {$class} float-right'>{$list['status'][$index]}</span>
							</div>
						</div>
					</div>
					<div class='mailbox-read-message'>
						<p><strong>".LANG['body_msg'].":</strong></p>
						<p>{$list['mssg'][$index]}</p>
						<hr>
						<p><strong>".LANG['answer'].":</strong></p>
						<p>{$list['response'][$index]}</p>
					</div>
				</div>
				<div class='card-footer bg-dark'></div>
				";
			}
		}

		return $body;
	}

	// ***********************************************************************************************
	// ***********************************************************************************************
	// ***********************************************************************************************

	public function entry_records($idrecord, $type)
	{
		$n = 0;
		$body = "";
		$info = parent::info_record($idrecord);
		$list = parent::entries_list($idrecord);
		if ($list)
		{
			switch ($type) {
				case 'profile':
					foreach ($list['identry'] as $i => $val)
					{
						$n++;
						$date = date('d-M-Y', strtotime($list['entrydate'][$i]));

						$body .= "
						<div class='card card-primary card-outline collapsed-card'>
							<div class='card-header'>
								<h3 class='card-title'>Entrada #{$n}</h3>
								<div class='card-tools'>
									<button type='button' class='btn btn-tool' data-card-widget='collapse'>
										<i class='fas fa-plus'></i>
									</button>
								</div>
							</div>
							<div class='card-body'>
								<div class='row'>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<span class='info-box-icon bg-turquesa text-white elevation-1'>
												<i class='fas fa-bookmark'></i>
											</span>
											<div class='info-box-content'>
												<span class='info-box-text'>Título</span>
												<span class='info-box-number'>{$list['title'][$i]}</span>
											</div>
										</div>
									</div>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<span class='info-box-icon bg-turquesa text-white elevation-1'>
												<i class='far fa-calendar-alt'></i>
											</span>
											<div class='info-box-content'>
												<span class='info-box-text'>Fecha de registro</span>
												<span class='info-box-number'>{$date}</span>
											</div>
										</div>
									</div>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<span class='info-box-icon bg-turquesa text-white elevation-1'>
												<i class='fas fa-user-edit'></i>
											</span>
											<div class='info-box-content'>
												<span class='info-box-text'>Creador de la entrada</span>
												<span class='info-box-number'>{$list['name'][$i]}</span>
											</div>
										</div>
									</div>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<span class='info-box-icon bg-turquesa text-white elevation-1'>
												<i class='fas fa-file-alt'></i>
											</span>
											<div class='info-box-content'>
												<span class='info-box-text'>Documento</span>
												<span class='info-box-number'>{$list['docname'][$i]}</span>
											</div>
										</div>
									</div>
								</div>
								<div class='row'>
									<div class='col-12'>
										<div class='card card-light' id='entries'>
											<div class='card-header'>
												<h5 class='card-title'>Descripción</h5>
											</div>
											<div class='card-body'>
												<p>{$list['description'][$i]}</p>
											</div>
										</div>
									</div>
								</div>
							</div>";
						if ($info['idstatus'] == 4) {
							$body .= "
							<div class='card-footer'>
								<div class='row'>
									<div class='col-12'>
										<button class='btn btn-link text-dark' data-toggle='modal' data-target='#nuevo-documento'>
											<i class='far fa-file-plus'></i> Agregar documento
										</button>
										<button class='btn btn-link text-blue' onclick='getentry({$val});'>
											<i class='fas fa-edit'></i> Editar entrada
										</button>
										<button class='btn btn-link text-danger' onclick='delentry({$val});'>
											<i class='fas fa-trash-alt'></i> Eliminar entrada
										</button>
									</div>
								</div>
							</div>
						</div>
						";
						}elseif ($info['idstatus'] == 5) {
							$body .= "
							<div class='card-footer'>
							</div>
						</div>
						";
						}
					}
				break;

				case 'report':
					foreach ($list['identry'] as $i => $val)
					{
						$n++;
						$date = date('d-M-Y', strtotime($list['entrydate'][$i]));

						$body .= "
						<div class='card card-primary card-outline'>
							<div class='card-header'>
								<h3 class='card-title'>Entrada #{$n}</h3>
							</div>
							<div class='card-body'>
								<div class='row'>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<div class='info-box-content'>
												<span class='info-box-text'><strong>Título</strong></span>
												<span class='info-box-number' style='font-weight: 400 !important;'>{$list['title'][$i]}</span>
											</div>
										</div>
									</div>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<div class='info-box-content'>
												<span class='info-box-text'><strong>Fecha de registro</strong></span>
												<span class='info-box-number' style='font-weight: 400 !important;'>{$date}</span>
											</div>
										</div>
									</div>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<div class='info-box-content'>
												<span class='info-box-text'><strong>Creador de la entrada</strong></span>
												<span class='info-box-number' style='font-weight: 400 !important;'>{$list['name'][$i]}</span>
											</div>
										</div>
									</div>
									<div class='col-12 col-sm-6 col-md-3'>
										<div class='info-box mb-3'>
											<div class='info-box-content'>
												<span class='info-box-text'><strong>Documento</strong></span>
												<span class='info-box-number' style='font-weight: 400 !important;'>{$list['docname'][$i]}</span>
											</div>
										</div>
									</div>
								</div>
								<div class='row'>
									<div class='col-12'>
										<div class='card card-light' id='entries'>
											<div class='card-header'>
												<h5 class='card-title'>Descripción</h5>
											</div>
											<div class='card-body'>
												<p>{$list['description'][$i]}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class='card-footer'>
							</div>
						</div>";
					}
				break;
			}
		}

		return $body;
	}
}

$objHome = new HomeController;

if (isset($_GET['req']))
{
	if (isset($_GET['val']))
		$objHome->reqviews($_GET['req'], $_GET['val']);
	else
		$objHome->reqviews($_GET['req']);
}