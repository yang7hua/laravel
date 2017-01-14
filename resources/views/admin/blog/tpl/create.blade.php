<form role="form" name="blog-create" action="{{url('xadmin/blog')}}">
<input type="hidden" name="_token" value="{{csrf_token()}}"/>
<div class="col-lg-8">
<div class="form-group">
	<label for="title">标题</label>
	<input data-toggle="tooltip" title="" type="text" name="title" class="form-control" placeholder="Enter title">
</div>
<br/>
<div class="form-group">
	<label for="content">内容</label>
	<?php (new \Helper\ueditor())->show() ?>
</div>
</div>

<div class="col-lg-4">
<div class="form-group">
	<label for="cid">文章分类</label>
	<div class="row">
	<div class="col-lg-8">
	<select name="cid" title="" class="form-control">
	@foreach ($categories as $category)
		<option value="{{$category['id']}}">{{$category['name']}}</option>
		@if (!empty($category['children']))
			@foreach ($category['children'] as $child)
				<option value="{{$child['id']}}">—— {{$child['name']}}</option>
			@endforeach
		@endif
	@endforeach
	</select>
	</div>
	</div>
</div>
<br/>
<div class="form-group">
	<label for="tag">标签</label>
	<input type="text" class="form-control" data-toggle="tooltip" title="" name="tag" placeholder="Enter tags">
	<span class="help-block">多个用空格分隔</span>
</div>
<br/>
<button submit="blog-create"  type="submit" class="btn btn-primary">发布</button>
</div>
</form>
