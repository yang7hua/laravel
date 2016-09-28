@extends('layout.main')	
@section('title', 'Welcome')
@section('content')
<div page="welcome">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-8">	
				<h1>最新</h1>
				@foreach ($newlist as $row)
				<div class="list">
					<a class="title" href="{{$row->url}}">{{$row->title}}</a>
					<div class="summary">
					{{$row->summary}}
					</div>
					<p class="info">
						<a href="/f/{{$row->fid}}">{{$blog_from[$row->fid]->name}}</a>
						&nbsp;&nbsp;<span>{{date('n/j H:i', $row->posttime)}}</span>
					</p>
				</div>
				@endforeach
			</div>
			<div class="col-lg-5 col-md-4">
				@include('side_right')
			</div>
		</div>
	</div>
</div>
@endsection
