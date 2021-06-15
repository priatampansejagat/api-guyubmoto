<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\MyworksModel;
use App\Models\AuthModel;

class Photography extends BaseController{

  protected $users_model;
  protected $myworks_model;
  protected $auth_model;

  public function __construct(){
    $this->users_model = new UsersModel();
    $this->myworks_model = new MyworksModel();
    $this->auth_model = new AuthModel();
  }


  public function list_photography(){
    $data = $this->request->getPost();
    $page_position = $data['page_position'];
    $results_per_page = $data['results_per_page'];

    $first_result = ($page_position*$results_per_page)-$results_per_page;

    $list_photography = $this->myworks_model->selectAllPhotography_limit($first_result, $results_per_page);

    foreach ($list_photography as $key => $value) {
      $list_photography[$key]['link'] = base_url().'/'.$list_photography[$key]['link'];

      // get username
      $login_info = $this->auth_model->getLoginInfo_byID($list_photography[$key]['login_id']);
      $list_photography[$key]['username'] = $login_info[0]['username'];
    }

    $this->success_response(array('status' => 'success', 'data' => $list_photography));
  }


}

?>
