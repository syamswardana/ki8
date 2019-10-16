<?php
class Users_model extends CI_Model{

  function validate($username,$password){
    $this->db->where('username',$username);
    $this->db->where('password',$password);
    $result = $this->db->get('users',1);
    return $result;
  }

  public function insert_user($data)
  {
    $this->db->insert('users', $data);
  }
  public function show_users()
  {
    $this->db->select('users.id, username, nama, sta.nama_stasiun as id_stasiun, password');
    $this->db->from('users');
    $this->db->join('stasiun as sta','sta.id=users.id_stasiun');
    $this->db->where('users.status','petugas');
    $result = $this->db->get();
    return $result;
  }

  public function get_user($id)
  {
    $this->db->where('id',$id);
    $result = $this->db->get('users',1);
    return $result;
  }

  public function update_user($data)
  {
    $this->db->set('username',$data["username"]);
    $this->db->set('nama',$data["nama"]);
    $this->db->set('id_stasiun',$data["stasiun"]);
    $this->db->set('password',$data["password"]);
    $this->db->where('id',$data["id"]);
    $this->db->update('users');
  }
  public function delete_user($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('users');
  }
}
