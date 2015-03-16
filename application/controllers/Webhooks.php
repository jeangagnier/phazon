<?php

namespace Controllers;

use Input, Redirect, Response;

class Webhooks extends \BaseController
{

	// http://help.mandrill.com/entries/58303976-Message-Event-Webhook-format
	public function anyMandrill()
	{
		$event = Input::get('event');
		$msg   = Input::get('msg');

		if (empty($msg)) {
			return null;
		}

		$user  = new \Unflr\User($msg['email']);

		if ($event === 'hard_bounce') {
			$user->orm()->update([
				'email_has_bounced'  => true,
				'extra' => array_merge($user->orm()->extra, [
					'bounce_description' => $msg['bounce_description'],
				]),
			]);

		} else if ($event === 'open') {
			if ( !$user->orm()->email_was_opened) {
				$user->orm()->update(['email_was_opened' => true]);
			}
		}

		return null;
	}

}
