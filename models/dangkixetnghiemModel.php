<?php 
    class dangkixetnghiemModel{
        public $table = "tbldangkixetnghiem";
        public $id;
        public $idBenhnhan;
        public $idXetnghiem;
        public $soTT;
        public $ngay;
        public $gio;

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

        function __construct2($idBenhnhan,$idXetnghiem,$soTT,$ngay,$gio){
            $this->idBenhnhan = $idBenhnhan;
            $this->idXetnghiem = $idXetnghiem;
            $this->soTT = $soTT;
            $this->ngay = $ngay;
            $this->gio = $gio;
        }
        public function insert(){
            $conn = connection::_open();
            $sql = "INSERT INTO tbldangkixetnghiem (idBenhnhan,idXetnghiem,soTT,ngay,gio) VALUES('{$this->idBenhnhan}','{$this->idXetnghiem}','{$this->soTT}','{$this->ngay}','{$this->gio}')";
            $result = mysqli_query($conn,$sql);
            connection::_close($conn);
            return $result;
        }
        public function GetAllLichXetNghiemByIdXNAndNgay($idXN,$ngay){
            $conn = connection::_open();
            $sql = "SELECT * FROM tbldangkixetnghiem A , tblbenhnhan B WHERE A.idBenhnhan = B.id AND idXetNghiem = '{$idXN}'  AND ngay = '{$ngay}' AND tinhTrang = '0' ORDER BY soTT ASC ";
            $result = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $result;
        }
        public function GetAllLichXetNghiemByIdBN($id_BN,$ngay,$id_time_XN){
            $conn = connection::_open();
            $sql = " SELECT * FROM tbldangkixetnghiem A , tblxetnghiem B WHERE A.idXetnghiem = B.id AND idBenhnhan = '{$id_BN}'  AND ngay = '{$ngay}' AND soTT = '{$id_time_XN}' ";
            $result = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $result;
        }
        public function GetLanThu($id_XN,$id_BN){
            $conn = connection::_open();
            $sql = "SELECT A.lanThu FROM tblphieuxetnghiem A , tblbenhan B  WHERE A.idBenhan = B.id AND A.idXetnghiem = '{$id_XN}' AND B.idBenhnhan= '{$id_BN}'
            ORDER BY A.lanThu  DESC ";
            $result = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $result;
        }
        public function GetInforBy($id_XN,$ngay,$id_time_XN){
            $conn = connection::_open();
            $sql = " SELECT * FROM tbldangkixetnghiem A , tblxetnghiem B WHERE A.idXetnghiem = B.id AND idXetnghiem = '{$id_XN}'  AND ngay = '{$ngay}' AND soTT = '{$id_time_XN}' ";
            $result = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
            connection::_close($conn);
            return $result;
        }
    }
?>