/*
-----------------------------------------
|       PROCEDIMIENTOS ALMACENADOS      |
-----------------------------------------
*/

USE `db_mailbox`;


DROP PROCEDURE IF EXISTS sp_getlvl;
DELIMITER //
CREATE PROCEDURE sp_getlvl( _id INT )
BEGIN
	SELECT
		n.level
	FROM
		tbl_users u
	INNER JOIN
		tbl_levels n ON u.idlvl = n.idlvl
	WHERE
		u.iduser = _id AND idstatus = 1;
END //


DROP PROCEDURE IF EXISTS sp_userinfo;
DELIMITER //
CREATE PROCEDURE sp_userinfo( _id INT )
BEGIN
	SELECT
		u.iduser,
		u.name,
        u.email,
		l.level,
		r.region,
        u.position,
        u.idlang,
        i.lancode,
        i.lanicon,
        p.picture,
        e.status,
        u.approval,
        c.idcountry
	FROM
		tbl_users u
	INNER JOIN
		tbl_levels l ON u.idlvl = l.idlvl
	INNER JOIN
		tbl_regions r ON u.idregion = r.idregion
	INNER JOIN
		tbl_countries c ON r.idcountry = c.idcountry
	INNER JOIN
		tbl_languages i ON u.idlang = i.idlang
	INNER JOIN
		tbl_profilepics p ON u.idpic = p.idpic
	INNER JOIN
		tbl_status e ON u.idstatus = e.idstatus
	WHERE
		u.iduser = _id;
END //


DROP PROCEDURE IF EXISTS sp_updtuser;
DELIMITER //
CREATE PROCEDURE sp_updtuser(
    _name 		VARCHAR(45),
    _position	VARCHAR(70),
    _level 		INT,
    _region 	INT,
    _lang		INT,
    _status 	INT,
    _iduser		INT
)
BEGIN
	UPDATE
		tbl_users
	SET
		name = _name,
        position = _position,
        idlvl = _level,
        idregion = _region,
        idlang = _lang,
        idstatus = _status
	WHERE
		iduser = _iduser;
END //


DROP PROCEDURE IF EXISTS sp_userlist;
DELIMITER //
CREATE PROCEDURE sp_userlist()
BEGIN
	SELECT
		u.iduser,
		u.name,
		u.email,
		u.position,
		r.region,
        i.language,
        n.level,
        u.registertype,
        s.status,
        u.approval
	FROM
		tbl_users u
	INNER JOIN
		tbl_regions r ON u.idregion = r.idregion
	INNER JOIN
		tbl_languages i ON u.idlang = i.idlang
	INNER JOIN
		tbl_status s ON u.idstatus = s.idstatus
	INNER JOIN
		tbl_levels n ON u.idlvl = n.idlvl;
END //


DROP PROCEDURE IF EXISTS sp_useregister;
DELIMITER //
CREATE PROCEDURE sp_useregister(
	_name			VARCHAR(45),
	_email			VARCHAR(70),
	_pass			VARCHAR(100),
	_position		VARCHAR(70),
	_region  		INT,
	_lang 			INT,
	_level  		INT,
	_mailregister	INT,
	_status			INT,
	_accesstype 	VARCHAR(8),
	_token			VARCHAR(70)
)
BEGIN

	DECLARE _tokendate DATETIME;

	IF _token IS NULL THEN
		SET _tokendate = NULL;
	ELSE
		SET _tokendate = NOW();
	END IF;

	INSERT INTO
		`tbl_users`
	VALUES
		(NULL, _name, _level, _region, _email, _pass, _position, _token, _tokendate, _accesstype, _mailregister, 0, _lang, 1, _status, 0);
END //


DROP PROCEDURE IF EXISTS sp_supportrequest;
DELIMITER //
CREATE PROCEDURE sp_supportrequest(
	_iduser		INT,
    _subject	VARCHAR(100),
    _mssg		VARCHAR(2000)
)
BEGIN
	INSERT INTO tbl_supports VALUES (NULL, _iduser, _subject, _mssg, '', 0, 3);
END //


DROP PROCEDURE IF EXISTS sp_supportlist;
DELIMITER //
CREATE PROCEDURE sp_supportlist()
BEGIN
	SELECT
		s.idsupport,
		u.name,
		u.email,
		u.position,
        l.level,
		s.subject,
		s.mssg,
		s.response,
		s.idstatus,
		e.status
	FROM
		tbl_supports s
	INNER JOIN
		tbl_users u ON s.iduser = u.iduser
	INNER JOIN
		tbl_status e ON s.idstatus = e.idstatus
    INNER JOIN
		tbl_levels l ON u.idlvl = l.idlvl;
END //


