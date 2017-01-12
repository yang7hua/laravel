<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class XadminController extends Controller
{
	protected function url($url)
	{
		return '/xadmin/'.trim($url, '/');
	}

	public function menus($module = null)
	{
		$menus = array(
			array('text' => '设置', 'module'=>'index', 'icon'=>'cog', 'link' => $this->url('')),
			array('text' => '文章', 'module'=>'blog', 'icon'=>'list', 'link' => $this->url('blog'), 
				'children' => array(
					array('text'=>'列表', 'action'=>'index', 'icon'=>'', 'link'=>$this->url('blog')),
					array('text'=>'新增', 'action'=>'create', 'icon'=>'add', 'link'=>$this->url('blog/create')),
					array('text'=>'分类', 'icon'=>'', 'link'=>$this->url('blogcategory')),
					array('text'=>'新增分类', 'icon'=>'add', 'link'=>$this->url('blogcategory/create')),
				)),
		);
		if (!is_null($module)) {
			foreach ($menus as $menu) {
				if ($menu['module'] == $module)
					return $menu['children'];
			}
		}
		return $menus;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
