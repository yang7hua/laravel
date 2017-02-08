@foreach ($comments as $comment)
<div class="comment" id="comment-{{$comment->id}}" comment-id="{{$comment->id}}">	
	<h5><span class="comment-uname">{{$comment->uname}}</span>:</h5>
	<div class="comment-content">{!! $comment->content !!}</div>
	<p class="comment-info">
		{{\Helper\formatTime(strtotime($comment->posttime))}}
		&nbsp;|&nbsp;<a href="#" func="comment_approve" func-param="{{$comment->id}}">approve</a> 
		(<span class="comment-approve">{{$comment->approve}}</span>)
		&nbsp;|&nbsp;<a href="#" func="comment_reply" func-param="{{$comment->id}}">quote</a>
	</p>
</div>
@endforeach
