<?php
namespace Helper;
/**
 * composer.json autoload.files
 * composer dump-autoload
 * 通用方法
 * blade中可以直接用 {{\Func\func()}} 调用
 */

class Ueditor
{
	public function __construct()
	{
	}
	
	public function show()
	{
		$script = '<script id="ue-container" name="content" type="text/plain"></script>';
		$script .= '<script type="text/javascript" src="/ueditor/ueditor.config.js"></script>';
		$script .= '<script type="text/javascript" src="/ueditor/ueditor.all.min.js"></script>';
		$script .= '<script type="text/javascript">'
				.'var ue = UE.getEditor("ue-container");'
				.'</script>';
		echo $script;
	}
}
