<?php

namespace ES\Taobaoke\Facades;

use Exception;

use Illuminate\Support\Facades\Facade;

class Taobaoke extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'taobaoke';
	}
}