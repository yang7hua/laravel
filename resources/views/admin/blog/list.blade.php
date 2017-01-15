<table class="table table-striped">
	<tr>
		<th>编号</th>
		<th>标题</th>
		<th>分类</th>
		<th>添加时间</th>
		<th>发布时间</th>
		<th>修改时间</th>
		<th>状态</th>
		<th>置顶</th>
		<th>阅读</th>
		<th>评论</th>
	</tr>
	@foreach ($list as $row)
	<tr>
		<td>{{$row->id}}</td>
		<td><a href="{{$row->url}}" target="_blank">{{$row->title}}</a></td>
		<td>{{$row->cname}}</td>
		<td>{{$row->addtime}}</td>
		<td>{{@date('Y-m-d H:i:s', $row->posttime)}}</td>
		<td>{{$row->uptime}}</td>
		<td>{{$row->statusname}}</td>
		<td>{{$row->is_ding ? '是' : '否'}}</td>
		<td>{{$row->view_count}}</td>
		<td>{{$row->comment_count}}</td>
	</tr>
	@endforeach
</table>
<?php echo $list->render(); ?>
