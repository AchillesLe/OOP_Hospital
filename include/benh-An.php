<?php 
    if( isset($_SESSION['user'] ) ){
        if( isset($_POST['nameRequest'])  && $_POST['nameRequest'] == REQUEST_THEMBENHAN ){
            $arr_basic = isset($_POST['basic'])?$_POST['basic']:[];
            $arr_thuoc = isset($_POST['thuoc'])?$_POST['thuoc']:[];
            $arr_xetnghiem = isset($_POST['xetnghiem'])?$_POST['xetnghiem']:[];
            $ngayXN = date("Y-m-d");
            $id_bacsi =  ($_SESSION['user'])['id'];
            $id_benh_nhan = $arr_basic['id_BN'];
            $conn = connection::_open();
            
            $id_benhAn = "";
            $tongtien_toathuoc = 0;
            $id_toathuoc ="";
            /** tạo  Bệnh án */
            $sql = "INSERT INTO tblbenhan(idBenhnhan,idBacsi,soTT,chuanDoan,chieuCao,canNang,huyetAp,ghiChu) 
            VALUES ('{$id_benh_nhan}','{$id_bacsi}','{$arr_basic['soTT']}','{$arr_basic['chuan_doan']}','{$arr_basic['chieu_cao']}','{$arr_basic['can_nang']}','{$arr_basic['huyet_ap']}','{$arr_basic['ghi_chu']}')";
            $result = mysqli_query($conn,$sql);
            $id_benhAn = mysqli_insert_id($conn);
             
            if( $id_benhAn ){
                /** Update status da tao benh án ở tbldatlichkham */
                $sql = "UPDATE tbldatlichkham SET datao_benhAn ='1' WHERE id='{$arr_basic['id_LK']}' ";
                $result = mysqli_query($conn,$sql);
                /** tạo xét nghiệm */
                if( count($arr_xetnghiem) > 0){
                    foreach($arr_xetnghiem as $xn){
                        /**  lấy giá  xet nghiem */
                        $sql = "SELECT * FROM tblxetnghiem WHERE id = '{$xn['id_XN']}'";
                        $xetnghiem = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
                        /**  lấy lần thứ ? xet nghiem */
                        // $lanthu = 1;
                        // $sql = "SELECT A.lanThu FROM tblphieuxetnghiem A , tblbenhan B  WHERE A.idBenhan = B.id AND A.idXetnghiem = '{$xn['id']}' AND B.idBenhnhan= '{$id_benh_nhan}'
                        // ORDER BY A.lanThu  DESC ";
                        // $result = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
                        // if($result){
                        //     $lanthu = intval($result[0]['lanThu']) + 1;
                        // }
                        if($xetnghiem){
                            /** tạo  phiếu xt nghiem */
                            $sql = "INSERT INTO tblphieuxetnghiem(idXetnghiem,idBenhan,soTT,ngayXetnghiem,gioXetnghiem,lanThu,ketQua) 
                            VALUES('{$xn['id_XN']}' , '{$id_benhAn}' , '{$arr_basic['soTT']}' , '{$ngayXN}' , '{$xn['gioXN']}','{$xn['lan_thu']}' , '{$xn['ketqua']}' )";
                            $result = mysqli_query($conn,$sql);
                        }
                    }
                }
            /** tạo toa thuốc */
                if( count($arr_thuoc) > 0){
                    /** tạo  toa thuốc mới */
                    $sql = "INSERT INTO tbltoathuoc(idBenhAn,tongTien) VALUES ('{$id_benhAn}','0')";
                    $result = mysqli_query($conn,$sql);
                    $id_toathuoc = mysqli_insert_id($conn);
                    if($id_toathuoc){
                        foreach($arr_thuoc as $t){
                            /** tạo  lấy giá */
                            $sql = "SELECT * FROM tblthuoc WHERE id = '{$t['id_Thuoc']}'";
                            $thuoc = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
                            if($thuoc){
                                $tienthuoc = floatval( $thuoc['donGia'] ) * intval($t['soluong']);
                                $tongtien_toathuoc += $tienthuoc;
                                /** tạo  chi tiet thuoc */
                                $sql = "INSERT INTO tblcttoathuoc(idtoathuoc,idthuoc,soLuong,tongTien) 
                                VALUES('{$id_toathuoc}' , '{$t['id_Thuoc']}' , '{$t['soluong']}' , '{$tienthuoc}')";
                                $result = mysqli_query($conn,$sql);
                            }
                        }
                    } 
                }
            }

            /** cập nhật  toa thuốc mới */
            $sql = "UPDATE tbltoathuoc SET tongTien = '{$tongtien_toathuoc}' WHERE id= '{$id_toathuoc}'";
            $result = mysqli_query($conn,$sql);

            echo json_encode(['status'=>true , 'message'=>"Tạo bệnh án thành công !"]);
            connection::_close($conn);
            exit();
        }else if(isset($_POST['nameRequest'])  && $_POST['nameRequest'] == REQUEST_SUABENHAN ){
            $arr_basic = isset($_POST['basic'])?$_POST['basic']:[];
            $arr_thuoc = isset($_POST['thuoc'])?$_POST['thuoc']:[];
            $arr_xetnghiem = isset($_POST['xetnghiem'])?$_POST['xetnghiem']:[];
            $ngayXN = date("Y-m-d");
            $id_bacsi =  ($_SESSION['user'])['id'];
            // $id_benh_nhan = $arr_basic['id_BN'];
            $conn = connection::_open();
            $id_benhAn = "";
            $tongtien_toathuoc = 0;
            $id_toathuoc ="";
            try{
                if( count($arr_basic) > 0){
                    $id_benhAn = $arr_basic['id_BA'];
                    /**Update bệnh án */
                    $sql = "UPDATE tblbenhan SET chuanDoan = '{$arr_basic['chuan_doan']}', chieuCao = '{$arr_basic['chieu_cao']}', canNang='{$arr_basic['can_nang']}', huyetAp='{$arr_basic['huyet_ap']}' ,ghiChu = '{$arr_basic['ghi_chu']}'
                        WHERE id = '{$id_benhAn}' ";
                    $result = mysqli_query($conn,$sql);
                    if($result ){
                        /**Update Xét nghiệm */
                        $sql = "SELECT A.* ,A.id as id_phieu , B.* FROM tblphieuxetnghiem A,tblxetnghiem B WHERE A.idXetnghiem = B.id AND A.idBenhan = '{$id_benhAn}' ";
                        $xetnghiem = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
                        if( $xetnghiem ){
                            if( $arr_xetnghiem ){
                                foreach( $arr_xetnghiem as $xn){
                                    $check = false;
                                    foreach( $xetnghiem as $_xn){
                                        
                                        if( $xn['id_XN'] == $_xn['id'] && $xn['ketqua'] != $_xn['ketQua']){
                                            $sql = "UPDATE tblphieuxetnghiem SET ketQua = '{$xn['ketqua']}' WHERE id= '{$_xn['id_phieu']}' ";
                                            $result = mysqli_query($conn,$sql);
                                            $check = true;
                                        }else if($xn['id_XN'] == $_xn['id'] && $xn['ketqua'] == $_xn['ketQua']){
                                            $check = true;
                                        }
                                    }
                                    if(!$check){
                                        $sql = "INSERT INTO tblphieuxetnghiem(idXetnghiem,idBenhan,soTT,ngayXetnghiem,gioXetnghiem,lanThu,ketQua) 
                                        VALUES('{$xn['id_XN']}' , '{$id_benhAn}' , '{$arr_basic['soTT']}' , '{$ngayXN}' , '{$xn['gioXN']}','{$xn['lan_thu']}' , '{$xn['ketqua']}' )";
                                        $result = mysqli_query($conn,$sql);
                                    }
                                }
                            }else{
                                $sql = "DELETE FROM tblphieuxetnghiem WHERE idBenhan = '{$id_benhAn}' ";
                                $result = mysqli_query($conn,$sql);
                            }
                            
                            /**xóa các record cũ không liên quan */
                            foreach(  $xetnghiem as $_xn){
                                $check_ = false;
                                foreach( $arr_xetnghiem as $xn ){
                                    if( $_xn['id'] == $xn['id_XN']  ){
                                        $check_ = true;
                                    }
                                }
                                if(!$check_){
                                    $sql = "DELETE FROM tblphieuxetnghiem WHERE id = '{$_xn['id_phieu']}' ";
                                    $result = mysqli_query($conn,$sql);
                                }
                            }
                        }else{
                            /**Thêm thẳng vào bảng phiếu xet nghiem */
                            foreach( $arr_xetnghiem as $xn){
                                $sql = "INSERT INTO tblphieuxetnghiem(idXetnghiem,idBenhan,soTT,ngayXetnghiem,gioXetnghiem,lanThu,ketQua) 
                                VALUES('{$xn['id_XN']}' , '{$id_benhAn}' , '{$arr_basic['soTT']}' , '{$ngayXN}' , '{$xn['gioXN']}','{$xn['lan_thu']}' , '{$xn['ketqua']}' )";
                                $result = mysqli_query($conn,$sql);
                                
                            }
                        }
                        /**Update thuốc */
                        $sql = "SELECT A.* , A.id as id_toathuoc , B.*,B.id as id_ctthuoc , C.* , C.id as id_thuoc FROM tbltoathuoc A , tblcttoathuoc B , tblthuoc  C WHERE B.idtoathuoc = A.id AND B.idthuoc = C.id AND A.idBenhan = '{$id_benhAn}'";
                        $thuoc = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
                      
                        if( $thuoc ){
                            if( $arr_thuoc ){
                                foreach( $arr_thuoc as $_t ){
                                    $check = false;
                                    foreach( $thuoc as $t ){
                                        if( $_t['id_Thuoc'] == $t['id_thuoc'] && $_t['soluong'] != $t['soLuong']){
                                            $sql = "UPDATE tblcttoathuoc SET soLuong = '{$_t['soluong']}' WHERE id= '{$t['id_ctthuoc']}' ";
                                            $result = mysqli_query($conn,$sql);
                                            $check = true;
                                        }else if( $_t['id_Thuoc'] == $t['id_thuoc'] && $_t['soluong'] == $t['soLuong'] ){
                                            $check = true;
                                        }
                                    }
                                    if( !$check ){
                                        $sql = "SELECT * FROM tblthuoc WHERE id = '{$_t['id_Thuoc']}' ";
                                        $data_thuoc = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
                                        if( $data_thuoc ){
                                            $tienthuoc = floatval( $data_thuoc['donGia'] ) * intval($_t['soluong']);
                                            $sql = "INSERT INTO tblcttoathuoc(idToathuoc,idThuoc,soLuong,TongTien) 
                                            VALUES('{$thuoc[0]['id_toathuoc']}' , '{$_t['id_Thuoc']}' , '{$_t['soluong']}' , '{$tienthuoc}' )";
                                            $result = mysqli_query($conn,$sql);
                                        }
                                    }
                                }
                                /**xóa các record cũ không liên quan */
                                foreach( $thuoc as $t){
                                    $check_ = false;
                                    foreach( $arr_thuoc as $_t ){
                                        if( $t['id_thuoc'] == $_t['id_Thuoc']  ){
                                            $check_ = true;
                                        }
                                    }
                                    if(!$check_){
                                        $sql = "DELETE FROM tblcttoathuoc WHERE id = '{$t['id_ctthuoc']}' ";
                                        $result = mysqli_query($conn,$sql);
                                    }
                                }
                            }else{
                                $sql = "UPDATE tbltoathuoc SET tongTien = '0' WHERE id = '{$thuoc[0]['id_toathuoc']}' ";
                                $result = mysqli_query($conn,$sql);
                                $sql = "DELETE FROM tblcttoathuoc WHERE idtoathuoc = '{$thuoc[0]['idtoathuoc']}' ";
                                $result = mysqli_query($conn,$sql);
                                
                            }
                            

                        }else{
                            /** Thêm mới toa thuốc  */
                            $sql = "INSERT INTO tbltoathuoc(idBenhAn,tongTien) VALUES ('{$id_benhAn}','0')";
                            $result = mysqli_query($conn,$sql);
                            $id_toathuoc = mysqli_insert_id($conn);
                            if( $id_toathuoc ){
                                foreach($arr_thuoc as $t){
                                    /** tạo  lấy giá */
                                    $sql = "SELECT * FROM tblthuoc WHERE id = '{$t['id_Thuoc']}'";
                                    $thuoc = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
                                    if($thuoc){
                                        $tienthuoc = floatval( $thuoc['donGia'] ) * intval($t['soluong']);
                                        $tongtien_toathuoc += $tienthuoc;
                                        /** tạo  chi tiet thuoc */
                                        $sql = "INSERT INTO tblcttoathuoc(idtoathuoc,idthuoc,soLuong,tongTien) 
                                        VALUES('{$id_toathuoc}' , '{$t['id_Thuoc']}' , '{$t['soluong']}' , '{$tienthuoc}')";
                                        $result = mysqli_query($conn,$sql);
                                    }
                                }
                            }
                        }
                        echo json_encode(['status'=>true , 'message'=> 'Cập nhật bệnh án thành công !']);
                        exit();
                    }
                }
            }catch(Exception $e){
                echo json_encode(['status'=>false , 'message'=> 'Cập nhật bệnh án thất bại !']);
                exit();
            }
            
        }
        
    }
?>