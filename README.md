# Report Module

## Installation

### Composer.json
	"require" : {
		"zendframework/zend-db" : "*",
		"zendframework/zend-i18n" : "*",
		"zendframework/zend-form" : "*",
	}, 
	"autoload" : {
		"psr-4" : {
			"Midnet\\" : "module/Midnet/src",
		},
	},

### modules.config.php
	return [
		'Midnet',
	];
	
### local.php

Edit your local.php to include specific settings for your database.  Be sure to enter proper values for host, database name, user and pass.  This module uses a database connection called `report-model-primary-adapter-config`, which is aliased to `model-primary-adapter-config` in the Street Lamp Module Config.  This allows for one database to hold multiple module tables, or point to different databases.

	return [
		'service_manager' => [
		    'services' => [
		        'model-primary-adapter-config' => [
		            'driver' => 'PDO',
		            'dsn' => 'mysql:host=host.domain.com;dbname=custom-database_name',
		            'username' => 'user-name',
		            'password' => 'CoMpLeXpAsSwOrD',
		        ],
		    ],
		],
	];

### Database Table Structure

	CREATE TABLE IF NOT EXISTS `reports` (
	  `UUID` varchar(36) NOT NULL,
	  `NAME` varchar(255) NULL,
	  `CODE` text NULL,
	  `VIEW` varchar(255) NULL,
	  `STATUS` int(11) DEFAULT NULL,
	  `DATE_CREATED` timestamp NULL DEFAULT NULL,
	  `DATE_MODIFIED` timestamp NULL DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	ALTER TABLE `reports`
		ADD PRIMARY KEY (`UUID`);