<!--with same cateogry's blog-->
<div class="box">
	<h5>{{$detail->cname}}<a title="more similar" href="{{$detail->curl}}">more+</a></h5>
	<ul>
	@foreach ($similar as $row)
		<li><a href="{{$row->url}}">{{$row->title}}</a></li>
	@endforeach
	</ul>
</div>
