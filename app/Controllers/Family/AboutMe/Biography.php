<?php

namespace App\Controllers\Family\AboutMe;
use App\Controllers\BaseController;

use App\Models\UsersModel;

class Biography extends BaseController{

  protected $users_model;

  public function __construct(){
    $this->users_model = new UsersModel();
  }

public function refresh(){
  $data = $this->request->getPost();

  $data_user = $this->users_model->getDataUser($data['login_id']);
  $this->success_response(array('status' => 'success', 'data' => $data_user));
}

  public function update(){

    $data = $this->request->getPost();

    $login_id = $data['login_id'];
    $dataArr = array('first_name' => $data['first_name'],
                      'mid_name'   => $data['mid_name'],
                      'last_name'   => $data['last_name'],
                      'age'   => $data['age'],
                      'gender'   => $data['gender'],
                      'email'   => $data['email'],
                      'phone_number'   => $data['phone_number'],
                      'biography'   => $data['biography'],
                      'address'   => $data['address'],
                      'city'   => $data['city'],
                      'country'   => $data['country'],
                      'instagram'   => $data['instagram'],
                      'portfolio'   => $data['portfolio']
                      );
    $update = $this->users_model->updateDataUser($login_id,$dataArr);
    if ($update) {
      $this->success_response(array('status' => 'success'));
    }else{
      $this->success_response(array('status' => 'failed'));
    }

  }

  // Insert data File ke DB dan safe file ke direktori
  public function updateProfilePic(){
    $data = $this->request->getPost();

    $decoded_data = json_decode($data['data'],true);

    if (isset($decoded_data['login_id'])) {
      $login_id = $decoded_data['login_id'];

      // save image
      $uploadOk = 1;
      $target_dir = 'uploads/aboutme/biography/';
      $target_file = $target_dir . $login_id . basename($_FILES["file"]["name"]);
      $imageFileType = strtolower(pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION));

      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
      }

      if ($uploadOk == 0) {

        $this->success_response(array('status' => 'failed', 'data' => 'Not an image'));

      } else {

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

          // compress
          $final_destination = $target_dir.$login_id.date("his").'.png';
          if ($_FILES["file"]["size"] > 5000000) {
            // 5MB
            $compressed_image = compress_image($target_file,$final_destination,50);
          }else {
            $compressed_image = compress_image($target_file,$final_destination,90);
          }

          //delete file temporary
          unlink($target_file);

          // update DB
          $dataArr = array('picture_profile' =>  base_url().'/'.$final_destination );
          $update = $this->users_model->updateDataUser($login_id, $dataArr);
          $this->success_response(array('status' => 'success', 'data' => $dataArr['picture_profile']));
        } else {
          $this->success_response(array('status' => 'failed', 'data' => 'Sorry, there was an error uploading your file.'));
        }

      }

    }else {
      $this->success_response(array('status' => 'failed', 'data' => ''));
    }

  }



}

?>
