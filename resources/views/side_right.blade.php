<?php 
	$all_categories = \App\BlogCategory::format(\App\BlogCategory::get());
?>
<div class="box box-item-float">
	<h5>@lang('label.all_categories')</h5>
	<ul>
		@foreach ($all_categories as $category)
		<li><a title="{{$category->name}}" href="{{$category->url}}">{{$category->name}} ({{$category->count}})</a></li>
		@endforeach
	</ul>
</div>
<div class="box">
	<h5>New comments<a href="{{url('comment')}}" title="more comment">@lang('label.more')</a></h5>
	<ul>
	@foreach ($comments as $comment)
		<li>{{$comment->uname}}: <a href="{{$comment->url}}">{{mb_substr(strip_tags($comment->content), 0, 30)}}</a></li>
	@endforeach
	</ul>
</div>
@foreach ($categories as $category)
<div class="box">
	<h5>{{$category->name}}<a title="{{$category->name}}" href="{{$category->url}}">@lang('label.more')</a></h5>
	<ul>
	@foreach ($category['list'] as $row)
		<li><a title="{{$row->title}}" href="{{$row->url}}">{{$row->title}}</a></li>
	@endforeach
	</ul>
</div>
@endforeach
