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
}