DROP PROCEDURE IF EXISTS sp_getsupportreq;
DELIMITER //
CREATE PROCEDURE sp_getsupportreq( _id INT )
BEGIN
	SELECT
		s.idsupport,
		u.name,
		s.subject,
		s.mssg,
        s.response
	FROM
		tbl_supports s
	INNER JOIN
		tbl_users u ON s.iduser = u.iduser
	WHERE
		s.idsupport = _id;
END //


DROP PROCEDURE IF EXISTS sp_savesupportres;
DELIMITER //
CREATE PROCEDURE sp_savesupportres( _id INT, _res VARCHAR(2000) )
BEGIN
	UPDATE tbl_supports SET response = _res, idstatus = 5 WHERE idsupport = _id;
END //


DROP PROCEDURE IF EXISTS sp_datareport;
DELIMITER //
CREATE PROCEDURE sp_datareport( _option VARCHAR(15) )
BEGIN
	IF _option = 'users' THEN
		SELECT
			u.name AS 'nombre',
			u.email,
			u.position AS 'cargo',
			v.level AS 'permiso',
			u.registertype AS 'tipo_registro',
			l.language AS 'idioma',
			p.picture AS 'imagen',
			s.status AS 'estado'
		FROM
			tbl_users u
		INNER JOIN
			tbl_languages l ON u.idlang = l.idlang
		INNER JOIN
			tbl_profilepics p ON u.idpic = p.idpic
		INNER JOIN
			tbl_status s ON u.idstatus = s.idstatus
		INNER JOIN
			tbl_levels v ON u.idlvl = v.idlvl;
	ELSE IF _option = 'supports' THEN
			SELECT
				u.name AS 'nombre',
				u.email,
				u.position AS 'cargo',
				v.level AS 'permiso',
				u.registertype AS 'tipo_registro',
				l.language AS 'idioma',
				p.picture AS 'imagen',
				s.status AS 'estado',
                sp.subject AS 'asunto',
                sp.mssg AS 'mensaje',
                sp.response AS 'respuesta'
			FROM
				tbl_supports sp
			INNER JOIN
				tbl_users u ON sp.iduser = u.iduser
			INNER JOIN
				tbl_languages l ON u.idlang = l.idlang
			INNER JOIN
				tbl_profilepics p ON u.idpic = p.idpic
			INNER JOIN
				tbl_status s ON sp.idstatus = s.idstatus
			INNER JOIN
				tbl_levels v ON u.idlvl = v.idlvl;
		ELSE IF _option = 'comments' THEN
				SELECT
					u.name AS 'nombre',
					u.email,
					u.position AS 'cargo',
					v.level AS 'permiso',
					u.registertype AS 'tipo_registro',
					l.language AS 'idioma',
					p.picture AS 'imagen',
					s.status AS 'estado',
					c.comment AS 'comentario',
                    c.dcomment AS 'fecha'
				FROM
					tbl_comments c
				INNER JOIN
					tbl_users u ON c.iduser = u.iduser
				INNER JOIN
					tbl_languages l ON u.idlang = l.idlang
				INNER JOIN
					tbl_profilepics p ON u.idpic = p.idpic
				INNER JOIN
					tbl_status s ON u.idstatus = s.idstatus
				INNER JOIN
					tbl_levels v ON u.idlvl = v.idlvl;
			END IF;
		END IF;
    END IF;
END //


-- ************************
-- **********************************
-- ********************************************
-- **********************************
-- ************************


DROP PROCEDURE IF EXISTS sp_newrecord;
DELIMITER //
CREATE PROCEDURE sp_newrecord(
	_idtype		INT,
    _nombre		VARCHAR(60),
    _email		VARCHAR(50),
    _idregion	INT,
    _idcase		INT,
    _asunto		VARCHAR(60),
    _mensaje	VARCHAR(2000),
    _fecha 		DATE,
    _sendmail	INT
)
BEGIN
	INSERT INTO tbl_records VALUES
    (NULL, _nombre, _email, _idregion, _asunto, _mensaje, _fecha, null, null, _idcase, _idtype, 3, 0, 0, _sendmail);
END //


DROP PROCEDURE IF EXISTS sp_recordslist;
DELIMITER //
CREATE PROCEDURE sp_recordslist( _year DATE, _country INT )
BEGIN

	SELECT
		r.idrecord,
		r.name,
		r.email,
		r.idregion,
		rr.region,
		rr.regioncod,
		r.subject,
		r.message,
		r.recorddate,
		r.opendate,
		r.closedate,
		r.idcase,
		c.casename,
		c.casecod,
		r.idtype,
		rt.type,
		r.idstatus,
		s.status,
		s.statuscod,
		r.iduseropen,
		r.iduserclose
	FROM
		tbl_records r
	INNER JOIN
		tbl_regions rr ON r.idregion = rr.idregion
	INNER JOIN
		tbl_countries cn ON rr.idcountry = cn.idcountry
	INNER JOIN
		tbl_cases c ON r.idcase = c.idcase
	INNER JOIN
		tbl_recordstype rt ON r.idtype = rt.idtype
	INNER JOIN
		tbl_status s ON r.idstatus = s.idstatus
	WHERE
		YEAR(r.recorddate) = YEAR(_year) AND rr.idcountry = _country;

