<?php

namespace Controllers;

use Input, Redirect, Response;

class Thanks extends \Unflr\PageController
{

	public function getIndex($ref)
	{
		try {
			$user = (new \Unflr\User)->findBy('referral_code', $ref);

			$this->data = array_merge($this->data, [
				'abFirstStepForm' => null,
				'bodyClass'       => 'modal-open',
				'referralCount'   => $user->orm()->referral_count,
				'referralLink'    => \uHelpers::referralLink($user->orm()->referral_code),
				'message'         => Input::get('m'),
				'user'            => $user->orm()->toArray(),
			]);

			return $this->render('web.root');

		} catch (\Exception $e) {
			return Redirect::to('/');
		}
	}

}
