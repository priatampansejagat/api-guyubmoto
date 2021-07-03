<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\UsersModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth extends BaseController{

  protected $auth_model;
  protected $users_model;

  public function __construct(){
    $this->auth_model = new AuthModel();
    $this->users_model = new UsersModel();
  }

  public function login_check(){
    $data = $this->request->getPost();

    if (isset($data['username'])) {
      if ($data['username'] != '' && $data['username'] != NULL && $data['password'] != '' && $data['password'] != NULL) {

        $login_data = $this->auth_model->getLoginInfo($data['username']);

        if (count($login_data) > 0) {
          $hash_passwd = crypt($data['password'], BLOWFISH_KEY);

          if ($hash_passwd == $login_data[0]['password']) {

            // GET ADMISSION
            $admissin_data = $this->users_model->getAdmissionByLoginId($login_data[0]['id']);
            $login_data[0]['admission'] = $admissin_data['admission'];

            // Filter data yang dikirim
            unset($login_data[0]['password']);
            // LOGIN SUKSES
            $this->success_response(array('status' => 'success','data_login' => $login_data[0]));

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

      }else {
        $this->success_response(array('status' => 'failed',
                                      'message' => 'Please fill email, username and password :)'
                                    ));
      }
    }else {
      $this->success_response(array('status' => 'failed',
                                    'message' => 'Please fill email, username and password :)'
                                  ));
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
          $data_user['level'] = USER_LEVEL_COMMON;
          $data_user['passwd'] = $data['password'];
          $data_user['instagram'] = $data['instagram'];
          $data_user['portfolio'] = $data['portfolio'];
          $data_user['admission'] = 'false';

          $create_account = $this->auth_model->createAccount($data_user);
          if ($create_account) {

            $cek_login_data = $this->auth_model->getLoginInfo($data_user['uname']);
            $data_user['login_id'] = $cek_login_data[0]['id'];

            $create_personal_data = $this->auth_model->createPersonalData($data_user);
            $create_admission = $this->auth_model->createFamilyAdmission($data_user);

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

  public function user_register_admin(){

  }

	public function password_reset(){
    $data = $this->request->getPost();
    $from = EMAIL_ADDRESS;
    $to = '';
    $subject = 'Reset Password From Guyubmoto';
    $message = 'Hello, Berikut adalah password baru kamu : <br>';

    // get data user
    $user_data = $this->users_model->getDataUser_byUsername($data['username']);
    $to = $user_data['data_personal_data']['email'];
    // generate new password
    $newPassword = generateRandomString();
    $md5pass  = md5($newPassword);
    $blowfishPass = crypt($md5pass, BLOWFISH_KEY);

    // save new password
    $save_newPass = $this->auth_model->updateAccount_byUsername($data['username'],array('password' => $blowfishPass));

    if ($save_newPass) {
      // send mail
      // Settings
      $mail = new PHPMailer(true);
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      $mail->Host       = 'smtp.guyubmoto.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = 'temancreator@guyubmoto.com';                     //SMTP username
      $mail->Password   = 'or4ngt4mp4n';                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      //Recipients
      $mail->setFrom($from, 'Mailer');
      $mail->addAddress($to);               //Name is optional

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $message . $newPassword;

      $mail->send();

      $this->success_response(array('status' => 'success'));
    }else{
      $this->success_response(array('status' => 'failed'));
    }

	}

}

?>
