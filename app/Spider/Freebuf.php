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

class Freebuf extends Spider
{
	public function run()
	{
		//(new Tag)->updateTag(100, ['系统安全','资讯']);
		//exit();
		static $count = 0;
		echo date('Ymd Hi')." cid {$this->config->cid}, freebuf start:\n";
		do {
			$p = 1;
			$ncount = $this->_list($p);
			$count += $ncount;
			$p++;
		} while ($count < $this->config->daily_count and $ncount and $p <= 10);
	}

	private function _list($p = 1)
	{
		$curl = new Curl();
		$url = 'http://www.freebuf.com/page/'.$p;
		$res = $curl->get($url);
		$html = new simple_html_dom($res);
		$curl->close();

		$M = new Blog();
		$count = 0;

		$list = $html->find('.news-list');
		foreach ($list as $row) { 
			$blog = [
				'cid' => $this->config->cid,
				'fid' => $this->config->fid,
				'key' => md5($row->find('.news-info dt a', 0)->href),
				'title' => trim($row->find('.news-info dt a', 0)->plaintext),
				'summary' => trim($row->find('.news-info .text', 0)->plaintext),
				'content' => '',
				'posttime' => strtotime($row->find('.news-info .time', 0)->plaintext),
				'furl' => $row->find('.news-info dt a', 0)->href,
				'status' => Blog::STATUS_OK,
			];

			if ($blog['posttime'] < strtotime(date('Ymd')))
				break;

			if ($M->keyexist($blog['key']))
				continue;

			$tagso = $row->find('.news-info .tags a');
			$tags = array();
			if (count($tagso)) {
				foreach ($tagso as $tag) {
					$tags[] = $tag->plaintext;
				}
			}
			$blog['tags'] = implode('#', $tags);

			$detail = $this->detail($blog['furl']);
			$blog['content'] = $detail['content'];

			if (empty($blog['content']))
				continue;
			$blog['content'] = htmlspecialchars($blog['content']);

			$blog['cover'] = $this->download($row->find('.news-img img', 0)->src, 'freebuf');

			$id = $M->insertOne($blog);
			if (!$id) {
				if (file_exists($blog['cover']))
					unlink($blog['cover']);
				continue;
			}

			(new BlogCategory)->incCount($this->config->cid);
			(new BlogFrom)->incCount($this->config->fid);

			(new Tag)->updateTag($id, $tags);

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
		//$res = iconv('gb2312', 'utf-8//ignore', $res);
		$html = new simple_html_dom($res);
		$curl->close();

		$cover = '';
		$content = $html->find('#contenttxt', 0)->innertext;
		$content = preg_replace('/<blockquote>.*<\/blockquote>/', '', $content);
		$content = preg_replace('/<h2>.*<\/h2>/', '', $content);
		//noscript
		/*
		$noscript = preg_match_all('/<noscript>[^<]*<img\s+alt="([^"]*)"\s+src="([^"]*)"((?!noscript).)*<\/noscript>/', $content, $matches);
		if ($matches and $matches[1] and $matches[2]) {
			$alt = $matches[1];
			$src = $matches[2];
		} else {
			$noscript = preg_match_all('/<noscript>[^<]*<img\s+src="([^"]*)"\s+alt="([^"]*)"((?!noscript).)*<\/noscript>/', $content, $matches);
			if ($matches and $matches[1] and $matches[2]) {
				$alt = $matches[2];
				$src = $matches[1];
			}
		}
		$content = preg_replace('/<noscript>((?!noscript).)*<\/noscript>/', '', $content);
		 */
		$imgs = preg_match_all('/<img[^>]*data-original="([^"]*)"\s+src="([^"]*)"[^>]+>/', $content, $matches);
		$original = $matches[1];
		$src = $matches[2];
		if ($original and $src) {
			for ($i = 0; $i < count($original); $i++) {
				$original[$i] = str_replace('/', '\/', $original[$i]);
				$content = preg_replace('/<img\s+alt="([^"]+)"\s+data-original="('.$original[$i].')"[^>]*>/', '<img alt="\\1" src="'.$src[$i].'">', $content);
			}
		}

		$html->clear();

		return array(
			'content' => $content,
		);
	}
}
