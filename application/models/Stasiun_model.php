<?php
class Stasiun_model extends CI_Model{


  public function show_stasiun()
  {
    $result = $this->db->get('stasiun');
    return $result;
  }

  public function insert_stasiun($data)
  {
    $this->db->insert('stasiun', $data);
  }
  public function get_stasiun($id)
  {
    $this->db->where('id',$id);
    $result = $this->db->get('stasiun',1);
    return $result;
  }

  public function get_rutes()
  {
    $result = $this->db->get('rute');
    return $result;
  }

  public function update_stasiun($data)
  {
    // Rute 	Panjang (cm) 	Lebar (cm) 	Tinggi (cm) 	Berat Max (kg) 	Tgl digunakan
    $this->db->set('nama_stasiun',$data["nama_stasiun"]);
    $this->db->set('kota',$data["kota"]);
    $this->db->where('id',$data["id"]);
    $this->db->update('stasiun');
  }
  public function delete_stasiun($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('stasiun');
  }
}
