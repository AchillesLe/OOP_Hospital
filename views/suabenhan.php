<?php include('header.php') ?>
<?php 
	if(  isset($_GET['ba']) && is_numeric($_GET['ba']) ){
        $conn = connection::_open();
        /**Dữ liệu master */
        $sql = "SELECT * FROM tblxetnghiem ";
        $s_xetnghiem = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
        $sql = "SELECT * FROM tblthuoc ";
        $s_thuoc = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);

        $id_ba = $_GET['ba'];
		$sql = "SELECT A.* , A.id as id_ba , B.* ,B.id as id_bn , B.ten  as ten_bn , C.* ,  C.id as id_bs , C.ten as ten_bs FROM tblbenhan A , tblbenhnhan B , tblbacsi C WHERE A.idBenhnhan = B.id AND A.idBacsi = C.id AND A.id= '{$id_ba}' ";
        $BenhAn = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
        $id_bn  = $BenhAn['id_bn'];
        /**Dữ liệu bệnh bán */
		if($BenhAn){
			$sql = "SELECT * FROM tblphieuxetnghiem A,tblxetnghiem B WHERE A.idXetnghiem = B.id AND A.idBenhan = '{$id_ba}' ";
			$xetnghiem = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
			$sql = "SELECT A.* , A.id as id_toathuoc , B.*,B.id as id_ctthuoc , C.* , C.id as id_thuoc FROM tbltoathuoc A , tblcttoathuoc B , tblthuoc  C WHERE B.idtoathuoc = A.id AND B.idthuoc = C.id AND A.idBenhan = '{$id_ba}'";
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
							<input class="form-control" type="text" name="id_benh_an" value="<?php echo $id_ba ?>" hidden>
							<input class="form-control" type="text" name="id_benh_nhan" value="<?php echo $BenhAn['id_bn'] ?>" hidden>
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
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-2">
						<label for="text_bacsi">Xét nghiệm</label>
					</div>	
					<div class="col-md-4">
						<select class="form-control" name="sel_xet_nghiem" id="sel_xet_nghiem">
							<option value="0">------------Chọn xét nghiệm------------</option>
							<?php 
								if($s_xetnghiem){
									foreach($s_xetnghiem as $XN){
										echo "<option value='{$XN['id']}'>{$XN['tenXetNghiem']}</option>";
									}
								}
							?>
						</select>
					</div>
					<div class="col-md-2">
						<label for="txt_gio" style="margin-left:30px;">Giờ XN ( 24h )</label>
					</div>
					<div class="col-md-2 bootstrap-timepicker timepicker">
						<input class="form-control" type="text" id="txt_gio" name="txt_gio">
					</div>
					<div class="col-md-1">
						<label for="txt_lan_thu">Lần thứ</label>
					</div>	
					<div class="col-md-1">
						<input class="form-control" type="text" name="txt_lan_thu" id="txt_lan_thu" readonly>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-2">
						<label for="txt_ket_qua">Kết quả</label>
					</div>	
					<div class="col-md-6">
						<textarea class="form-control" name="txt_ket_qua" id="txt_ket_qua"  rows="3"></textarea>
                    </div>
				</div>
			</div>
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-2 offset-md-2">
						<button class="btn btn-warning" id="btn_them_xet_nghiem"><i class="fas fa-plus"></i>Thêm phiếu</button>
					</div>
				</div>
			</div>

			<hr class="hr_tag_warning">
			<div class="table-responsive">
				<table class="table table-bordered" id="table_xet_nghiem" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Xét nghiệm</th>
							<th>Giờ</th>
							<th>Lần thứ</th>
							<th>Kết quả</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        <?php 
                            if( count( $xetnghiem ) > 0 ){
                                foreach( $xetnghiem as $xn ){
                                    $ngay = date('d/m/Y',strtotime($xn['ngayXetnghiem']) );
                                    $gio = substr($xn['gioXetnghiem'] , 0 ,5);
                                    echo "<tr data-id_XN='{$xn['id']}'>
                                    <td>{$xn['tenXetNghiem']}</td>
                                    <td>{$gio}</td>
                                    <td>{$xn['lanThu']}</td>
                                    <td>{$xn['ketQua']}</td>
                                    <td><input type='button' class='btn btn-warning btn-delete-XN' Onclick='delete_row_XN(this)' value='Xóa'></td>
                                    </tr>";
                                }
                            }
                        ?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
    <div class="card mb-3 mt-3">
		<div class="card-header bg-dark text-white">
			<i class="fas fa-table"></i>
			Thông tin toa thuốc
		</div>
		<div class="card-body">
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-2">
						<label for="sel_thuoc">Tên thuốc</label>
					</div>	
					<div class="col-md-4">
						<select class="form-control" name="sel_thuoc" id="sel_thuoc">
							<option value="0">------------Chọn thuốc------------</option>
							<?php 
								if($s_thuoc){
									foreach($s_thuoc as $t){
										echo "<option value='{$t['id']}' data-donvi='{$t['donVi']}'>{$t['tenThuoc']}</option>";
									}
								}
							?>
						</select>
					</div>
					<div class="col-md-1">
						<label for="txt_donvi">Đơn vị</label>
					</div>
					<div class="col-md-1">
						<input class="form-control" type="text"  id="txt_donvi"  readonly>
					</div>
					<div class="col-md-1">
						<label for="txt_soluong">Số lượng</label>
					</div>
					<div class="col-md-1">
						<input class="form-control" type="text"  name="txt_soluong" id="txt_soluong" >
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="form-row">
					<div class="col-md-2 offset-md-2">
						<button class="btn bg-dark text-white" id="btn_them_thuoc"><i class="fas fa-plus"></i>Thêm vào toa thuốc</button>
					</div>
				</div>
			</div>

			<hr class="hr_tag_dark">
			<div class="table-responsive">
				<table class="table table-bordered" id="table_thuoc" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>Tên thuốc</th>
							<th>Đơn vị</th>
							<th>Số lượng</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        <?php
                            if( count( $thuoc ) > 0 ){
                                foreach( $thuoc as $t ){
                                    echo "<tr data-id_thuoc='{$t['id_thuoc']}'>
                                    <td>{$t['tenThuoc']}</td>
                                    <td>{$t['donVi']}</td>
                                    <td>{$t['soLuong']}</td>
                                    <td><input type='button' class='btn btn-warning btn-delete-thuoc' Onclick='delete_row_thuoc(this)' value='Xóa'></td>
                                    </tr>";
                                }
                            }
                        ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row row-end">
		<div class="offset-md-3 col-md-4">
			<button class="btn btn-info"  id="btn_edit_benh_an"><i class="fas fa-save"></i> Lưu bệnh án</button>
		</div>
		<div class="col-md-4">
			<a href="/ho-so-benh-an" class="btn btn-danger" id="btn_cancel"><i class="fas fa-arrow-left"></i> Hủy</a>
		</div>
	</div>
</div>
<?php include('footer.php') ?>
<script>
	var id_BN_ = "<?php echo $id_bn?>";
    var href_benh_an = "/ho-so-benh-an?bn="+id_BN_;
	$("#sel_thuoc").chosen({});
	$(function(){
		$('#form-benh-an').validate({
			rules: {
				text_chieu_cao: {
					required: true,
					number: true,
				},
				txt_can_nang: {
					required:true,
					number: true,
				},
				txt_huyet_ap: {
					required:true,
					number: true,
				},
				text_chuan_doan :{
					required:true,
					minlength:6,
					maxlength:200
				}
			},
			messages:{
				text_chieu_cao: {
					required: Message.MS_01,
					number:  Message.MS_02,
				},
				txt_can_nang: {
					required:  Message.MS_07,
					number: Message.MS_02,
				},
				txt_huyet_ap: {
					required: Message.MS_01,
					number:  Message.MS_02,
				},
				text_chuan_doan: {
					required: Message.MS_01,
					minlength: Message.MS_05,
					maxlength: Message.MS_200,
					
				},
			},
			errorClass: "label-danger",
			errorPlacement: function(error, element) {
				if(element.attr("name")=="rd_sex"){
					error.insertAfter(element.parent().parent());
				}
				else
					error.insertAfter(element);
			}
		});
	});
</script>

