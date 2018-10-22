<?php
    $id = isset($_GET['bn'])?$_GET['bn']:0;
    $benhnhanmodel = new benhnhanModel();
    $result = $benhnhanmodel->getAllByID($id);
    $name = "";
    if( $result ){
        $name = $result['ten'];
    }else{
        echo "<meta http-equiv='Refresh' content='0;URL=/'>";
    }
?>
<?php include('header.php') ?>
<div id="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3 dklichkham">
            <div class="card-header">
              <i class="fas fa-table"></i> Đặt lịch hẹn
            </div>
            <div id="message-lichhen">
            </div>
            <div class="card-body">
                <form id="form-appointment-schedule-bs" method="POST" action="/p-dangki-lichkham">
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-8">
                            <label >Tên bệnh nhân</label>
                            <input type="text" class="form-control" value="<?php echo $name ?>" disabled>
                            <input type="text" id="id_bn" name="id_bn" value="<?php echo $id ?>" hidden>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-6">
                            <label for="txt_ngayhen">Ngày khám</label>
                            <input type="text" class="form-control" name="txt_ngayhen" id="txt_ngayhen"   placeholder="dd/mm/yyyy">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="sel_time_hen">Giờ khám</label>
                            <select name="sel_time_hen"  id="sel_time_hen" class="form-control" >
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-8">
                            <label for="txt_reason">Lý do &nbsp;&nbsp;( Tối đa 300 kí tự )</label>
                            <textarea class="form-control" name="txt_reason" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group offset-md-2 col-md-4">
                            <input class="form-control" value="300" name="nameRequest" hidden>
                            <button type="button" class="btn btn-primary bnt-appointment-schedule-bs">Tạo lịch hẹn</button>
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
    $('#txt_ngayhen').datepicker(options_Y_M_D);
    $('#txt_ngayhen').data('datepicker').setStartDate(currdate);
    $('#form-appointment-schedule-bs').validate({
        rules: {
            txt_ngayhen:{
                required:true
            },
            txt_reason:{
                required:true,
                maxlength : 300,
                minlength:3
            },
        },
        messages:{
            txt_ngayhen:{
                required:"Vui lòng nhập/chọn ngày hẹn !",
            },
            txt_reason:{
                required:"Vui lòng nhập nguyên nhân triệu chứng !",
                maxlength : "Nhập tối đa 300 kí tự !",
                minlength : "Nhập tối đa 3 kí tự !",
            },
        },
        errorClass: "label-danger",
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
    $('#txt_ngayhen').on('change',function(){
        $('#message-lichhen').html("");
        $('#sel_time_hen').empty();
        $('#sel_time_hen').append('<option value="0">-chọn-</option>');
        $ngay =  $(this).val();
        var res = $ngay.split('/');
        $newngay = res[1]+"/"+res[0]+"/"+res[2];
        $now = new Date();
        $date_now = ($now.getMonth()+1)+"/"+$now.getDate()+"/"+$now.getFullYear() +" "+$now.getHours()+":"+$now.getMinutes();
        $.each(JSON.parse(array_time),function(index,element){
            $date_comp = $newngay+" "+element;
            if(Date.parse(new Date($date_comp)) > Date.parse(new Date($date_now))){
                let html = '<option value="'+index+'">'+element+'</option>';
                $('#sel_time_hen').append(html);
            }
        });

        var indextime = $(this).val();
        var time = $('#sel_time_hen option:selected').text();
        var ngay = $('#txt_ngayhen').val();
        var idbn = $('#id_bn').val();
        $.ajax({
            url:"/check-lichkham",
            type:"POST",
            dataType:'json',
            data:{nameRequest:290,indextime:indextime,time:time,ngay:ngay,idbn:idbn},
            success:function(result){
                let html ="";
                if(!result.status){
                    html = "<div class='alert alert-danger'>"+result.massage+"</div>";
                }
                $('#message-lichhen').html(html);
            }
        });
    });
    $('#sel_time_hen').on('change',function(){
        $('#message-lichhen').html("");
        var indextime = $(this).val();
        var time = $('#sel_time_hen option:selected').text();
        var ngay = $('#txt_ngayhen').val();
        var idbn = $('#id_bn').val();
        $.ajax({
            url:"/check-lichkham",
            type:"POST",
            dataType:'json',
            data:{nameRequest:290,indextime:indextime,time:time,ngay:ngay,idbn:idbn},
            success:function(result){
                let html ="";
                if(!result.status){
                    html = "<div class='alert alert-danger'>"+result.massage+"</div>";
                }
                $('#message-lichhen').html(html);
            }
        });
    });
    $('.bnt-appointment-schedule-bs').on('click',function(){
        
        if( $('#form-appointment-schedule-bs').valid()==false ){
            return;
        }
        if( $('#sel_time_hen').val() == 0 ){
            alert("Vui lòng chọn thời gian hẹn !");
            return;
        }
        if( $('#message-lichhen').html() == ''){
            $('#form-appointment-schedule-bs').submit();
        }
    });
</script>
