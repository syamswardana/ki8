<?php
class Barang_model extends CI_Model{


  public function show_barang()
  {
    // id	berat	panjang	lebar	tinggi	asal	tujuan	user_id
    $this->db->select('barang.id, berat, panjang, lebar, tinggi, asa.nama_stasiun as asal, tuj.nama_stasiun as tujuan');
    $this->db->from('barang');
    $this->db->join('stasiun as asa','asa.id = barang.asal');
    $this->db->join('stasiun as tuj','tuj.id = barang.tujuan');
    $this->db->join('users','users.id = barang.user_id');
    $this->db->where('users.id',$this->session->userdata('id'));
    $result = $this->db->get();
    return $result;
  }

  public function insert_barang($data)
  {
    $this->db->insert('barang', $data);
  }
  public function get_barang($id)
  {
    $this->db->where('id',$id);
    $result = $this->db->get('barang',1);
    return $result;
  }

  public function update_barang($data)
  {
    // id	berat	panjang	lebar	tinggi	asal	tujuan	user_id
    $this->db->set('berat',$data["berat"]);
    $this->db->set('panjang',$data["panjang"]);
    $this->db->set('lebar',$data["lebar"]);
    $this->db->set('tinggi',$data["tinggi"]);
    $this->db->set('asal',$data["asal"]);
    $this->db->set('tujuan',$data["tujuan"]);
    $this->db->where('id',$data["id"]);
    $this->db->update('barang');
  }
  public function delete_barang($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('barang');
  }
}
