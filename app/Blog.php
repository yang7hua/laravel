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

	//获取博文详细页面url
	static function url($blog)
	{
		return route('detail', ['id'=>$blog->id]);
	}

	//格式化博文数据
	static function format($blogs)
	{
		$cids = array();
		foreach ($blogs as $row) {
			if (in_array($row->cid, $cids))
				continue;
			$cids[] = $row->cid;
		}
		$clist = (new BlogCategory)->whereIn('id', $cids)->get();
		$cnames = array();
		foreach ($clist as $row) {
			$cnames[$row->id] = $row['name'];
		}

		foreach ($blogs as &$blog) {
			//博文详情链接
			$blog->url = self::url($blog);
			$blog->content = htmlspecialchars_decode($blog->content);
			//内容概要
			$blog->summary = self::summary($blog);
			if ($blog->cover and file_exists($blog->cover)) {
				$blog->cover = str_replace(public_path(), '', $blog->cover);
			} else {
				$blog->cover = '';
			}
			//分类名称
			$blog->cname = $cnames[$blog->cid];
			//分类链接
			$blog->curl = route('category', ['cid'=>$blog->cid]);
			$blog->statusname = $blog->status == self::STATUS_OK ? '已发布' : '未发布';
		}
		return $blogs;
	}

	//格式化相关数据
	static function formatOne($blog)
	{
		return self::format(array($blog))[0];
	}

	//通过key判断是否已存在
	static function keyexist($key)
	{
		$list = self::where('key', '=', $key)->get();
		return count($list);
	}

	//获取博文的摘要
	static function summary($blog)
	{
		if (!empty($blog->summary))
			return $blog->summary;
		return mb_substr(strip_tags($blog->content), 0, 100, 'utf-8');
	}

	//评论数修改
	static function incComment($id)
	{
		$ins = self::query()->find($id);
		$ins->comment_count++;
		return $ins->save();
	}
}
