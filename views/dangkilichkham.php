<?php include('header.php') ?>
<?php
    $khoamodel = new khoaModel();
    $khoa = $khoamodel->GetAll();
?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3 dklichkham">
            <div class="card-header">
              <i class="fas fa-table"></i>Đăng kí lịch khám 
            </div>
            <div id="message-lichkham">
                <?php
                    if( isset($_SESSION['status']) && $_SESSION['status']==true ){
                        echo "<div class='alert alert-success alert-massage'>{$_SESSION['message-dklichkham']}</div>";
                        unset($_SESSION['message-dklichkham']);
                        unset($_SESSION['status']);
                    }else if(isset($_SESSION['status']) && $_SESSION['status']==false){
                        echo "<div class='alert alert-danger alert-massage'>{$_SESSION['message-dklichkham']}</div>";
                        unset($_SESSION['message-dklichkham']);
                        unset($_SESSION['status']);
                    }
                ?>
            </div>
            <div class="card-body">
                <form id="form-appointment-schedule" method="POST" action="/p-dangki-lichkham">
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-8">
                            <label for="sel_khoa">Khoa</label>
                            <select name="sel_khoa" id="sel_khoa" class="form-control">
                                <option value="0">--------------------------Chọn khoa------------------------</option>
                                    <?php 
                                    if( count($khoa) > 0){
                                        foreach($khoa as $item){
                                            echo "<option value='{$item['id']}'>{$item['tenKhoa']}</option>";
                                        }
                                    }
                                    ?>
                            </select>
                            <label id="error-sel-khoa" class="label-danger" hidden>Vui lòng chọn khoa !</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-6">
                            <label for="sel_bacsi">Bác sĩ</label>
                            <select name="sel_bacsi" id="sel_bacsi" class="form-control">
                                <option value="0">------ Khoa tự sắp xếp ------</option> 
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-6">
                            <label for="txt_ngaykham">Ngày khám</label>
                            <input type="text" class="form-control" name="txt_ngaykham" id="txt_ngaykham"   placeholder="dd/mm/yyyy">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="sel_time">Giờ khám</label>
                            <select name="sel_time"  id="sel_time" class="form-control" >
                                <!-- <option value="0">--Chọn--</option> -->
                                <!-- <?php 
                                    foreach($array_time as $key => $time){
                                        echo "<option value={$key}>{$time}</option>";
                                    }
                                ?> -->
                            </select>
                        </div>
                        <label id="error-sel-time" class="label-danger" hidden>Vui lòng chọn thời gian !</label>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-6">
                            <label for="txt_sdt">Số điện thoại</label>
                            <input type="text" class="form-control" id="txt_sdt" name="txt_sdt" placeholder="Số điện thoại">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-8">
                            <label for="txt_reason">Nguyên nhân / Triệu chứng &nbsp;&nbsp;( Tối đa 300 kí tự )</label>
                            <textarea class="form-control" name="txt_reason" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-4">
                            <input class="form-control" value="200" name="nameRequest" hidden>
                            <button type="button" class="btn btn-primary bnt-appointment-schedule">Tạo lịch hẹn</button>
                        </div>
                    </div>
                </form>
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
    $('#txt_ngaykham').datepicker(options_Y_M_D);
    $('#txt_ngaykham').data('datepicker').setStartDate(currdate);
    // $("#sel_bacsi").chosen({});

</script>
