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

class Kr extends Spider
{
	public function run()
	{
		static $count = 0;
		echo date('Ymd Hi')." cid {$this->config->cid}, fid {$this->config->fid} start:\n";
		do {
			$count += $this->_list($this->config->daily_count - $count);
		} while ($count < $this->config->daily_count and $count);
	}

	private function _list($max_count = 10)
	{
		static $url_code = null;

		$count = 0;
		$last_posttime = $this->config->last_posttime;
		$now_max_posttime = 0;

		$curl = new Curl();
		if (is_null($url_code)) {
			$res = $curl->get($this->config->url);
			$html = new simple_html_dom($res);
			$curl->close();
			$key = 'data-props';
			$data = $html->find('.js-react-on-rails-component', 0)->$key;
			$data = htmlspecialchars_decode($data);
			$feed_posts = json_decode($data, true)['data']['feed_posts'];
			$html->clear();
		} else {
			$url = $this->config->url . '/asynces/posts/info_flow_post_more.json?'.$url_code;
			$res = $curl->get($url);
			$feed_posts = json_decode($res, true)['data']['feed_posts'];
			$curl->close();
		}

		$M = new Blog();

		foreach ($feed_posts as $row) { 
			if (!isset($row['url_code']))
				continue;
			if (is_null($url_code) or $row['url_code'] < $url_code)
				$url_code = $row['url_code'];
			$blog = [
				'cid' => $this->config->cid,
				'fid' => $this->config->fid,
				'title' => $row['title'],
				'summary' => $row['plain_summary'],
				'content' => $this->detail($this->config->url.'/p/'.$row['url_code'].'.html'),
				'posttime' => strtotime($row['created_at']),
				'furl' => rtrim($this->config->url, '/').'/p/'.$row['url_code'].'.html',
				'status' => Blog::STATUS_OK,
			];
			$blog['key'] = md5($blog['furl']);
			//这里的抓取是posttime从大到小的顺序,第一篇文章的发布时间小于上一次抓取的最新发表时间,说明已过时,则跳出
			if ($blog['posttime'] <= $last_posttime)
				break;

			if ($M->keyexist($blog['key']))
				continue;

			if (empty($blog['content']))
				continue;
			$blog['content'] = htmlspecialchars($blog['content']);

			if ($row['cover']) {
				$blog['cover'] = $this->download($row['cover'], 'kr');
			}	

			$id = $M->insertOne($blog);
			if (!$id)
				continue;

			(new BlogCategory)->incCount($this->config->cid);
			(new BlogFrom)->incCount($this->config->fid);

			if (isset($row['tag_list'])) {
				$tags = $row['tag_list'];
				(new Tag)->updateTag($id, $tags);
			}

			if ($blog['posttime'] > $now_max_posttime) {
				$now_max_posttime = $blog['posttime'];
				(new BlogFromConfig)->updateLastPosttime($this->config->id, $now_max_posttime);
			}
			$count++;
		}

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
		$key = 'data-props';
		$data = $html->find('.js-react-on-rails-component', 0)->$key;
		$data = htmlspecialchars_decode($data);
		$html->clear();

		$data = json_decode($data, true);
		if ($data['status']['code'] != 200)
			return false;

		return $data['data']['post']['display_content'];
	}
}
