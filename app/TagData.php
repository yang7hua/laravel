<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagData extends Model
{
	protected $table = 'blog_tag_data';
	const DELETED_AT = null;
	const UPDATED_AT = null;
	const CREATED_AT = null;

	static function findIDByName($name, $insert = false)
	{
		$name = strtolower($name);
		$info = self::query()->where('name', '=', $name)->first();
		if (empty($info)) {
			if ($insert)
				return self::newTag($name);
			return null;
		}
		return $info->id;
	}

	static function newTag($name)
	{
		$id = self::findIDByName($name);
		if (!empty($id))
			return $id;

		$tag = new self;
		$tag->name = $name;
		$res = $tag->save();
		if ($res)
			return $tag->id;
		return false;
	}

	static function inc($tag_id)
	{
		$tag = self::query()->find($tag_id);
		if (empty($tag))
			return false;
		$tag->count++;
		return $tag->save();
	}
}
