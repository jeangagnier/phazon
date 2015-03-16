<?php

namespace Yeb\Helpers;

class String 
{

	/**
	 * Split string between $start and $end strings
	 * @param  string $content
	 * @param  string $start
	 * @param  string $end
	 * @return string
	 */
	static function getBetween($string, $start, $end)
	{	
		$regex = '/' . preg_quote($start, '/') . '(.*?)' . preg_quote($end, '/') . '/';
		preg_match_all($regex, $string, $matches);

		return $matches[1];
	}

	/**
	* Check if string has NOT whitespace
	* @param $str string
	* @return boolean
	*/
  	static function checkTrim($string) 
	{
		return !preg_match('/\s/', $string);
	}
   
   /**
	* Convert all links in string to html links
	* @param  string $string 
	* @return string
	*/
	static function makeHtmlLinks($string)
	{
		$string = preg_replace('/(((f|ht){1}tp(s)?:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" >\\1</a>', $string);
		$string = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" >\\2</a>', $string);
		$string = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" >\\1</a>', $string);
	
		return $string;
	}

	/**
	 * Remove all links in string
	 * @param  string $string 
	 * @return string
	 */
	static public function removeLinks($string)
	{
		$regex = '@^(https?|ftp)://[^\s/$.?#].[^\s]*$@iS';
		return preg_replace($regex, '', $string);		
	}

	static public function removeAccents($string)
	{
		return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
	}

	static public function extractWords($string)
	{
		return preg_split('/[\pZ\pC(?\,)]+/u', $string, null, PREG_SPLIT_NO_EMPTY);
	}

}
