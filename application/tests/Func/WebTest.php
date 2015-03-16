<?php

class WebTest extends \Codeception\TestCase\Test
{
	
	use \Unflr\TestsHelperTrait;

	protected $testGuy;
	protected function _before() {}
	protected function _after() {}

	public function testSetup()
	{
		$this->cleanupDB();
		$this->testGuy->resetEmails();
	}

// index, register
// ---------------------------------------------------

	public function testRootIndex()
	{
		$this->testGuy->sendGET('/');
		$this->testGuy->seeResponseEquals('web.root');
	}

	public function testRootRegisterWithReferralCode()
	{
		// setup
		(new \Unflr\User())->register('1@dummy.com', '1');
		$referralCode = \Unflr\Eloquents\User::find(1)->referral_code;
		$this->testGuy->setCookie('referrer', $referralCode);

		// action
		$data = ['email' => '2@dummy.com'];
		$this->testGuy->sendPOST('/register', $data);

		// assert
		$this->testGuy->seeInDatabase('users', array_merge($data, [
			'id' => 2, 'referred_by' => $referralCode,
		]));

		$registered = \Unflr\Eloquents\User::find(2);
		$this->testGuy->seeInCurrentUrl('/thanks/'.$registered->referral_code);
	}

	public function testThanksIndex()
	{
		$user = \Unflr\Eloquents\User::find(1);
		$url = '/thanks/'.$user->referral_code;
		$this->testGuy->sendGET($url);
		$this->testGuy->seeInCurrentUrl($url);
	}

// failures
// ---------------------------------------------------
 
	public function testRootRegisterEmailFailure()
	{
		$data = ['email' => '3dummy.com'];

		$this->testGuy->sendPOST('/register', $data);

		$this->testGuy->dontSeeInDatabase('users', $data);
		$this->testGuy->seeCurrentUrlEquals('');
		$this->assertTrue(Session::get('errors')->has('email'));
	}

	public function testThanksIndexFailure()
	{
		$this->testGuy->sendGET('/thanks/dummy');
		$this->testGuy->seeCurrentUrlEquals('');
	}

	public function testRootRegisterIpAddressLimitFailure()
	{
		for ($i=3; $i <= 5 ; $i++) { 
			$data = ['email' => $i.'@dummy.com'];
			$this->testGuy->sendPOST('/register', $data);
		}

		$this->testGuy->dontSeeInDatabase('users', [
			'id' => 4, 'email' => '4@dummy.com',
		]);

		$this->testGuy->seeCurrentUrlEquals('');
		$this->assertTrue(Session::get('errors')->has('email'));
	}

// other / webhooks
// ---------------------------------------------------

	public function testOtherUnsubscribe()
	{
		$user = \Unflr\Eloquents\User::find(1);
		$this->testGuy->sendGET('/other/unsubscribe/'.$user->unsubscribe_guid);
		$this->testGuy->seeInDatabase('users', [
			'id' => 1, 'receives_notifs' => 'f',
		]);
		$this->testGuy->seeInCurrentUrl('/thanks/'.$user->referral_code);
	}

	public function testWebhookMandrill()
	{
		$this->testGuy->sendPOST('/webhooks/mandrill', [
			'event' => 'hard_bounce',
			'msg' => [
				'email' => '1@dummy.com',
				'bounce_description' => 'bounce',
			]
		]);

		$this->testGuy->seeInDatabase('users', [
			'id' => 1, 'email_has_bounced' => 't',
		]);
	}

}
