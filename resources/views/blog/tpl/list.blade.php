				@foreach ($list as $row)
				<div class="list">
					<a class="title" title="{{$row->title}}" href="{{$row->url}}">{{$row->title}}</a>
					<div class="summary">
					{{$row->summary}}
					</div>
					<p class="info">
					@if ($row->cname)
						<a href="{{$row->curl}}">{{$row->cname}}</a>
					@endif
					@if ($row->fid)
						{{$row->fname}}
					@endif
					@if ($row->comment_count)
						&nbsp;&nbsp;<a href="{{$row->url}}#comments">comment ({{$row->comment_count}})</a>
					@endif
						&nbsp;&nbsp;<span>{{\Helper\formatTime($row->posttime)}}</span>
					</p>
				</div>
				@endforeach
