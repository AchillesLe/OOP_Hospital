<?php 
    if(isset($_POST['submit-form-dangki'])){

        $name = $_POST['txt_name'];
        $sex = $_POST['rd_sex'];
        $address = $_POST['txt_address'];
        $birthday = str_replace('/', '-', $_POST['txt_birthday']);
        $bhyt = $_POST['txt_bhyt'];
        $cmt = $_POST['txt_cmt'];
        $job = $_POST['txt_nghe'];
        $dantoc = $_POST['txt_dantoc'];
        $email = $_POST['txt_email'];
        $sdt = $_POST['txt_sdt'];
        $birthday = date("Y-m-d", strtotime($birthday) );
        $password = $_POST['txt_password'];
        
        $bnModel = new benhnhanModel(null,$name,$sex,$address,$birthday,$sdt,$cmt,$dantoc,$job,$bhyt,1,null);
        $message = $bnModel->CheckBeforeInsert();
        if($message!=""){
            $_SESSION['message-register'] = $message;
            header("Location: /dangki",301);
            exit();
        }
        $dangnhapModel = new dangnhapModel(0,$email,$password,1,0);
        if($dangnhapModel->CheckEmailExist() == true){
            $_SESSION['message-register'] = MessageNoti::$msgEmailExist;
            header("Location: /dangki",301);
            exit();
        }
        $idDangnhap = $dangnhapModel->InsertLastId();
        if($idDangnhap){
            $bnModel->idDangnhap = $idDangnhap;
            if($bnModel->insert() == false){
                $_SESSION['message-register'] = MessageNoti::$msgRegisterFailed;
                header("Location: /dangki",301);
                exit();
            }
        }else{
            $_SESSION['message-register'] = MessageNoti::$msgRegisterFailed;
            header("Location: /dangki", 301);
            exit();
        }
    }
    $_SESSION['message-register'] = MessageNoti::$msgRegisterSuccessfully;
    header("Location: /", 301);
    exit();
?>