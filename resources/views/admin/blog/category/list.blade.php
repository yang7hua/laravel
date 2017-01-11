<button type="button" menu-link="{{$url['add']}}" class="btn btn-link">
	添加分类 <span class="glyphicon glyphicon-plus-sign"></span>
</button>
<table class="table table-striped">
	<tr><th>编号</th><th>名称</th><th>父分类名称</th><th>文章数</th></tr>
	@foreach ($list as $row)
	<tr><td>{{$row->id}}</td><td>名称</td><td>父分类名称</td><td>文章数</td></tr>
	@endforeach
</table>
