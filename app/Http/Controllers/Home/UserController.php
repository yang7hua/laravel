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
				return $this->error(null, $validator->errors());
			} else {
				$info = DB::table('user')->where('username', $request->input('account'))->first();
				if (empty($info) or $info->password != $this->mkpwd($request->input('password'))) {
					return $this->error(null, array('account'=>'账号不存在或密码错误'));
				} else {
					session('user', $info);
					return $this->success('登录成功', array('url'=>route('home')));
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
