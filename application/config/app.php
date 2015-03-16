<?php

return [

	// if disabled, a simple generic error page is shown.
	'debug' => DEBUG,

	// for artisan URLs generated
	'url' => PUBLIC_FULL_URL,

	// Application Timezone : used by the PHP date and date-time functions
	'timezone' => 'UTC',

	// Default Locale Configuration
	'locale' => 'en',

	// Encryption Key is used by the Illuminate encrypter service and should be set
	// to a random, 32 character string, otherwise these encrypted strings
	// will not be safe. Please do this before deploying an application!
	'key'    => 'Wscxw78wxswTJWYAxAZgBXsBnZG',
	'cipher' => MCRYPT_RIJNDAEL_256,

	// Autoloaded Service Providers
	'providers' => [

		// laravel
		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Session\CommandsServiceProvider',
		'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Remote\RemoteServiceProvider',
		'Illuminate\Auth\Reminders\ReminderServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',

		// yeb framework
		'Yeb\ServiceProviders\Start',
		'Yeb\ServiceProviders\Bindings',

		// vendor
		'Barryvdh\Debugbar\ServiceProvider',
		'Crhayes\BladePartials\ViewServiceProvider',
		'Indatus\Dispatcher\ServiceProvider',
		'Jenssegers\Agent\AgentServiceProvider',
		'Msurguy\Honeypot\HoneypotServiceProvider',
		'Rosio\PhpToJavaScriptVariables\PhpToJavaScriptVariablesServiceProvider',
		'Valorin\L4DownSafe\L4DownSafeServiceProvider',

		// Unflare
		'Unflr\Provider',
	],


	// Service Provider Manifest
	'manifest' => storage_path().'/meta',

	// Class Aliases
	'aliases' => [

		// Unflare app
		'uHelpers' => 'Unflr\Helpers',

		// yeb framework
		'Item'       => 'Yeb\Facades\Item',
		'hAsset'     => 'Yeb\Helpers\Asset',
		'hArray'     => 'Yeb\Helpers\ArrayHelpers',
		'hBootstrap' => 'Yeb\Helpers\Bootstrap',
		'hDatabase'  => 'Yeb\Helpers\Database',
		'hDisqus'    => 'Yeb\Helpers\Disqus',
		'hForm'      => 'Yeb\Helpers\Form',
		'hImage'     => 'Yeb\Helpers\Image',
		'hString'    => 'Yeb\Helpers\String',
		'hUrl'       => 'Yeb\Helpers\Url',
		'hUtils'     => 'Yeb\Helpers\Utils',
		'hView'      => 'Yeb\Helpers\View',
		
		// vendor
		'Agent'     => 'Jenssegers\Agent\Facades\Agent',
		'Debugbar'  => 'Barryvdh\Debugbar\Facade',
		'Image'     => 'Intervention\Image\Facades\Image',
		'Datatable' => 'Chumper\Datatable\Facades\DatatableFacade',
		
		// laravel
		'App'               => 'Illuminate\Support\Facades\App',
		'Artisan'           => 'Illuminate\Support\Facades\Artisan',
		'Auth'              => 'Illuminate\Support\Facades\Auth',
		'Blade'             => 'Illuminate\Support\Facades\Blade',
		'Cache'             => 'Illuminate\Support\Facades\Cache',
		'ClassLoader'       => 'Illuminate\Support\ClassLoader',
		'Config'            => 'Illuminate\Support\Facades\Config',
		'Controller'        => 'Illuminate\Routing\Controller',
		'Cookie'            => 'Illuminate\Support\Facades\Cookie',
		'Crypt'             => 'Illuminate\Support\Facades\Crypt',
		'DB'                => 'Illuminate\Support\Facades\DB',
		'Eloquent'          => 'Illuminate\Database\Eloquent\Model',
		'Event'             => 'Illuminate\Support\Facades\Event',
		'File'              => 'Illuminate\Support\Facades\File',
		'Form'              => 'Illuminate\Support\Facades\Form',
		'Hash'              => 'Illuminate\Support\Facades\Hash',
		'HTML'              => 'Illuminate\Support\Facades\HTML',
		'Input'             => 'Illuminate\Support\Facades\Input',
		'Lang'              => 'Illuminate\Support\Facades\Lang',
		'Log'               => 'Illuminate\Support\Facades\Log',
		'Mail'              => 'Illuminate\Support\Facades\Mail',
		'Paginator'         => 'Illuminate\Support\Facades\Paginator',
		'Password'          => 'Illuminate\Support\Facades\Password',
		'Queue'             => 'Illuminate\Support\Facades\Queue',
		'Redirect'          => 'Illuminate\Support\Facades\Redirect',
		'Redis'             => 'Illuminate\Support\Facades\Redis',
		'Request'           => 'Illuminate\Support\Facades\Request',
		'Response'          => 'Illuminate\Support\Facades\Response',
		'Route'             => 'Illuminate\Support\Facades\Route',
		'Schema'            => 'Illuminate\Support\Facades\Schema',
		'Seeder'            => 'Illuminate\Database\Seeder',
		'Session'           => 'Illuminate\Support\Facades\Session',
		'SoftDeletingTrait' => 'Illuminate\Database\Eloquent\SoftDeletingTrait',
		'SSH'               => 'Illuminate\Support\Facades\SSH',
		'Str'               => 'Illuminate\Support\Str',
		'URL'               => 'Illuminate\Support\Facades\URL',
		'Validator'         => 'Illuminate\Support\Facades\Validator',
		'View'              => 'Illuminate\Support\Facades\View',

	],

];
