<?php 
class dangnhapModel
{
    public $table = "tbldangnhap";
    public $id;
    public $Email;
    public $matKhau;
    public $quyen;
    public $tinhTrang = 0;

    function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                self::__construct1( );
                break;
            case 5:
                self::__construct2( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4] );
                break;
         }
    }

    function __construct1( ) {
     
    } 

    function __construct2($id, $Email, $matKhau, $quyen, $tinhTrang){
        $this->id = $id;
        $this->Email = $Email;
        $this->matKhau = $matKhau;
        $this->quyen = $quyen;
        $this->tinhTrang = $tinhTrang;
    }
    
    //Insert vào database
    public function Insert()
    {
        $conn = connection::_open();
        $sql = "INSERT INTO {$this->table}(Email,
                                        matKhau,
                                        quyen,
                                        tinhTrang) 
                VALUES ('{$this->Email}',
                        '{$this->matKhau}',
                        '{$this->quyen}',
                        '{$this->tinhTrang}')";
        $data = mysqli_query($conn, $sql);
        connection::_close($conn);
        if ($data != null) {
            return true;
        } else {
            return false;
        }
    }
    public function GetInforBenhNhan($id_benhnhan){
        $conn = connection::_open();
        $sql = "SELECT * FROM tblbenhnhan A, tbldangnhap B WHERE A.idDangnhap = B.id AND A.id= '{$id_benhnhan}'";
        $data = mysqli_query($conn, $sql)->fetch_array(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }
    //Insert vào database, trả về id lúc insert
    public function InsertLastId()
    {
        $conn = connection::_open();
        $matkhau = base64_encode($this->matKhau);
        $sql = "INSERT INTO {$this->table}(Email,
                                        matKhau,
                                        quyen,
                                        tinhTrang) 
                VALUES ('{$this->Email}',
                        '{$matkhau}',
                        '{$this->quyen}',
                        '{$this->tinhTrang}')";
        $data = mysqli_query($conn, $sql);
        $id = mysqli_insert_id($conn);
        connection::_close($conn);
        return $id;
    }

    //Kiểm tra Email đã tồn tại? 
    public function CheckEmailExist()
    {
        $conn = connection::_open();
        $sql = "SELECT * 
                FROM tbldangnhap 
                WHERE Email = '{$this->Email}'";
        $data = mysqli_query($conn, $sql)->num_rows;
        connection::_close($conn);
        if (intval($data) == 0) {
            return false;
        } else {
            return true;
        }
    }

    //Trả về thông tin đăng nhập
    public function Login($email, $password)
    {
        $conn = connection::_open();
        $login = array();
        $password = base64_encode($password);
        $sql = "SELECT * 
                FROM tblDangnhap 
                WHERE Email='{$email}' AND  matKhau='{$password}'";
        $result = mysqli_query($conn, $sql)->fetch_array(MYSQLI_ASSOC);
        if (!empty($result) && isset($result['quyen'])) {
            $result['matKhau'] = base64_decode($result['matKhau'] );
            $role = $result['quyen'];
            $idDangnhap = $result['id'];
            $result1 = [];
            if ($role == 1) {
                $sql = "SELECT * 
                        FROM tblbenhnhan 
                        WHERE idDangnhap = '$idDangnhap'";
                $result1 = mysqli_query($conn, $sql)->fetch_array(MYSQLI_ASSOC);
            } else {
                $sql = "SELECT * 
                        FROM tblbacsi 
                        WHERE idDangnhap = '{$idDangnhap}'";
                $result1 = mysqli_query($conn, $sql)->fetch_array(MYSQLI_ASSOC);
            }
            if (!empty($result1))
                $login = array_merge($result, $result1);

        }
        connection::_close($conn);
        return $login;
    }

    // Cập nhật đăng nhập thành công?
    public function UpdateLogin()
    {
        $conn = connection::_open();
        $encodeMatKhau = base64_encode($this->matKhau);
        $sql = "UPDATE  tbldangnhap 
                SET Email ='{$this->Email}', 
                    matKhau = '$encodeMatKhau' 
                WHERE id='{$this->id}'";
        $data = mysqli_query($conn, $sql);
        connection::_close($conn);
        if ($data == true) {
            return true;
        }
        return false;
    }
    //Lấy thông tin đăng nhập
    public function GetInforLogin($table, $id)
    {
        $conn = connection::_open();
        $sql = "SELECT * 
                FROM tbldangnhap B , 
                    {$table}  A  
                WHERE A.idDangnhap = B.id AND A.id='{$id}'";
        $data = mysqli_query($conn, $sql)->fetch_array(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }
    public function GetInforByEmail()
    {
        $conn = connection::_open();
        $sql = "SELECT * FROM tbldangnhap 
                WHERE Email='{$this->Email}'";
        $data = mysqli_query($conn, $sql)->fetch_array(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }
}
?>