<?php
namespace App\Models;

use CodeIgniter\Model;

class MyworksModel extends Model{

  public function insertPhotography($dataArr){
    $db      = \Config\Database::connect();

    return $db->table('myworks_photography')->insert($dataArr) == true ? $db->insertID() : false ;
  }

  public function updatePhotography($id, $dataArr){
    $db      = \Config\Database::connect();

    $builder = $db->table('myworks_photography');
    $builder->where('mw_photography_id', $id);
    return $builder->update($dataArr) ? true : false ;
  }

  public function deletePhotography($id){
    $db      = \Config\Database::connect();

    $builder = $db->table('myworks_photography');
    $builder->where('mw_photography_id', $id);
    // $builder->delete();
    return $builder->delete() ? true : false ;
  }

  public function selectPhotography($where){
    $db      = \Config\Database::connect();
    $builder = $db->table('myworks_photography');

    $builder->where($where);
    $builder->orderBy('mw_photography_id', 'DESC');
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return $decoded;
  }

  public function selectAllPhotography_limit($start, $offset){
    $db      = \Config\Database::connect();
    $builder = $db->table('myworks_photography');

    $builder->limit($offset, $start);
    $builder->orderBy('mw_photography_id', 'DESC');
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return $decoded;
  }

  public function selectPhotography_limit($where, $start, $offset){
    $db      = \Config\Database::connect();
    $builder = $db->table('myworks_photography');

    $builder->where($where);
    $builder->limit($offset, $start);
    $builder->orderBy('mw_photography_id', 'DESC');
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return $decoded;
  }

  public function countPhotography($where){
    $db      = \Config\Database::connect();
    $builder = $db->table('myworks_photography');

    $builder->where($where);
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return count($decoded);
  }


}

?>
