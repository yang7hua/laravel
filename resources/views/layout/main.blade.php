@include('common/header')	
	<div class="header">
		<div class="top">
			<div class="container">
				<ul>
					<li><a href="/" class="current">首页</a></li>
				</ul>
				<ul class="right">
					<li><a href="/login">登录</a></li>
				</ul>
			</div>
		</div>	
	</div>
@yield('content')
@include('common/footer')	
