@foreach ($comments as $comment)
<div class="comment">	
	<h5>{{$comment->uname}}:</h5>
	<div class="comment-content">{{$comment->content}}</div>
	<p class="comment-info">
		{{$comment->posttime}}
	</p>
</div>
@endforeach
