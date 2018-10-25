<?php 
/**
 * (2) Xử lý đăng kí tài khoản
 *      1. Nhấn nút Đăng kí thì thực hiện xử lý.
 * 
 */
if (isset($_POST['submit-form-dangki'])) {

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
    $birthday = date("Y-m-d", strtotime($birthday));
    $password = $_POST['txt_password'];

    /**
     * (2) Xử lý đăng kí tài khoản
     *      2. Xử lý check
     *          a. Check hạng mục
     *              17,18:Check tồn tại BHYT or CMND?
     */
    $bnModel = new benhnhanModel(null, $name, $sex, $address, $birthday, $sdt, $cmt, $dantoc, $job, $bhyt, 1, null);
    $data = $bnModel->CheckBeforeInsert();
    if ($data == false) {
        $_SESSION['message-register'] = MessageNoti::$msgBHYTOrCMNDExist;
        header("Location: /dangki", 301);
        exit();
    }

    /**
     * (2) Xử lý đăng kí tài khoản
     *      2. Xử lý check
     *          a. Check hạng mục
     *              19:Check tồn tại Email?
     */
    $dangnhapModel = new dangnhapModel(0, $email, $password, 1, 0);
    if ($dangnhapModel->CheckEmailExist() == true) {
        $_SESSION['message-register'] = MessageNoti::$msgEmailExist;
        header("Location: /dangki", 301);
        exit();
    }

    /**
     * (3) Xử lý lưu thông tin tài khoản
     *      (1) Lưu thông tin vào tbldangnhap
     */
    $idDangnhap = $dangnhapModel->InsertLastId();
    if ($idDangnhap) {
        $bnModel->idDangnhap = $idDangnhap;
        //(2) Lưu thông tin vào tblbenhnhan
        if ($bnModel->insert() == false) {
            $_SESSION['message-register'] = MessageNoti::$msgRegisterFailed;
            header("Location: /dangki", 301);
            exit();
        }
    } else {
        $_SESSION['message-register'] = MessageNoti::$msgRegisterFailed;
        header("Location: /dangki", 301);
        exit();
    }
}

/**
 * (4) Xử lý lưu thông tin thành công
 *      Hiện message thông báo đăng kí thành công
 */
$_SESSION['message-register'] = MessageNoti::$msgRegisterSuccessfully;
header("Location: /", 301);
exit();
?>