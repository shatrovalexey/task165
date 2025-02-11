<?php
require_once('config/resp.php');

$result = ['radial' => [], 'time' => [],];

$dbh = require_once('config/dba.php');

foreach ([
	'uniq' => '
SELECT
	`l1`.`city`
	, count(DISTINCT `l1`.`id_session`) AS `count`
FROM
	`log` AS `l1`
GROUP BY
	1
;
	'
	, 'time' => '
SELECT
	`l1`.`date`
	, `l1`.`hr`
	, count(DISTINCT `l1`.`id_session`) AS `count`
FROM
	`log` AS `l1`
GROUP BY
	1, 2
;
	',
] as $key => $sql) {
	$sth_sel = $dbh->prepare($sql);
	$sth_sel->execute();
	$result[$key] = $sth_sel->fetchAll(\PDO::FETCH_NUM);
	$sth_sel->closeCursor();
}

response($result, true);