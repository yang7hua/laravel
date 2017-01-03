@include('common/header')	
	<div class="header">
		<div class="top">
			<div class="container">
				<ul>
					<li><a href="/" class="current">@lang('links.home')</a></li>
				</ul>
				<ul class="right">
					<li><a href="/login">@lang('links.login')</a></li>
				</ul>
			</div>
		</div>	
	</div>
@yield('content')
@include('common/footer')	
