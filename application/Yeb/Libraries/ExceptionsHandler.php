<?php

namespace Yeb\Libraries;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Redirect;
use Request;
use Response;
use Session;

class ExceptionsHandler
{

	protected $exception;
	protected $httpCode;
	protected $title;
	protected $message;
	protected $type = 'danger';
	protected $redirect = '/';

	public function __construct(\Exception $exception, $httpCode) 
	{
		if (\App::runningInConsole()) { // no cli
			return;
		}

		$this->exception = $exception;
		$this->httpCode  = $httpCode;
		$this->title     = __('Un problème est survenu');
	}

	public function handle()
	{
		$e =& $this->exception;

		if ($e instanceof ModelNotFoundException) {
			$this->title  = __('Le groupe ou la ressource demandé n\'existe plus.');
	
		} else if ($e instanceof \ValidationException) {
			$this->forceFriendly = true;
			$this->title = __('Oops! Il y a quelques erreurs :');

			foreach ($e->getMessages() as $error) {
				$this->message.= '<li>'.$error.'</li>';
			}
			$this->message = '<ul>'.$this->message.'</ul>';

			$this->redirect = 'back';
		}

		return $this->response();
	}

// protected methods
// ------------------------------------------------
	protected function response()
	{
		if ( !DEBUG or isset($this->forceFriendly) ) {
			return $this->redirect();
		}

		return null;
	}

	protected function missing()
	{
		$controller = new \Yeb\Laravel\PageController(true);

		return \Response::make($controller->callAction('render404', [404]));
	}

	protected function redirect()
	{
		$path =& $this->redirect;

		if ($path === 'back') {
			return Redirect::back();
		}

		// prevent infinite loop redirection
		return Redirect::to(Request::is($path) ? '/' : $path);
	}

}
