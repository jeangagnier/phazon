<?php

return [
	'driver'   => is_null(SMTP_HOST) ? 'mandrill' : 'smtp',
	'host'     => SMTP_HOST,
	'port'     => SMTP_PORT,
	'username' => SMTP_USER,
	'password' => SMTP_PASSWORD,
];
