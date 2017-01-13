<form role="form">
<div class="col-lg-8">
<div class="form-group">
	<label for="title">标题</label>
	<input type="text" class="form-control" placeholder="Enter title">
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
	<select name="cid" class="form-control">
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
	<input type="text" class="form-control" name="tag" placeholder="Enter tags">
	<span class="help-block">多个用空格分隔</span>
</div>
</div>
</form>
