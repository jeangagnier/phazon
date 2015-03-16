<?php

namespace Yeb\Helpers;

class Bootstrap
{

	/**
	 * Form helper class name.
	 * @var string
	 */
	static public $form_helper = '\Yeb\Helpers\Form';

	/**
	 * Returns a control-group div element. Read README.markdown for more information.
	 * 
	 * @param  Array  $args two values
	 * @return string control-group div element
	 *	 
	 */
	public static function form(array $args)
	{
		// element type
		$keys = array_keys($args);
		$type = $keys[1];
		$controls = null;

		// multiple elements
		if ($type === 'multiple') {

			foreach ($args['multiple'] as $values){
				$type = $values[0];
				array_shift($values); // removes type
				$controls.= call_user_func_array([static::$form_helper, $type], $values);
			}

			$for = null;

		// single element
		} else {
			$values   = static::normalizeArray($args[$type]);
			$controls = call_user_func_array([static::$form_helper, $type], $values);
			$for	  = $values[0];

		}
	

		// controls: variables setup
		if (isset($args['control'])) {

			$c = $args['control']; 

			$label		= $c[0] ?: null;
			$class		= $c[1] ?: null;
			$help_text	= $c[2] ?: null;
			$help_display = $c[3] ?: 'block';

			// help
			$help = ($help_text) ? '<p class="help-'.$help_display.'">'.$help_text.'</p>' : null;

		// controls: string shortcut	
		} else {
			$label = $args[0] ?: null;
			$class = null;
			$help  = null;
		}

		// dom
		$dom = '<div class="control-group '.$class.'">';
		$dom.= call_user_func_array([static::$form_helper, 'label'], [null, $label, $for, 'control-label']);
		$dom.= '<div class="controls">'.$controls.$help.'</div>';
		$dom.= '</div>';

		return $dom;
	}

	/**
	 * Converts array strings keys to numeric keys
	 * 
	 * @param  array $array in
	 * @return array		out
	 */
	private static function normalizeArray(array $array) {
		$new_array  = [];
		$array_keys = array_keys($array);
		$i = 0;
		foreach($array_keys as $key){
			$new_array[$i] = $array[$key];
			$i++;
		}
		return $new_array;
	}

	/**
	 * Returns a nav list. Read README.markdown for more information.
	 * 
	 * @param  string $nav_class    UL class ('nav', 'nav-tabs' etc.)
	 * @param  Array  $items        Set of links and their text
	 * @param  closure $url_filter  Link filter Closure function
	 * @param  closure $url_active  Closure function that determines if the link is active or not 
	 * 
	 * @return string                  Nav list
	 */
	public static function nav($nav_class = 'nav', array $items, callable $url_filter = null, callable $url_active = null)
	{
		$dom = null;

		foreach ($items as $item) {

			if (is_callable($item)) {
				$dom.= $item();
			
			} else if (!is_array($item)) {
				  $dom.= '<li class="nav-header">'.$item.'</li>';  
			
			} else {
				$text  =& $item[0];
				$url   =& $item[1];

				$extra = isset($item[2]) ? $item[2] : null;


				if ($url_filter) {
					$url = $url_filter($url);
				} 
	
				if (!$url_active) {
					$url_active = function ($url) {
						// ignore all query strings
						return ($url === preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']));
					};
				}

				$active = ($url_active($url)) ? 'active' : '';
				$dom.= '<li class="'.$active.'"><a href="'.$url.'" '.$extra.'>'.$text.'</a></li>';  
			}

		}
		return ($nav_class) ? '<ul class="'.$nav_class.'">'.$dom.'</ul>' : $dom;
	}


	/**
	 * Returns a subform title
	 * 
	 * @param  string $label Label
	 * @return string        subform title
	 */
	static public function form_title($title, $infos = null, $class = null)
	{
		$out = '<div class="control-group '.$class.'"><h3>'.$title.'</h3>'; 
		$infos and $out.= '<p>'.$infos.'</p>';
		$out.= '</div>';
		return $out;
	}


	static public function modal_header($title, $icon = null, $close = false)
	{
		$out = '<div class="modal-header">';
		$close and $out.= '<button class="close" data-dismiss="modal">×</button>';
		$out.= '<h2>';
		$icon and $out.= '<i class="icon-'.$icon.'"></i>';
		$out.= $title.'</h2></div>';

		return $out;
	}

}
