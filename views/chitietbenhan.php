<?php include('header.php') ?>
<?php 
	if(  isset($_GET['ba']) && is_numeric($_GET['ba']) ){
		$conn = connection::_open();
        $id_ba = $_GET['ba'];
		$sql = "SELECT A.* , A.id as id_ba , B.* ,B.id as id_bn , B.ten  as ten_bn , C.* ,  C.id as id_bs , C.ten as ten_bs FROM tblbenhan A , tblbenhnhan B , tblbacsi C WHERE A.idBenhnhan = B.id AND A.idBacsi = C.id AND A.id= '{$id_ba}' ";
        $BenhAn = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
		if($BenhAn){
			$sql = "SELECT * FROM tblphieuxetnghiem A,tblxetnghiem B WHERE A.idXetnghiem = B.id AND A.idBenhan = '{$id_ba}' ";
			$xetnghiem = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
			$sql = "SELECT * FROM tbltoathuoc A , tblcttoathuoc B , tblthuoc  C WHERE B.idtoathuoc = A.id AND B.idthuoc = C.id AND A.idBenhan = '{$id_ba}'";
            
            // die(var_dump($sql));
            $thuoc = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
			connection::_close($conn);
		}
		else{
            echo "<meta http-equiv='Refresh' content='0;URL=/' />";
            exit();
		}
		
	}else{
        echo "<meta http-equiv='Refresh' content='0;URL=/' />";
        exit();
	}
	
?>
<div class="container-fluid">
	
    <div class="card mb-3 mt-3">
		<div class="card-header bg-info">
			<i class="fas fa-table"></i>
			Thông tin cơ bản của bệnh án
		</div>
		<div class="card-body">
			<div id="message-tao_benh_An">

			</div>
			<form id="form-benh-an">
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-2">
							<label for="text_bacsi">Người tạo bệnh án</label>
						</div>	
						<div class="col-md-3">
							<input class="form-control" type="text" name="text_bacsi" value="<?php echo $BenhAn['ten_bs'] ?>" readonly>
						</div>
						<div class="col-md-1">
							<label for="id_benh_nhan">Bệnh nhân</label>
						</div>	
						<div class="col-md-3">
							<input class="form-control" type="text" name="text_benh_nhan" value="<?php echo $BenhAn['ten_bn'] ?>" readonly>
						</div>
						<div class="col-md-1">
							<label for="txt_soTT">Số thứ tự</label>
						</div>
						<div class="col-md-1">
							<input class="form-control" type="text" name="txt_soTT" value="<?php echo $BenhAn['soTT'] ?>" readonly>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-2">
							<label for="text_chieu_cao">Chiều cao</label>
						</div>	
						<div class="col-md-2">
							<input class="form-control" type="text" name="text_chieu_cao" placeholder="CM" value="<?php echo $BenhAn['chieuCao'] ?>"> 
						</div>
						<div class="col-md-1 offset-md-1">
							<label for="txt_can_nang">Cân nặng</label>
						</div>	
						<div class="col-md-2">
							<input class="form-control" type="text" name="txt_can_nang" placeholder="KG" value="<?php echo $BenhAn['canNang'] ?>">
						</div>
						<div class="col-md-1 offset-md-1">
							<label for="txt_huyet_ap">Huyết Áp</label>
						</div>
						<div class="col-md-2">
							<input class="form-control" type="text" name="txt_huyet_ap" placeholder="mmHg" value="<?php echo $BenhAn['huyetAp'] ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-2">
							<label for="text_chuan_doan">Chuẩn đoán</label>
						</div>	
						<div class="col-md-6">
							<textarea class="form-control" name="text_chuan_doan" cols="30" rows="3"><?php echo $BenhAn['chuanDoan'] ?></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-2">
							<label for="text_chuan_doan">Ghi chú</label>
						</div>	
						<div class="col-md-6">
							<textarea class="form-control" name="text_ghi_chu" cols="30" rows="3"><?php echo $BenhAn['ghiChu'] ?></textarea>
						</div>
					</div>
				</div>
			</form>
		</div>
    </div>
    <div class="card mb-3 mt-3">
		<div class="card-header bg-warning">
			<i class="fas fa-table"></i>
			Thông tin xét nghiệm
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table_xet_nghiem_detail" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Xét nghiệm</th>
							<th>Ngày</th>
							<th>Giờ</th>
							<th>Lần thứ</th>
							<th>Kết quả</th>
						</tr>
					</thead>
					<tbody>
                        <?php 
                            if( count( $xetnghiem ) > 0 ){
                                foreach( $xetnghiem as $xn ){
                                    $ngay = date('d/m/Y',strtotime($xn['ngayXetnghiem']) );
                                    $gio = substr($xn['gioXetnghiem'] , 0 ,5);
                                    echo "<tr>
                                    <td>{$xn['tenXetNghiem']}</td>
                                    <td>{$ngay}</td>
                                    <td>{$gio}</td>
                                    <td>{$xn['lanThu']}</td>
                                    <td>{$xn['ketQua']}</td>
                                    </tr>";
                                }
                            }
                        
                        ?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
    <div class="card mb-5 mt-3">
		<div class="card-header bg-dark text-white">
			<i class="fas fa-table"></i>
			Thông tin toa thuốc
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table_thuoc" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Tên thuốc</th>
							<th>Đơn vị</th>
							<th>Số lượng</th>
						</tr>
					</thead>
					<tbody>
                        <?php 
                            if( count( $thuoc ) > 0 ){
                                foreach( $thuoc as $t ){
                                    echo "<tr>
                                    <td>{$t['tenThuoc']}</td>
                                    <td>{$t['donVi']}</td>
                                    <td>{$t['soLuong']}</td>
                                    </tr>";
                                }
                            }
                        ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<?php include('footer.php') ?>
