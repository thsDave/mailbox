/*
----------------------------------------
|         CREACIÓN Y SELECCION         |
----------------------------------------
*/

DROP DATABASE IF EXISTS `db_mailbox`;

CREATE DATABASE IF NOT EXISTS `db_mailbox` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE `db_mailbox`;

/*
----------------------------------------
|          TABLAS PRINCIPALES          |
----------------------------------------
*/

/*TABLA Paises*/

CREATE TABLE IF NOT EXISTS tbl_countries(
	idcountry	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	country 	VARCHAR(45) NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Regiones*/

CREATE TABLE IF NOT EXISTS tbl_regions(
	idregion	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	region		VARCHAR(45) NOT NULL,
  regioncod VARCHAR(5) NOT NULL,
	idcountry INT NOT NULL,

	CONSTRAINT FK_regions_idcountry FOREIGN KEY (idcountry) REFERENCES tbl_countries (idcountry)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Niveles de Usuario*/

CREATE TABLE IF NOT EXISTS tbl_levels(
  idlvl 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  level 	VARCHAR(20) NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA Estados */

CREATE TABLE IF NOT EXISTS tbl_status(
	idstatus 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	status 		VARCHAR(25) NOT NULL,
  statuscod VARCHAR(5) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Fotos de Perfil*/

CREATE TABLE IF NOT EXISTS tbl_profilepics(
	idpic 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name 			VARCHAR(15) NOT NULL,
	format 		VARCHAR(12) NOT NULL,
	picture 	BLOB NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA idiomas */

CREATE TABLE IF NOT EXISTS tbl_languages(
	idlang 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	language	VARCHAR(15) NOT NULL,
	lancode		VARCHAR(3) NOT NULL,
	lanicon 	VARCHAR(15) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA Casos */

CREATE TABLE IF NOT EXISTS tbl_cases(
	idcase 		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	casename 	VARCHAR(60) NOT NULL,
  casecod   VARCHAR(5) NOT NULL,
  type      VARCHAR(10) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA Tipos de registros */

CREATE TABLE IF NOT EXISTS tbl_recordstype(
	idtype 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type 		VARCHAR(25) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA Registros */

CREATE TABLE tbl_records(
	idrecord			INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name					VARCHAR(60) NOT NULL,
  email					VARCHAR(50) NOT NULL,
  idregion			INT NOT NULL,
  subject				VARCHAR(60) NOT NULL,
  message				VARCHAR(2000) NOT NULL,
  recorddate		DATE NOT NULL,
  opendate			DATE,
  closedate			DATE,
  idcase				INT NOT NULL,
  idtype				INT NOT NULL,
  idstatus			INT NOT NULL,
  iduseropen		INT NOT NULL,
  iduserclose		INT NOT NULL,
  sendmail      TINYINT NOT NULL DEFAULT 0,
  CONSTRAINT 		FK_tbl_records_idregion FOREIGN KEY (idregion) REFERENCES tbl_regions (idregion),
  CONSTRAINT 		FK_tbl_records_idcase FOREIGN KEY (idcase) REFERENCES tbl_cases (idcase),
  CONSTRAINT 		FK_tbl_records_idtype FOREIGN KEY (idtype) REFERENCES tbl_recordstype (idtype),
  CONSTRAINT 		FK_tbl_records_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Usuarios*/

CREATE TABLE IF NOT EXISTS tbl_users(
	iduser				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name 					VARCHAR(45) NOT NULL,
	idlvl 				INT NOT NULL,
	idregion 			INT NOT NULL,
	email 				VARCHAR(70) NOT NULL,
	pass					VARCHAR(100) NOT NULL,
	position			VARCHAR(70) NOT NULL,
	token 				VARCHAR(70) NULL,
	tokendate 		DATETIME NULL,
	registertype 	VARCHAR(8) NOT NULL,
	registermail	INT NOT NULL DEFAULT 0,
	forgetpass		INT NOT NULL DEFAULT 0,
	idlang				INT NOT NULL,
  idpic					INT NOT NULL DEFAULT 1,
  idstatus			INT NOT NULL,
  approval			TINYINT NOT NULL,

	CONSTRAINT FK_users_idlvl FOREIGN KEY (idlvl) REFERENCES tbl_levels (idlvl),
	CONSTRAINT FK_users_idregion FOREIGN KEY (idregion) REFERENCES tbl_regions (idregion),
	CONSTRAINT FK_users_idlang FOREIGN KEY (idlang) REFERENCES tbl_languages (idlang),
  CONSTRAINT FK_users_idpic FOREIGN KEY (idpic) REFERENCES tbl_profilepics (idpic),
  CONSTRAINT FK_users_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA de entradas */

CREATE TABLE tbl_entries(
	identry				INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title					VARCHAR(100) NOT NULL,
  description		VARCHAR(2000) NOT NULL,
  docname				VARCHAR(50) NOT NULL,
  docroute			VARCHAR(1000) NOT NULL,
  entrydate			DATE NOT NULL,
  idrecord			INT NOT NULL,
  iduser				INT NOT NULL,
  CONSTRAINT		FK_tbl_entries_idrecord FOREIGN KEY (idrecord) REFERENCES tbl_records (idrecord),
  CONSTRAINT		FK_tbl_entries_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA historial de entradas */

CREATE TABLE tbl_entryhistory(
	idhistory		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	identry			INT NOT NULL,
  title				VARCHAR(100) NOT NULL,
  description	VARCHAR(2000) NOT NULL,
  docname			VARCHAR(50) NOT NULL,
  docroute		VARCHAR(1000) NOT NULL,
  entrydate		DATE NOT NULL,
  idrecord		INT NOT NULL,
  iduser			INT NOT NULL,
  CONSTRAINT	FK_tbl_entryhistory_idrecord FOREIGN KEY (idrecord) REFERENCES tbl_records (idrecord),
  CONSTRAINT	FK_tbl_entryhistory_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* TABLA de documentos */

CREATE TABLE tbl_documents(
	iddoc			INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  docname		VARCHAR(50) NOT NULL,
  routedoc	VARCHAR(1000) NOT NULL,
  docdate		DATE NOT NULL,
  iduser		INT NOT NULL,
  CONSTRAINT	FK_tbl_documents_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Cookies*/

CREATE TABLE IF NOT EXISTS tbl_cookies(
	email			VARCHAR(60) NOT NULL,
	pass			VARCHAR(60) NOT NULL,
  sessiontoken	VARCHAR(125) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Comentarios*/

CREATE TABLE IF NOT EXISTS tbl_comments(
	idcomment	INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  iduser		INT NOT NULL,
  comment		VARCHAR(200) NOT NULL,
  dcomment	DATE NOT NULL,
  tcomment	TIME NOT NULL,

  CONSTRAINT FK_comments_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*TABLA Soporte técnico*/

CREATE TABLE IF NOT EXISTS tbl_supports(
	idsupport	INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  iduser		INT NOT NULL,
  subject		VARCHAR(100) NOT NULL,
  mssg		VARCHAR(2000) NOT NULL,
  response	VARCHAR(2000) NOT NULL,
  sendmail	BOOLEAN NOT NULL,
  idstatus 	INT NOT NULL,

  CONSTRAINT FK_supports_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE,
  CONSTRAINT FK_supports_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Registros de Entradas de usuarios */

CREATE TABLE IF NOT EXISTS tbl_inputs(
	idinput		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iduser		INT NOT NULL,
  indate		DATETIME NOT NULL DEFAULT NOW(),

  CONSTRAINT FK_inputs_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Registros de salidas */

CREATE TABLE IF NOT EXISTS tbl_outputs(
	idoutput	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  iduser		INT NOT NULL,
  outdate		DATETIME NOT NULL DEFAULT NOW(),

  CONSTRAINT FK_outputs_iduser FOREIGN KEY (iduser) REFERENCES tbl_users (iduser) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


/* Registros de cron.php */

CREATE TABLE IF NOT EXISTS tbl_logscron(
	idlog		INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  idstatus 	INT NOT NULL,
  message		VARCHAR(100) NOT NULL,

  CONSTRAINT FK_logscron_idstatus FOREIGN KEY (idstatus) REFERENCES tbl_status (idstatus)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;