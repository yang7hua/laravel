@extends('layout.main')
@section('title', 'login')

@section('content')
<img class="bg" src="/images/site/bg-login.jpg">
<div id="login">
<form action="{{url('login')}}" method="post" init=0 method="post" AUTOCOMPLETE="OFF">
{{csrf_field()}}
<div class="panel panel-default">
	<div class="panel-heading">登录到 iwebfox</div>
	<div class="panel-body">
	<div class="form-group">
		<input type="text" name="account" class="input {required:true}" placeholder="账号" value="{{@$_REQUEST['account']}}">
	</div>
	<div class="form-group">
		<input type="password" name="password" class="input {required:true}" placeholder="密码">
	</div>
	<div class="form-group">
		<input type="text" name="captcha" class="input {required:true}" placeholder="验证码">
		<img src="{{url('/image/captcha')}}" class="captcha">
	</div>
@if (isset($result))
@if ($result['status'] < 1)
	<div class="form-group msg-block-error">
@foreach ($result['errors'] as $error)
	<p>* {{$error}}</p>
@endforeach
	</div>
@endif
@endif
	<button type="submit" submit-type="ajax" class="btn btn-primary">登录</button>
	<div class="form-group oinfo">
		<a href="{{url('reg')}}">立即注册</a>
	</div>
	</div>
</div>
</form>
</div>
<style>
body{
	padding-top:170px;
	overflow:hidden;
}
img.bg{
	filter:blur(3px);
	-webkit-filter:blur(10px);
	position:absolute;
	bottom:0;
	z-index:-1;
}
</style>
@endsection
