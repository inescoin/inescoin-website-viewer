<?php

// Copyright 2019 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.

namespace Blockchain;

// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

use GuzzleHttp\Client;

class App
{
	public $currentLangue = 'en';

	private $websiteName = '';

	public $body = [];

	public $client;

	public $languesMenu = [];

	public $cacheTimeout = 20;
	public $cacheFolder = '../cache/';
	public $cacheClearTimer = 180;

	public function __construct($nodeUrl = 'https://node.inescoin.org/')
	//public function __construct($nodeUrl = 'http://inescoin-node:8086')
	{
		$this->client = new \GuzzleHttp\Client([
			'base_uri' => $nodeUrl,
			'request.options' => [
			     'exceptions' => false,
			]
		]);

		include(__DIR__ . '/config.php');
		$this->websiteName = $website;
	}

	public function run() {
		$this->controller();

		return $this->render();
	}

	protected function controller() {
		$lg = $this->_getParameterValue('lg');

		$domain = $this->getDomainByUrl($this->websiteName);
		$domain = isset($domain['body'])
			? @json_decode(base64_decode($domain['body']), true)
			: [];

		if (empty($domain)) {
			die('...');
		}

		$this->body['websiteName'] = $this->websiteName;
		$this->body['status'] = $this->getStatus();
		$this->body['currentLangue'] = $this->currentLangue;

		if (isset($domain['html'])) {
			$chooseOne = !isset($domain['html'][$this->currentLangue]) || !$domain['html'][$this->currentLangue]['website']['active'];
			foreach ($domain['html'] as $langue => $content) {
				if ($content['website']['active']) {
					$languesMenu[$langue] = $content['label'];
					$this->currentLangue = $chooseOne ? $langue : $this->currentLangue;
				}
			}

			if (empty($languesMenu)) {
				die('Not langues');
			}

			if (!empty($domain) && isset($domain['html']) && isset($domain['html'][$lg]) && array_key_exists($lg, $languesMenu)) {
				$this->currentLangue = $lg;
				$this->body['currentLangue'] = $lg;
			}

			$this->body['languesMenu'] = $languesMenu;

			if (!empty($domain) && isset($domain['html']) && isset($domain['html'][$this->currentLangue])) {
				$this->body['domain'] = $domain['html'][$this->currentLangue];
			}
		}

		// var_dump($this->body['domain']); exit();
	}

	protected function render()
	{
		extract($this->body);

		if (empty($domain)) {
			header("HTTP/1.0 404 Not Found");
			include(__DIR__ . '/../template/404.tpl.php');
			return;
		}

		include(__DIR__ . '/../template/wrapper.tpl.php');
	}

	public function getStatus() {
		return $this->_client('GET', 'status');
	}

	public function getDomainByUrl($url = 'inescoin.org')
	{
		return $this->_client('POST', 'get-domain-url', [
			'url' => $url
		]);
	}

	private function _client($method = 'GET', $uri = 'get-status', $params = []) {
		$response = [];

		$hash = md5($method . $uri . serialize($params));
		if (!!($cache = $this->_getCache($hash))) {
			return $cache;
		}

		try {
			$response = @json_decode($this->client->request($method, $uri, [
				'json' =>
					$params
			])->getBody()->getContents(), true);

			$this->_setCache($hash, $response);
		} catch (\Exception $e) {
		}

		return $response;
	}

	protected function getWhiteList() {
		return [
			'lg',
		];
	}

	private function _getParameterValue($parameter) {
		$whiteList = $this->getWhiteList();

		$value = null;
		if (!in_array($parameter, $whiteList)) {
			return $value;
		}

		if (isset($_GET[$parameter])) {
			$value = filter_input(INPUT_GET, $parameter, FILTER_SANITIZE_STRING);
		}

		if (isset($_POST[$parameter])) {
			$value = filter_input(INPUT_POST, $parameter, FILTER_SANITIZE_STRING);
		}

		return $value;
	}

	private function _getCache($md5) {
		$this->_checkCacheForlder();
		$this->_clearTimeoutedCache();

		$filename = $this->cacheFolder . $md5 . '.json';

		if (!is_file($filename)) {
			return null;
		}

		$timeLeft = time() - filemtime($filename);
		if ($timeLeft > $this->cacheTimeout) {
			return null;
		}

		return unserialize(file_get_contents($filename));
	}

	private function _setCache($md5, $serialized) {
		$this->_checkCacheForlder();

		$filename = $this->cacheFolder . $md5 . '.json';
		file_put_contents($filename, serialize($serialized));
	}

	private function _checkCacheForlder() {
		if (!is_dir($this->cacheFolder)) {
			@mkdir($this->cacheFolder, 0777, true);
		}
	}

	private function _clearTimeoutedCache() {

		$filetime = 'time.lock';
		$folderTimeFile = $this->cacheFolder . $filetime;

		if (!file_exists($folderTimeFile)) {
			file_put_contents($folderTimeFile, '');
			return;
		}

		$time = time();
		if ($time - filemtime($folderTimeFile) > $this->cacheClearTimer) {
			$files = glob($this->cacheFolder . '*');

			foreach($files  as $file) {
				$timeLeft = $time - filemtime($file);
				if ($timeLeft > ($this->cacheTimeout) && $folderTimeFile !== $file) {
					@unlink($file);
				}
			}

			@unlink($folderTimeFile);
		}
	}
}
