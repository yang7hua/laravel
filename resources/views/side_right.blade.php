<div class="box">
	<h5>编程语言<a>@lang('label.more')</a></h5>
	<ul>
		<li><a>PHP抽象类</a></li>
		<li><a>PHP MSSQL 分页实例(刷新)</a></li>
		<li><a>Swift开发第九篇——Any和AnyObject&amp;typealias和泛型接口</a></li>
		<li><a>Swift中的部分更新与旧版的区别</a></li>
		<li><a>PHP抽象类</a></li>
	</ul>
</div>
<div class="box">
	<h5>数据库</h5>
	<ul>
		<li><a>PHP抽象类</a></li>
		<li><a>PHP MSSQL 分页实例(刷新)</a></li>
		<li><a>Swift开发第九篇——Any和AnyObject&amp;typealias和泛型接口</a></li>
		<li><a>Swift中的部分更新与旧版的区别</a></li>
		<li><a>PHP抽象类</a></li>
	</ul>
</div>
<div class="box">
	<h5>New comments<a href="{{url('comment')}}">@lang('label.more')</a></h5>
	<ul>
	@foreach ($comments as $comment)
		<li>{{$comment->uname}}: <a href="{{$comment->url}}">{{mb_substr(strip_tags($comment->content), 0, 30)}}</a></li>
	@endforeach
	</ul>
</div>
