<?php

namespace App\Lib;

class Func
{
	static public function mkpwd($string)	
	{
		return md5(md5($string));
	}
}
