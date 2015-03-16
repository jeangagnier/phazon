<?php

/*
 * Améliorations : ajouter parent_id + optgroup
 */

namespace Yeb\Libraries;

use Cache;
use DB;

class Item
{

	public $locale;
	
	public function __construct() 
	{
		$this->locale = \App::getLocale();
	}
	
	public function setLocale($locale)
	{
		$this->locale = $locale;

		return $this;
	}

// main methods
// ------------------------------------------------------
	public function get($item, $schema = 'items')
	{
		if (Cache::tags('items')->has($item)) {
			return Cache::tags('items')->get($item);
		}

		$specific = 'items_'.$item;
		$table = \Schema::connection($schema)->hasTable($specific) ? $specific : 'items';

		$values = DB::connection($schema)
			->table($table)
			->select('id AS value', 'text_'.$this->locale.' AS text')
			->where('item', $item)
			->get();

		return $this->prepareOutput($item, $values);
	}
	

	public function getSpecific($table = null, $schema = 'items')
	{
		if (Cache::tags('items')->has($table)) {
			return Cache::tags('items')->get($table);
		}

		$values = DB::connection($schema)
			->table($table)
			->select('id AS value', 'text_'.$this->locale.' AS text')
			->get();

		return $this->prepareOutput($table, $values);
	}
	

	public function getArray($capitalize = true)
	{	
		$out = [];
		foreach (func_get_args() as $item) {
			$out[$item] = $this->get($item);
		}

		// capitalize
		if ($capitalize) {
			array_walk_recursive($out, function(&$item, $key) {
				if ($key === 'text') {
					$item = ucfirst($item);
				}
			});
		}

		return $out;
	}


// protected
// ------------------------------------------------------

	protected function prepareOutput($item, $values)
	{
		$output = \Yeb\Helpers\ArrayHelpers::objectToArray($values);
		
		Cache::tags('items')->put($item, $output, $minutes = 60);

		return $output;
	}

}
