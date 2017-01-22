@extends('layout.main')
@section('title', 'SIGN IN')

@section('content')
<!--<img class="bg" src="/images/site/bg-login.jpg">-->
<div class="container">
<div class="col-lg-3"></div>
<div class="col-lg-6" id="login">
<form action="{{url('login')}}" method="post" class="form-horizontal" role="form" init=0 name="login" AUTOCOMPLETE="OFF">
{{csrf_field()}}
<div class="panel panel-default">
	<div class="panel-heading">@lang('label.loginin title')</div>
	<div class="panel-body">
	<br/>
	<div class="form-group">
		<label class="col-lg-3 control-label">@lang('label.your account')</label>
		<div class="col-lg-8">
		<input type="text" data-toggle="tooltip" data-placement="bottom" title="" class="form-control" name="account" placeholder="">
		</div>
	</div>
	<br/>
	<div class="form-group">
		<label class="col-lg-3 control-label">@lang('label.your password')</label>
		<div class="col-lg-8">
		<input type="password" class="form-control" name="password" data-toggle="tooltip" data-placement="bottom" title="" placeholder="">
		</div>
	</div>
	<br/>
	<div class="form-group">
		<label class="col-lg-3 control-label">@lang('label.captcha')</label>
		<div class="col-lg-5">
			<input type="text" name="captcha" class="form-control" data-toggle="tooltip" data-placement="bottom">
		</div>
		<div class="col-lg-3">
		<img src="{{url('/image/captcha')}}" class="captcha">	
		</div>
	</div>
	<br/>
@if (isset($result))
@if ($result['status'] < 1)
	<div class="msg-block-error">
@foreach ($result['errors'] as $error)
	<p>* {{$error}}</p>
@endforeach
	</div>
@endif
@endif
	<button type="submit" submit="login" submit-ok="login" class="btn btn-primary">@lang('label.login')</button>
	<div class="oinfo">
		<a href="{{url('reg')}}">@lang('label.signup')</a>
	</div>
	</div>
</div>
</form>
</div>
</div>
<style>
.header{position:fixed; z-index:999;}
img.bg{
	/*filter:blur(3px);
	-webkit-filter:blur(10px);*/
	position:absolute;
	bottom:0;
	z-index:-1;
}
#footer{position:fixed; bottom:0; width:100%;}
</style>
@endsection
