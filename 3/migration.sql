DROP TABLE IF EXISTS `log`;

CREATE TABLE IF NOT EXISTS `log` (
	`id` BIGINT UNSIGNED NOT null AUTO_INCREMENT
	, `id_session` VARCHAR(256)
	, `ip` VARCHAR(17) NOT null
	, `city` VARCHAR(100) null
	, `ua` TEXT null
	, `hr` TINYINT UNSIGNED NOT null
	, `date` DATE NOT null

	, PRIMARY KEY(`id`)
	, INDEX(`date`, `hr`, `id_session`, `city`)
) COMMENT = 'журнал посещений';