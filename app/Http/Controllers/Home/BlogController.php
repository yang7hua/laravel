<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
	public function detail($id)
	{
		$detail = \App\Blog::format(array(\App\Blog::detail($id)))[0];
		$detail->from = \App\BlogFrom::map()[$detail->fid];
		return view('blog.detail', array(
			'detail' => $detail,
		));
	}
}
