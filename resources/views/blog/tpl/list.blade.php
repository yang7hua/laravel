				@foreach ($newlist as $row)
				<div class="list">
					<a class="title" href="{{$row->url}}">{{$row->title}}</a>
					<div class="summary">
					{{$row->summary}}
					</div>
					<p class="info">
					@if ($row->cname)
						<a href="{{$row->curl}}">{{$row->cname}}</a>
					@endif
					@if ($row->fid)
						<a href="/f/{{$row->fid}}">{{$blog_from[$row->fid]->name}}</a>
					@endif
					@if ($row->comment_count)
						&nbsp;&nbsp;<a href="{{$row->url}}#comments">comment ({{$row->comment_count}})</a>
					@endif
						&nbsp;&nbsp;<span>{{date('n/j H:i', $row->posttime)}}</span>
					</p>
				</div>
				@endforeach
