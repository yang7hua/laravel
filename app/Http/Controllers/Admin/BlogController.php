<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Blog;
use App\BlogCategory;

class BlogController extends XadminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if ($request->ajax()) {
			$list = (new Blog)->orderBy('addtime', 'desc')
				->paginate(12);
			return $this->ajaxReturn(view('admin.blog.list', array(
				'list' => $list,
			))->render());
		}

		return view('admin.blog.index', array(
			'_module_name' => 'blog',
			'_action_name' => 'index',
			'links' => $this->menus('blog'),
		));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		if ($request->ajax()) {
		}
		$categories = (new BlogCategory)->tree();
		//$this->getRouter()->current()->getActionName();
		return view('admin.blog.create', array(
			'_module_name' => 'blog',
			'_action_name' => 'create',
			'links' => $this->menus('blog'),
			'categories' => $categories
		));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
