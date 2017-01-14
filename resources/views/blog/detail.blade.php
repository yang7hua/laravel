@extends('layout.main')
@section('title', $detail->title)
@section('keywords', $detail->keywords)
@section('description', trim($detail->summary))
@section('content')
<div page="detail">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-9">
				<h1>{{$detail->title}}</h1>
				<div class="blog-info">
				@if ($detail->cname)
				<a href="/c/{{$detail->cid}}">{{$detail->cname}}</a>
				@endif
				@if ($detail->from)
				来自&nbsp;<a href="{{$detail->from->domain}}" target="_blank">{{$detail->from->name}}</a>
				@endif
				&nbsp;&nbsp;{{date('n/j H:i', $detail->posttime)}}
				</div>
				<div class="blog-content">
				@if ($detail->cover)
				@endif
				{!!$detail->content!!}
				</div>
				<div class="blog-moreinfo">
				@if ($detail->furl)
					原文&nbsp;<a target="_blank" href="{{$detail->furl}}">{{$detail->furl}}</a>
				@endif
				</div>
			</div>
		</div>	
	</div>
</div>
@endsection
