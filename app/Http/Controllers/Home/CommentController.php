<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Input, Validator, DB, Session;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$bid = $request->input('bid');
		if ($bid)
			$list = \App\Comment::findByBid($bid);
		else
			$list = (new \App\Comment)->orderBy('id', 'desc')->paginate(20);

		if ($request->ajax()) {
			return $this->ajaxReturn(view('comment.tpl.list', array(
							'comments' => $list,
							))->render());
		}
		return view('comment.list', array(
			'comments' => $list
		));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$rules = [
			'content' => 'required',
			'id' => 'required|numeric',
			'name' => 'required',
			'email' => 'email',
			'pid' => 'numeric'
		];
		$messages = [
			'content.required' => 'Content can not be empty',
			'id.required' => 'Param miss',
			'name.required' => 'Your name can not be empty',
			'email.email' => 'Your email is not correct',
			'pid.numeric' => 'Param error'
		];
		$validator = Validator::make(Input::all(), $rules, $messages);
		if ($validator->fails()) {
			return $this->error(null, $validator->errors());
		}

		//控制评论频率
		$bid = $request->input('id');
		$session_comment = $request->session()->get('comment.post');
		if (isset($session_comment[$bid])) {
			$config = config('comment');
			if (time() - $session_comment[$bid]['time'] < 60
				and $session_comment[$bid]['count'] >= $config['count_per_minute']) {
				return $this->error('comment too often');
			}
		}

		$Comment = new \App\Comment;
		$Comment->bid = $request->input('id');
		if ($request->input('pid'))
			$Comment->pid = $request->input('pid');
		$Comment->uname = $request->input('name');
		$Comment->email = $request->input('email');
		$content = strip_tags($request->input('content'), '<blockquote><quote>');
		$content = str_replace("\r\n", '<br/>', $content);
		$Comment->content = $content;
		$Comment->ip = ip2long($request->getClientIp());
		$Comment->approve = 0;

		DB::beginTransaction();
		$flag = true;

		if ($Comment->save()) {
			if (!\App\Blog::incComment($Comment->bid))
				$flag = false;
			else {
				if ($Comment->pid > 0) {
					//todo send email to pid's email

					//todo add score
				}
			}
		} else {
			$flag = false;
		}

		if ($flag) {
			DB::commit();
			$tpl = view('comment.tpl.list', array(
				'comments' => array($Comment)
			))->render();

			if (!isset($session_comment[$bid])) 
				$session_comment[$bid] = array('time'=>0, 'count'=>0);
			$session_comment[$bid]['time'] = time();
			$session_comment[$bid]['count']++;
			Session::put('comment.post', $session_comment);

			return $this->success('Commit success', $tpl);
		}
		DB::rollback();
		return $this->error('Commit error');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

	public function todo($id, $type)
	{
		if ($type == 'approve') {
			if (\App\Comment::incApprove($id))
				return $this->success();
			return $this->error('try later');
		}
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
