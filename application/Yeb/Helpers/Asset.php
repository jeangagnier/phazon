<?php

namespace Yeb\Helpers;

use HTML;

class Asset
{
	static $busted;

	public static function html($name)
	{
		$name = (\Config::get('yeb.assetsCompiler') === 'grunt')
			? static::gruntMinified($name)
			: static::gulpMinified($name);

		$link = ASSETS_URL.'/../minified/'.$name;
		$ext  = pathinfo($name, PATHINFO_EXTENSION);

		if ($ext === 'js') {
			return HTML::script($link);
		
		} else if ($ext === 'css') {
			return HTML::style($link);
		}
	}

	protected static function gulpMinified($name) 
	{ 
		$out = null;

		if (!static::$busted) {
			$busted = (array) json_decode(file_get_contents(
				sprintf('%s/minified/busters.json', TEMP_PATH)
			));
		}

		foreach ($busted as $key => $value) {
			if ($name === basename($key)) {
				return $name.'?'.$value;
			}
		}
		
		return null;
	}

	public static function gruntMinified($name) 
	{ 
		$out = null;
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		
		if (!static::$busted) {
			$busted = (array) json_decode(file_get_contents(
				sprintf('%s/minified/busted%s.json', TEMP_PATH, ucfirst($ext))
			));
		}
		
		return $busted[basename($name, '.'.$ext)];
	}

}
