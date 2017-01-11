<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SysController extends XadminController
{
	public function getMenus()
	{
		$menus = array(
			array('text' => '仪表盘', 'link' => $this->url('sys/dashboard')),
			array('text' => '网站设置', 'link' => $this->url('sys/setting')),
			array('text' => '文章分类', 'link' => $this->url('blogcategory')),
			array('text' => '添加文章分类', 'link' => $this->url('blogcategory/create')),
		);
		return $this->ajaxReturn($menus);
	}

	//仪表盘页面
	public function getDashboard()
	{
		$tpl = view('admin.sys.dashboard');
		return $this->ajaxReturn($tpl->render());
	}
}
