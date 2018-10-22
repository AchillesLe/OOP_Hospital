<?php 
class model{
    
    private $connection ;
    public function __construct(){
        $connection = mysqli_connect(DB_HOST, DB_USER_NAME, DB_PASSWORD);
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_select_db( $conn , DB_NAME );
        mysqli_query($conn,"SET NAMES 'utf8'");
        return $connection;
    }
}
?>