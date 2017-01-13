@extends('layout.admin')
@section('title', '文章')

@section('content')
<div id="blog" 
	page-url="{{@url('xadmin/blog')}}"
	page-target="#blog"
	page-page=1
	page-load-success-func=""
>
</div>
@endsection
