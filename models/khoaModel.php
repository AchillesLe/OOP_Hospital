<?php 
class khoaModel{
    public $table ="tblkhoa";
    public $id;
    public $tenKhoa;
    public $lePhiKHam;
    public $donGiangayDem;

    public function __construc(){

    }
    public function GetAll(){
        $conn = connection::_open();
        $sql = "SELECT * FROM {$this->table} ";
        $data = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
        connection::_close($conn);
        return $data;
    }
}