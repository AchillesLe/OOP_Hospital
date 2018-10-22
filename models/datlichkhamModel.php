<?php 
    class datlichkhamModel{
        public $table = "tbldatlichkham";
        public $id;
        public $idBenhnhan;
        public $idBacsi;
        public $soTT;
        public $ngayHen;
        public $gioHen;
        public $soDT;
        public $lyDo;
        public $chuDong;
    
        function __construct() {
            $argv = func_get_args();
            switch( func_num_args() ) {
                case 0:
                    self::__construct1( );
                    break;
                case 8:
                    self::__construct2( $argv[0], $argv[1], $argv[2], $argv[3], $argv[4] , $argv[5] ,$argv[6] , $argv[7]);
                    break;
             }
        }
    
        function __construct1( ) {
         
        } 
    
        function __construct2($idBenhnhan,$idBacsi,$soTT,$ngayHen,$gioHen,$soDT,$lyDo,$chuDong){
            $this->idBenhnhan = $idBenhnhan;
            $this->idBacsi = $idBacsi;
            $this->soTT = $soTT;
            $this->ngayHen = $ngayHen;
            $this->gioHen = $gioHen;
            $this->soDT = $soDT;
            $this->lyDo = $lyDo;
            $this->chuDong = $chuDong;
        }
        public function UpdateConfirmDone($id){
            $conn = connection::_open();
            $sql = "UPDATE tbldatlichkham SET tinhTrang = '0' WHERE id='{$id}'" ;
            $data = mysqli_query($conn,$sql);
            return $data;
        }
        public function GetAllLichKhamByIdbacsiAndNgay($idbacsi,$ngay){
            $conn = connection::_open();
            $sql = "SELECT * FROM tbldatlichkham A , tblbenhnhan B WHERE A.idBenhnhan = B.id AND idBacsi = '{$idbacsi}'  AND ngayHen = '{$ngay}' AND tinhTrang = '1' ORDER BY soTT ASC ";
            $result = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
            connection::_close($conn);
            return $result;
        }
        public function insert(){
            $conn = connection::_open();
            $sql = "INSERT INTO tbldatlichkham(idBenhnhan,idBacsi,soTT,ngayHen,gioHen,soDT,lyDo)
                VALUES('{$this->idBenhnhan}','{$this->idBacsi}','{$this->soTT}','{$this->ngayHen}','{$this->gioHen}','{$this->soDT}','{$this->lyDo}')";
            connection::_close($conn);
            $data = mysqli_query($conn,$sql);
            return $data;
        }
        public function insertHasChuDong(){
            $conn = connection::_open();
            $sql = "INSERT INTO tbldatlichkham(idBenhnhan,idBacsi,soTT,ngayHen,gioHen,soDT,lyDo)
                VALUES('{$this->idBenhnhan}','{$this->idBacsi}','{$this->soTT}','{$this->ngayHen}','{$this->gioHen}','{$this->soDT}','{$this->lyDo}')";
            $data = mysqli_query($conn,$sql);
            connection::_close($conn);
            return $data;
        }
        public function CheckDuplicateKhoa($id_benhnhan,$ngay,$idkhoa){
            //Kiểm tra trùng khoa
            $conn = connection::_open();
            $sql  = "SELECT * FROM tbldatlichkham A , tblbacsi  B WHERE A.idBacsi = B.id AND A.idBenhnhan = {$id_benhnhan}  AND ngayHen='{$ngay}' AND B.idkhoa = {$idkhoa}  ";
            $data = mysqli_query($conn,$sql)->num_rows;
            connection::_close($conn);
            return $data;
        }
        public function CheckDuplicateDatetime($id_benhnhan,$ngay,$indextime){
            //Kiểm tra lịch hẹn  có trùng ngày giờ 
            $conn = connection::_open();
            $sql  = "SELECT * FROM tbldatlichkham WHERE idBenhnhan ='{$id_benhnhan}' AND ngayHen='{$ngay}' AND soTT='{$indextime}'  ";
            $data = mysqli_query($conn,$sql)->num_rows;
            connection::_close($conn);
            return $data;
        }
        public function CheckBacsiDuplicateLich($id_benhnhan,$id_bacsi,$ngay,$indextime){
            //Kiểm tra lịch hẹn có trùng ngày giờ và bác sĩ với người khác hay không
            $conn =  connection::_open();
            $sql  = "SELECT * FROM tbldatlichkham WHERE idBenhnhan !='{$id_benhnhan}'
                                                    AND idBacsi='{$id_bacsi}' 
                                                    AND ngayHen='{$ngay}' 
                                                    AND soTT='{$indextime}'  ";
            $data = mysqli_query($conn,$sql)->num_rows;
            connection::_close($conn);
            return $data;
        }
        public function CheckMultiBacsiDuplicateLich($id_benhnhan,$ngayhen,$stt){
            $conn = connection::_open();
            $sql = "SELECT * FROM tbldatlichkham A WHERE  A.idBenhnhan = '{$id_benhnhan}' AND A.ngayHen = '{$ngayhen}' AND A.soTT = '{$stt}'";
            $data = mysqli_query($conn,$sql)->num_rows;
            connection::_close($conn);
            return $data;
        }
        public function CheckBacsiHasLichHen($id_bacsi,$ngayhen,$stt){
            $conn = connection::_open();
            $sql = "SELECT * FROM tbldatlichkham A WHERE  A.idBacsi = '{$id_bacsi}' AND A.ngayHen = '{$ngayhen}' AND A.soTT = '{$stt}'";
            $data = mysqli_query($conn,$sql)->num_rows;
            connection::_close($conn);
            return $data;
        }
        public function Check_001($id_bacsi,$id_benhnhan,$ngayhen){
            $conn = connection::_open();
            $sql = "SELECT * FROM tblbacsi WHERE id='{$id_bacsi}' AND idKhoa in (SELECT B.idKhoa FROM tbldatlichkham A,tblbacsi B WHERE A.idBacsi = B.id AND A.idBenhnhan = '{$id_benhnhan}' AND A.ngayHen = '{$ngayhen}') ";
            $data = mysqli_query($conn,$sql)->num_rows;
            return $data;
        }

    }
?>