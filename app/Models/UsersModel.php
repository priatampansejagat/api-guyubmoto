<?php
namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model{

  public function getDataUser($login_id){
    $db      = \Config\Database::connect();
    $data_users=[];

    // AMBIL DATA LOGIN
    $builder_login = $db->table('login');

    $builder_login->where('id', $login_id);
    $builder_login->select('username, id');
    $query_login = $builder_login->get()->getResult();

    $encoded_login = json_encode($query_login);
    $decoded_login = json_decode($encoded_login,true);

    $data_user['data_login'] = $decoded_login[0];

    // AMBIL DATA personal_data
    $builder_personaldata = $db->table('personal_data');

    $builder_personaldata->where('login_id', $login_id);
    $query_personaldata = $builder_personaldata->get()->getResult();

    $encoded_personaldata = json_encode($query_personaldata);
    $decoded_personaldata = json_decode($encoded_personaldata,true);

    $data_user['data_personal_data'] = $decoded_personaldata[0];

    return $data_user;
  }

  public function getDataUser_byUsername($username){
    $db      = \Config\Database::connect();
    $data_users=[];

    // AMBIL DATA LOGIN
    $builder_login = $db->table('login');

    $builder_login->where('username', $username);
    $builder_login->select('username, id');
    $query_login = $builder_login->get()->getResult();

    $encoded_login = json_encode($query_login);
    $decoded_login = json_decode($encoded_login,true);

    $data_user['data_login'] = $decoded_login[0];

    // AMBIL DATA personal_data
    $builder_personaldata = $db->table('personal_data');

    $builder_personaldata->where('login_id', $decoded_login[0]['id']);
    $query_personaldata = $builder_personaldata->get()->getResult();

    $encoded_personaldata = json_encode($query_personaldata);
    $decoded_personaldata = json_decode($encoded_personaldata,true);

    $data_user['data_personal_data'] = $decoded_personaldata[0];

    return $data_user;
  }

  public function updateDataUser($login_id,$dataArr){
    $db      = \Config\Database::connect();
    $builder = $db->table('personal_data');

    $builder->set($dataArr);
    $builder->where('login_id', $login_id);
    $query = $builder->update();

    return $query;
  }

  // Ambil admisson by login_id only, whatever its true or false
  public function getAdmissionByLoginId($login_id){

    $db      = \Config\Database::connect();
    $builder = $db->table('family_admission');

    $builder->where('login_id', $login_id);
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return $decoded[0];
  }

  // Ambil single admision with value true or false
  public function getAdmission($login_id, $admission){

    $db      = \Config\Database::connect();
    $builder = $db->table('family_admission');

    $builder->where('login_id', $login_id);
    $builder->where('admission',$admission);
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return $decoded[0];
  }

  // Ambil all admision with value true or false
  public function getAllAdmission($admission){

    $db      = \Config\Database::connect();
    $builder = $db->table('family_admission');

    $builder->where('admission',$admission);
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return $decoded;
  }

  // Update admisson to true or false
  public function updateAdmission($login_id, $update){

    $db      = \Config\Database::connect();
    $builder = $db->table('family_admission');

    $builder->set($update);
    $builder->where('login_id', $login_id);
    $query = $builder->update();

    return $query;
  }

}

?>
