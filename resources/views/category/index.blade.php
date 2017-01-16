@extends('layout.main')	
@section('title', $detail->name)
@section('content')
<div page="welcome">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8">	
				@include('blog.tpl.list')	
				<?php echo $list->render();?>
			</div>
			<div class="col-lg-4 col-md-4">
				<div class="box">
					<h5>@lang('label.all_categories')</h5>
					<ul>
						@foreach ($categories as $category)
						<li><a title="{{$category->name}}" href="{{$category->url}}">{{$category->name}} ({{$category->count}})</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
