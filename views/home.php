
<?php include('header.php') ?>
<?php 
/**
* (1) Hiển thị ban đầu
*		2. Hiển thị màn hình ở trạng thái ban đầu
*			 Quyền đăng nhập ứng với Bác sĩ
*/
$id_bacsi = $user['id'];
$benhnhanmodel = new benhnhanModel();

//3. Load data từ tblbenhnhan và tbldatlichkham
$data = $benhnhanmodel->GetALLLichKhamBY_IDBACSI($id_bacsi);
?>
<?php if ($user['quyen'] == 0) : ?>
<div class="container-fluid">
	<div class="card mb-2 card-ds-lich-kham">
		<div class="card-header bg-info">
			<i class="fas fa-table"></i>
			Danh sách lịch khám  
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table-ds-lich-kham-1" width="100%" cellspacing="0">
					<thead>
						<tr>
                            <th>#</th>
                            <th>Ngày</th>
                            <th>Giờ</th>
                            <th>Số TT</th>
                            <th>Bệnh nhân</th>
							<th>Số ĐT</th>
							<th>Lý do</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php 
				$index = 0;
				if ($data) {
					foreach ($data as $lichkham) {
						if ($lichkham['chuDong'] == 0) {
							$index++;
							$status = 'warning';
							$disbled = '';
							//(2) Xử lý Check lịch khám
							//		1. Nhấn nút Check lịch khám thì thực hiện xử lý Khám?
							//			2. Xử lý check
							if ($lichkham['tinhTrang'] == 0) {
								$status = 'success';
								$disbled = 'disabled';
							}
							$ngayhen = $lichkham['ngayHen'];
							$ngayhen = date_create($ngayhen);
							$ngayhen = date_format($ngayhen, 'd/m/Y');
							$gio = substr($lichkham['gioHen'], 0, 5);
							echo "<tr data-id='{$lichkham['id']}'>
										<td>{$index}</td>
										<td>{$ngayhen}</td>
										<td>{$gio}</td>
										<td>{$lichkham['soTT']}</td>
										<td>{$lichkham['ten']}</td>
										<td>{$lichkham['soDT']}</td>
										<td>{$lichkham['lyDo']}</td>
										<td><button class='btn btn-{$status} btn-confirm-done' data-id='{$lichkham['id']}' {$disbled}><i class='fas fa-check'></i></button></td> 
										<td>";
							if ($lichkham['tinhTrang'] == 0 && $lichkham['datao_benhAn'] == 0) {
								echo "<a class='btn btn-success'  href='/them-ho-so-benh-an?LK={$lichkham['id']}'><i class='fas fa-plus'></i>Thêm bệnh án</a>";
							}
							echo "</td></tr>";
						}
					}
				}
				?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	if ($index > 0) {
		$date_updated = $data[0]['ngayTao'];
		$date_updated = date_create($date_updated);
		$date_updated = date_format($date_updated, 'd/m/y H:i:s');
		echo "<div class='card-footer small text-muted'>Cập nhật mới nhất lúc {$date_updated}</div>";
	}
	?>
	</div>
	<div class="card mb-3 card-ds-lich-hen-1">
		<div class="card-header bg-secondary text-white">
			<i class="fas fa-table"></i>
			Danh sách lịch hẹn với bệnh nhân
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table-ds-lich-hen-1" width="100%" cellspacing="0">
					<thead>
						<tr>
                            <th>#</th>
                            <th>Ngày</th>
                            <th>Giờ</th>
                            <th>Số TT</th>
                            <th>Bệnh nhân</th>
							<th>Số ĐT</th>
							<th>Lý do</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php 
				$index = 0;
				if ($data) {
					foreach ($data as $lichkham) {
						if ($lichkham['chuDong'] == '1') {
							$index++;
							$status = 'warning';
							$disbled = '';
							//(2) Xử lý Check lịch khám
							//		1. Nhấn nút Check lịch khám thì thực hiện xử lý Khám?
							//			2. Xử lý check
							if ($lichkham['tinhTrang'] == 0) {
								$status = 'success';
								$disbled = 'disabled';
							}
							$ngayhen = $lichkham['ngayHen'];
							$ngayhen = date_create($ngayhen);
							$ngayhen = date_format($ngayhen, 'd/m/Y');
							$gio = substr($lichkham['gioHen'], 0, 5);
							echo "<tr data-id='{$lichkham['id']}'>
										<td>{$index}</td>
										<td>{$ngayhen}</td>
										<td>{$gio}</td>
										<td>{$lichkham['soTT']}</td>
										<td>{$lichkham['ten']}</td>
										<td>{$lichkham['soDT']}</td>
										<td>{$lichkham['lyDo']}</td>
										<td><button class='btn btn-{$status} btn-confirm-done' data-id='{$lichkham['id']}' {$disbled} ><i class='fas fa-check'></i></button></td> 
										<td>";
							if ($lichkham['tinhTrang'] == 0) {
								echo "<a class='btn btn-success'  href='/them-ho-so-benh-an?LK={$lichkham['id']}'><i class='fas fa-plus'></i>Thêm bệnh án</a>";
							}
							echo "</td></tr>";
						}
					}
				}
				?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	if ($index > 0) {
		$date_updated = $data[0]['ngayTao'];
		$date_updated = date_create($date_updated);
		$date_updated = date_format($date_updated, 'd/m/y H:i:s');
		echo "<div class='card-footer small text-muted'>Cập nhật mới nhất lúc {$date_updated}</div>";
	}
	?>
	</div>
