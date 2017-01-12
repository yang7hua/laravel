<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SysController extends XadminController
{
	public function getMenus()
	{
		return $this->ajaxReturn($this->menus());
	}

	//仪表盘页面
	public function getDashboard()
	{
		$tpl = view('admin.sys.dashboard');
		return $this->ajaxReturn($tpl->render());
	}
}
