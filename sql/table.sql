CREATE TABLE `simplon_doi` (
  `token` varchar(40) NOT NULL DEFAULT '',
  `connector` char(4) NOT NULL DEFAULT '',
  `connector_data_json` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL,
  UNIQUE KEY `token_status` (`token`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;