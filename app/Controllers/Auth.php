<?php

namespace App\Controllers;

use App\Models\AuthModel;
class Auth extends BaseController{

  protected $auth_model;

  public function __construct(){
    $this->auth_model = new AuthModel();
  }

  public function login_check(){
    $data = $this->request->getPost();

    if (isset($data['username'])) {
      if ($data['username'] != '' && $data['username'] != NULL) {

        $login_data = $this->auth_model->getLoginInfo($data['username']);

        if (count($login_data) > 0) {
          $hash_passwd = crypt($data['password'], BLOWFISH_KEY);

          if ($hash_passwd == $login_data[0]['password']) {
            $this->success_response(array('status' => 'success'));
          }else {
            $this->success_response(array('status' => 'failed',
                                          'message' => 'Login failed'
                                        ));
          }

        }else{
          $this->success_response(array('status' => 'failed',
                                        'message' => 'Username is not registered'
                                      ));
        }

      }
    }

    // $md5pass = md5($data['password']);
    // $passwd = crypt($data['password'], '$2a$07$'.$md5pass'.$');

	}

	public function user_register(){
    $data = $this->request->getPost();

    // Cek if there is post named username
    if (isset($data['username'])) {
      if ($data['username'] != '' && $data['username'] != NULL && $data['password'] != '' && $data['password'] != NULL) {

        // check if username is already registered
        $login_data = $this->auth_model->getLoginInfo($data['username']);
        // $this->success_response($login_data);
        if (count($login_data) > 0) {

          $this->success_response(array('status' => 'failed', 'message' => 'This user is already registered'));

        }else {

          $data_user['email'] = $data['email'];
          $data_user['uname'] = $data['username'];
          $data_user['passwd'] = $data['password'];
          $data_user['instagram'] = $data['instagram'];
          $data_user['portfolio'] = $data['portfolio'];

          $create_account = $this->auth_model->createAccount($data_user);
          if ($create_account) {

            $cek_login_data = $this->auth_model->getLoginInfo($data_user['uname']);
            $data_user['login_id'] = $cek_login_data[0]['id'];

            $create_personal_data = $this->auth_model->createPersonalData($data_user);

            $this->success_response(array('status' => 'success'));

          }else {
            $this->success_response(array('status' => 'failed',
                                          'message' => 'Failed to create account, please contact the customer service'));
          }
        }

      }else{
        $this->success_response(array('status' => 'failed',
                                      'message' => 'Please fill email, username and password :)'
                                    ));
      }
    }else {
      $this->success_response(array('status' => 'failed',
                                    'message' => 'Please fill email, username and password'
                                  ));
    }
	}

	public function reset_password(){

	}

}

?>
