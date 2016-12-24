<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cache extends CI_Controller {

	private $cache_driver = 'redis';

	public function index() {
		echo 'Loading from the cache.<br />';

		/* キャッシュからデータを取得 */
		$driver = $this->cache_driver;
		$this->load->driver('cache', array('adapter' => $driver));
		if (!$this->cache->is_supported($driver)) {
			echo "$driver is not supported<br />";
			die;
		}

		$value = $this->cache->get('key');

		/* データを表示 */
		if ($value) {
			echo "Saved value is '" . html_escape($value) . "'.";
		} else {
			echo 'Saved value is not found.';
		}
	}

	public function save() {
		echo 'Saving to the cache.<br />';

		/* パラメータからキャッシュに保存するデータを取得 */
		$value = 'Default Value';
		$data = $this->input->get();
		if (isset($data['value'])) {
			$value = $data['value'];
		}

		/* データをキャッシュに保存 */
		$driver = $this->cache_driver;
		$this->load->driver('cache', array('adapter' => $driver));
		if (!$this->cache->is_supported($driver)) {
			echo "$driver is not supported<br />";
			die;
		}

		$ttl = 5; //sec
		$this->cache->save('key', $value, $ttl);
	}
}
