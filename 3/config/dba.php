<?php
$dbh = new \PDO('mysql:dbname=21302_', 'root', 'f2ox9erm');
$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$dbh->query('SET NAMES utf8mb4;');

return $dbh;