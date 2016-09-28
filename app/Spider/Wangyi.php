<?php
#163
namespace App\Spider;

use \Curl\Curl;
use \SimpleHtmlDom\simple_html_dom;

use App\Blog;
use App\Tag;
use App\BlogFrom;
use App\BlogFromConfig;
use App\BlogCategory;

class Wangyi extends Spider
{
	public function run()
	{
		static $count = 0;
		echo date('Ymd Hi')." cid {$this->config->cid}, 163 start:\n";
		do {
			$p = 1;
			$count += $this->_list($p);
			$p++;
		} while ($count < $this->config->daily_count and $count and $p <= 10);
	}

	private function _list($p = 1)
	{
		$curl = new Curl();
		if ($p <= 1) {
			$url = $this->config->url;
		} else {
			if ($p < 10)
				$p = '0'.$p;
			$url = 'http://tech.163.com/special/0009rt/tech_hlw_'.$p.'.html';
		}
		$res = $curl->get($url);
		$html = new simple_html_dom($res);
		$curl->close();

		$M = new Blog();
		$count = 0;

		$list = $html->find('.newsList li');
		foreach ($list as $row) { 
			$blog = [
				'cid' => $this->config->cid,
				'fid' => $this->config->fid,
				'key' => md5($row->find('.titleBar a', 0)->href),
				'title' => $row->find('.titleBar a', 0)->plaintext,
				'summary' => $row->find('.newsDigest p', 0)->plaintext,
				'content' => '',
				'posttime' => $row->find('.sourceDate', 0)->plaintext,
				'furl' => $row->find('.titleBar a', 0)->href,
				'status' => Blog::STATUS_OK,
			];
			$blog['summary'] = str_replace('[阅读更多]', '', $blog['summary']);
			$posttime = explode(' ', $blog['posttime']);
			array_shift($posttime);
			$blog['posttime'] = strtotime(implode(' ', $posttime));

			if ($M->keyexist($blog['key']))
				continue;

			$detail = $this->detail($blog['furl']);
			$blog['content'] = $detail['content'];
			$blog['cover'] = $detail['cover'];

			if (empty($blog['content']))
				continue;
			$blog['content'] = preg_replace('/<iframe .*<\/iframe>/', '', $blog['content']);
			$blog['content'] = htmlspecialchars($blog['content']);

			if ($blog['cover']) {
				$blog['cover'] = $this->download($blog['cover'], 'kr');
			}	

			$id = $M->insertOne($blog);
			if (!$id)
				continue;

			(new BlogCategory)->incCount($this->config->cid);
			(new BlogFrom)->incCount($this->config->fid);

			//$tags = $row['tag_list'];
			//(new Tag)->updateTag($id, $tags);

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
		$res = iconv('gb2312', 'utf-8//ignore', $res);
		$html = new simple_html_dom($res);
		$curl->close();

		$cover = '';
		$coverobj = $html->find('.f_center img', 0);
		if ($coverobj)
			$cover = $html->find('.f_center img', 0)->src;
		$content = $html->find('.post_text', 0)->innertext;
		$html->clear();

		return array(
			'content' => $content,
			'cover' => $cover
		);
	}
}
