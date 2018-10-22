<?php include('header.php') ?>
<?php 
	$id_bacsi =  $user['id'];
	$benhnhanmodel = new benhnhanModel();
	$result = $benhnhanmodel->getAllByBacsiID($id_bacsi);
?>
<div class="container-fluid">
	<div class="card mb-3 mt-5">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Danh sách bệnh nhân
		</div>
		<div id="message-dklichhen">
			<?php
				if( isset($_SESSION['status']) && $_SESSION['status']==true ){
					echo "<div class='alert alert-success alert-massage'>{$_SESSION['message-dklichhen']}</div>";
					unset($_SESSION['message-dklichhen']);
					unset($_SESSION['status']);
				}
			?>
		</div>
		
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table-ds-benh-nhan" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>Họ tên</th>
							<th>SDT</th>
							<th>Ngày sinh</th>
							<th>CMND</th>
							<th>BHYT</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$index = 0;
							if( $result ){
								foreach( $result as $benhnhan){
									$index ++;
									$ngaysinh = date_create($benhnhan['ngaySinh'] );
									$ngaysinh = date_format($ngaysinh,'d/m/Y');
									echo "<tr>
										<td>{$index}</td>
										<td>{$benhnhan['ten']}</td>
										<td>{$benhnhan['soDT']}</td>
										<td>{$ngaysinh}</td>
										<td>{$benhnhan['CMND']}</td>
										<td>{$benhnhan['BHYT']}</td>
										<td><a href='/dat-hen?bn={$benhnhan['id']}' class='btn btn-primary btn-lich-hen'>Đặt hẹn</a></td>
										<td><a href='/ho-so-benh-an?bn={$benhnhan['id']}' class='btn btn-success btn-xem-BA'>Xem bệnh án</td>
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
<script>
$(function(){
	setTimeout(function(){ 
		$('#message-lichkham').html('');
	}, 4000);
})
</script>