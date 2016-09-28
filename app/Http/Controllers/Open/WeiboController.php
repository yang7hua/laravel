<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WeiboController extends Controller
{
	private $API = null;

	public function __construct()
	{
		include app_path().'/Open/libweibo/config.php';
		$file_api = app_path().'/Open/libweibo/saetv2.ex.class.php';
		include $file_api;
		$this->API = new \SaeAuthV2(WB_AKEY, WB_SKEY);
	}

	public function login()
	{
		echo $url = $this->API->getAuthorizeURL(WB_CALLBACK_URL);
	}

	public function callback(Request $request)
	{
	}
}
