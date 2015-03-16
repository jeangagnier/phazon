<?php

namespace Unflr;

use Carbon\Carbon;
use Queue, Mail, Config, Str;

class User
{

	public $orm;
	protected $email;

	public function __construct($email = null)
	{
		$this->email = $email;
	}

	public function orm()
	{
		if ( !$this->orm and $this->email) {
			$this->orm = Eloquents\User::where('email', $this->email)->firstOrFail();
		}

		return $this->orm;
	}

	public function exists()
	{
		return (bool) $this->orm();
	}

	public function findBy($key, $value)
	{
		$this->orm = Eloquents\User::where($key, $value)->first();	
		
		if ($this->orm) {
			$this->email = $this->orm->email;
		}

		return $this;
	}

	public function register($email, $ipAddress, $referrerCode = null, $isMobile = null, $extra = null)
	{
		if (Eloquents\User::where('email', $email)->first()) {
			throw new \Unflr\Exceptions\AlreadyRegistered();
		}

		$this->email = $email;
		$this->orm   = Eloquents\User::create([
			'email'                 => $email,
			'ipaddress'             => $ipAddress,
			'referral_code'         => $this->createReferralCode(),
			'referred_by'           => $referrerCode,
			'unsubscribe_guid'      => Str::random(24),
			'has_mobile_registered' => $isMobile,
			'coupon'                => Str::random(10), // Phazon Coupon
		]);

		// referrer notif
		if ($referrerCode) {
			$referrer = (new User)->findBy('referral_code', $referrerCode);
			$referrer->exists() and $referrer->addReferralSuccess();
		}

		$this->sendWelcomeEmail();

		return $this;
	}

	public function unsubscribeFromNotifs()
	{
		$this->orm()->update(['receives_notifs' => false]);

		return $this;
	}

// protected methods
// --------------------------------------------------------------

	protected function createReferralCode()
	{
		$code = Str::quickRandom(5);
		$user = (new User)->findBy('referral_code', $code);

		while ($user->exists()) {
			$code = Str::quickRandom(5);
			$user = (new User)->findBy('referral_code', $code);
		}

		return $code;
	}
	
	protected function sendWelcomeEmail()
	{
		$data = ['user' => $this->orm()];

		// when
		$minutes = Config::get('unflr.minutesBeforeWelcomeEmail');
		$date    = Carbon::now()->addMinutes($minutes);
		$subject = Config::get('unflr.emails.welcome.subject');
		Helpers::sendEmail('welcome', $data, $subject, $this->email, $date);
	}

	protected function addReferralSuccess()
	{
		$successCount = Config::get('unflr.referralsCountForSuccess');

		$this->orm()->referral_count++;
		$this->orm()->save();
		$count = $this->orm()->referral_count;

		if ( !$this->orm()->receives_notifs or $count > $successCount) {
			return $this;
		}

		// send email
		$type     = ($count === $successCount) ? 'referralSuccess' : 'referralNotif';
		$subject = __(Config::get('unflr.emails')[$type]['subject'], $count, $successCount);
	
		Helpers::sendEmail($type, ['user' => $this->orm()], $subject, $this->email);	

		return $this;
	}

}
