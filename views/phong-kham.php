<?php include('header.php') ?>
<?php
    $conn = connection::_open();
    $sql = "SELECT * FROM tblkhoa";
    $khoa = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
    connection::_close($conn);
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3 tracuuTT">
            <div class="card-header">
              <i class="fas fa-table"></i>Tra cứu số thứ tự
            </div>
            <div class="card-body">
				<div class="form-row">
					<div class="form-group offset-md-2 col-md-8">
						<label for="sel_khoa_tracuu">Khoa</label>
						<select  id="sel_khoa_tracuu" class="form-control">
							<option value="0">--------------------------Chọn khoa------------------------</option>
								<?php 
									foreach($khoa as $item){
										echo "<option value='{$item['id']}'>{$item['tenKhoa']}</option>";
									}
								?>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group offset-md-2 col-md-6">
						<label for="sel_bacsi">Bác sĩ</label>
						<select  id="sel_bacsi_tracuu" class="form-control">
							<option value="0">--------------Chọn bác sĩ-----------</option> 
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group offset-md-2 col-md-6">
						<label for="txt_ngay_check">Ngày khám</label>
						<input type="text" class="form-control" name="txt_ngay_check" id="txt_ngay_check"   placeholder="dd/mm/yyyy">
					</div>
				</div>
				
			</div>
			<!-- <div class="form-row">
				<div class="form-group offset-md-9 col-md-3">
					<input type="button" id="btn_My_sott" class="btn btn-info" value="Số thứ tự của tôi">
				</div>
			</div> -->
        </div>

		<div class="card mb-3 mt-5">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Kết quả tra cứu
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="table-tracuu-phongkham" width="100%" cellspacing="0">
						<thead>
							<tr>
								<th>#</th>
								<th>Số thứ tự</th>
								<th>Giờ</th>
								<th>Tên</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
		</div>
    </div>
</div>

<?php include('footer.php') ?>
<script>
    var array_time = '<?php echo json_encode($array_time) ?>';
    var options_Y_M_D = {
        format: 'dd/mm/yyyy',
        minViewMode: 'days',
        todayHighlight: true,
        autoclose: true,
        orientation: "auto right",
    };
    var date = new Date();
    var currdate =  date.getDate()+"/"+ (date.getMonth()+1) +"/"+date.getFullYear();
    $('#txt_ngay_check').datepicker(options_Y_M_D);
    $('#txt_ngay_check').data('datepicker').setStartDate(currdate);
    // $("#sel_bacsi").chosen({});

</script>
