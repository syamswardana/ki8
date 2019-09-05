<?php
class Kontainer_model extends CI_Model{


  public function show_kontainer()
  {
    // $this->db->where('status','petugas');
    $this->db->select('kontainer.id,rute.nama_rute as rute, panjang, lebar, tinggi, berat_maksimal,tanggal_digunakan');
    $this->db->from('kontainer');
    $this->db->join('rute', 'rute.id = kontainer.rute_id');
    $result = $this->db->get();
    return $result;
  }

  public function insert_kontainer($data)
  {
    $this->db->insert('kontainer', $data);
  }
  public function get_kontainer($id)
  {
    $this->db->where('id',$id);
    $result = $this->db->get('kontainer',1);
    return $result;
  }

  public function get_rutes()
  {
    $result = $this->db->get('rute');
    return $result;
  }

  public function update_kontainer($data)
  {
    // Rute 	Panjang (cm) 	Lebar (cm) 	Tinggi (cm) 	Berat Max (kg) 	Tgl digunakan
    $this->db->set('rute_id',$data["rute"]);
    $this->db->set('panjang',$data["panjang"]);
    $this->db->set('lebar',$data["lebar"]);
    $this->db->set('tinggi',$data["tinggi"]);
    $this->db->set('berat_maksimal',$data["berat"]);
    $this->db->set('tanggal_digunakan',$data["tanggal"]);
    $this->db->where('id',$data["id"]);
    $this->db->update('kontainer');
  }
  public function delete_kontainer($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('kontainer');
  }
}
