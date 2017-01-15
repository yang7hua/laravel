<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input, Validator, Captcha, DB;
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
			$list = (new Blog)->orderBy('id', 'desc')
				->paginate(12);
			return $this->ajaxReturn(view('admin.blog.list', array(
				'list' => \App\Blog::format($list),
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
		$rules = [
			'title' => 'required',
			'cid' => 'required|numeric',
			'content' => 'required',
			'tag' => 'regex:/^[^~!@#$%^&\*()]*$/'
		];
		$messages = [
			'title.required' => '请输入标题',
			'content.required' => '请输入内容',
			'cid.required' => '请选择分类',
			'cid.numeric' => '分类格式不正确',
			'tag.regex' => '标签格式不正确',
		];
		$validator = Validator::make(Input::all(), $rules, $messages);
		if ($validator->fails()) {
			return $this->error('失败', $validator->errors());
		}

		DB::beginTransaction();
		$flag = true;

		$Blog = new Blog();
		$Blog->title = $request->input('title');
		$Blog->content = htmlspecialchars($request->input('content'));
		$Blog->cid = $request->input('cid');
		$tags = trim($request->input('tag'));
		$tags = str_replace(' ', '#', $tags);
		$Blog->tags = $tags;
		$Blog->posttime = time();

		$id = $Blog->save();
		if (!$id) {
			$flag = false;
		} else {
			$tags = explode('#', $tags);
			if (!empty($tags)) {
				if (!(new \App\Tag)->updateTag($id, $tags))
					$flag = false;
			}
			if ($flag) {
				if (!\App\BlogCategory::incCount($Blog->cid))
					$falg = false;
			}
		}

		if ($flag) {
			DB::commit();
			return $this->success('操作成功');
		}
		DB::rollback();
		return $this->error('操作失败');
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
