<?php

return [

	// PDO Fetch Style
	'fetch' => PDO::FETCH_CLASS,

	// Default Database Connection Name
	'default' => 'main',

	// Database Connections
	'connections' => [

		'main' => [
			'driver'   => 'pgsql',
			'host'     => PG_HOST,
			'database' => PG_APP_DBNAME,
			'username' => PG_USER,
			'password' => PG_PASSWORD,
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		],
		
	],

];
