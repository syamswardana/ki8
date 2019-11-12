<?php
class Rute_model extends CI_Model{


  public function show_rute()
  {
    $result = $this->db->get('rute');
    return $result;
  }

  public function insert_rute($data)
  {
    $this->db->insert('rute', $data);
  }
  public function get_rute($id)
  {
    $this->db->where('id',$id);
    $result = $this->db->get('rute',1);
    return $result;
  }

  public function update_rute($data)
  {
    $this->db->set('nama_rute',$data["nama_rute"]);
    $this->db->where('id',$data["id"]);
    $this->db->update('rute');
  }
  public function delete_rute($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('rute');
  }
  public function get_detail($id)
  {
    $this->db->select('*');
    $this->db->from('detail_rute');
    $this->db->join('stasiun','stasiun.id = detail_rute.id_stasiun');
    $this->db->where('id_rute',$id);
    $result = $this->db->get();
    return $result;
  }
}
