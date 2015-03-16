<?php 

namespace Yeb\Helpers;

class Url
{

	static public function newPurl($url = null)
	{
		$url or $url = $_SERVER['REQUEST_URI'];
		return new \Purl\Url($url);
	}


	static public function add($url = null, array $array) 
	{
		$purl   = static::newPurl($url);
		$params = $purl->query->getData(); 

		$purl->query->setData(array_merge(
			$params, $array
		));

		return $purl->path . '?' . $purl->query;
	}


	static public function remove($url = null, $key, $values = null) 
	{
		$purl   = static::newPurl($url);
		$params = $purl->query->getData(); 

		if ($values) {
			$params[$key] = array_diff(
				(array) $params[$key], (array) $values
			);

		} else {
			unset($params[$key]);
		}

		$purl->query->setData($params);
		return $purl->path . '?' . $purl->query;
	}


	static public function exists($url = null, $key) 
	{
		$purl = static::newPurl($url);
		$exists = array_key_exists($key, $purl->query->getData());
		if ($exists) {
			return $purl->query->getData()[$key];
		}
		return $exists;
	}


}