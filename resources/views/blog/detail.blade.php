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
				<a href="{{$detail->curl}}">{{$detail->cname}}</a>
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

			<div class="col-lg-4">
				@include('side_right2')
			</div>
		</div>	

		<div class="row">
			<div class="col-lg-8" id="comments">
				<h2>Comments ({{$detail->comment_count}})</h2>	
				@include('comment.tpl.list')
			</div>
		</div>

		<div class="row">
			<div class="col-lg-8" id="comment-publish">
				<h2>Post Your Comment</h2>

				<form role="form" class="form-horizontal" name="comment-publish" type="post" action="{{url('comment')}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<input type="hidden" name="id" value="{{$detail->id}}"/>
					<input type="hidden" name="pid" value="0"/>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="title">Content</label>
						<div class="col-lg-8">
						<textarea data-toggle="tooltip" data-placement="right" title="" type="text" name="content" class="form-control" placeholder="Enter Content"></textarea>
						</div>
					</div>
					<br/>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="title">Your Name</label>
						<div class="col-lg-5">
						<input data-toggle="tooltip" data-placement="right" title="" type="text" name="name" class="form-control" placeholder="Enter your name">
						</div>
					</div>
					<br/>
					<div class="form-group">
						<label class="col-lg-2 control-label" for="title">Your Email</label>
						<div class="col-lg-10">
						<div class="row">
						<div class="col-lg-6">
						<input data-toggle="tooltip" data-placement="right" title="" type="email" name="email" class="form-control" placeholder="Enter your email">
						</div>
						</div>
						<span class="help-block">You will receive a email when somebody else reply your comment.</span>
						</div>
					</div>
					<br/>
					<div class="form-group">
						<div class="col-lg-2"></div>
						<div class="col-lg-5">
						<button submit="comment-publish" submit-ok="comment_append" type="submit" class="btn btn-primary">Post Your Comment</button>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/ueditor/third-party/SyntaxHighlighter/shCore.js"></script>
<script>SyntaxHighlighter.all();</script>
@endsection
