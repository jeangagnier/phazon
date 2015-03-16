<?php 

namespace Yeb\Helpers;

class Disqus
{

	/**
	 * $data examples
	 * $data = [
	 *     "id"       => $user["id"],
	 *     "username" => $user["username"],
	 *     "email"    => $user["email"]
	 * ];
	*/

	static public function remoteAuthS3($data, $key = DISQUS_API_SECRET) 
	{
		$message   = base64_encode(json_encode($data));
		$timestamp = time();
		$hmac      = static::dsq_hmacsha1($message.' '.$timestamp, $key);

		return $message.' '.$hmac.' '.$timestamp;
	}

	static public function dsqHmacSha1($data, $key) 
	{
		$blocksize = 64;
		$hashfunc  ='sha1';
		
		if (strlen($key)>$blocksize) {
			$key  = pack('H*', $hashfunc($key));
		}

		$key  = str_pad($key, $blocksize, chr(0x00));
		$ipad = str_repeat(chr(0x36), $blocksize);
		$opad = str_repeat(chr(0x5c), $blocksize);
		$hmac = pack('H*', $hashfunc(($key^$opad).pack('H*', $hashfunc(($key^$ipad).$data))));


		return bin2hex($hmac);
	}

}
