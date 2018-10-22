<?php include('header.php') ?>
<?php 
	if( ( $user['quyen']==0) && isset($_GET['LK']) && is_numeric($_GET['LK']) ){
		$conn = connection::_open();
		$id_LK = $_GET['LK'];
		$sql = "SELECT * FROM tbldatlichkham WHERE id='{$id_LK}' ";
		$LK = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
		$id_bn = $LK['idBenhnhan'];
		$stt = $LK['soTT'];
		$sql = "SELECT * FROM tblbenhnhan WHERE id= '{$id_bn}' ";
		$benhnhan = mysqli_query($conn,$sql)->fetch_array(MYSQLI_ASSOC);
		if($benhnhan){
			$sql = "SELECT * FROM tblxetnghiem ";
			$xetnghiem = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
			$sql = "SELECT * FROM tblthuoc ";
			$thuoc = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
			connection::_close($conn);
		}
		else{
			echo "<meta http-equiv='Refresh' content='0;URL=/' />"; exit();
		}
		
	}else{
		echo "<meta http-equiv='Refresh' content='0;URL=/' />"; exit();
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
							<input class="form-control" type="text" name="text_bacsi" value="<?php echo $user['ten'] ?>" readonly>
						</div>
						<div class="col-md-1">
							<label >Bệnh nhân</label>
						</div>	
						<div class="col-md-3">
							<input class="form-control" type="text" name="id_benh_nhan" value="<?php echo $id_bn ?>" hidden>
							<input class="form-control" type="text" name="id_LK" value="<?php echo $id_LK ?>" hidden>
							<input class="form-control" type="text" name="text_benh_nhan" value="<?php echo $benhnhan['ten'] ?>" readonly>
						</div>
						<div class="col-md-1">
							<label for="txt_soTT">Số thứ tự</label>
						</div>
						<div class="col-md-1">
							<input class="form-control" type="text" name="txt_soTT" value="<?php echo $stt ?>" readonly>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-2">
							<label for="text_chieu_cao">Chiều cao</label>
						</div>	
						<div class="col-md-2">
							<input class="form-control" type="text" name="text_chieu_cao" placeholder="CM">
						</div>
						<div class="col-md-1 offset-md-1">
							<label for="txt_can_nang">Cân nặng</label>
						</div>	
						<div class="col-md-2">
							<input class="form-control" type="text" name="txt_can_nang" placeholder="KG">
						</div>
						<div class="col-md-1 offset-md-1">
							<label for="txt_huyet_ap">Huyết Áp</label>
						</div>
						<div class="col-md-2">
							<input class="form-control" type="text" name="txt_huyet_ap" placeholder="mmHg">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-2">
							<label for="text_chuan_doan">Chuẩn đoán</label>
						</div>	
						<div class="col-md-6">
							<textarea class="form-control" name="text_chuan_doan" cols="30" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-row">
						<div class="col-md-2">
							<label for="text_chuan_doan">Ghi chú</label>
						</div>	
						<div class="col-md-6">
							<textarea class="form-control" name="text_ghi_chu" cols="30" rows="3"></textarea>
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
								if($xetnghiem){
									foreach($xetnghiem as $XN){
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
								if($xetnghiem){
									foreach($thuoc as $t){
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

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row row-end">
		<div class="offset-md-3 col-md-4">
			<button class="btn btn-info"  id="btn_add_benh_an"><i class="fas fa-save"></i> Lưu bệnh án</button>
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
					required: Message.MS_07,
					number:  Message.MS_02,
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
			},
			focusInvalid: function() {
				if ( this.settings.focusInvalid ) {
					try {
						var firstInvalidElement = $(this.errorList[0].element);
						$('html,body').scrollTop(firstInvalidElement.offset().top);
						firstInvalidElement.focus();
					} catch ( e ) {
						// ignore IE throwing errors when focusing hidden elements
					}
				}
			}
		});
	});
</script>