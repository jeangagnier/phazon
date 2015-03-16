<?php

/**
 * Notes:
 * ----------------------------------
 * set defer-flush to true in codeception.yml - settings ?
 * Redirect::back() doesn't work ?
 */

namespace Codeception\Module;

class YebLaravelCodeception extends Laravel4 
{

	static protected $app;

    protected function getApplication()
    {
    	if (static::$app) {
    		return static::$app;
    	}

        // load codeception
        $root = \Codeception\Configuration::projectDir().'../../';
        require $root.'vendor/autoload.php';

        // env define
        define('TESTING', true);
        $testEnvironment = 'testing';
        $unitTesting     = $this->config['unit'];
        
        // request bugfixes
        $_SERVER['REQUEST_URI']    = substr($_SERVER['PHP_SELF'], 0);
        $_SERVER['REQUEST_METHOD'] = 'POST'; // todolater: improve

        // run laravel
		$app = require $root.'application/bootstrap.php';
		static::$app = $app;

        return $app;
    }

    public function _after(\Codeception\TestCase $test)
    {
        if ($this->transactionCleanup()) {
            $this->kernel['db']->rollback();
        }

        if ($this->kernel['cache']) {
            $this->kernel['cache']->flush();
        }

        if ($this->kernel['session']) {
            $this->kernel['session']->flush();
        }
    }

}
