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

	static function tree()
	{
		$list = self::query()->orderBy('pid', 'asc')->get()->toArray();
		$tree = array();
		foreach ($list as $row) {
			if ($row['pid'] < 1) {
				$row['children'] = array();
				$tree[$row['id']] = $row;
				continue;
			}
			$tree[$row['pid']]['children'][] = $row;
		}
		return $tree;
	}

	static function format($list)
	{
		if (empty($list))
			return $list;
		foreach ($list as &$row) {
			$row->url = route('category', ['code'=>$row->code]);
		}
		return $list;
	}

}
