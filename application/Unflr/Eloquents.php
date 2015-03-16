<?php

namespace Unflr\Eloquents;

use Yeb\Laravel\ExtendedEloquent;
use Watson\Validating\ValidatingTrait;

class User extends ExtendedEloquent
{

	public $table = 'users';
	public $primaryKey = 'id';
	public $timestamps = true;
	protected $jsonFields    = ['extra'];
	protected $booleanFields = [
		'email_was_opened',
		'email_has_bounced',
		'email_is_on_facebook',
		'receives_notifs',
		'has_mobile_registered',
	];

	use ValidatingTrait;
	protected $throwValidationExceptions = true;
	protected $rules = [
		'email' => 'email|unique:users',
	];

}
