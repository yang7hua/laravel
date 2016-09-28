<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $table = 'blog';

	const DELETED_AT = null;
	const UPDATED_AT = 'uptime';
	const CREATED_AT = 'addtime';
	const STATUS_OK  = 1;
	const STATUS_NO  = 0;

	public function fromDateTime($value)
	{
		return strtotime(parent::fromDateTime($value));
	}

	public function insertOne($blog)
	{
		$ins = new Blog();
		foreach ($blog as $field=>$value) {
			$ins->$field = $value;
		}
		$ins->toArray();
		$res = $ins->save();
		if ($res)
			return $ins->id;
		return false;
	}

	static function newlist($p, $size)
	{
		return DB::table('blog')->orderBy('addtime', 'desc')
			->skip(($p-1)*$size)
			->take($size)
			->get();
	}

	static function detail($id)
	{
		return self::query()->find($id);
	}

	static function url($blog)
	{
		return route('detail', ['id'=>$blog->id]);
	}

	static function format($blogs)
	{
		foreach ($blogs as &$blog) {
			$blog->url = self::url($blog);
			//$blog->summary = self::summary($blog);
			$blog->content = htmlspecialchars_decode($blog->content);
			if ($blog->cover and file_exists($blog->cover)) {
				$blog->cover = str_replace(public_path(), '', $blog->cover);
			} else {
				$blog->cover = '';
			}
		}
		return $blogs;
	}

	static function keyexist($key)
	{
		$list = self::where('key', '=', $key)->get();
		return count($list);
	}
}
