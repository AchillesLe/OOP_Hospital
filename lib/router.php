<?php 

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
if( isset($_SESSION['user'] ) ){
    if( $_SESSION['user']['quyen'] == 1 ){
        // Chỉ bệnh nhân có thể truy cập
        switch( $request_uri[0] ){ 
            case '/dangki-lichkham':
                require 'views/dangkilichkham.php';
                exit();
            case '/dat-lich-xet-nghiem':
                require 'include/tracuu.php';
                exit();
            case '/ho-so-benh-an':
                require 'views/ho-so-benh-an.php';
                exit();
            default:
                break;
        }
    }
    else{
        // chỉ bác sĩ  có thể truy cập
        
        switch( $request_uri[0] ){  
            case '/ho-so-benh-an':
                require 'views/ho-so-benh-an.php';
                exit();
            case '/them-ho-so-benh-an':
                require 'views/thembenhAn.php';
                exit();
            case '/sua-benh-an':
                require 'views/suabenhan.php';
                exit();
            case '/p-benh-an':
                require 'include/benh-An.php';
                exit();
            case '/danh-sach-benh-nhan':
                require 'views/danh_sach_benh_nhan.php';
                exit();
            case '/dat-hen':
                require 'views/dangkilichhen.php';
                exit();
            case '/xem-benh-an':
                require 'include/benhAn-bacsi.php';
                exit();
            default:
                break;
        }
        
    }
// bác sĩ và bệnh nhân đểu có thể truy cập
    switch( $request_uri[0] ){ 
        case '/':
            require 'views/home.php';
            exit();
        case '/inforbasic':
            require 'views/information.php';
            exit();
        case '/p-inforbasic':
            require 'include/update-infor.php';
            exit();
        case '/get-bacsi-by-idKhoa':
                require 'include/khoa.php';
                exit();
        case '/p-dangki-lichkham':
            require 'include/lichkham.php';
            exit();
        case '/comfirm-done':
            require 'include/lichkham.php';
            exit();
        case '/check-lichkham':
            require 'include/lichkham.php'; 
            exit();
        case '/phong-kham':
            require 'views/phong-kham.php';
            exit();
        case '/phong-xet-nghiem':
            require 'views/phong-xet-nghiem.php';
            exit();
        case '/tra-cuu':
            require 'include/tracuu.php';
            exit();
        case '/chi-tiet-benh-an':
            require 'views/chitietbenhan.php';
            exit();
        case '/dangxuat':
            require 'include/dangxuat.php';
            exit();
        default:
            require 'views/404.php';
            exit();
    }
    
}else{
    // bất kì ai có thể truy cập
    switch ($request_uri[0]) {
        case '/':
            require 'views/dangnhap.php';
            exit();
        case '/p-dangnhap':
            require 'include/dangnhap.php';
            exit();
        case '/dangki':
            require 'views/dangki.php';
            exit();
        case '/p-dangki':
            require 'include/dangki.php';
            exit();
        case '/forgot-password':
            require 'views/forgot-pass.php';
            exit();
        case '/p-forgotpassword':
            require 'include/forgot-pass.php';
            exit();
        default:
            require 'views/404.php';
            exit();
    }
}
?>