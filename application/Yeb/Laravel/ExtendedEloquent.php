<?php

namespace Yeb\Laravel;

class ExtendedEloquent extends \Eloquent
{

	public static $unguarded = true;
	protected $emptyAsNull   = false;
	protected $booleanFields = [];
	protected $jsonFields    = [];

// events
// -----------------------------------------------------------
	public static function boot()
    {
        parent::boot();

		static::saving(function($model) {
			$model->beforeSave();
		});
    }

	public function beforeSave()
	{
		// pdo postgresql fix: boolean false to string 
		foreach ($this->attributes as &$attr) {
			$attr === false and $attr = 'false';
		} 

		// set null if empty post value
		if ($this->emptyAsNull) {
			foreach ($this->attributes as &$attr) {
				empty($attr) and $attr = null;
			} 
		}
	}

// posgresql types
// -----------------------------------------------------------
	protected function getAttributeValue($key) {
		$value = parent::getAttributeValue($key);
		
		// booleans
		if (in_array($key, $this->booleanFields)) {
			if ($value == 'true') {
				return true;
			
			} else if ($value == 'false') {
				return false;
			}

			return null;
		}

		// json
		if (in_array($key, $this->jsonFields)) {
			$array = json_decode($value, true);
			$array and ksort($array);
			return (array) $array; 
		}

		return $value;
	}

	public function setAttribute($key, $value)
	{
		// json
		if (in_array($key, $this->jsonFields)) {
			if (is_array($value) or is_object($value)) {
				$value = json_encode($value, JSON_UNESCAPED_UNICODE);
			}
		}

		parent::setAttribute($key, $value);
	}

}
