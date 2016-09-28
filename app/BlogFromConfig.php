<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class BlogFromConfig extends Model
{
    //
	protected $table = 'blog_from_config';
	const UPDATED_AT = null;

	static function findByFid($fid)
	{
		return self::where('fid', '=', $fid)->where('status', '=', 1)->get();
	}

	static function updateLastPosttime($id, $last_posttime)
	{
		$ins = self::query()->find($id);
		$ins->last_posttime = $last_posttime;
		return $ins->save();
	}
}
