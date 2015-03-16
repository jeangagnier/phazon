<?php
 
namespace Yeb\Laravel;

class BaseController extends \Controller 
{
 
	protected $params;

	public function __construct($missing = false)
	{
		if ($missing) {
			return;
		}

		$this->params = \Route::current()->parameters();
	}

}
