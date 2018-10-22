<?php 
class bacsiModel{
    public $table ="tblbacsi";
    public $id;
    public $idBenhnhan;
    public $ten;
    public $idKhoa;
    public $ngaySinh;
    public $gioiTinh;
    public $diaChi;
    public $CMND;
    public $danToc;
    public $trinhDo;
    public $BHYT;
    public $soDT;
    public $idDangnhap;

    function __construct() {
        $argv = func_get_args();
        switch( func_num_args() ) {
            case 0:
                self::__construct1( );
                break;
            case 12:
                self::__construct2( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5], $argv[6], $argv[7], $argv[8], $argv[9], $argv[10], $argv[11] );
                break;
         }
    }

    function __construct1( ) {
     
    } 

    function __construct2($id,$ten,$gioiTinh,$diaChi,$ngaySinh,$soDT,$CMND,$danToc,$BHYT,$idDangnhap,$idKhoa,$trinhDo){
        $this->id = $id;
        $this->ten = $ten;
        $this->gioiTinh = $gioiTinh;
        $this->diaChi = $diaChi;
        $this->ngaySinh = $ngaySinh;
        $this->soDT = $soDT;
        $this->CMND = $CMND;
        $this->danToc = $danToc;
        $this->BHYT = $BHYT;
        $this->idDangnhap = $idDangnhap;
        $this->idKhoa = $idKhoa;
        $this->trinhDo = $trinhDo;
    }
    public function GetAll(){
        $conn = connection::_open();
        $sql = "SELECT * FROM {$this->table} ";
        $data = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }
    public function GetAllBacsiByIdKhoa($idKhoa){
        try{
            $conn = connection::_open();
            $sql = "SELECT * FROM {$this->table} where idKhoa = '{$idKhoa}'";
            $data = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $data;
        } catch (Exception $e) {
            return null;
        }
       
    }
    public function GetinforKhoaAndbacSi($id_bacsi){
        $conn = connection::_open();
        $sql = "SELECT * FROM tblbacsi A , tblkhoa B WHERE A.idKhoa=B.id AND A.id = $id_bacsi ";
        $data = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }

    public function CheckCMND($cmt){
        $conn = connection::_open();
        $sql = "SELECT * FROM {$this->table}  WHERE  CMND = '{$cmt}'";
        $data = mysqli_query($conn,$sql)->num_rows;
        connection::_close($conn);
        if( $data == 0){
            return false;
        }
        return true;
    }
    public function CheckBHYT($bhyt){
        $conn = connection::_open();
        $sql = "SELECT * FROM {$this->table}  WHERE  BHYT = '{$bhyt}'";
        $data = mysqli_query($conn,$sql)->num_rows;
        connection::_close($conn);
        if( $data == 0){
            return false;
        }
        return true;
    }
    public function update(){
        try {
            $conn = connection::_open();
            $sql = "UPDATE {$this->table} SET ten = '{$this->ten}' , gioiTinh ='{$this->gioiTinh}',soDT= '{$this->soDT}',ngaySinh ='{$this->ngaySinh}',diaChi = '{$this->diaChi}',CMND = '{$this->CMND}',danToc = '{$this->danToc}', BHYT = '{$this->BHYT}'  WHERE id = '{$this->id}'";
            $data = mysqli_query($conn,$sql);
            connection::_close($conn);
            if($data == true){
                return true;
            }
            return false;
            
        } catch (Exception $e) {
            return false;
        }
    }

    public function GetAllBacsiNoLichKhamInDay($idkhoa,$ngaykham){
        $conn = connection::_open();
        $sql = "SELECT F.id FROM tblbacsi F WHERE   F.idKhoa ='{$idkhoa}' AND F.id NOT IN 
            ( SELECT A.id FROM  tblbacsi A JOIN tbldatlichkham  B ON A.id = B.idBacsi  WHERE ngayhen='{$ngaykham}' ) ";
         $data = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }

    public function GetBacsiItLichKhamTrongNgayNhat($idkhoa,$ngaykham){
        // Những bác sĩ trong khoa có lịch khám bệnh trong ngày ít nhất
        $conn = connection::_open();
        $sql = "SELECT B.id ,count(C.id) as sohen 
        FROM  tblkhoa A
            JOIN tblbacsi B ON A.id = B.idKhoa
            LEFT  JOIN tbldatlichkham  C ON B.id = C.idBacsi		
        WHERE A.id = '{$idkhoa}'  AND C.ngayhen='{$ngaykham}' 
                    GROUP BY B.id  ORDER BY sohen ASC";
        connection::_close($conn);
        $data = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
        return $data;
    }
}