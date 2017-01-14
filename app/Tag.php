<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\TagData;

class Tag extends Model
{
	protected $table = 'blog_tag';
	const DELETED_AT = null;
	const UPDATED_AT = null;
	const CREATED_AT = null;

	public function updateTag($blog_id, $tags)
	{
		if (empty($blog_id) or empty($tags))
			return;
		if (is_string($tags)) {
			$tags = array($tags);
		}
		$flag = true;
		foreach ($tags as $tag) {
			$tag_id = TagData::findIDByName($tag, true);
			if (!$tag_id)
				continue;
			if (self::exist($tag_id, $blog_id))
				continue;
			if (!self::newrow($tag_id, $blog_id)) {
				$flag = false;
				break;
			}
			if (!TagData::inc($tag_id)) {
				$flag = false;
				break;
			}
		}
		return $flag;
	}

	static function exist($tag_id, $blog_id)
	{
		$list = self::where('tag_id', '=', $tag_id)
			->where('blog_id', '=', $blog_id)
			->first(array('id'));
		return count($list);
	}

	static function newrow($tag_id, $blog_id)
	{
		$tag = new self;
		$tag->tag_id = $tag_id;
		$tag->blog_id = $blog_id;
		$tag->save();
		return $tag->id;
	}
}
