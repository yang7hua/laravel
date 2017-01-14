<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function mkpwd($password)
	{
		return \App\Lib\Func::mkpwd($password);
	}

	protected function ajaxReturn($data, $msg = '', $no = 0)
	{
		return response()->json(array(
			'status' => $no,
			'msg' => $msg,
			'data' => $data
		));
	}

	protected function error($msg, $data = array(), $no = 1)
	{
		return $this->ajaxReturn($data, $msg, $no);
	}

	protected function success($msg, $data = array(), $no = 0)
	{
		return $this->ajaxReturn($data, $msg, $no);
	}

}
