<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator,Input,DB;

class UserController extends Controller
{
    //
	public function login(Request $request)
	{
		if ($request->method() == 'POST') {
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
				$result = array(
					'status' => 0,
					'errors' => $validator->errors()->all()
				);
			} else {
				$info = DB::table('user')->where('username', $request->input('account'))->first();
				if (empty($info) or $info->password != $this->mkpwd($request->input('password'))) {
					$result = array(
						'status' => 0,
						'errors' => array('账号不存在或密码错误'),
					);
				} else {
					session('user', $info);
					$result = array(
						'status' => 1,
						'info' => '登录成功'
					);
					return redirect('/');
				}
			}

			return view('user.login', array('result'=>$result));
		}
		return view('user.login');
	}

	public function reg(Request $request)
	{
		return view('user.reg');
	}
}
