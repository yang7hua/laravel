<?php
#36kr
namespace App\Spider;

use \Curl\Curl;
use \SimpleHtmlDom\simple_html_dom;

use App\Blog;
use App\Tag;
use App\BlogFrom;
use App\BlogFromConfig;
use App\BlogCategory;

class Cnblogs extends Spider
{
	public function run()
	{
		static $count = 0;
		echo date('Ymd Hi')."cid {$this->config->cid}, fid {$this->config->fid} start:\n";
		do {
			$p = 1;
			$count += $this->_list($p, $this->config->daily_count - $count);
		} while ($count < $this->config->daily_count and $count);
	}

	private function _list($p = 1, $max_count = 10)
	{
		$curl = new Curl();
		if ($p > 1) {
			$res = $curl->get($this->config->url.'#p'.$p);
		} else {
			$res = $curl->get($this->config->url);
		}
		$html = new simple_html_dom($res);
		$curl->close();
		$list = $html->find('.post_item_body');
		$blogs = array();

		$last_posttime = $this->config->last_posttime;
		$now_max_posttime = 0;
		$M = new Blog();

		$count = 0;
		foreach ($list as $row) {
			if ($count >= $max_count)
				break;
			$a = $row->find('.titlelnk', 0);
			$furl = $a->href;
			$title = $a->plaintext;
			$detail = $this->detail($furl);
			$summary = $row->find('.post_item_summary', 0)->plaintext;
			if (empty($detail))
				continue;
			$blog = [
				'cid' => $this->config->cid,
				'fid' => $this->config->fid,
				'title' => $title,
				'summary' => $summary,
				'content' => htmlspecialchars($detail['content']),
				'posttime' => strtotime($detail['posttime']),
				'addtime' => time(),
				'uptime' => time(),
				'furl' => $furl,
				'status' => Blog::STATUS_OK,
			];
			//这里的抓取是posttime从大到小的顺序,第一篇文章的发布时间小于上一次抓取的最新发表时间,说明已过时,则跳出
			if ($blog['posttime'] <= $last_posttime)
				break;
			//echo "<br/>",$blog['posttime'],"<br/>",$last_posttime;
			//break;
			$tags = $detail['tags'];

			$id = $M->insertOne($blog);
			if (!$id)
				continue;
			(new Tag)->updateTag($id, $tags);
			(new BlogCategory)->incCount($this->config->cid);
			(new BlogFrom)->incCount($this->config->fid);

			if ($blog['posttime'] > $now_max_posttime) {
				$now_max_posttime = $blog['posttime'];
				(new BlogFromConfig)->updateLastPosttime($this->config->id, $now_max_posttime);
			}
			echo $id." ok\n";
			$count++;
		}
		$html->clear();

		return $count;
	}

	private function detail($url)
	{
		$detail = array();
		$curl = new Curl();
		$curl->error(function($ins) {
			echo $ins->errorMessage;
		});
		$res = $curl->get($url);
		$html = new simple_html_dom($res);
		$curl->close();

		$detail = array(
			'content' => $html->find('#cnblogs_post_body', 0)->innertext,
			'tags' => [],
			'posttime' => time(),
		);
		if ($posttime = $html->find('#post-date', 0)) {
			$detail['posttime'] = $posttime->plaintext;
		}
		$tags = $html->find('#EntryTag', 0);
		if (!empty($tags->children)) {
			foreach ($tags->children as $a) {
				$tag = $a->plaintext;
				$detail['tags'][] = $tag;
			}
		}
		$html->clear();
		return $detail;
	}
}
