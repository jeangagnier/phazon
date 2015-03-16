<?php

namespace Controllers;

use Input, Redirect, Response;
use Unflr\User;

class Other extends \Unflr\PageController
{

	public function anyUnsubscribe($guid)
	{
		try {
			$user = (new User)->findBy('unsubscribe_guid', $guid);
			$user->unsubscribeFromNotifs();
			return Redirect::to('/thanks/'.$user->orm()->referral_code)
				->with('message', __('<strong>You won\'t receive any more email</strong>'));

		} catch (\Exception $e) {
			return Redirect::to('/');
		}
	}

}
