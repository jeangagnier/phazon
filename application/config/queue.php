<?php

return [

	// Supported: "sync", "beanstalkd", "sqs", "iron"
	'default' => QUEUE_CONNECTION,
		
	'connections' => [

		'sync' => [
			'driver' => 'sync',
		],

	],

	'failed' => [
		'database' => 'main', 
		'table'    => 'failed_jobs',
	],
];
