<?php

namespace Yeb\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use App, Blade, Input, Log, Request, Route, Sessio, View;

class Start extends ServiceProvider 
{
	
	public function register() 
	{
		if ( !defined('TESTING')) {
			App::register('PhpConsole\Laravel\ServiceProvider');
		}
	}

	public function boot()
	{
		// global
		$this->config();
		$this->setCommands();
		$this->appErrors();
		$this->appDebug();
		// filters
		$this->appLifetime();
		$this->routeFilters();
		$this->routes();
	}

	protected function config()
	{
		// View
		View::addLocation(VIEWS_PATH);
		View::addExtension('phtml', 'php');
		View::addExtension('txt', 'php');
		View::addExtension('blade', 'blade');
	}

	protected function setCommands()
	{
		$commands = [
			'\Yeb\Commands\CompileViews',
		];

		foreach ($commands as $command) {
			$this->commands($command);
		}
	}

	protected function appErrors()
	{
		$this->app->error(function(\Exception $e, $code) {
			if ( 
				!($e instanceof \ExpectedException) 
				and !($e instanceof \ValidationException)
				and ($code !== 404) ) 
			{
				\Log::error($e);
			}
		});

		$this->app->down(function() {
			return \Response::make(View::make('yeb.down'), 503);
		});	
	}

	protected function appDebug()
	{
		if (DEBUG and ( !defined('ARTISAN') and !defined('TESTING') ) ) {
			$this->app->error(function(\Exception $e) {
				Request::ajax() and \PC::debug($e);
			});
		}
	}

	protected function appLifetime()
	{
		$this->app->before(function($request) {
			// ...
		});

		$this->app->after(function($request) {
			// ...
		});
	}

	protected function routeFilters()
	{
		Route::filter('csrf', function() {
			if (\Session::token() != \Input::get('_token')) {
				throw new \Illuminate\Session\TokenMismatchException;
			}
		});
	}

	protected function routes()
	{
		\Route::any('/packages/maximebf/php-debugbar/vendor/jquery/dist/jquery.min.map', function() {
			return null;
		});
	}
	
}
