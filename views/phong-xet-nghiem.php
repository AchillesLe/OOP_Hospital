<?php include('header.php') ?>
<?php
    $conn = connection::_open();
    $sql = "SELECT * FROM tblxetnghiem";
    $phongXN = mysqli_query($conn,$sql)->fetch_all(MYSQLI_ASSOC);
    connection::_close($conn);
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3 tracuuTT">
            <div class="card-header">
              <i class="fas fa-table"></i> Tra cứu số thứ tự
            </div>
            <div class="card-body">
			<div class="alert alert-info">Lưu ý : Chỉ tra cứu  ngày hiện tại ( <?php echo date('d/m/Y'); ?> ) .</div>
			<div id="message"></div>
				<div class="form-row">
					<div class="form-group offset-md-2 col-md-8">
						<label for="sel_XN_tracuu">Phòng xét nghiệm</label>
						<select  id="sel_XN_tracuu" class="form-control">
							<option value="0">------------------------------------Chọn phòng xét nghiệm-----------------------------------</option>
								<?php 
									foreach($phongXN as $item){
										echo "<option value='{$item['id']}'>{$item['tenXetNghiem']}</option>";
									}
								?>
						</select>
					</div>
				</div>
			</div>
			<hr>
			<?php if($user['quyen'] == 1):?>
			<div class="form-row">
				<div class="form-group offset-md-2 col-md-2">
					<label id="lb_time_XN">Giờ XN</label>
					<select name="sel_time_XN"  id="sel_time_XN" class="form-control" >
						<option value="0">--Chọn--</option> -->
						<!-- <?php 
							foreach($array_time as $key => $time){
								echo "<option value={$key}>{$time}</option>";
							}
						?> -->
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group offset-md-2 col-md-5">
					<a id="btn_dat_lich_XN" class="btn btn-info text-white" ><i class="fas fa-registered"></i> Đặt lịch xét nghiệm tại phòng</a>
				</div>
			</div>
			<?php endif;?>
        </div>

		<div class="card mb-3 mt-5">
			<div class="card-header">
				<i class="fas fa-table"></i>
				Kết quả tra cứu . 
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="table-tracuu-phongXN" width="100%" cellspacing="0">
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

</script>
