<?php
namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model{

  public function getLoginInfo($username){

    $db      = \Config\Database::connect();
    $builder = $db->table('login');

    $builder->where('username',$username);
    $query = $builder->get()->getResult();

    $encoded = json_encode($query);
    $decoded = json_decode($encoded,true);
    return $decoded;
  }

  public function createAccount($arrData){
    $db      = \Config\Database::connect();

    $uname = $arrData['uname'];
    $hash_passwd = crypt($arrData['passwd'], BLOWFISH_KEY);

    $data = [
        'username' => $uname,
        'password'  => $hash_passwd
    ];

    return $db->table('login')->insert($data) == true ? true : false ;

  }

  public function createPersonalData($arrData){
    $db      = \Config\Database::connect();

    // Untuk Login_id harus ada
    $data = [
      'login_id '       => $arrData['login_id'],
      'first_name '     => isset($arrData['first_name']) ? $arrData['first_name'] : "",
      'mid_name '       => isset($arrData['mid_name']) ? $arrData['mid_name'] : "",
      'last_name '      => isset($arrData['last_name']) ? $arrData['last_name'] : "",
      'age '            => isset($arrData['age']) ? $arrData['age'] : "",
      'gender '         => isset($arrData['gender']) ? $arrData['gender'] : "",
      'email '          => isset($arrData['email']) ? $arrData['email'] : "",
      'phone_number '   => isset($arrData['phone_number']) ? $arrData['phone_number'] : "",
      'biography '      => isset($arrData['biography']) ? $arrData['biography'] : "",
      'address '        => isset($arrData['address']) ? $arrData['address'] : "",
      'city '           => isset($arrData['city']) ? $arrData['city'] : "",
      'country '        => isset($arrData['country']) ? $arrData['country'] : "",
      'instagram '      => isset($arrData['instagram']) ? $arrData['instagram'] : "",
      'portfolio '      => isset($arrData['portfolio']) ? $arrData['portfolio'] : "",
      'picture_profile' => isset($arrData['picture_profile']) ? $arrData['picture_profile'] : ""
    ];

    return $db->table('personal_data')->insert($data) == true ? true : false ;

  }


}

?>
