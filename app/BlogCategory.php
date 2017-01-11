<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    //
	protected $table = 'blog_category';
	const UPDATED_AT = null;

	static function incCount($cid)
	{
		$ins = self::query()->find($cid);
		$ins->count++;
		return $ins->save();
	}

}
