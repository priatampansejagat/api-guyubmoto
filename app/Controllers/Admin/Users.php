<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Users extends BaseController{

  protected $users_model;

  public function __construct(){
    $this->users_model = new UsersModel();
  }

  public function users_admission(){

    $data_users=[];
    $data_admission = $this->users_model->getAllAdmission('false');

    for ($i=0; $i < count($data_admission) ; $i++) {
      $data_users[$i] = $this->users_model->getDataUser($data_admission[$i]['login_id']);
    }

    $this->success_response(array('status' => 'success', 'data_user' => $data_users));

	}

  public function user_acceptance_true(){
    $data = $this->request->getPost();

    $update = array('admission' => 'true');
    $update_admission = $this->users_model->updateAdmission($data['login_id'], $update);
    if ($update_admission) {
      $this->success_response(array('status' => 'success'));
    }else {
      $this->success_response(array('status' => 'failed'));
    }

  }

}

?>
