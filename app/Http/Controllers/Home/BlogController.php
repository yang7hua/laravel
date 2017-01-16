<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
	public function detail($id)
	{
		$detail = \App\Blog::formatOne(\App\Blog::detail($id));
		$detail->from = $detail->fid ? \App\BlogFrom::map()[$detail->fid] : '';

		$similar = \App\Blog::where('cid', $detail->cid)
			->where('id', '!=', $detail->id)
			->orderBy('id', 'desc')
			->take(10)->get();
		return view('blog.detail', array(
			'detail' => $detail,
			//相关评论 
			'comments' => \App\Comment::findByBid($id),
			//同分类下的博文
			'similar' => \App\Blog::format($similar),

			'prev' => \App\Blog::formatOne($this->prev($detail)),
			'next' => \App\Blog::formatOne($this->next($detail)),
		));
	}

	public function listbycategory($code)
	{
		if (preg_match('/^\d+$/', $code)) {
			$category = \App\BlogCategory::where('id', $code)->first();
		} else {
			$category = \App\BlogCategory::where('code', $code)->first();
		}
		if (empty($category))
			return redirect(route('home'));

		$cid = $category->id;
	
		$list = \App\Blog::where('cid', $cid)->orderBy('id', 'desc')->paginate(config('website.category.size'));
		$list = \App\Blog::format($list);

		$categories = \App\BlogCategory::get();

		return view('category.index', array(
			'detail' => $category,
			'list' => $list,
			'categories' => \App\BlogCategory::format($categories)
		));
	}

	public function prev($blog)
	{
		return \App\Blog::where('id', '<', $blog->id)
			->where('cid', $blog->cid)
			->select(array('id','title'))
			->orderBy('id', 'desc')
			->first();
	}

	public function next($blog)
	{
		return \App\Blog::where('id', '>', $blog->id)
			->where('cid', $blog->cid)
			->select(array('id','title'))
			->orderBy('id', 'asc')
			->first();
	}

}
