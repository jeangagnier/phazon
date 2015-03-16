<?php 

namespace Yeb\Helpers;

class Image
{

	public static function toJpeg($source, $quality = 100)
	{
		if (exif_imagetype($source) === IMAGETYPE_JPEG) {
			// already jpeg
			return $source;
		
        } else {
			$target = pathinfo($source)['filename'].'.jpg';
			$image = static::createFromFile($source);
			imagejpeg($image, $target, $quality);
			imagedestroy($image);
			unlink($source);

            return $target;
		}
		
	}

	public static function blur($source, $target, $strength = 8)
	{
		$image = static::createFromFile($source);
		
        for ($x=0; $x<$strength; $x++) {
			imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
		}

		imagejpeg($image, $target);
		imagedestroy($image);
		
        return $target;
	}

	public static function createFromFile($path)
	{
		$info = @getimagesize($path);

		if( ! $info) {
			return false;
		}

		$functions = [
			IMAGETYPE_GIF  => 'imagecreatefromgif',
			IMAGETYPE_JPEG => 'imagecreatefromjpeg',
			IMAGETYPE_PNG  => 'imagecreatefrompng',
			IMAGETYPE_WBMP => 'imagecreatefromwbmp',
			IMAGETYPE_XBM  => 'imagecreatefromwxbm',
		];

		if ( ! $functions[$info[2]]) {
			return false;
		}

		if ( ! function_exists($functions[$info[2]])) {
			return false;
		}

		return $functions[$info[2]]($path);
	}

}
