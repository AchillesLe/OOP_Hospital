<?php include('header.php') ?>
<?php 
	$quyen = $user['quyen'];
	$benhnhanmodel = new benhnhanModel();
	if( isset($_GET['bn']) && $quyen == '0'){
		$id_bacsi =  $user['id'];
		$id_benhnhan = $_GET['bn'];
		$benhAn = $benhnhanmodel->GetALLBenhAnBY_IDBN_IDBACSI($id_benhnhan,$id_bacsi);
	}else if( $quyen == '1' ){
		$id_benhnhan =  $user['id'];
		$benhAn = $benhnhanmodel->GetALLBenhAnBY_IDBN($id_benhnhan);
	}else{
		echo "<meta http-equiv='Refresh' content='0;URL=/' />";
		exit();
	}
	
?>
<div class="container-fluid">
	<div class="card mb-3 mt-3">
		<div class="card-header">
			<i class="fas fa-table"></i>
			Danh sách bệnh án
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table-ds-benh-an" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>#</th>
							<th>Họ tên</th>
							<th>Số TT</th>
							<th>Chuẩn đoán</th>
							<th>Ngày</th>
							<th></th>
							<?php if($quyen=='0'):?>
							<th></th>
							<?php endif;?>
						</tr>
					</thead>
					<tbody>
						<?php 
							$index = 0;
							if($benhAn){
								foreach($benhAn as $ba){
									$index ++;
									$ngay = date('d/m/Y' , strtotime($ba['ngayTao']));
									echo "<tr>
										<td>{$index}</td>
										<td>{$ba['ten']}</td>
										<td>{$ba['soTT']}</td>
										<td>{$ba['chuanDoan']}</td>
										<td>{$ngay}</td> 
										<td><a class='btn btn-info btn-detail' href='/chi-tiet-benh-an?ba={$ba['id_ba']}'>Chi tiết</a></td>";
										if($quyen=='0'):
											echo "<td><a class='btn btn-warning btn-edit' href='/sua-benh-an?ba={$ba['id_ba']}'>Sửa</a></td>";
										endif;
									echo"</tr>";
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