<?php

namespace Unflr;

use App, DB;
use Carbon\Carbon;
use Feed\Eloquents, Feed\Core, Feed\Contents;

trait TestsHelperTrait
{	

	/**
	 * Delete & Reset Serial. Faster than Redumping Database
	 * @return void
	 */
	protected function cleanupDb()
	{
		DB::connection('main')->getPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
		DB::statement('
			DELETE FROM users;
			ALTER SEQUENCE users_id_seq RESTART WITH 1;
		');
	}

	protected function dummyUser($i)
	{
		return [
			'email'     => $i.'@dummy.com',
			'ipAddress' => $i,
		];
	}
	
}
