<?php

require_once APP.'/config/Connection.php';

class Model extends Connection
{
	public function pst($query, $arr_data = [], $expect_values = true)
    {
        $pdo = parent::connect();
        $pst = $pdo->prepare($query);
        if ($pst->execute($arr_data)) {
            if ($expect_values)
                $res = $pst->fetchAll();
            else
                $res = true;
        }else {
            $res = false;
        }
        return $res;
    }

    public function info_login($email, $pass = null)
    {
        $arr_data = ['email' => $email, 'idstatus' => 1];

        $res = $this->pst("SELECT * FROM tbl_users WHERE email = :email AND idstatus = :idstatus", $arr_data);

        if (!empty($res))
        {
            if (!is_null($pass))
                $iduser = (password_verify($pass, $res[0]->pass)) ? $res[0]->iduser : false;
            else
                $iduser = $res[0]->iduser;

            if ($iduser)
            {
                $res = $this->pst("CALL sp_getlvl(:iduser)", ['iduser' => $iduser]);

                if (!empty($res))
                {
                    $level = $res[0]->level;

                    $res = $this->pst("SELECT COUNT(*) AS 'total' FROM tbl_inputs WHERE iduser = :iduser", ['iduser' => $iduser]);

                    if (!empty($res))
                    {
                        if ($res[0]->total > 0)
                        {
                            $this->pst("INSERT INTO tbl_inputs(iduser) VALUES (:iduser)", ['iduser' => $iduser], false);
                            $_SESSION['mailbox_log'] = $this->user_info($iduser);
                            $_SESSION['lang'] = [ 'lanicon' => $_SESSION['mailbox_log']['lanicon'], 'lancode' => $_SESSION['mailbox_log']['lancode'] ];
                            return true;
                        }
                        else
                        {
                            return 'firstIn';
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
        else
        {
            return false;
        }
    }

    public function outputs($id)
    {
        $this->pst("INSERT INTO tbl_outputs(iduser) VALUES (:id)", ['id' => $id], false);
    }

	public function user_info($iduser)
    {
    	$res = $this->pst("CALL sp_userinfo(:iduser)", ['iduser' => $iduser]);

    	if (!empty($res))
		{
			$info = [];

			foreach($res as $val)
			{
                $info['id'] = $val->iduser;
				$info['name'] = $val->name;
				$info['email'] = $val->email;
				$info['level'] = $val->level;
                $info['region'] = $val->region;
                $info['idlang'] = $val->idlang;
                $info['lancode'] = $val->lancode;
                $info['lanicon'] = $val->lanicon;
				$info['position'] = $val->position;
                $info['pic'] = base64_encode($val->picture);
                $info['status'] = $val->status;
                $info['approval'] = $val->approval;
                $info['idcountry'] = $val->idcountry;
			}

			return $info;
		}
		else
		{
			return false;
		}
    }

    public function lang_list()
    {
        $res = $this->pst("SELECT * FROM tbl_languages");

        if (!empty($res))
        {
            $info = [];

            foreach($res as $val)
            {
                $info['idlang'][] = $val->idlang;
                $info['language'][] = $val->language;
                $info['lancode'][] = $val->lancode;
                $info['lanicon'][] = $val->lanicon;
            }

            return $info;
        }
        else
        {
            return false;
        }
    }

    public function region_list()
    {
        $res = $this->pst("SELECT * FROM tbl_regions");

        if (!empty($res))
        {
            $info = [];

            foreach($res as $val)
            {
                $info['idregion'][] = $val->idregion;
                $info['region'][] = $val->region;
            }

            return $info;
        }
        else
        {
            return false;
        }
    }

    public function update_user($data_user)
    {
        $id = (isset($_SESSION['val'])) ? $_SESSION['val'] : $_SESSION['mailbox_log']['id'];
        $name = $data_user[0];
        $position = $data_user[1];
        $level = $data_user[2];
        $status = $data_user[3];
        $lang = $data_user[4];
        $region = $data_user[5];

        $data = [
            'name' => $name,
            'position' => $position,
            'lang' => $lang,
            'region' => $region,
            'level' => $level,
            'status' => $status,
            'id' => $id
        ];

        $res = $this->pst("CALL sp_updtuser(:name, :position, :level, :region, :lang, :status, :id)", $data, false);

        if (!isset($_SESSION['val']))
            $_SESSION['mailbox_log'] = $this->user_info($id);

        return ($res) ? true : false;
    }

	public function set_cookie_token($email, $pass, $token)
	{
        $arr_data = [
            'email' => $email,
            'pass' => $pass,
            'token' => $token
        ];

		$res = $this->pst("INSERT INTO tbl_cookies VALUES (:email, :pass, :token)", $arr_data, false);

		if($res)
			return true;
		else
			return false;
	}

	public function get_cookie_token($token)
	{
		$res = $this->pst("SELECT email, pass FROM tbl_cookies WHERE sessiontoken = :token", ['token' => $token]);

        if (!empty($res))
        {
    		$info = [];

    		foreach($res as $val)
    		{
    		    $info['user'] = $val->email;
    		    $info['pass'] = $val->pass;
    		}

            return $info;
        }
        else
        {
            return false;
        }
	}

	public function set_reset_token($email, $token)
	{
        $now = date('Y-m-d');

        $arr_data = [
            'token' => $token,
            'now' => date('Y-m-d'),
            'email' => $email,
            'id' => 1
        ];

		$res = $this->pst("UPDATE tbl_users SET token = :token, tokendate = :now WHERE email = :email AND idstatus = :id", $arr_data, false);

        return ($res) ? true : false;
	}

	public function token_validator($token)
	{
		if (strlen($token) == 50)
		{
			$res = $this->pst("SELECT * FROM tbl_users WHERE token = :token", ['token' => $token]);

			if (!empty($res))
				return true;
			else
				return false;
		}
	}

	public function recover_password($pass, $token)
	{
        $data = $this->pst("SELECT iduser FROM tbl_users WHERE token = :token", ['token' => $token]);

        if (!empty($data))
        {
            unset($_SESSION['token']);

            $id = $data[0]->iduser;

            $this->pst("INSERT INTO tbl_inputs(iduser) VALUES (:id)", ['id' => $id], false);

            $arr_data = [
                'pass' => $pass,
                'token' => NULL,
                'td' => NULL,
                'fp' => 0,
                'idstatus' => 1,
                'iduser' => $id
            ];

            $query = "UPDATE tbl_users SET pass = :pass, token = :token, tokendate = :td, forgetpass = :fp, idstatus = :idstatus WHERE iduser = :iduser";

            $res = $this->pst($query, $arr_data, false);

    		return ($res) ? true : false;
        }
        else
        {
            return false;
        }
	}

	public function pass_validator($currentpwd, $iduser)
	{
		$res = $this->pst("SELECT * FROM tbl_users WHERE iduser = :iduser", ['iduser' => $iduser]);

        return (password_verify($currentpwd, $res[0]->pass)) ? true : false;
	}

	public function update_password($pass, $id)
	{
        $arr_data = [
            'pass' => $pass,
            'iduser' => $id
        ];

		$res = $this->pst("UPDATE tbl_users SET pass = :pass WHERE iduser = :iduser", $arr_data, false);

		return ($res) ? true : false;
	}

    public function thumbnail_profile()
    {
        $res = $this->pst("SELECT * FROM tbl_profilepics");

        if (!empty($res))
        {
            $fotos = [];

            foreach ($res as $val)
            {
                $fotos['id'][] = $val->idpic;
                $fotos['name'][] = $val->name;
                $fotos['format'][] = $val->format;
                $fotos['pic'][] = base64_encode($val->picture);
            }

            return $fotos;
        }
        else
        {
            return false;
        }
    }

    public function update_pic($idpic)
    {
        $arr_data = [
            'idpic' => $idpic,
            'iduser' => $_SESSION['mailbox_log']['id']
        ];

        $res = $this->pst("UPDATE tbl_users SET idpic = :idpic WHERE iduser = :iduser", $arr_data, false);

        $_SESSION['mailbox_log'] = $this->user_info($_SESSION['mailbox_log']['id']);

        return ($res) ? true : false;
    }

    public function status_list()
    {
        $res = $this->pst("SELECT * FROM tbl_status");

        if (!empty($res))
        {
            $stts = [];

            foreach ($res as $val)
            {
                $stts['id'][] = $val->idstatus;
                $stts['status'][] = $val->status;
            }

            return $stts;
        }
        else
        {
            return false;
        }
    }

    public function user_list()
    {
        $res = $this->pst("CALL sp_userlist()");

        if (!empty($res))
        {
            $userdata = [];

            foreach ($res as $val)
            {
                $userdata['id'][] = $val->iduser;
                $userdata['name'][] = $val->name;
                $userdata['email'][] = $val->email;
                $userdata['position'][] = $val->position;
                $userdata['region'][] = $val->region;
                $userdata['language'][] = $val->language;
                $userdata['level'][] = $val->level;
                $userdata['registertype'][] = $val->registertype;
                $userdata['status'][] = $val->status;
                $userdata['approval'][] = $val->approval;
            }

            return $userdata;
        }
        else
        {
            return false;
        }
    }

    public function level_list()
    {
        $res = $this->pst("SELECT * FROM tbl_levels");

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['id'][] = $val->idlvl;
                $data['level'][] = $val->level;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function support_list()
    {
        $res = $this->pst("CALL sp_supportlist()");

        if (!empty($res))
        {
            $supports = [];

            foreach ($res as $val)
            {
                $supports['idsupport'][] = $val->idsupport;
                $supports['name'][] = $val->name;
                $supports['email'][] = $val->email;
                $supports['position'][] = $val->position;
                $supports['level'][] = $val->level;
                $supports['subject'][] = $val->subject;
                $supports['mssg'][] = $val->mssg;
                $supports['response'][] = $val->response;
                $supports['idstatus'][] = $val->idstatus;
                $supports['status'][] = $val->status;
            }

            return $supports;
        }
        else
        {
            return false;
        }
    }

    public function insert_comment($comment, $iduser)
    {
        if (!empty($comment))
        {
            $arr_data = [
                'idc' => null,
                'idu' => $iduser,
                'comment' => $comment
            ];

            $query = "INSERT INTO tbl_comments VALUES (:idc, :idu, :comment, CURDATE(), TIME_FORMAT(NOW(), '%H:%i'))";

            return $this->pst($query, $arr_data, false);
        }
        else
        {
            return false;
        }
    }

    public function del_comment($idcomment, $iduser)
    {
        $arr_data = [
            'idc' => $idcomment,
            'idu' => $iduser
        ];

        $res = $this->pst("SELECT * FROM tbl_comments WHERE idcomment = :idc AND iduser = :idu", $arr_data);

        if (!empty($res))
        {
            $this->pst("DELETE FROM tbl_comments WHERE idcomment = :idc", ['idc' => $idcomment], false);
        }
    }

    public function get_comments()
    {
        $res = $this->pst("SELECT * FROM tbl_comments ORDER BY idcomment DESC");

        if (!empty($res))
        {
            $comments = [];

            foreach ($res as $val)
            {
                $comments['id'][] = $val->idcomment;
                $comments['idUser'][] = $val->iduser;
                $comments['comment'][] = $val->comment;
                $comments['date'][] = $val->dcomment;
                $comments['time'][] = $val->tcomment;
            }

            return $comments;
        }
        else
        {
            return false;
        }
    }

    public function is_correct_mail($email)
    {
        $res = $this->pst("SELECT iduser FROM tbl_users WHERE email = :email", ['email' => $email]);
        return (!empty($res)) ? $res[0]->iduser : false;
    }

    public function recovery_req_on($iduser)
    {
        return $this->pst("UPDATE tbl_users SET forgetpass = 1 WHERE iduser = :id", ['id' => $iduser], false);
    }

    public function available_mail($email)
    {
        $res = $this->pst("SELECT * FROM tbl_users WHERE email = :email", ['email' => $email]);
        return (empty($res)) ? true : false;
    }

    public function register_user($arr_data, $accesstype)
    {
        if (is_null($accesstype))
            return $this->pst("CALL sp_useregister(:name, :email, :pwd, :position, :region, :lang, :level, 0, 3, 'local', :token)", $arr_data, false);
        else
            return $this->pst("CALL sp_useregister(:name, :email, :pwd, :position, :region, :lang, :level, 1, 1, 'social', NULL)", $arr_data, false);
    }

    protected function del_register($token)
    {
        $this->pst("DELETE FROM tbl_users WHERE token = :token", ['token' => $token], false);
    }

    public function new_support_request($subject, $mssg, $id)
    {
        $arr_data = [
            'id' => $id,
            'subject' => $subject,
            'mssg' => $mssg
        ];

        return $this->pst("CALL sp_supportrequest(:id, :subject, :mssg)", $arr_data, false);
    }

    public function history_request($iduser)
    {
        $query = "SELECT s.subject, s.mssg, s.response, s.idstatus, e.status FROM tbl_supports s INNER JOIN tbl_status e ON s.idstatus = e.idstatus WHERE iduser = :iduser";

        $res = $this->pst($query, ['iduser' => $iduser]);

        if (!empty($res))
        {
            $list = [];

            foreach ($res as $val)
            {
                $list['subject'][] = $val->subject;
                $list['mssg'][] = $val->mssg;
                $list['response'][] = $val->response;
                $list['idstatus'][] = $val->idstatus;
                $list['status'][] = $val->status;
            }

            return $list;
        }
        else
        {
            return false;
        }
    }

    // ************************
    // **********************************
    // ********************************************
    // **********************************
    // ************************

    public function new_record($data)
    {
        $arr_data = [
            'name' => $data[0],
            'office' => $data[1],
            'email' => $data[2],
            'subject' => $data[3],
            'type' => $data[4],
            'mnsj' => $data[5],
            'date' => $data[6],
            'case' => $data[7],
            'send' => $data[8]
        ];

        return $this->pst("CALL sp_newrecord(:case, :name, :email, :office, :type, :subject, :mnsj, :date, :send)", $arr_data, false);
    }

    public function charts($req, $year)
    {
        $res = $this->pst("CALL sp_{$req}chart(:year)", ['year' => $year]);

        if (!empty($res))
        {
            $data = [];

            switch ($req) {
                case 'dashboard':

                    foreach ($res as $val)
                    {
                        $data['idstatus'][] = $val->idstatus;
                        $data['recorddate'][] = $val->recorddate;
                        $data['mes'][] = $val->mes;
                        $data['anno'][] = $val->anno;
                    }

                    $chart = [
                        'pendientes' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'abiertos' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                        'cerrados' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                    ];

                    foreach ($data['idstatus'] as $i => $val)
                    {
                        switch ($val)
                        {
                            case 3:
                                // pendientes...
                                $chart['pendientes'][$data['mes'][$i] - 1] += 1;
                                break;

                            case 4:
                                // abiertos...
                                $chart['abiertos'][$data['mes'][$i] - 1] += 1;
                                break;

                            case 5:
                                // cerrados...
                                $chart['cerrados'][$data['mes'][$i] - 1] += 1;
                                break;
                        }
                    }

                break;
            }

            return $chart;
        }
        else
        {
            return false;
        }
    }

    public function records_list($year, $country)
    {
        $res = $this->pst("CALL sp_recordslist(:year, :country)", ['year' => $year, 'country' => $country]);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['idrecord'][] = $val->idrecord;
                $data['name'][] = $val->name;
                $data['email'][] = $val->email;
                $data['idregion'][] = $val->idregion;
                $data['region'][] = $val->region;
                $data['regioncod'][] = $val->regioncod;
                $data['subject'][] = $val->subject;
                $data['message'][] = $val->message;
                $data['recorddate'][] = $val->recorddate;
                $data['opendate'][] = $val->opendate;
                $data['closedate'][] = $val->closedate;
                $data['idcase'][] = $val->idcase;
                $data['casename'][] = $val->casename;
                $data['casecod'][] = $val->casecod;
                $data['idtype'][] = $val->idtype;
                $data['type'][] = $val->type;
                $data['idstatus'][] = $val->idstatus;
                $data['status'][] = $val->status;
                $data['statuscod'][] = $val->statuscod;
                $data['iduseropen'][] = $val->iduseropen;
                $data['iduserclose'][] = $val->iduserclose;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }

    public function info_record($idrecord)
    {
        $res = $this->pst("CALL sp_inforecord(:idrecord)", ['idrecord' => $idrecord]);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['idrecord'] = $val->idrecord;
                $data['name'] = $val->name;
                $data['email'] = $val->email;
                $data['idregion'] = $val->idregion;
                $data['region'] = $val->region;
                $data['regioncod'] = $val->regioncod;
                $data['subject'] = $val->subject;
                $data['message'] = $val->message;
                $data['recorddate'] = date('d-M-Y', strtotime($val->recorddate));
                $data['opendate'] = (is_null($val->opendate)) ? '-' : date('d-M-Y', strtotime($val->opendate));
                $data['closedate'] = (is_null($val->closedate)) ? '-' : date('d-M-Y', strtotime($val->closedate));
                $data['idcase'] = $val->idcase;
                $data['casename'] = $val->casename;
                $data['casecod'] = $val->casecod;
                $data['idtype'] = $val->idtype;
                $data['type'] = $val->type;
                $data['idstatus'] = $val->idstatus;
                $data['status'] = $val->status;
                $data['statuscod'] = $val->statuscod;
                $data['iduseropen'] = $val->iduseropen;
                $data['useropen'] = ($val->iduseropen == 0) ? '-' : $val->useropen;
                $data['iduserclose'] = $val->iduserclose;
                $data['userclose'] = ($val->iduserclose == 0) ? '-' : $val->useropen;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }


    public function open_record($idrecord, $iduser, $date)
    {
        $res = $this->pst("UPDATE tbl_records SET idstatus = 4, opendate = :odate, iduseropen = :iduser WHERE idrecord = :idrecord", ['idrecord' => $idrecord, 'iduser' => $iduser, 'odate' => $date], false);

        return $res;
    }

    public function close_record($idrecord, $iduser, $date)
    {
        $res = $this->pst("UPDATE tbl_records SET idstatus = 5, closedate = :cdate, iduserclose = :iduser WHERE idrecord = :idrecord", ['idrecord' => $idrecord, 'iduser' => $iduser, 'cdate' => $date], false);

        return $res;
    }

    public function new_entry($data)
    {
        $res = $this->pst("CALL sp_newentry(:title, :desc, :idrecord, :iduser, :date)", $data, false);

        return $res;
    }

    public function update_entry($data)
    {
        $res = $this->pst("CALL sp_editentry(:title, :desc, :iduser, :date, :identry)", $data, false);

        return $res;
    }

    public function delete_entry($id)
    {
        $step1 = $this->pst("DELETE FROM tbl_entryhistory WHERE identry = :id", ['id' => $id], false);

        if ($step1)
            $res = $this->pst("DELETE FROM tbl_entries WHERE identry = :id", ['id' => $id], false);
        else
            $res = false;

        return $res;
    }

    public function entries_list($idrecord)
    {
        $res = $this->pst('CALL sp_entrylist(:idrecord)', ['idrecord' => $idrecord]);

        if (!empty($res))
        {
            $list = [];

            foreach ($res as $val)
            {
                $list['identry'][] = $val->identry;
                $list['title'][] = $val->title;
                $list['description'][] = $val->description;
                $list['docname'][] = (empty($val->docname)) ? '-' : $val->docname;
                $list['docroute'][] = (empty($val->docroute)) ? '-' : $val->docroute;
                $list['entrydate'][] = $val->entrydate;
                $list['name'][] = $val->name;
            }

            return $list;
        }
        else
        {
            return false;
        }
    }

    public function entry_info($identry)
    {
        $res = $this->pst('SELECT e.*, u.name FROM tbl_entries e JOIN tbl_users u ON e.iduser = u.iduser WHERE e.identry = :id', ['id' => $identry]);

        if (!empty($res))
        {
            $data = [];

            foreach ($res as $val)
            {
                $data['identry'] = $val->identry;
                $data['title'] = $val->title;
                $data['desc'] = $val->description;
                $data['docname'] = (empty($val->docname)) ? '-' : $val->docname;
                $data['docroute'] = (empty($val->docroute)) ? '-' : $val->docroute;
                $data['entrydate'] = $val->entrydate;
                $data['idrecord'] = $val->idrecord;
                $data['iduser'] = $val->iduser;
                $data['name'] = $val->name;
            }

            return $data;
        }
        else
        {
            return false;
        }
    }
}