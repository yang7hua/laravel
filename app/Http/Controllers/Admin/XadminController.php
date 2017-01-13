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

}
