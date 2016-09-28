<?php

namespace App\Http\Controllers\Cli;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BlogFromConfig;

class SpiderController extends Controller
{
    //
	public function run($fid)
	{
		static $config;

		if (empty($fid))
			exit("fid error\n");

		if (is_null($config))
			$config = config('spider');

		$list = BlogFromConfig::findByFid($fid);
		if (count($list) < 1)
			exit("no config list\n");

		foreach ($list as $row) {
			$do = ucfirst($config[$row['fid']]);
			if (empty($do))
				continue;
			$Class = 'App\Spider\\'.$do;
			$Obj = new $Class($row);
			$Obj->run();
		}
	}

}
