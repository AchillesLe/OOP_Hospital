<?php 
class benhnhanModel
{
    public $table = "tblbenhnhan";
    public $id;
    public $ten;
    public $gioiTinh;
    public $diaChi;
    public $ngaySinh;
    public $soDT;
    public $CMND;
    public $danToc;
    public $ngheNghiep;
    public $BHYT;
    public $ngoaiTuyen = 0;
    public $idDangnhap;

    function __construct()
    {
        $argv = func_get_args();
        $num = func_num_args();
        switch ($num) {
            case 0:
                self::__construct1();
                break;
            case 12:
                self::__construct2($argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8], $argv[9], $argv[10], $argv[11]);
                break;
        }
    }

    function __construct1()
    {

    }
    public function __construct2($id, $ten, $gioiTinh, $diaChi, $ngaySinh, $soDT, $CMND, $danToc, $ngheNghiep, $BHYT, $ngoaiTuyen, $idDangnhap)
    {
        $this->id = $id;
        $this->ten = $ten;
        $this->gioiTinh = $gioiTinh;
        $this->diaChi = $diaChi;
        $this->ngaySinh = $ngaySinh;
        $this->soDT = $soDT;
        $this->CMND = $CMND;
        $this->danToc = $danToc;
        $this->ngheNghiep = $ngheNghiep;
        $this->BHYT = $BHYT;
        $this->ngoaiTuyen = $ngoaiTuyen;
        $this->idDangnhap = $idDangnhap;
    }

    //Lấy tất cả các thông tin của bệnh nhân của cùng một Bác sĩ
    public function getAllByBacsiID($id_bacsi)
    {
        try {
            $conn = connection::_open();
            $sql = "SELECT DISTINCT B.id ,
                                    B.ten, 
                                    B.soDT , 
                                    B.ngaySinh , 
                                    B.CMND ,
                                    B.BHYT 
                    FROM tblbenhan A, 
                         tblbenhnhan B 
                    WHERE A.idBenhnhan = B.id AND A.idBacsi =  '{$id_bacsi}' ";
            $result = mysqli_query($conn, $sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $result;
        } catch (Exception $ex) {
            return null;
        }
    }

    //Lấy thông tin từ bảng tblbenhnhan có id?
    public function getAllByID($id)
    {
        try {
            $conn = connection::_open();
            $sql = "SELECT * 
                    FROM $this->table 
                    WHERE id='{$id}' ";
            $result = mysqli_query($conn, $sql)->fetch_array(MYSQLI_ASSOC);
            connection::_close($conn);
            return $result;
        } catch (Exception $ex) {
            return null;
        }
    }

    //Insert vào database
    public function insert()
    {
        try {
            $conn = connection::_open();
            $sql = "INSERT INTO tblbenhnhan(ten,
                                            gioiTinh,
                                            diaChi,
                                            ngaySinh,
                                            soDT,
                                            CMND,
                                            danToc,
                                            ngheNghiep,
                                            BHYT,
                                            ngoaiTuyen,
                                            idDangnhap) 
                    VALUES ('{$this->ten}',
                            '{$this->gioiTinh}',
                            '{$this->diaChi}',
                            '{$this->ngaySinh}',
                            '{$this->soDT}',
                            '{$this->CMND}',
                            '{$this->danToc}',
                            '{$this->ngheNghiep}',
                            '{$this->BHYT}',
                            '{$this->ngoaiTuyen}',
                            '{$this->idDangnhap}')";
            $data = mysqli_query($conn, $sql);
            connection::_close($conn);
            if ($data) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }

    //Check trước khi insert vào databse
    public function CheckBeforeInsert()
    {
        $conn = connection::_open();
        if (!empty($this->BHYT) || !empty($this->CMND)) {
            if (!empty($this->BHYT) && !empty($this->CMND)) {
                $sql = "SELECT * 
                        FROM tblbenhnhan 
                        WHERE CMND = '{$this->CMND}' OR BHYT='{$this->BHYT}'";
            } else if (empty($this->CMND) && !empty($this->BHYT)) {
                $sql = "SELECT * 
                        FROM tblbenhnhan 
                        WHERE  BHYT='{$this->BHYT}'";
            } else {
                $sql = "SELECT * 
                        FROM tblbenhnhan 
                        WHERE  CMND = '{$this->CMND}'";
            }
            $data = mysqli_query($conn, $sql)->num_rows;
            connection::_close($conn);
            if ($data != 0) {
                 /**
                * (2) Xử lý đăng kí tài khoản
                *      2. Xử lý check
                *          a. Check hạng mục
                *              Check tồn tại BHYT or CMND?
                */
                return false;
            }
        }
        return true;
    }
    
    //Kiểm tra CMND có tồn tại?
    public function CheckCMND($cmt)
    {
        $conn = connection::_open();
        $sql = "SELECT * 
                FROM {$this->table}  
                WHERE  CMND = '{$cmt}'";
        $data = mysqli_query($conn, $sql)->num_rows;
        if ($data == 0) {
            return false;
        }
        return true;
    }

    //Kiểm tra BHYT có tồn tại?
    public function CheckBHYT($bhyt)
    {
        $conn = connection::_open();
        $sql = "SELECT * 
                FROM {$this->table}  
                WHERE  BHYT = '{$bhyt}'";
        $data = mysqli_query($conn, $sql)->num_rows;
        if ($data == 0) {
            return false;
        }
        return true;
    }

    // Cập nhật Profile
    public function update($arrayinfor)
    {
        try {
            $conn = connection::_open();
            $sql = "UPDATE {$this->table} 
                    SET ten = '{$this->ten}' , 
                        gioiTinh ='{$this->gioiTinh}',
                        soDT= '{$this->soDT}',
                        ngaySinh ='{$this->ngaySinh}',
                        diaChi = '{$this->diaChi}',
                        CMND = '{$this->CMND}',
                        danToc = '{$this->danToc}', 
                        BHYT = '{$this->BHYT}'  
                    WHERE id = '{$this->id}'";
            $data = mysqli_query($conn, $sql);
            connection::_close($conn);
            if ($data == true) {
                return true;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    //Lấy tất cả thông tin bệnh án của id Bệnh nhân, id Bác sĩ?
    public function GetALLBenhAnBY_IDBN_IDBACSI($id_benhnhan, $id_bacsi)
    {
        try {
            $conn = connection::_open();
            $sql = "SELECT  A.*,
                            A.id 
                    AS id_ba,
                            B.*,
                            B.id 
                    AS id_bn 
                    FROM tblbenhan A , 
                         tblbenhnhan B 
                    WHERE A.idBenhnhan = B.id 
                    AND A.idBenhnhan = '{$id_benhnhan}'
                    AND A.idBacsi =  '{$id_bacsi}' ";
            $benhAn = mysqli_query($conn, $sql)->fetch_all(MYSQLI_ASSOC);
            return $benhAn;
        } catch (Exception $e) {
            return null;
        }
    }

    //Lấy tất cả thông tin bệnh án của Bệnh nhân có id?
    public function GetALLBenhAnBY_IDBN($id_benhnhan)
    {
        try {
            $conn = connection::_open();
            $sql = "SELECT  A.*,
                            A.id 
                    AS id_ba,
                            B.*,
                            B.id 
                    AS id_bn 
                    FROM tblbenhan A , 
                    tblbenhnhan B 
                    WHERE A.idBenhnhan = B.id 
                    AND A.idBenhnhan = '{$id_benhnhan}' ";
            $benhAn = mysqli_query($conn, $sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $benhAn;
        } catch (Exception $e) {
            return null;
        }
    }

    //Lịch khám của Bác sĩ có id?
    public function GetALLLichKhamBY_IDBACSI($id_bacsi)
    {
        try {
            $conn = connection::_open();
            $sql = "SELECT  A.*,
                            B.id 
                    AS benh_nhan_id , 
                            B.ten 
                    FROM tbldatlichkham A , 
                         tblbenhnhan B 
                    WHERE A.idBenhnhan = B.id AND A.idBacsi='{$id_bacsi}' 
                    ORDER BY A.ngayHen DESC";
            $data = mysqli_query($conn, $sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $data;
        } catch (Exception $e) {
            return null;
        }
    }
    public function GetALLLichKham($id_benhnhan){
        $conn = connection::_open();
        $sql = "SELECT A.*,  B.id as bs_id , B.ten 
                FROM tbldatlichkham A , tblbacsi B 
                WHERE A.idBacsi = B.id AND A.idBenhnhan='{$id_benhnhan}' ORDER BY A.ngayHen DESC";
        $data = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }
}
?>