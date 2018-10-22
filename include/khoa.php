<?php 
    if( isset($_SESSION['user'])){
        if( isset($_POST['nameRequest']) && $_POST['nameRequest'] == REQUEST_GET_BACSI_BY_KHOA ){
            $id = $_POST['idkhoa'];
            if(intval($id) > 0){
                $bacsiModel = new bacsiModel();
                $data =  $bacsiModel->GetAllBacsiByIdKhoa($id);
                if($data){
                   echo json_encode(['success'=>true,'data'=>$data]);
                }
                else
                    echo json_encode(['success'=>false ,'data'=>""]);
            }
        }
        else{
            echo "";
        }
    }else{
        echo "";
    }
    
?>