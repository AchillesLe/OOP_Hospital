<?php 
/**
 * (2) Xử lý đăng nhập
 *      1. Nhấn nút Đăng nhập thì thực hiện xử lý.
 * 
 */
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['matkhau'];
    $dangnhap = new dangnhapModel(null, $email, $password, null, 0);
    $userLogin = $dangnhap->Login($email, $password);

    /**
     * (2) Xử lý đăng nhập
     *      2. Xử lý check
     */
    if (!empty($userLogin)) {
        /**
         * (2) Xử lý đăng nhập
         *      3. Lưu thông tin session 
         */
        $_SESSION['user'] = $userLogin;

        /**
         * (2) Xử lý đăng nhập 
         *      4. Xử lý tạo file log Log_DDMMYYYY.txt và thực hiện xuất logs
         */

        $today = date("Y-m-d");
        $filelog = LOG_PATH . "/log_" . $today . ".txt";
        $infor = '[' . date('Y-m-d h:i:s') . '] [client ' . $_SERVER['REMOTE_ADDR'] . ']';
        $content = $infor . "------" . $userLogin["ten"] . " đăng nhập vào hệ thống !\r\n";
        if (file_exists($filelog)) {
            $handle = fopen($filelog, 'a+') or die('Cannot open file:  ' . $filelog);
            fwrite($handle, $content);
            fclose($handle);
        } else {
            $handle = fopen($filelog, 'wb+') or die('Cannot open file:  ' . $filelog);
            fwrite($handle, $content);
            fclose($handle);
        }
    } else {
        $_SESSION['message-login'] = MessageNoti::$MSG_01;
    }

    header('Location: /', 301);
    exit();
}
?>