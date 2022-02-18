<?php

require_once APP.'/models/Model.php';

class Controller extends Model
{
	public function actions($action, $value = '')
	{
		switch ($action)
		{
			case 'login':
				$_SESSION['gestion'] = 'login';
			break;

			case 'forgot':
				$_SESSION['gestion'] = 'forget';
			break;

			case 'register':
				$_SESSION['gestion'] = 'register';
			break;

			case 'reset':
				if (strlen($value) == 50)
				{
					if (parent::token_validator($value))
					{
						$_SESSION['gestion'] = 'reset';
						$_SESSION['token'] = $value;
					}
					else
					{
						session_destroy();
					}
				}
			break;

			case 'delRegister':
				if (strlen($value) == 50)
				{
					if (parent::token_validator($value))
					{
						parent::del_register($value);
						session_destroy();
					}
					else
					{
						session_destroy();
					}
				}
			break;

			case 'mailbox':
				session_destroy();
			break;

			case 'resetpass':
				$this->resetPass($_SESSION['email']);
			break;

			case 'delresetpass':
				unset($_SESSION['progressBar']);
				unset($_SESSION['email']);
				unset($_SESSION['resetpass']);
			break;

			case 'delPass':
				$this->delCookie();
			break;

			case 'selectlang':
				$this->selectlang($value);
			break;
		}

		load_view();
	}

	public function login($email, $accesstype, $pass = null, $remember = null)
	{
		if (strlen($email) != 0)
		{
			switch ($accesstype)
			{
				case 'local':
					$info = (strlen($pass) != 0) ? parent::info_login($email, $pass) : false;
					break;

				case 'social':
					$info = parent::info_login($email);
					break;

				default:
					$info = false;
					break;
			}

			if($info)
			{
				if ($info === 'firstIn')
				{
					$key = $this->getKey(50);

					if (parent::set_reset_token($email, $key))
					{
						$_SESSION['gestion'] = 'reset';
						$_SESSION['token'] = $key;
					}
				}
				else
				{
					if (!is_null($remember) && $remember = '1')
					{
						$token = $this->getKey(100);

						if (parent::set_cookie_token($email, $pass, $token)) {
							setcookie('MONSTER', $token, strtotime( '+365 days' ));
						}
					}
				}

				return true;
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

	public function newregister($name, $email, $position = '', $region, $lang, $level, $accesstype = null)
	{
		if (parent::available_mail($email))
		{
			$pwd = password_hash($this->getKey(8), PASSWORD_DEFAULT, ['cost' => 10]);
			$token = password_hash($this->getKey(8), PASSWORD_DEFAULT, ['cost' => 10]);

			$arr_data = [
	            'name' => $name,
	            'email' => $email,
	            'pwd' => $pwd,
	            'position' => $position,
	            'region' => $region,
	            'lang' => $lang,
	            'level' => $level,
	            'token' => $token
	        ];

			return parent::register_user($arr_data, $accesstype);
		}
		else
		{
			return false;
		}
	}

	public function delCookie()
	{
		if (isset($_COOKIE['MONSTER']))
		{
			parent::pst("DELETE FROM tbl_cookies WHERE sessiontoken = :cmonster", ['cmonster' => $_COOKIE['MONSTER']], false);
			setcookie('MONSTER', '', 1);
		}

	}

	public function resetPass($email)
	{
		$data = parent::is_correct_mail($email);

		if ($data)
			return (parent::recovery_req_on($data)) ? true : false;
		else
			return false;
	}

	public function resetPassword($pass)
	{
		$arr_pass = str_split($pass);

		$banco = 'ABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789abcdefghijklmnñopqrstuvwxyz_@-$!';

		$arr_banco = str_split($banco);

		$x = true;

		foreach ($arr_pass as $valor_pass)
	        if (!in_array($valor_pass, $arr_banco)) { $x = false; }

		if ($x)
		{
			$password = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 12]);

			return parent::recover_password($password, $_SESSION['token']);
		}
	}

	protected function getKey($length)
	{
	    $cadena = "ABCDFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
	    $longitudCadena = strlen($cadena);
	    $pass = "";
	    for($i=1 ; $i<=$length ; $i++)
	    {
	        $pos = rand(0,$longitudCadena-1);
	        $pass .= substr($cadena,$pos,1);
	    }
	    return $pass;
	}

	public function date_time($request, $date = null)
    {
        date_default_timezone_set("America/El_Salvador");
        setlocale(LC_TIME, "spanish");

        switch ($request)
        {
        	case 'format':
        		$date = str_replace("/", "-", $date);
        		return strftime("%d/%B/%Y", strtotime(date('d-M-Y', strtotime($date))));
        		break;

            case 'date':
                return strftime("%d/%B/%Y", strtotime(date('d-M-Y', time())));
                break;

            case 'datadate':
                return date('Y-m-d', time());
                break;

            case 'time':
                return date('H:i:s', time());
                break;

            default:
                return false;
                break;
        }
    }

    public function selectlang($lang = null)
    {
    	$langs = parent::lang_list();

    	$lanicon = null;

    	foreach ($langs['idlang'] as $key => $val)
    	{
    		if ($langs['lancode'][$key] == $lang)
    		{
    			$lanicon = $langs['lanicon'][$key];
    			break;
    		}
    	}

    	if (!is_null($lang) && !is_null($lanicon))
    	{
    		$_SESSION['lang']['lanicon'] = $lanicon;
    		$_SESSION['lang']['lancode'] = $lang;
    	}
    }

    protected function sendMail($email, $asunto, $html)
	{
		require_once 'plugins/phpMailer/PHPMailerAutoload.php';

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

		return ($mail->Send()) ? true : false;
	}
}

$objController = new Controller;

$model = new Model;

if (isset($_GET['action']))
{
	if (isset($_GET['value']))
		$objController->actions($_GET['action'], $_GET['value']);
	else
		$objController->actions($_GET['action']);
}