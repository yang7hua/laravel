<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogFrom extends Model
{
    //
	protected $table = 'blog_from';
	const UPDATED_AT = null;

	static function incCount($fid)
	{
		$ins = self::query()->find($fid);
		$ins->count++;
		return $ins->save();
	}

	static function map()
	{
		static $map = array();
		if (!empty($map))
			return $map;
		$list = self::all();
		foreach ($list as $row) {
			$map[$row->id] = $row;
		}
		return $map;
	}

}
