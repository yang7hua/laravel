<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input, Validator, Captcha, DB;
use Session;

class IndexController extends XadminController
{

    public function dashboard()
    {
		return view('admin.index', array(
			'_module_name' => 'index',
		));
    }

	public function login(Request $request)
	{
		if ($request->ajax()) {
			$rules = [
				'account' => 'required|alpha_dash',
				'password' => 'required',
				'captcha' => 'required|captcha'
			];
			$messages = [
				'account.required' => '请输入账号',
				'password.required' => '请输入密码',
				'captcha.required' => '请输入验证码',
				'captcha.captcha' => '验证码错误',
			];
			$validator = Validator::make(Input::all(), $rules, $messages);
			if ($validator->fails()) {
				return array(
					'status' => 0,
					'info' => $validator->errors()->first()
				);
			}

			$info = DB::table('xadmin')->where('username', $request->input('account'))->first();
			if (empty($info) or $info->password != $this->mkpwd($request->input('password'))) {
				return array(
					'status' => 0,
					'info' => '账号不存在或密码错误',
				);
			}

			session('xainfo', $info);
			return array(
				'status' => 1,
				'info' => '登录成功'
			);
		}
		return view('admin.login');
	}

	public function logout()
	{
		session('xainfo', null);
		return redirect('/xadmin');
	}

}
