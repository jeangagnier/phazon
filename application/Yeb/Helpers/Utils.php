<?php 

namespace Yeb\Helpers;

use Carbon\Carbon;

class Utils
{

	static $userAgents = [
		'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36',
		'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0',
		'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/537.13+ (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2',
	];
 	
 	static function timeToString($timestamp, $format)
 	{
 		return Carbon::createFromTimeStamp($timestamp)->formatLocalized($format);
 	}

 	static function stringToSqlTime($string)
 	{
 		return Carbon::parse($string)->format('Y-m-d H:i:s');
 	}

	static function itemText($value, Array $options = [])
	{	
		foreach ($options as $o) {		
			if ($o['value'] == $value) {
				return $o['text'];
				break; 
			}		
		}
	}

	static function addHttp($url)
	{
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}

}
