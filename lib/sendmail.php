<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'lib/PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'lib/PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'lib/PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php';
require 'lib/PHPMailer/vendor/autoload.php';
    class Mail{

        public $mail;
        public function __construct(){
            $this->mail = new PHPMailer(true);
            $this->mail->SMTPDebug = 0;                                 
            $this->mail->isSMTP();                                      
            $this->mail->Host = MAIL_HOST;  
            $this->mail->SMTPAuth = true;                               
            $this->mail->Username = MAIL_SEND;                 
            $this->mail->Password = MAIL_PASSWORD;                           
            $this->mail->SMTPSecure = MAIL_SMTP_SECURE;                            
            $this->mail->Port = 587;
            $this->mail->CharSet = "UTF-8";    
            $this->mail->isHTML(true);  
            $this->mail->setFrom(MAIL_SEND , APP_NAME);  
            
        }
        public  function send( $infor=array() ){
            if( isset($infor['emailTo']) && !empty($infor['emailTo'])  ){                           
                try {
                    $this->mail->addAddress( $infor['emailTo'] );                     
                    $this->mail->Subject = $infor['subject'];
                    $this->mail->Body    =  $infor['body'];
                    $this->mail->send();
                    return true;
                } catch (Exception $e) {
                    return false;
            }
        }
    }
}
