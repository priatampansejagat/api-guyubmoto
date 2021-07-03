<?php
namespace App\Libraries;

class Mailib{

  private $from;
  private $to;
  private $subject;
  private $message;

  private $headers;


  public function _init($from,$to,$subject,$message,$headersArr=array()){

    $this->from = $from;
    $this->to = $to;
    $this->subject = $subject;
    $this->message = $message;

    $this->headers = "MIME-Version: 1.0" . "\r\n";
    $this->headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $this->headers .= $this->from . "\r\n";

    for ($i=0; $i < count($headersArr); $i++) {
      $this->headers .= $headersArr[$i] . "\r\n";
    }
  }

  public function send_mail(){
    mail($this->to,$this->subject,$this->message,$this->headers);
  }

  public function check(){
    $mail_data = array( 'from' => $this->from,
                        'to'  => $this->to,
                        'subject' => $this->subject,
                        'message' => $this->message,
                        'headers' => $this->headers
    );

    return json_encode($mail_data);
  }
}
?>
