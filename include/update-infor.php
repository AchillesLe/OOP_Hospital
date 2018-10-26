<?php 
    if(isset($_POST['submit-update-infor']) && isset($_SESSION['user']) ){
        $user = $_SESSION['user'];
        $id= $_POST['id'];
        $idDangnhap= $_POST['idDangnhap'];
        $name = $_POST['txt_name'];
        $sex = $_POST['rd_sex'];
        $address = $_POST['txt_address'];
        $birthday = str_replace('/', '-', $_POST['txt_birthday']);
        $bhyt = $_POST['txt_bhyt'];
        $cmt = $_POST['txt_cmt'];
        $job = $user['quyen']==1 ? $_POST['txt_nghe'] : "";
        $dantoc = $_POST['txt_dantoc'];
        $email = $_POST['txt_email'];
        $sdt = $_POST['txt_sdt'];
        $birthday = date("Y-m-d", strtotime($birthday) );
        $password = $_POST['txt_pass'];
        $table = $user['quyen']==1?"tblbenhnhan":"tblbacsi";
        $table2 = $table=='tblbacsi'?'tblbenhnhan':'tblbacsi';

        // Validate dữ liệu trên này
        $benhnhanModel = new benhnhanModel($id,$name,$sex,$address, $birthday,$sdt,$cmt,$dantoc,$job,$bhyt,0,$idDangnhap);
        $bacsiModel = new bacsiModel($id,$name,$sex,$address, $birthday,$sdt,$cmt,$dantoc,$bhyt,0,null,$idDangnhap);
        $dangnhapModel = new dangnhapModel($idDangnhap,$email,$password,$user["quyen"],0);
        // kiểm tra cmt đã tồn tại hay chưa
        if( $cmt != $user['CMND'] && $cmt!='' ){
            $checkCMND = $benhnhanModel->CheckCMND($cmt);
            if( $checkbenhnhan == false){
                $checkCMND  = $bacsiModel->CheckCMND($cmt);
            }
            if( $checkCMND == true ){
                $_SESSION['message-update-infor'] = MessageNoti::$msgCMNDExist;
                $_SESSION['status'] = false;
                echo "<meta http-equiv='Refresh' content='0;URL=/inforbasic' />";
                exit();
            }
        }
        // kiểm tra bảo hiểm y tế đã tồn tại hay chưa
        if( $bhyt != $user['BHYT'] && $bhyt!='' ){
            $checkBHYT =  $benhnhanModel->CheckBHYT($bhyt);
            if($checkBHYT == false){
                $checkBHYT =  $bacsiModel->CheckBHYT($bhyt);
            }
            if( $checkBHYT == true ){
                $_SESSION['message-update-infor'] = MessageNoti::$msgBHYTExist;
                $_SESSION['status'] = false;
                echo "<meta http-equiv='Refresh' content='0;URL=/inforbasic' />";
                exit();
            }
        }
        // kiểm tra email đã tồn tại hay chưa
        if( $email != $user['Email'] && $bhyt!='' ){
            $checkEmail = $dangnhapModel->CheckEmail($email);
            if(  $checkEmail == true ){
                $_SESSION['message-update-infor'] = MessageNoti::$msgEmailExist;
                $_SESSION['status'] = false;
                echo "<meta http-equiv='Refresh' content='0;URL=/inforbasic' />";
                exit();
            }
        }
        // cập nhật thông tin đăng nhập
        $data = $dangnhapModel->UpdateLogin();
        if($data == true){
            // Cập nhật infor
            if( $table == $benhnhanModel->table ){
                $data = $benhnhanModel->update();
            }else{
                $data = $bacsiModel->update();
            }
            if(!$data){
                $_SESSION['message-update-infor'] = MessageNoti::$msgUpdateFailed;
                $_SESSION['status'] = false;
                echo "<meta http-equiv='Refresh' content='0;URL=/inforbasic' />";
                exit();
            }
            $data = $dangnhapModel->GetInforLogin($table,$id);
            if($data ){
                $_SESSION['user'] = $data;
            }
        }
        $_SESSION['message-update-infor'] = MessageNoti::$msgUpdateSuccessfully;
        $_SESSION['status'] = true;
        echo "<meta http-equiv='Refresh' content='0;URL=/inforbasic' />";
        exit();
    }
?>