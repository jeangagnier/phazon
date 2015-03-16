<?php

namespace Unflr\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MandrillTest extends Command 
{

	protected $name = 'unflr:mandrillTest'; 

	public function fire()
	{
		\Config::set('mail.driver', 'mandrill');

		// view setup
		$data = [
			'view'    => \View::make('emails.dummy')->render(),
			'subject' => 'dummy',
		];

		\Mail::send('layouts.email', $data, function($message) {
			
			$from = \Config::get('unflr.mailFrom');

			$message
				->to('email@gmail.com')
				->from($from['address'], $from['name'])
				->subject('dummy');
			
			// for mandrill
			$headers = [
				'X-MC-Subaccount' => MANDRILL_ACCOUNT,
				'X-MC-Tags'       => 'test'
			];

			foreach ($headers as $key => $value) {
				$message->getHeaders()->addTextHeader($key, $value);
			}
					
		});
	}

}
