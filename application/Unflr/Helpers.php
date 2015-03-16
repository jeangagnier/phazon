<?php

namespace Unflr;

use Config, Mail, HTML, View;
use Carbon\Carbon;

class Helpers
{

// mailer helpers
// ------------------------------------------------------------

	public static function sendEmail($type, $data, $subject, $to, Carbon $date = null)
	{
		// view setup
		$data = array_merge($data, [
			'view'    => View::make('emails.'.$type, $data)->render(),
			'subject' => $subject,
		]);

		// send email
		$date = $date ?: Carbon::now();

		Mail::later($date, 'layouts.email', $data, function($message) use ($to, $data, $type) {
			
			$from = \Config::get('unflr.mailFrom');

			$message
				->to($to)
				->from($from['address'], $from['name'])
				->subject($data['subject']);
			
			// for mandrill
			$headers = [
				'X-MC-GoogleAnalytics' => MANDRILL_GA,
				'X-MC-Subaccount' => MANDRILL_ACCOUNT,
				'X-MC-Tags'       => $type,
			];

			foreach ($headers as $key => $value) {
				$message->getHeaders()->addTextHeader($key, $value);
			}
					
		});

	}

// view and other helpers
// ------------------------------------------------------------

	static public function referralLink($code)
	{
		return PUBLIC_FULL_URL.'?ref='.$code;
	}

	static public function emailLink($url, $title = null, Array $attr = []) 
	{
		return HTML::link(PUBLIC_FULL_URL.$url, $title, $attr);
	}

	static public function emailPrimaryLink($url, $title, Array $attr = [])
	{
		$out = HTML::link($url, $title, array_merge($attr, [
			'class' => 'btn btn-primary'
		]));

		return '<table><tr><td class="padding">'.$out.'</td></tr></table>';
	}

	static public function facebookSharer($url, $mobile = false)
	{
		$head = $mobile
			? 'https://m.facebook.com/sharer.php?u='
			: 'https://www.facebook.com/sharer/sharer.php?u=';

		return $head.htmlentities($url);
	}

	static public function fbSharerReferral($code)
	{
		return static::facebookSharer(
			static::referralLink($code)
		);
	}

}