END //


DROP PROCEDURE IF EXISTS sp_inforecord;
DELIMITER //
CREATE PROCEDURE sp_inforecord( _idrecord INT)
BEGIN

	DECLARE _idopen INT;
	DECLARE _useropen VARCHAR(60);

	DECLARE _idclose INT;
	DECLARE _userclose VARCHAR(60);

	SET _idopen = (SELECT iduseropen FROM tbl_records r WHERE r.idrecord = _idrecord);
	SET _useropen = (SELECT name FROM tbl_users u WHERE u.iduser = _idopen);

	SET _idclose = (SELECT iduserclose FROM tbl_records r WHERE r.idrecord = _idrecord);
	SET _userclose = (SELECT name FROM tbl_users u WHERE u.iduser = _idclose);

	SELECT
		r.idrecord,
		r.name,
		r.email,
		r.idregion,
		rr.region,
		rr.regioncod,
		r.subject,
		r.message,
		r.recorddate,
		r.opendate,
		r.closedate,
		r.idcase,
		c.casename,
		c.casecod,
		r.idtype,
		rt.type,
		r.idstatus,
		s.status,
		s.statuscod,
		r.iduseropen,
		_useropen AS 'useropen',
		r.iduserclose,
		_userclose AS 'userclose'
	FROM
		tbl_records r
	INNER JOIN
		tbl_regions rr ON r.idregion = rr.idregion
	INNER JOIN
		tbl_countries cn ON rr.idcountry = cn.idcountry
	INNER JOIN
		tbl_cases c ON r.idcase = c.idcase
	INNER JOIN
		tbl_recordstype rt ON r.idtype = rt.idtype
	INNER JOIN
		tbl_status s ON r.idstatus = s.idstatus
	WHERE
		r.idrecord = _idrecord;

END //


DROP PROCEDURE IF EXISTS sp_opencase;
DELIMITER //
CREATE PROCEDURE sp_opencase( _cod INT, _codUser INT, _fecha DATE )
BEGIN
	UPDATE tbl_records SET idstatus = 4, iduseropen = _codUser, opendate = _fecha WHERE idrecord = _cod;
END //


DROP PROCEDURE IF EXISTS sp_newentry;
DELIMITER //
CREATE PROCEDURE sp_newentry(
	_titulo			VARCHAR(100),
    _descripcion	VARCHAR(2000),
    _idrecord		INT,
    _codUser		INT,
    _fecha			DATE
)
BEGIN
	INSERT INTO tbl_entries VALUES (NULL, _titulo, _descripcion, '', '', _fecha, _idrecord, _codUser);
END//


DROP PROCEDURE IF EXISTS sp_editentry;
DELIMITER //
CREATE PROCEDURE sp_editentry(
	_titulo			VARCHAR(100),
    _descripcion	VARCHAR(2000),
    _codUser		INT,
    _fecha			DATE,
    _identry		INT
)
BEGIN
	UPDATE tbl_entries SET title = _titulo, description = _descripcion, iduser = _codUser, entrydate = _fecha WHERE identry = _identry;
END //


DROP PROCEDURE IF EXISTS sp_uploadoc;
DELIMITER //
CREATE PROCEDURE sp_uploadoc(
	_identry	INT,
    _docname	VARCHAR(50),
    _docroute	VARCHAR(1000),
    _codUsuario	INT
)
BEGIN
	UPDATE tbl_entries SET docname = _docname, docroute = _docroute, iduser = _codUsuario WHERE identry = _identry;
END //


DROP PROCEDURE IF EXISTS sp_newdoc;
DELIMITER //
CREATE PROCEDURE sp_newdoc(
    _docname	VARCHAR(50),
    _docroute	VARCHAR(1000),
    _codUsuario	INT
)
BEGIN
	INSERT INTO tbl_documents VALUES (NULL, _docname, _docroute, CURDATE(), _codUsuario);
END //


DROP PROCEDURE IF EXISTS sp_entrylist;
DELIMITER //
CREATE PROCEDURE sp_entrylist( _idrecord INT )
BEGIN
	SELECT
		e.identry,
        e.title,
        e.description,
        e.docname,
        e.docroute,
        e.entrydate,
        u.name
	FROM
        tbl_entries e
	JOIN
		tbl_users u ON e.iduser = u.iduser
	WHERE
		e.idrecord = _idrecord;
END //


