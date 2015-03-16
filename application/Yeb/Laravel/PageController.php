<?php

namespace Yeb\Laravel;

use Agent;
use Cookie;
use Input;
use Request;
use Response;
use Session;
use View;

class PageController extends BaseController 
{

	public $layout = 'layouts.main';

	public $data = [];
	public $jsVars = [];

	protected $appAlias;
	protected $ie_min = 7;
	protected $view = null;
	protected $head = [];
	protected $locale; 
	protected $title;
	protected $item;

	public function __construct() 
	{	
		parent::__construct();		
		$this->isGet  = ($_SERVER['REQUEST_METHOD'] === 'GET');
		$this->isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

		// render presetup
		$this->setLocale();

		// data	
		$this->jsVars['config'] = \Config::get($this->appAlias.'.javascript');
		$this->jsVars['lang']   = \Lang::get($this->appAlias.'Javascript');

		$this->head = array_merge($this->head, [
			'keywords' => null, 'description' => null
		]);
	}

// Render
// -------------------------------------------------------
	protected function render($view = null, $layout = true)
	{
		$view and $this->view =& $view;

		// testing: return view
		if (defined('TESTING')) {
			return Response::make($this->view, 200);
		}

		\JSLocalize::put($this->jsVars);

		// ajax
		if (Request::ajax()) {
			echo \App::make('JSLocalizeDumper')->dump('ajaxResponse');
			echo \Yeb\Helpers\View::showNotif();
			$layout = $layout ?: false;
		
		} else {
			$this->setHead();
		}

		// layout or not ?
		if ($layout === true) {
			$this->data['head'] =& $this->head;

		} else {
			$this->layout = is_string($layout) ? $layout : 'layouts.blank';
		}

		// render
		$this->layout = \View::make($this->layout);
		$this->layout->with($this->data);
		$this->layout->view = View::make($this->view, $this->data);

	}	

	protected function setHead()
	{
		$this->head['title'] = ($this->title) ? 'Mysite - '.$this->title : 'Mysite';
	}


// Multilingual
// -------------------------------------------------------
	protected function setLocale()
	{
		// defines locale
		if (!$this->locale) {
			
			// user changes locale
			if ($locale = Input::get('locale')) {

				if ( in_array($locale, \Config::get('yeb.translate.locales')) ) {
					$this->locale = $locale;
					Cookie::queue('locale', $this->locale, (3600*24*7), '/');
				}

			// cookie apply
			} elseif (Input::cookie('locale')) {
				$this->locale = Input::cookie('locale');
				
			// first accepted language
			} else {
				$accepted = Agent::languages();

				if ( Agent::isRobot() or !$accepted ) { // only homepage
					$this->locale = 'en';

				} else {
		 			$first        = substr($accepted[0], 0, 2);
					$this->locale = in_array($first, \Config::get('yeb.translate.locales')) ? $first : 'en';
				}
			} 

		}
		
		// content
		\Config::set('locale', $this->locale);
		defined('TESTING') or $GLOBALS['translate']->setLocale($this->locale);

		$this->head['lang'] = $this->locale;
		$this->jsVars['locale']    = $this->locale;
	}

// public methods
// -------------------------------------------------------
	
	public function render404() {}

}