</div>
<?php else : ?>
<?php 
/**
* (1) Hiển thị ban đầu
*		2. Hiển thị màn hình ở trạng thái ban đầu
*			 Quyền đăng nhập ứng với Bệnh nhân
*/
$id_benhnhan = $user['id'];
$benhnhan = new benhnhanModel();
//3. Load data từ tblbenhnhan và tbldatlichkham
$data = $benhnhan->GetALLLichKham($id_benhnhan);
?>
<div class="container-fluid">
	<div class="card mb-2 card-ds-lich-kham">
		<div class="card-header bg-info">
			<i class="fas fa-table"></i>
			Danh sách lịch hẹn - Bạn hẹn bác sĩ
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table-ds-lich-kham-2" width="100%" cellspacing="0">
					<thead>
						<tr>
                            <th>#</th>
                            <th>Ngày</th>
                            <th>Giờ</th>
                            <th>Số TT</th>
                            <th>Bác sĩ</th>
							<th>Số ĐT</th>
							<th>Lý do</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php 
				$index = 0;
				if ($data) {
					foreach ($data as $lichkham) {
						if ($lichkham['chuDong'] == 0) {
							$index++;
							$status = 'warning';
							$disbled = '';
							//(2) Xử lý Check lịch khám
							//		1. Nhấn nút Check lịch khám thì thực hiện xử lý Khám?
							//			2. Xử lý check
							if ($lichkham['tinhTrang'] == 0) {
								$status = 'success';
								$disbled = 'disabled';
							}
							$ngayhen = $lichkham['ngayHen'];
							$ngayhen = date_create($ngayhen);
							$ngayhen = date_format($ngayhen, 'd/m/Y');
							$gio = substr($lichkham['gioHen'], 0, 5);
							echo "<tr >
											<td>{$index}</td>
											<td>{$ngayhen}</td>
											<td>{$gio}</td>
											<td>{$lichkham['soTT']}</td>
											<td>{$lichkham['ten']}</td>
											<td>{$lichkham['soDT']}</td>
											<td>{$lichkham['lyDo']}</td>
											<td><button class='btn btn-{$status}  btn-confirm-done' data-id='{$lichkham['id']}' {$disbled} ><i class='fas fa-check'></i></button></td>
										</tr>";
						}
					}
				}
				?>
						
					</tbody>
				</table>
			</div>
		</div>
		<?php
	if ($index > 0) {
		$date_updated = $data[0]['ngayTao'];
		$date_updated = date_create($date_updated);
		$date_updated = date_format($date_updated, 'd/m/y H:i:s');
		echo "<div class='card-footer small text-muted'>Cập nhật mới nhất lúc {$date_updated}</div>";
	}
	?>
	</div>

	<div class="card mb-3 card-ds-lich-hen">
		<div class="card-header bg-secondary text-white">
			<i class="fas fa-table"></i>
			Danh sách lịch khám - Bác sĩ hẹn bạn
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="table-ds-lich-hen-2" width="100%" cellspacing="0">
					<thead>
						<tr>
                            <th>#</th>
                            <th>Ngày</th>
                            <th>Giờ</th>
                            <th>Số TT</th>
                            <th>Bác sĩ</th>
							<th>Số ĐT</th>
							<th>Lý do</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php 
				$index = 0;
				if ($data) {
					foreach ($data as $lichkham) {
						if ($lichkham['chuDong'] == '1') {
							$index++;
							$status = 'warning';
							$disbled = '';
							//(2) Xử lý Check lịch khám
							//		1. Nhấn nút Check lịch khám thì thực hiện xử lý Khám?
							//			2. Xử lý check
							if ($lichkham['tinhTrang'] == 0) {
								$status = 'success';
								$disbled = 'disabled';
							}
							$ngayhen = $lichkham['ngayHen'];
							$ngayhen = date_create($ngayhen);
							$ngayhen = date_format($ngayhen, 'd/m/Y');
							$gio = substr($lichkham['gioHen'], 0, 5);
							echo "<tr data-id='{$lichkham['id']}'>
										<td>{$index}</td>
										<td>{$ngayhen}</td>
										<td>{$gio}</td>
										<td>{$lichkham['soTT']}</td>
										<td>{$lichkham['ten']}</td>
										<td>{$lichkham['soDT']}</td>
										<td>{$lichkham['lyDo']}</td>
										<td><button class='btn btn-{$status}  btn-confirm-done' data-id='{$lichkham['id']}' {$disbled} ><i class='fas fa-check'></i></button></td>
									</tr>";
						}
					}
				}
				?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	if ($index > 0) {
		$date_updated = $data[0]['ngayTao'];
		$date_updated = date_create($date_updated);
		$date_updated = date_format($date_updated, 'd/m/y H:i:s');
		echo "<div class='card-footer small text-muted'>Cập nhật mới nhất lúc {$date_updated}</div>";
	}
	?>
	</div>
</div>
<?php endif; ?>
<?php include('footer.php') ?>