<?php
class Jenis_barang_model extends CI_Model{


  public function show_jenis()
  {
    $this->db->where('deleted_at',null);
    $result = $this->db->get('jenis_barang');
    return $result;
  }

  public function insert_jenis($data)
  {
    $this->db->insert('jenis_barang', $data);
  }
  public function get_jenis($id)
  {
    $this->db->where('id',$id);
    $result = $this->db->get('jenis_barang',1);
    return $result;
  }

  public function update_jenis($data)
  {
    $this->db->set('jenis_barang',$data["jenis_edit"]);
    $this->db->where('id',$data["id"]);
    $this->db->update('jenis_barang');
  }
  public function delete_jenis($id)
  {
    $this->db->where('id',$id);
    $this->db->set('deleted_at','now()',false);
    $this->db->update('jenis_barang');
  }
}
