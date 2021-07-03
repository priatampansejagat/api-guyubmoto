<?php

namespace App\Controllers\Family\MyWorks;
use App\Controllers\BaseController;

use App\Models\UsersModel;
use App\Models\MyworksModel;

class Photography extends BaseController{

  protected $users_model;
  protected $myworks_model;

  public function __construct(){
    $this->users_model = new UsersModel();
    $this->myworks_model = new MyworksModel();
  }

// Insert data text ke DB
  public function upload(){

    $data = $this->request->getPost();

    $dataArr = array('login_id' => $data['user_id'],
                      'title'   => $data['photo_title'],
                      'description' => '',
                      'link'        => ''
                      );
    $insert = $this->myworks_model->insertPhotography($dataArr);
    if ($insert) {
      $this->success_response(array('status' => 'success', 'photo_id' => $insert));
    }else{
      $this->success_response(array('status' => 'failed', 'photo_id' => false));
    }

  }

  // Insert data File ke DB dan safe file ke direktori
  public function upload_file(){
    $data = $this->request->getPost();

    $decoded_data = json_decode($data['data'],true);

    if (isset($decoded_data['photo_id'])) {
      $photo_id = $decoded_data['photo_id'];

      // save image
      $uploadOk = 1;
      $target_dir = 'uploads/myworks/photography/';
      $target_file = $target_dir . $photo_id . basename($_FILES["file"]["name"]);
      $imageFileType = strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));

      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
      }

      if ($uploadOk == 0) {

        $delete = $this->myworks_model->deletePhotography($photo_id);
        $this->success_response(array('status' => 'failed', 'data' => 'Not an image'));


      } else {

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

          // compress
          $final_destination = $target_dir.$photo_id.'.png';
          if ($_FILES["file"]["size"] > 5000000) {
            // 5MB
            $compressed_image = compress_image($target_file,$final_destination,50);
          }else {
            $compressed_image = compress_image($target_file,$final_destination,90);
          }

          //delete file temporary
          unlink($target_file);

          // update DB
          $dataArr = array('link' => $final_destination );
          $update = $this->myworks_model->updatePhotography($decoded_data['photo_id'],$dataArr);
          $this->success_response(array('status' => 'success', 'data' => ''));
        } else {
          $delete = $this->myworks_model->deletePhotography($photo_id);
          $this->success_response(array('status' => 'failed', 'data' => 'Sorry, there was an error uploading your file.'));
        }

      }

    }else {
      $delete = $this->myworks_model->deletePhotography($photo_id);
      $this->success_response(array('status' => 'failed', 'data' => ''));
    }

  }

  public function list_photography(){
    $data = $this->request->getPost();
    $page_position = $data['page_position'];
    $results_per_page = $data['results_per_page'];

    $first_result = ($page_position*$results_per_page)-$results_per_page;

    $where = array('login_id' => $data['user_id']);
    $list_photography = $this->myworks_model->selectPhotography_limit($where,$first_result, $results_per_page);
    foreach ($list_photography as $key => $value) {
      $list_photography[$key]['link'] = base_url().'/'.$list_photography[$key]['link'];
    }
    $this->success_response(array('status' => 'success', 'data' => $list_photography));
  }

  public function count_photography(){
    $data = $this->request->getPost();
    $where = array('login_id' => $data['user_id']);

    $count_photography = $this->myworks_model->countPhotography($where);

    $this->success_response(array('status' => 'success', 'count' => $count_photography));
  }

  public function delete_photography(){
    $data = $this->request->getPost();

    //get data foto untuk delete filenya
    $where = array('login_id' => $data['user_id'],
                    'mw_photography_id' => $data['photo_id']);
    $data_photo = $this->myworks_model->selectPhotography($where);

    $delete_photography = $this->myworks_model->deletePhotography($data['photo_id']);
    if ($delete_photography) {
      // delete files
      unlink($data_photo[0]['link']);
      $this->success_response(array('status' => 'success', 'deleted' => $data));
    }else {
      $this->success_response(array('status' => 'failed', 'deleted' => $data));
    }
  }

}

?>
