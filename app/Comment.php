<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = 'comment';

	const DELETED_AT = null;
	const UPDATED_AT = 'uptime';
	const CREATED_AT = 'posttime';

	const STATUS_OK  = 1; //显示
	const STATUS_NO  = 0; //待审核
	const STATUS_DELETED = 5; //已删除

	public function fromDateTime($value)
	{
		return strtotime(parent::fromDateTime($value));
	}

	static public function findByBid($bid)
	{
		return self::where('bid', $bid)->orderBy('id', 'asc')->get();
	}
}
