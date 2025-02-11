<?php
require_once('config/resp.php');
$dbh = require_once('config/dba.php');

session_start();

$sth_ins = $dbh->prepare('
INSERT IGNORE INTO
	`log`
SET
	`id_session` := :id_session
	, `ip` := :ip
	, `ua` := :ua
	, `hr` := hour(current_timestamp())
	, `date` := current_date()
;');
$result = $sth_ins->execute([
	':id_session' => session_id()
	, ':ua' => $_SERVER['HTTP_USER_AGENT']
	, ':ip' => (
		!empty($_SERVER['HTTP_CLIENT_IP'])
			? $_SERVER['HTTP_CLIENT_IP']
			: !empty($_SERVER['HTTP_X_FORWARDED_FOR'])
				? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']
	),
]);
$dbh->disconnect();

response($result, true);