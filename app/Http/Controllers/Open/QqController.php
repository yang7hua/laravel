<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QqController extends Controller
{
	private $API = null;

	public function __construct()
	{
		$file_api = app_path().'/Open/qq/API/qqConnectAPI.php';
		include $file_api;
		$this->API = new \QC();
	}

	public function login()
	{
		$this->API->qq_login();
	}

	public function callback(Request $request)
	{
		$res = $this->API->qq_callback();
		print_r($res);
	}
}
