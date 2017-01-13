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
		<td>{{$row->title}}</td>
		<td>{{$row->cid}}</td>
		<td>{{@date('y/m/d H:i', $row->addtime)}}</td>
		<td>{{@date('y/m/d H:i', $row->posttime)}}</td>
		<td>{{@date('y/m/d H:i', $row->uptime)}}</td>
		<td>{{$row->status}}</td>
		<td>{{$row->is_ding ? '是' : '否'}}</td>
		<td>{{$row->view_count}}</td>
		<td>{{$row->comment_count}}</td>
	</tr>
	@endforeach
</table>
<?php echo $list->render(); ?>
