<?php

return [

	// Default Session Driver ("native", "cookie", "database", "apc", "memcached", "redis", "array")
	'driver' => 'memcached',

	// Session Lifetime (minutes)
	'lifetime' => 120,

	// Session File Location
	'files' => storage_path().'/sessions',

	// Session Sweeping Lottery
	// By default, the odds are 2 out of 100.
	'lottery' => [2, 100],

	'expire_on_close' => false,

	// Session Cookie
	// ------------------------------------------
	'cookie' => 'unflr_session', // Name
	'path' => '/',
	'domain' => null,
	

];
