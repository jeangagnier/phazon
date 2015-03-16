<?php

return [

	//  Default Cache Driver
	//  Supported: "file", "database", "apc", "memcached", "redis", "array"
	'driver' => 'memcached',

	// File Cache Location
	'path' => storage_path().'/cache',

	// Memcached Servers
	'memcached' => [
		['host' => '127.0.0.1', 'port' => 11211, 'weight' => 100],
	],

	//  Cache Key Prefix (avoid collisions)
	'prefix' => 'unflr',

];
