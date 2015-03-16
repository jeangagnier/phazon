<?php

// debug
define('DEBUG', false); 

// url
define('DOMAIN', 'stage.phazon.ca'); 
define('PUBLIC_URL', '/');
define('PUBLIC_FULL_URL', 'http://'.DOMAIN.PUBLIC_URL);
define('ASSETS_URL', 'http://'.DOMAIN.'/assets');

// database
define('PG_HOST', 'localhost');
define('PG_USER', 'app');
define('PG_PASSWORD', '_nEs283678p7q0j');
define('PG_APP_DBNAME', 'phazon_prod');

// memcached
define('MEMCACHED_HOST', 'localhost');
define('MEMCACHED_PORT', 11211);
define('MEMCACHED_WEIGHT', 100);

// google
define('GOOGLE_ANALYTICS', 'UA-55573812-1');

// emailing: mandrill
define('SMTP_HOST', null);
define('SMTP_PORT', null);
define('MANDRILL_ACCOUNT', '');

// queue
define('QUEUE_CONNECTION', 'sync');
define('QUEUE_URL', null);