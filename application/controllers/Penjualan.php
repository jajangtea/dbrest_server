<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Penjualan extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

	public function index_get(){
		$id = $this->get('nomor_transaksi');
        $this->db->where('nomor_transaksi', $id);
        $this->db->join('produk','produk.id=penjualan_detil.id_produk','left');
        $produk = $this->db->get('penjualan_detil')->result();
        $this->response($produk, REST_Controller::HTTP_OK);
	}

    public function pilihbarang_get(){
        $produk = $this->db->get('produk')->result();
        $this->response($produk, REST_Controller::HTTP_OK);
    }

    public function nomor_transaksi_post()
    {
        $timestamp = mt_rand(1, time());
        $no = date('dmy' . $timestamp);
        $nomor=array('nomor_transaksi'=>$no);
        $this->response($nomor, REST_Controller::HTTP_OK);
    }

    public function simpan_master_post()
    {
        $data = array(
            'nomor_transaksi'        => $this->post('nomor_transaksi'),
            'tanggal'        => date('d-m-y'),
        );
        $insert = $this->db->insert('penjualan_master', $data);
        if ($insert) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'failed', 502));
        }
    }

    public function simpan_penjualan_post()
    {
        $data = array(
            'nomor_transaksi'   => $this->post('nomor_transaksi'),
            'id_produk'           =>  $this->post('id_produk'),
            'jumlah'           =>  $this->post('jumlah'),
            'harga'           =>  $this->post('harga'),
            'subtotal'           =>  floatval($this->post('jumlah')*$this->post('harga')),
        );
        $insert = $this->db->insert('penjualan_detil', $data);
        if ($insert) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(array('status' => 'failed', 502));
        }
    }

    public function hapus_penjualan_delete(){
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('penjualan_detil');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'failed'), 502);
        }
    }
}

/* End of file Penjualan.php */
