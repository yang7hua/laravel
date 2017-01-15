<!--with same cateogry's blog-->
<div class="box">
	<h5>{{$detail->cname}}<a href="{{$detail->curl}}">more+</a></h5>
	<ul>
	@foreach ($similar as $row)
		<li><a href="{{$row->url}}">{{$row->title}}</a></li>
	@endforeach
	</ul>
</div>
<div class="box">
	<h5>编程语言<a>more+</a></h5>
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
