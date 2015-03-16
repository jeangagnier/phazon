<?php

namespace Yeb\ServiceProviders;
use Illuminate\Support\ServiceProvider;
use App;
use Config;

class Bindings extends ServiceProvider 
{
	
	public function register()
	{
		// user session facade
		$this->app->bind('Item', function() {
			return new \Yeb\Libraries\Item();
		});

		// facebook api
		App::bind('FacebookGuzzleHttpClient', function() {
			return new \Facebook\HttpClients\FacebookGuzzleHttpClient;
		});

	}

}
