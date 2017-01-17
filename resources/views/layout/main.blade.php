@include('common/header')	
	<div class="header">
		<div class="top">
			<div class="container">
			<div class="row">
			<nav class="collapse navbar-collapse " role="navigation">
				<div class="navbar-header">  
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  
					data-target="#navbar" aria-expanded="false" aria-controls="navbar">  
					<span class="sr-only"></span>  
					<span class="icon-bar"></span>  
					<span class="icon-bar"></span>  
					<span class="icon-bar"></span>  
					</button>  
			    	<ul class="nav navbar-nav">
						<li><a href="/" class="current">@lang('links.home')</a></li>
					</ul>
				</div>  
				<div id="navbar" class="navbar-collapse collapse">  
					<ul class="nav navbar-nav navbar-right">
						<li><a href="/login">@lang('links.login')</a></li>
					</ul>
				</div> 
			</nav>
			</div>
			</div>
		</div>	
	</div>
@yield('content')
@include('common/footer')	
