<!DOCTYPE html>
<html>
<head>
<title>@yield('title') - 控制台</title>
<link rel="stylesheet" type="text/css" href="/css/admin.css">
<script type="text/javascript" src="/js/lib/jquery-1.11.1.min.js"></script>
<script>
var _MODULE_NAME = '{{$_module_name}}';
</script>
</head>
<body class="admin">
<div class="container-fluid">
	<div class="row">
		<div id="dashboard-left">
			<div class="menubox"></div>
		</div>
		<div id="dashboard-right">
			<div id="dashboard-top">
				<ul id="dashboard-top-sublinks">
				@if (isset($links))
				@foreach ($links as $link)
				@if (isset($link['action']) and $link['action'] == $_action_name)
					<li class="on" menu-link="{{$link['link']}}">{{$link['text']}}</li>
				@else
					<li menu-link="{{$link['link']}}">{{$link['text']}}</li>
				@endif
				@endforeach
				@endif
				</ul>
			</div>
			<div id="dashboard-main">
