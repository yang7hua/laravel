@extends('layout.base')
@section('title', 'login')

@section('content')
<div id="login">
<form action="{{url('xadmin/login')}}" method="post">
{{csrf_field()}}
<div class="panel panel-default">
	<div class="panel-heading">管理员登录</div>
	<div class="panel-body">
	<div class="form-group">
		<label>账号</label>
		<div>
		<input type="text" name="account" class="form-control {required:true}" placeholder="账号">
		<span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
		<label>密码</label>
		<div>
		<input type="password" name="password" class="form-control {required:true}" placeholder="密码">
		<span class="help-block"></span>
		</div>
	</div>
	<div class="form-group">
		<label>验证码</label>
		<br/>
		<div>
		<input type="text" name="captcha" class="form-control {required:true}" placeholder="验证码">
		<img src="{{url('/image/captcha')}}" class="captcha">
		<span class="help-block"></span>
		</div>
	</div>
	<button type="submit" submit-type="ajax" class="btn btn-primary">登录</button>
	</div>
</div>
</form>
</div>
@endsection
