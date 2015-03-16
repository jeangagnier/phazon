<?php

namespace Controllers;

use Input, Redirect, Response;
use Unflr\Exceptions\AlreadyRegistered;
use Unflr\Exceptions\RegistrationFailed;
use Unflr\User;
use Illuminate\Support\MessageBag;
use EmailChecker\EmailChecker;

class Root extends \Unflr\PageController
{

	public function getIndex()
	{
		// ref
		\Cookie::queue('referrer', Input::get('ref'));

		// abtesting
		$this->data['abFirstStepForm'] = (Input::get('v') == 2)
			? true
			: \Config::get('unflr.abtesting.firstStepForm');
		
		return $this->render('web.root');
	}

	public function postRegister()
	{
		$email = Input::get('email');

		try {
			$this->checkEmail($email);

			// create user
			$user = new User();
			$user->register(
				$email, 
				\Request::getClientIp(), 
				\Cookie::get('referrer'), 
				\Agent::isMobile()
			);
	
			return Redirect::to('/thanks/'.$user->orm()->referral_code)
				->with('message', __('Thank you for signing up!'));

		} catch (AlreadyRegistered $e) {
			$user = (new User)->findBy('email', $email);

			return Redirect::to('/thanks/'.$user->orm()->referral_code)
				->with('message', __('You already registered!'));

 		} catch (\ValidationException $e) {
			return Redirect::to('/')->withErrors($e->getValidator());

		} catch (RegistrationFailed $e) {
			$bag = (new MessageBag)->add('email', $e->getMessage());
			
			return Redirect::to('/')->withErrors($bag);
		}
	}

	protected function checkEmail($email)
	{
		// required / spam
		$rules = ['email' => 'required|email'];

		if (!defined('TESTING')) {
			$rules = array_merge($rules, [
				'my_name' => 'honeypot',
				'my_time' => 'required|honeytime:2',
			]);
		}

		$validator = \Validator::make(Input::get(), $rules);
		if ($validator->fails()) {
			throw new \ValidationException($validator);
		}

		// throwable emails
		if ( ! (new EmailChecker)->isValid($email) ) {
			throw new RegistrationFailed(__('Please use a real address!'));
		}

		// check ip
		if (\Unflr\Eloquents\User::where('ipaddress', \Request::getClientIp())->count() >= 2) {
			throw new RegistrationFailed(
				__(	'We like your enthusiasm but try sharing this with your friends!')
			);
		}

		return $this;
	}

}
