<?php

class CoreTest extends \Codeception\TestCase\Test
{

	use \Unflr\TestsHelperTrait;

	protected $codeGuy;
	protected function _before() {}
	protected function _after() {}

	public function testSetup()
	{
		$this->cleanupDB();
		$this->codeGuy->resetEmails();
	}

	public function testSendEmail()
	{
		// setup, action
		$email = 'a@dummy.com';
		$user['unsubscribe_guid'] = null;
		\uHelpers::sendEmail('dummy', ['user' => $user], 'dummy', $email);

		// assert
		$this->codeGuy->seeInLastEmailTo($email, 'dummy');
	}

	public function testUserCreation()
	{
		// setup
		$values = $this->dummyUser(1);

		// action
		$user = new \Unflr\User();
		$user->register($values['email'], $values['ipAddress'], null, true);

		// assert
		$this->codeGuy->seeInDatabase('users', array_merge($values, [
			'id' => 1, 
			'has_mobile_registered' => true,
		]));

		$this->codeGuy->seeInLastEmailTo($values['email'], 'Parrainage');
	}

	/**
	 * @expectedException \Unflr\Exceptions\AlreadyRegistered
	 */
	public function testAlreadyRegisteredException()
	{
		$values = $this->dummyUser(1);
		$user = new \Unflr\User();
		$user->register($values['email'], $values['ipAddress']);
	}

	public function testReferredUserCreation()
	{
		// wrong last email because of inaccurate second unit
		$this->codeGuy->resetEmails();

		// setup
		$values = $this->dummyUser(2);

		// action
		$referrer = new \Unflr\User('1@dummy.com');
		$referrerCode = $referrer->orm()->referral_code;

		$user = new \Unflr\User();
		$user->register($values['email'], $values['ipAddress'], $referrerCode);

		// assert
		$this->codeGuy->seeInDatabase('users', array_merge($values, [
			'id'          => 2, 
			'referred_by' => $referrerCode,
		]));

		$this->codeGuy->seeInDatabase('users', [
			'id'             => 1, 
			'referral_count' => 1,
		]);

		$this->codeGuy->seeInLastEmailTo('1@dummy.com', '1 / 5');
	}

	public function testFakeReferralCode()
	{
		// setup
		$this->codeGuy->resetEmails();
		$values = $this->dummyUser(3);
		
		// action
		$user = new \Unflr\User();
		$user->register($values['email'], $values['ipAddress'], 'dummy');

		// assert
		$this->codeGuy->seeInDatabase('users', array_merge($values, [
			'id'          => 3, 
			'referred_by' => 'dummy',
		]));

		$this->codeGuy->dontSeeInLastEmail('1@dummy.com', '2 / 5');
	}

	public function testReferralSuccessAndFiveNotifsOnly()
	{
		$email = '1@dummy.com';
		$referrer = new \Unflr\User($email);
		$referrerCode = $referrer->orm()->referral_code;

		for ($i=1; $i < 10; $i++) { 
			$values = $this->dummyUser($i + 3);
			$user = new \Unflr\User();
			$user->register($values['email'], $values['ipAddress'], $referrerCode);
		}

		$this->codeGuy->seeInDatabase('users', [
			'id'             => 1, 
			'referral_count' => $i,
		]);

		$this->codeGuy->dontSeeInLastEmailTo($email, '5 / 5');
	}

	public function testNotifsUnsubscribe()
	{
		$user = (new \Unflr\User('1@dummy.com'))->unsubscribeFromNotifs();
		
		$this->codeGuy->seeInDatabase('users', [
			'id' => 1, 
			'receives_notifs' => 'f',
		]);
	}

}
