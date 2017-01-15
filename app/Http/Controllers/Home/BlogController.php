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
			'similar' => \App\Blog::format($similar)
		));
	}

	public function listbycategory($cid)
	{

	}
}
