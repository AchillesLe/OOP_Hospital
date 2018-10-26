<?php 
    
    if( isset($_SESSION['user'] ) ){
        if( isset($_POST['nameRequest'])  && $_POST['nameRequest'] == REQUEST_TRACUUSOTT_KHAM ){
            $idbacsi = $_POST['idbacsi'];
            $ngay = str_replace('/','-',$_POST['ngay'] );
            $ngay = date('Y-m-d',strtotime($ngay) );
            $id_benhnhan = ($_SESSION['user'])['quyen'] == '1'?($_SESSION['user'])['id'] :'';
            $datlichkham = new datlichkhamModel();
            $result = $datlichkham->GetAllLichKhamByIdbacsiAndNgay($idbacsi,$ngay);
            if($result){
                $html ="";
                $index = 0;
                foreach( $result as $lichkham ){
                    $active = "";
                    $index++;
                    if( $id_benhnhan != '' && $lichkham['id'] == $id_benhnhan ){
                        $active = "class ='active' ";
                    }
                    $gio = substr($lichkham['gioHen'] ,0,5);
                    $html .= "<tr {$active}>
                        <td>{$index}</td>
                        <td>{$lichkham['soTT']}</td>
                        <td>{$gio}</td>
                        <td>{$lichkham['ten']}</td>
                    </tr>";
                }
                echo ( $html );
                exit();
            }
        }else if( isset($_POST['nameRequest'])  && $_POST['nameRequest'] == REQUEST_TRACUUSOTT_XN  ){
            $idXN = $_POST['idXN'];
            $ngay = $_POST['ngay'];
            $id_benhnhan = ($_SESSION['user'])['quyen'] == '1'?($_SESSION['user'])['id'] :'';
            $dangkixetnghiemModel = new dangkixetnghiemModel();
            $result = $dangkixetnghiemModel->GetAllLichXetNghiemByIdXNAndNgay($idXN, $ngay);
            if($result){
                $html ="";
                $index = 0;
                foreach( $result as $lichkham ){
                    $index++;
                    $active = "";
                    if( $id_benhnhan != '' && $lichkham['id'] == $id_benhnhan ){
                        $active = "class ='active' ";
                    }
                    $gio = substr($lichkham['gio'] ,0,5);
                    $html .= "<tr {$active}>
                        <td>{$index}</td>
                        <td>{$lichkham['soTT']}</td>
                        <td>{$gio}</td>
                        <td>{$lichkham['ten']}</td>
                    </tr>";
                }
                echo ( $html );
                exit();
            }
        }else if( isset($_POST['nameRequest'])  && $_POST['nameRequest'] == REQUEST_TRACUUSOTT_CUA_XN  ){
            $id_XN = $_POST['id_XN'];
            $id_BN = $_POST['id_BN'];
            $dangkixetnghiemModel = new dangkixetnghiemModel();
            $result = $dangkixetnghiemModel->GetLanThu($id_XN,$id_BN);
            if($result){
                echo intval($result[0]['lanThu']) + 1;
            }else{
                echo 1;
            }
            exit();
        }else if( isset($_POST['nameRequest'])  && $_POST['nameRequest'] == REQUEST_DANGKIXETNGHIEM  ){
            $id_XN = $_POST['id_XN'];
            $id_time_XN = $_POST['id_time_XN'];
            $gio = $_POST['time'];
            $ngay = $_POST['ngay'];
            $id_BN = ($_SESSION['user'])['id'];
            $new_ngay = date('d/m/Y',strtotime($ngay));
            $dangkixetnghiemModel = new dangkixetnghiemModel($id_BN,$id_XN,$id_time_XN,$ngay,$gio);

            $result = $dangkixetnghiemModel->GetAllLichXetNghiemByIdBN($id_BN, $ngay,$id_time_XN);
            if( $result ){
                echo json_encode(['status'=>false , 'message'=>MessageNoti::MS_16($gio,$new_ngay)]);
                exit();
            }
            else{
                $result = $dangkixetnghiemModel->GetInforBy($id_XN,$ngay,$id_time_XN);
                if( $result ){
                    echo json_encode(['status'=>false , 'message'=>MessageNoti::MSG_500($gio,$new_ngay)]);
                    exit();
                }
                $result = $dangkixetnghiemModel->insert();
                if($result){
                    echo json_encode(['status'=>true , 'message'=>MessageNoti::$RegisAnalysisSuccesfully]);
                    exit();
                }else{
                    echo json_encode(['status'=>false , 'message'=>MessageNoti::$RegisAnalysisFailed]);
                    exit();
                }
            }
        }
    }
?>