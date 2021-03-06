<?php
if(isset( $_POST['txt_email'] )){
    ob_start();
    $email =  $_POST['txt_email'];
    if(!empty($email)){
        $dangnhap = new dangnhapModel(null,$email,null,null,null);
        if($dangnhap->CheckEmailExist()){
            // get account by email
            $data = $dangnhap->GetInforByEmail();
            $pass = base64_decode($data['matKhau']);
            $url_login = SITE_NAME;
            $inforMail = array(
                'emailTo'=>$email,
                'subject'=>"Send mail forgot password",
                'body'=>MessageNoti::MS_400($pass,$url_login)
            );
            $mail = new Mail();
            $result = $mail->send($inforMail);
            if($result){
                $_SESSION['message-forgotmail'] = MessageNoti::$msgSendMailSuccessfully;
                $_SESSION['status'] = true;
                header("Location: /forgot-password",301);
                exit();
            }else{
                $_SESSION['message-forgotmail'] = MessageNoti::$msgSendMailFailed;
                $_SESSION['status'] = false;
                header("Location: /forgot-password",301);
                exit();
            }
        }else{
            $_SESSION['message-forgotmail'] = MessageNoti::$msgEmailNotExist;
            $_SESSION['status'] = false;
            header("Location: /forgot-password",301);
            exit();
        }
    }
    ob_end_flush();
    
}
