<?php

namespace Yeb\Helpers;

class Form 
{
	
	/**
	 * Label 
	 */
	public static function label($name = null, $value, $for = null, $class = null, array $extras = [])
	{
		return \Form::label($name, $value, array_merge([
			'class' => $extras,
			'id'    => $name, 
		], $extras));
	}

	/**
	 * RawLabel
	 */
	public static function rawLabel($name, $value = null, $options = []) 
	{
		return sprintf(\Form::label($name, '%s', $options), $value);
	}

	/**
	 * Input
	 */
	public static function input($name, $value = null, $class = null, $encode = true, $type = 'text', array $extras = []) 
	{ 
		$value = ($encode) ? e($value) : $value;

		return \Form::input($type, $name, $value, array_merge([
			'class' => $class,
			'id'    => isset($extras['id']) ? $extras['id'] : $name, 
		], $extras));
	}
	
	/**
	 * Returns a textarea
	 */
	public static function textarea($name, $value = null, $class = null, $encode = true, array $extras = []) 
	{ 
		$valvalue = ($encode) ? e($value) : $value;

		return \Form::textarea($name, $value, array_merge([
			'class' => $class,
			'id'    => isset($extras['id']) ? $extras['id'] : $name, 
			'rows'  => 2,
		], $extras));
	}

	/**
	 * Returns a checkbox within a label
	 */
	public static function checkbox($name = null, $value = true, $checked = false, $labelText, $labelClass = null) 
	{ 
		$checkbox = \Form::checkbox($name, $value, $checked, ['id' => $name]);
		$index    = \Form::hidden($name, 0);

		return static::rawLabel($name, $index . $checkbox. $labelText, [
			'class' => 'checkbox '.$labelClass
		]);
	}

	/**
	 * Returns a radio within a label
	 */
	public static function radio($id = null, $name, $value, $checked = false, $labelText, $labelClass = null) 
	{ 
		$radio = \Form::radio($name, $value, $checked, ['id' => $id]);

		return static::rawLabel($id, $radio . $labelText, [
			'class' => 'radio '.$labelClass
		]);
	}

	/**
	 * Returns a select
	 * --------------------------------
	 * 
	 * Exemple of complex array:
	 * [
	 *     [
	 * 			'value'    => 'dog', 'text' => 'Dogs', 'extras' => ['picture' => 'myurl_one'], 
	 * 		 	'children' => ['value' => 1, 'text' => 'Max' ]
	 * 	   ],
	 * ];
	 */
 	public static function select($id, $value = null, $options = [], $class = null, $allowEmpty = true, $multiple = false, array $extras = []) 
	{	
		$selectedStr = ' selected="selected"';

		// is multiple ?
		if ($multiple) {
			$multipleStr = 'multiple';
			$name = preg_replace('/(?:\d*)/', '', $id);
			$name.= '[]';

		} else {
			$multipleStr = null;
			$name        = $id;
		}

		$dom = sprintf(
			'<select id="%s" name="%s" class="%s" %s %s>',
			$id, $name, $class, $multipleStr, static::addExtras($extras)
		);

		if ($allowEmpty) {
			$dom.= sprintf(
				'<option value="">%s</option>', 
				is_string($allowEmpty) ? $allowEmpty : null
			);
		}

		foreach ($options as $opt) {
			// no optgroup
			if ( !isset($opt['children']) ) {
				$dom.= static::option($opt, $value, $multiple);
				
			// optgroup			
			} else { 
				$options = null;
				foreach ($opt['children'] as $optChild) {
					$options.= static::option($optChild, $optChild['value'], $multiple);
				}

				$dom.= sprintf('<optgroup label="%s">%s</optgroup>', $opt['text'], $options);
			}
		}

		$dom.= '</select>';
		
		return $dom;
	}

	/**
	 * Returns an option
	 */
	public static function option(array $option = [], $selected = null, $multiple = false)
	{
		$selectedStr = ' selected="selected" ';
		
		$option['value'] = isset($option['value']) ? $option['value'] : null;
		$option['text']  = isset($option['text']) ? $option['text'] : null;

		$value = $option['value'];

		$dom = '<option value="'.$value.'" ';
		
		if (isset($option['extras']) and is_array($option['extras'])) {
			$dom.= static::addExtras($dom, $option['extras']);
		}

		// multiple: $value must be an array
		if ($multiple) {
			$length = sizeof($value);
			for ($i=0; $i<$length; $i++) {
				if ($value[$i] == $option['value'] ) {
					$dom.= $selectedStr;
				}
			}

		// not multiple
		} else {
			if ($option['value'] == $selected) {
				$dom.= $selectedStr;
			}
		}

		$dom.= '>';
		$dom.= $option['text'];
		$dom.= '</option>';

		return $dom;
	}

	/**
	 * Returns a Numeric select
	 */
	public static function numSelect($id, $value = null, $min, $max, $class = null, $allowEmpty = true, $addon = null, array $extras = []) 
	{
		$options = null;
		
		if ($allowEmpty) {
			$options.= sprintf(
				'<option value="">%s</option>', 
				is_string($allowEmpty) ? $allowEmpty : null
			);
		}
		
		for ($i = $min; $i <= $max; $i++) {
			$selected = ( $i == $value ) ? 'selected="selected"' : null;
			$options  .= sprintf('<option value="%s" %s>%s %s</option>', $i, $selected, $i, $addon);
		}

		return sprintf(
			'<select id="%s" name="%s" class="%s" %s>%s</select>',
			$id, $id, $class, static::addExtras($extras), $options
		);
	}
 
 	/**
 	 * Add extra attributes
 	 */
	private static function addExtras(array $extras = [])
	{
		$dom = null;
		foreach ($extras as $extra => $value) {
			$dom.= sprintf('%s="%s" ', $extra, $value);
		}
		return $dom;
	}

}
