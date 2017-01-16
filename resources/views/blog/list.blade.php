@extends('layout.main')	
@section('title', 'Welcome')
@section('content')
<div page="welcome">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8">	
				<h1>@lang('label.newest')</h1>
				@include('blog.tpl.list')	
				<?php echo $list->render();?>
			</div>
			<div class="col-lg-4 col-md-4">
			</div>
		</div>
	</div>
</div>
@endsection
