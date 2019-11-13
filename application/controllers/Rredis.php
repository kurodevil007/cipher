<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Predis\Client;

class Rredis extends CI_Controller
{

    protected $redis;

    function __construct()
    {
        require_once 'vendor/autoload.php';
        try {
            $this->redis = new Client('tcp://127.0.0.1:6379');
        } catch (Exception $e) {
            die($e->getMessage());
        }
        parent::__construct();
        // $this->load->model('redis_model');
    }

    public function index()
    {
        return $this->load->view('rredis');
    }

    public function testing()
    {
        var_dump($this->redis->hscan('user'));
    }

    public function get_data()
    {
        // $data['id'] = $this->redis->hget('user', 'id');
        // $data = [
        //     'data' =>
        //     [
        //         $this->redis->hget('user', 'id') =>
        //         [
        //             'nama' => $this->redis->hget('user', 'nama'),
        //             'alamat' => $this->redis->hget('user', 'alamat')
        //         ]
        //     ]
        // ];
        $data = $this->redis->lpop('');
        $datas = [
            'data' => [
                $data['id'] =>
                [
                    'nama' => $data['nama'],
                    'alamat' => $data['alamat'],
                ]
            ]
        ];
        echo json_encode($datas);
    }

    public function add()
    {
        echo json_encode($this->input->post());
        // $this->redis->hset('user', 'id', 1);
        // $this->redis->lset('user', 'nama');
        // $this->redis->lset('user', 'alamat');
        $this->redis->lpush('user', ['nama' => $this->input->post('nama'), 'alamat' => $this->input->post('alamat')]);
    }
}
