<?php

// Copyright 2019-2020 The Inescoin developers.
// - Mounir R'Quiba
// Licensed under the GNU Affero General Public License, version 3.

namespace Blockchain;

// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

use GuzzleHttp\Client;

class App
{
	public $currentLangue = 'en';

	private $nodeUrl = 'https://node.inescoin.org/';

	private $websiteName = '';

	public $body = [];

	public $client;

	public $languesMenu = [];

	public $cacheTimeout = 1;
	public $cacheFolder = '../cache/';
	public $cacheClearTimer = 1;

	public $isStore = false;
	public $isCheckout = false;

	private $categorySku = null;
	private $productSku = null;

	public function __construct()
	{
		$this->client = new \GuzzleHttp\Client([
			'base_uri' => $this->nodeUrl,
			'request.options' => [
			     'exceptions' => false,
			]
		]);

		include(__DIR__ . '/config.php');

		$this->websiteName = $website;
	}

	public function run() {
		$this->controller();

		return $this->render([
			'view' => __DIR__ . '/../template/website.tpl.php',
		]);
	}

	public function runCheckout() {
		$this->isCheckout = true;
		$this->controller();

		return $this->render([
			'view' => __DIR__ . '/../template/store-checkout.tpl.php',
		]);
	}

	public function runStore() {
		$this->isStore = true;

		$category = $this->_getParameterValue('c');
		$categoryData = [];
		$categorySku = null;
		if ($category) {
			$categoryData = explode('._.', $category);
			if (count($categoryData) === 2) {
				$this->body['categoryName'] = $categoryData[0];
				$this->categorySku = $categoryData[1];
			}
		}

		$product = $this->_getParameterValue('p');
		$productData = [];
		$productSku = null;
		if ($product) {
			$productData = explode('._.', $product);
			if (count($productData) === 2) {
				$this->productSku = $productData[1];
			}
		}

		$this->controller();

		$template = 'store-index';
		if (!empty($this->productSku)) {
			$template = 'store-item';
		} elseif (!empty($this->categorySku)) {
			$template = 'store-category';
		}

		$this->body['navStoreCagories'] = __DIR__ . '/../template/store-categories.tpl.php';
		return $this->render([
			'view' => __DIR__ . '/../template/' . $template . '.tpl.php',
		]);
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

		// echo '<pre>';
		// var_dump($domain['html'][$this->currentLangue]['categories']);
		// var_dump($domain['html'][$this->currentLangue]['tags']);
		// var_dump($domain['html'][$this->currentLangue]['products']);
		// echo '</pre>';exit();

		$this->body['websiteName'] = $this->websiteName;
		$this->body['status'] = $this->getStatus();
		$this->body['currentLangue'] = $this->currentLangue;
		$this->body['categories'] = [];
		$this->body['products'] = [];
		$this->body['isCheckout'] = $this->isCheckout;


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

			if (!$this->isStore) {
				if (isset($this->body['domain']['categories'])) {
					unset($this->body['domain']['categories']);
				}

				if (isset($this->body['domain']['products'])) {
					unset($this->body['domain']['products']);
				}
			} else {
				// Categories
				$this->body['categories'] = $this->body['domain']['categories'];
				$this->body['categoriesFlat'] = [];
				foreach ($this->body['domain']['categories'] as $k => $category) {
					$this->body['categoriesFlat'][$category['sku']] = $category['title'];

					if (isset($this->body['domain']['categories'][$k]['children'])) {
						foreach ($this->body['domain']['categories'][$k]['children'] as $subCategory) {
							$this->body['categoriesFlat'][$subCategory['sku']] = $subCategory['title'];
						}
					}
				}

				// Products
				$this->body['products'] = array_filter($this->body['domain']['products'], function ($product, $key) {
					$filtered = false;

					if (empty($this->categorySku) && empty($this->productSku)) {
						$filtered = !!$product['active'];
					} else {
						if (!empty($this->productSku) && $this->productSku === $product['sku']) {
							$filtered = !!$product['active'];
						} elseif (!empty($this->categorySku) && isset($product['categories']) && is_array($product['categories']) && in_array($this->categorySku, $product['categories'])) {
							$filtered = !!$product['active'];
						}
					}

					return $filtered;
				}, ARRAY_FILTER_USE_BOTH);

				$this->body['products'] = array_map(function ($product) {
					if (isset($product['categories']) && is_array($product['categories'])) {
						$product['categories'] = array_map(function ($categorySKU) {
							return [
								'label' => $this->body['categoriesFlat'][$categorySKU] ?? '',
								'sku' => $categorySKU,
								'link' => './?c=' . $this->body['categoriesFlat'][$categorySKU] . '._.' . $categorySKU
	 						];
						}, $product['categories']);
					}

					$product['categories'] = $product['categories'] ?? [];
					$product['amount'] = sprintf('%0.2f', (float) $product['amount']);
					$product['amountCrypto'] = sprintf('%0.2f', (float) $product['amount'] / 0.042);

					return $product ?? [];
				}, $this->body['products']);
			}
		}


		// var_dump($this->body['domain']); exit();
	}

	protected function render(array $params)
	{
		extract($this->body);
		extract($params);

		if (!$this->isCheckout && empty($domain)) {
			header("HTTP/1.0 404 Not Found");
			include(__DIR__ . '/../template/404.tpl.php');
			return;
		}


		include(__DIR__ . '/../template/wrapper.tpl.php');
	}

	public function getStatus() {
		return $this->_client('GET', 'status');
	}

	public function getDomainByUrl($url = 'inescoin')
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
			'c',
			'p'
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
