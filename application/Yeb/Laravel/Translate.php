<?php

namespace Yeb\Laravel;

class Translate
{

	public $zendTranslate;
	protected $config;

	public function __construct() 
	{
		$this->config = \Config::get('yeb.translate');

		// translate
		// ------------------------------------
		$this->zendTranslate = new \Zend\I18n\Translator\Translator();

		foreach ($this->config['files'] as $file => $language) {
			$this->zendTranslate->addTranslationFile('gettext', $file, 'default', $language);
		}
	
		// cache
		// ------------------------------------
		// memcache
		$cache = \Zend\Cache\StorageFactory::factory(['adapter' => [
			'name' => 'Memcached',
			'options' => [
				'ttl' => (60*60*2),
				'servers' => [[
					'host'   => MEMCACHED_HOST, 
					'port'   => MEMCACHED_PORT, 
					'weight' => MEMCACHED_WEIGHT, 
				]]
			]
		]]);

		// don't set cache in debug mode
		DEBUG or $this->zendTranslate->setCache($cache);
	}
	
	public function setLocale($lang)
	{
		\App::setLocale($lang);
		setlocale(LC_ALL, $this->config['locales'][$lang]); 
		$this->zendTranslate->setLocale($lang);
	}
	
}
