<?php

namespace Unflr;

use Illuminate\Support\ServiceProvider;
use Redirect, Request, Session;
use Route as R;

class Provider extends ServiceProvider 
{

	public function register() 
	{
		$this->routes();
		$this->registerCommands();
	}

	public function routes()
	{
		R::group(['namespace' => 'Controllers'], function() {
			R::controller('thanks/{ref}', 'Thanks');
			R::controller('webhooks', 'Webhooks');
			R::controller('other', 'Other');
			R::controller('/', 'Root');
		});
	}

	public function registerCommands()
	{
		$commands = [
			'\Unflr\Commands\MandrillTest',
		];

		foreach ($commands as $command) {
			$this->commands($command);
		}
	}

}
