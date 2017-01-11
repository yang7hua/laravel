@extends('layout.admin')
@section('title', '控制台')
@section('content')
<div class="mini-layout" style="width:100%; height:100%;">
	<div class="header" region="north" height="70" showSplit="false" showHeader="false">
		<h1 style="margin:0;padding:15px;cursor:default;font-family:微软雅黑,黑体,宋体;">后台管理</h1>
		<div style="position:absolute;top:18px;right:10px;">
			<a class="mini-button mini-button-iconTop" iconCls="icon-add" onclick="onQuickClick" plain="true">快捷</a>    
			<a class="mini-button mini-button-iconTop" iconCls="icon-edit" onclick="onClick"  plain="true" >首页</a>        
			<a class="mini-button mini-button-iconTop" iconCls="icon-date" onclick="onClick"  plain="true" >消息</a>        
			<a class="mini-button mini-button-iconTop" iconCls="icon-edit" onclick="onClick"  plain="true" >设置</a>        
			<a class="mini-button mini-button-iconTop" iconCls="icon-close" onclick="onClick"  plain="true" >关闭</a>        
		</div>
	</div>
	<div title="south" region="south" showSplit="false" showHeader="false" height="30" >
		<div style="line-height:28px;text-align:center;cursor:default">Copyright © 2016</div>
	</div>
	<div title="center" region="center" style="border:0;" bodyStyle="overflow:hidden;">
		<!--Splitter-->
		<div class="mini-splitter" style="width:100%;height:100%;" borderStyle="border:0;">
			<div size="180" maxSize="250" minSize="100" showCollapseButton="true" style="border:0;">
				<!--OutlookTree-->
				<div id="leftTree" class="mini-outlooktree" url="" onnodeclick="onNodeSelect"
					textField="text" idField="id" parentField="pid">
				</div>
			</div>
			<div showCollapseButton="false" style="border:0;">
				<!--Tabs-->
				<div id="mainTabs" class="mini-tabs" activeIndex="2" style="width:100%;height:100%;" plain="false">
					<div title="首页" url="" ></div>
				</div>
			</div>        
		</div>
	</div>
</div>
<script>
mini.parse();
</script>
@endsection
