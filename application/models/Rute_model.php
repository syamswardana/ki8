<?php
class Rute_model extends CI_Model{


  public function show_rute()
  {
    $this->db->where('deleted_at',null);
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
    $this->db->set('deleted_at','now()',false);
    $this->db->update('rute');
  }
  public function get_detail($id)
  {
    $this->db->select('detail_rute.id,detail_rute.id_stasiun,stasiun.nama_stasiun,stasiun.kota');
    $this->db->from('detail_rute');
    $this->db->join('stasiun','stasiun.id = detail_rute.id_stasiun');
    $this->db->where('id_rute',$id);
    $this->db->order_by('urutan');
    $result = $this->db->get();
    return $result;
  }
  public function insert_detail_rute($stasiun, $rute)
  {
    $this->db->select('urutan');
    $this->db->from('detail_rute');
    $this->db->where('id_rute',$rute);
    $this->db->order_by('urutan','DESC');
    $terbesar = NULL;
    try {
      $terbesar = $this->db->get()->row()->urutan;
      $data = array(
        'id_rute' => $rute,
        'id_stasiun' => $stasiun,
        'urutan' => ($terbesar+1)
      );
      $this->db->insert('detail_rute', $data);

    } catch (\Exception $e) {
      $data = array(
        'id_rute' => $rute,
        'id_stasiun' => $stasiun,
        'urutan' => 0
      );
      $this->db->insert('detail_rute', $data);
    }
  }
  public function update_detail_rute($id,$id_stasiun)
  {
    $this->db->set('id_stasiun',$id_stasiun);
    $this->db->where('id',$id);
    $this->db->update('detail_rute');
  }
  public function delete_detail($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('detail_rute');
  }
}
