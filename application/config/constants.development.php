<?php

// debug
define('DEBUG', true); 

// url
define('DOMAIN', 'dev.phazon.ca'); 
define('PUBLIC_URL', '/');
define('PUBLIC_FULL_URL', 'http://'.DOMAIN.PUBLIC_URL);
define('ASSETS_URL', 'http://'.DOMAIN.'/assets');

// database
define('PG_HOST', 'localhost');
define('PG_USER', 'admin');
define('PG_PASSWORD', 'postgres');
define('PG_APP_DBNAME', 'phazon');

// memcached
define('MEMCACHED_HOST', 'localhost');
define('MEMCACHED_PORT', 11211);
define('MEMCACHED_WEIGHT', 100);

// emailing: mailcatcher
// define('SMTP_HOST', localhost);
// define('SMTP_PORT', 1025);
define('SMTP_HOST', null);
define('SMTP_PORT', null);
define('MANDRILL_ACCOUNT', '');

// google
define('GOOGLE_ANALYTICS' , null);

// queue
define('QUEUE_CONNECTION', 'sync');
define('QUEUE_URL', null);
