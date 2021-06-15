<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Fams extends BaseController{

  protected $users_model;

  public function __construct(){
    $this->users_model = new UsersModel();
  }

  public function refresh(){
    $data = $this->request->getPost();

    $data_user = $this->users_model->getDataUser_byUsername($data['username']);
    $this->success_response(array('status' => 'success', 'data' => $data_user));
  }

}

?>
