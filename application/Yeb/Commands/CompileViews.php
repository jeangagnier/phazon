<?php

namespace Yeb\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\View\Compilers\BladeCompiler;

class CompileViews extends Command {

	protected $name = 'yeb:compileviews'; // console command name
	protected $description = 'Compile all blade views';

	public function fire()
	{
		$app = app();

		$cache = $app['path.storage'].'/views';
		$compiler = new BladeCompiler($app['files'], $cache);

		// delete compiled
		$files = new \GlobIterator(TEMP_PATH.'/views/*');

		foreach ($files as $file) {
			if ($file->getExtension() !== '.gitignore') {
				unlink($file);
			}
		}

		// generate new ones
		$files = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(VIEWS_PATH), 
			\RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($files as $file) {
			if ($file->getExtension() === 'blade') {
				$compiler->compile($file->getPathname());
			}
		}
	}

}

