<?php

namespace App\Spider;

use Curl\Curl;
use Image;

abstract class Spider
{
	protected $config = null;

	public function __construct($config)
	{
		$this->config = $config;
	}

	abstract function run();

	protected function download($url, $savepath)
	{
		$fname = md5($url.time()).'.'.pathinfo($url, PATHINFO_EXTENSION);
		$path = public_path().'/upload/spider/'.$savepath.'/'.date('Ymd').'/';
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}
		$fname = $path.$fname;
		$curl = new Curl();
		$curl->download($url, $fname);
		$curl->close();

		if (!file_exists($fname))
			return '';
		$rfname = $this->resize($fname);
		unlink($fname);
		return $rfname;
	}

	protected function resize($fname, $width = 320, $height = 200)
	{
		list($dirname, $basename, $extension, $filename) = array_values(pathinfo($fname));
		$img = Image::make($fname);
		$img->resize($width, $height);
		$fname = $dirname.'/'.$filename.'.'.$width.'x'.$height.'.'.$extension;
		$img->save($fname);
		return $fname;
	}

}
