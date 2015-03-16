<?php

// Error Logger
$logFile = 'log-'.php_sapi_name().'.log';
Log::useDailyFiles(LOGS_PATH.$logFile);