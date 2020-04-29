<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk_model extends CI_Model
{
    public function getProduk($id = null)
    {
        if ($id == null) {
            return $this->db->query("select * from produk")->result();
        } else {
            return $this->db->query("select * from produk where id = $id")->result();
        }
    }
}

