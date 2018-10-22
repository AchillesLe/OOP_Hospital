<?php include('header.php') ?>
<?php 
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }else{
        $user['tenBenhnhan'] = "";
        $user['gioiTinh'] = "";
        $user['diaChi'] = "";
        $user['ngaySinh'] = "";
        $user['CMND'] = "";
        $user['danToc'] = "";
        $user['ngheNghiep'] = "";
        $user['BHYT'] = "";
        $user['matKau'] = "";
        $user['Email'] = "";
    }
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3 dklichkham">
            <div class="card-header">
              <i class="fas fa-table"></i>Thông tin 
            </div>
            <div class="card-body">
                <?php 
                if( isset($_SESSION['message-update-infor']) && isset( $_SESSION['status']) ){
                    if($_SESSION['status']){
                        echo "<div class='alert alert-success'>{$_SESSION['message-update-infor']}</div>";
                    }else
                    echo "<div class='alert alert-danger'>{$_SESSION['message-update-infor']}</div>";
                    unset($_SESSION['message-update-infor']);
                    unset($_SESSION['status']);
                }
                ?>
            <form id="update-infor" action="/p-inforbasic" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txt_name">Họ và tên</label>
                        <input type="text" class="form-control" name="txt_name" value="<?php echo $user['ten'] ?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="mr-5">Giới tính</label>
                        <div class="form-row group-cbx-sex">
                            <div class="col-md-4">
                                <input type="radio" name="rd_sex" id="sex_1"  value="Nam" <?php if($user['gioiTinh'] == "Nam") echo 'checked' ?> >
                                <label for="rd_sex">Nam</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio"  name="rd_sex" id="sex_2" value="Nu" <?php if($user['gioiTinh'] == "Nu") echo 'checked' ?>>
                                <label for="rd_sex">Nữ</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio"  name="rd_sex" id="sex_3" value="Khac" <?php if($user['gioiTinh'] == "Khac") echo 'checked' ?>>
                                <label for="rd_sex">Khác</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txt_email">Email</label>
                        <input type="email" class="form-control" name="txt_email" value="<?php echo $user['Email'] ?>" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txt_sdt">Số điện thoại</label>
                        <input type="text" class="form-control" name="txt_sdt" value="<?php echo $user['soDT'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txt_birthday">Ngày sinh</label>
                        <?php 
                            $birthday = str_replace('-', '/', $user['ngaySinh']); 
                            $birthday = date("d/m/Y", strtotime($birthday) );
                        ?>
                        <input type="text" class="form-control" name="txt_birthday" id="txt_birthday" placeholder="dd/mm/yyyy" value="<?php echo $birthday ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="txt_cmt">CMND</label>
                        <input type="text" class="form-control" name="txt_cmt" value="<?php echo $user['CMND'] ?>" >
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txt_bhyt">Bảo hiểm y tế</label>
                        <input type="text" class="form-control" name="txt_bhyt" value="<?php echo $user['BHYT'] ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txt_dantoc">Dân tộc</label>
                        <input type="text" class="form-control" name="txt_dantoc" value="<?php echo $user['danToc'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="txt_address">Địa chỉ</label>
                    <input type="text" class="form-control" name="txt_address" value="<?php echo $user['diaChi'] ?>">
                </div>
                <?php if($user['quyen']==1): ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txt_nghe">Nghề nghiệp</label>
                        <input type="text" class="form-control" name="txt_nghe" value="<?php echo $user['ngheNghiep'] ?>">
                    </div>
                </div>
                <?php endif;?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="txt_pass">Password</label>
                        <input type="password" class="form-control" name="txt_pass" value="<?php echo $user['matKhau'] ?>">
                    </div>
                </div>
                <input type="text" class="form-control" name="submit-update-infor" hidden>
                <input type="text" class="form-control" name="id" value="<?php echo $user['id'] ?>" hidden>
                <input type="text" class="form-control" name="idDangnhap" value="<?php echo $user['idDangnhap'] ?>" hidden>
                <button type="button" class="btn btn-primary" id="btn-update-infor">Cập nhật thông tin</button>
            </form>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php') ?>
<script>
    var options_Y_M_D = {
        format: 'dd/mm/yyyy',
        minViewMode: 'days',
        todayHighlight: true,
        autoclose: true,
        orientation: "auto right",
    };
    var date = new Date();
    var currdate =  date.getDate()+"/"+ (date.getMonth()+1) +"/"+date.getFullYear();
    $('#txt_birthday').datepicker(options_Y_M_D);
    $('#txt_birthday').data('datepicker').setEndDate(currdate);
</script>