DROP PROCEDURE IF EXISTS sp_checkdoc;
DELIMITER //
CREATE PROCEDURE sp_checkdoc( _cod INT, _tipo INT )
BEGIN
	IF _tipo = 1 THEN
		SELECT docroute FROM tbl_entries WHERE identry = _cod;
    ELSE
		SELECT docroute FROM tbl_documents WHERE iddoc = _cod;
    END IF;
END //


DROP PROCEDURE IF EXISTS sp_deletedoc;
DELIMITER //
CREATE PROCEDURE sp_deletedoc(
    _identry		INT,
    _codUsuario		INT
)
BEGIN
	UPDATE tbl_entries SET docname = '', docroute = '' WHERE identry = _identry;
END //


DROP PROCEDURE IF EXISTS sp_deletentry;
DELIMITER //
CREATE PROCEDURE sp_deletentry( _identry INT, _idrecord INT, _codUsuario INT, _fecha DATE )
BEGIN
	INSERT INTO
		tbl_entryhistory
	VALUES
		(NULL, _identry, 'ELIMINADO', 'ELIMINADO', 'ELIMINADO', 'ELIMINADO', _fecha, _idrecord, _codUsuario);

    DELETE FROM tbl_entries WHERE identry = _identry;

END //


DROP PROCEDURE IF EXISTS sp_closecase;
DELIMITER //
CREATE PROCEDURE sp_closecase(
	_idrecord 		INT,
    _codUsuario		INT,
    _fecha			DATE
)
BEGIN
	UPDATE tbl_records SET idstatus = 5, iduserclose = _codUsuario, closedate = _fecha WHERE idrecord = _idrecord;
END //


DROP PROCEDURE IF EXISTS sp_charts;
DELIMITER //
CREATE PROCEDURE sp_charts(_fecha DATE)
BEGIN
	SELECT
		r.idrecord,
        t.type,
        c.casename,
        r.idstatus,
        r.recorddate,
        MONTH(r.recorddate) AS 'mes',
        YEAR(r.recorddate) AS 'anno'
	FROM
		tbl_records r
	JOIN
		tbl_recordstype t ON r.idtype = t.idtype
	JOIN
		tbl_cases c ON r.idcase = c.idcase
	WHERE
		YEAR(r.recorddate) = YEAR(_fecha);
END //


DROP PROCEDURE IF EXISTS sp_dashboardchart;
DELIMITER //
CREATE PROCEDURE sp_dashboardchart(_fecha DATE)
BEGIN
	SELECT
		r.idstatus,
        r.recorddate,
        MONTH(r.recorddate) AS 'mes',
        YEAR(r.recorddate) AS 'anno'
	FROM
		tbl_records r
	WHERE
		YEAR(r.recorddate) = YEAR(_fecha);
END //


DROP PROCEDURE IF EXISTS sp_entryhistory;
DELIMITER //
CREATE PROCEDURE sp_entryhistory( _identry INT )
BEGIN
	SELECT
		h.idhistory,
		h.title,
        h.description,
        h.docname,
        h.docroute,
        h.entrydate,
        u.name
	FROM
		tbl_entryhistory h
	JOIN
		tbl_users u ON h.iduser = u.iduser
	WHERE
		identry = _identry;
END //


DROP PROCEDURE IF EXISTS sp_recordslistformail;
DELIMITER //
CREATE PROCEDURE sp_recordslistformail( _status INT )
BEGIN
	SELECT
		r.*,
		c.casename,
		o.region
	FROM
		tbl_records r
	INNER JOIN
		tbl_cases c ON r.idcase = c.idcase
	INNER JOIN
		tbl_regions o ON r.idregion = o.idregion
	WHERE
		sendmail = _status AND email <> 'N/A';
END //


/*
------------------------------------
|              TRIGGERS 		   |
------------------------------------
*/


DROP TRIGGER IF EXISTS inserthistory_insert;
DELIMITER //
CREATE TRIGGER inserthistory_insert AFTER INSERT
ON	tbl_entries
FOR EACH ROW
BEGIN
	INSERT INTO
		tbl_entryhistory (identry, title, description, docname, docroute, entrydate, idrecord, iduser)
	VALUES
		(NEW.identry, NEW.title, NEW.description, NEW.docname, NEW.docroute, NEW.entrydate, NEW.idrecord, NEW.iduser);
END //


DROP TRIGGER IF EXISTS inserthistory_update;
DELIMITER //
CREATE TRIGGER inserthistory_update AFTER UPDATE
ON	tbl_entries
FOR EACH ROW
BEGIN
	INSERT INTO
		tbl_entryhistory (identry, title, description, docname, docroute, entrydate, idrecord, iduser)
	VALUES
		(NEW.identry, NEW.title, NEW.description, NEW.docname, NEW.docroute, NEW.entrydate, NEW.idrecord, NEW.iduser);
END //