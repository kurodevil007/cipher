<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Predis\Client;

class Redis extends CI_Controller
{

	protected $redis;

	function __construct()
	{
		require_once 'vendor/autoload.php';
		try {
			$param = [
				[
					'host' => '192.168.10.3',
					'port' => 6379,
					// 'database' => 15,
					'alias' => 'master'
				],
				[
					'host' => '192.168.10.4',
					'port' => 6379,
					// 'database' => 15,
					'alias' => 'slave'
				],
				[
					'host' => '192.168.10.5',
					'port' => 6379,
					// 'database' => 15,
					'alias' => 'slave'
				]
			];
			$op = ['replication' => true];
			// $this->redis = new Client($param, $op);
			$this->redis = new Client('tcp://127.0.0.1:6379');
		} catch (Exception $e) {
			die($e->getMessage());
		}
		parent::__construct();
		$this->load->model('redis_model');
	}

	// private function redis_version($info)
	// {
	//     if (isset($info['Server']['redis_version'])) {
	//         return $info['Server']['redis_version'];
	//     } elseif (isset($info['redis_version'])) {
	//         return $info['redis_version'];
	//     } else {
	//         return 'unknown version';
	//     }
	// }

	public function testing()
	{
		echo json_encode($this->redis->mget('nama'));
		// die('exit');
		// $exists = $this->redis->exists('foo') ? 'yes' : 'no';
		// $current = $this->redis->getConnection()->getCurrent()->getParameters();
		// echo "Does 'foo' exist on {$current->alias}? $exists.", PHP_EOL;

		// // Write operation.
		// $this->redis->set('foo', 'bar');
		// $current = $this->redis->getConnection()->getCurrent()->getParameters();
		// echo "Now 'foo' has been set to 'bar' on {$current->alias}!", PHP_EOL;

		// // Read operation.
		// $bar = $this->redis->get('foo');
		// $current = $this->redis->getConnection()->getCurrent()->getParameters();
		// echo "We fetched 'foo' from {$current->alias} and its value is '$bar'.", PHP_EOL;
		// $this->redis->get('nama');
		// $current = $this->redis->getConnection()->getCurrent()->getParameters();
		// print_r($current->alias);
		// print_r($this->redis_version($this->redis->info()));
		// $this->redis->hset('user:1', 'nama', 'Ihsan Fawzan');
		// $this->redis->hset('user:1', 'alamat', 'Tasikmalaya');
		// $this->redis->del('user:1');
		// $this->redis->hset('user:123', 'name', 'arslan');
		// $this->redis->hset('user:123', 'email', 'arslan@gmail.com');
		// $this->redis->hset('user:123', 'dob', '1990-09-09');

		// print_r($this->redis->hgetall('user:123'));

		// echo $this->redis->hget('user:123', 'name')."\n";
		// echo $this->redis->hget('user:123', 'email')."\n";
		// echo $this->redis->hget('user:123', 'dob')."\n";

		// print_r($this->redis->hkeys('user:123'));
		// print_r($this->redis->hvals('user:123'));
		// $this->redis->hdel('user:123', 'dob')."\n";
	}

	public function index()
	{
		return $this->load->view('redis');
	}

	public function get_data()
	{
		$datas = [
			'data' => [
				[
					'nama' => $this->redis->get('nama'),
					'alamat' => $this->redis->get('alamat'),
				]
			]
		];
		echo json_encode($datas);
	}

	public function add()
	{
		echo json_encode($this->input->post());
		$this->redis->hset('nama', $this->input->post('nama'));
		$this->redis->hset('alamat', $this->input->post('alamat'));
	}
}
