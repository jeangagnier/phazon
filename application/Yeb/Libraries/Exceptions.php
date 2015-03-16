<?php

class ExpectedException extends \Exception {}

class NotFoundException extends \Exception 
{
 	public function __construct($message = null, $code = 404)
	{
		parent::__construct($message ?: 'Resource Not Found', $code);
	}

}

class ValidationException extends \Exception 
{

	protected $validator;

	public function __construct(\Illuminate\Validation\Validator $validator)
	{
		$this->validator = $validator;
		parent::__construct(null, 400);
	}

	public function getValidator()
	{
		return $this->validator;
	}

	public function getMessages()
	{
		return $this->validator->messages()->all();
	}

}

class PermissionException extends Exception
{
	public function __construct($message = null, $code = 403)
	{
		parent::__construct($message ?: 'Action not allowed', $code);
	}
}
