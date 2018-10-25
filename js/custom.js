var option_time = { minuteStep: 5,
    showInputs: false,
    defaultTime:"current",
    mode:'24h',
    disableFocus: true,
    showMeridian: false  };

$(document).ready(function() {

    /**
     * (2) Xử lý đăng kí
     *      2. Xử lý check
     *          a. Check hạng mục
     *              2.a.1-2.a.16
     */
    $('#form-dangki').validate({
        rules: {
            txt_name: {
                required: true
            },
            rd_sex: {
                required:true
            },
            txt_address: {
                required:true
            },
            txt_birthday: {
                required:true
            },
            txt_bhyt: {
                number: true,
                maxlength : 15,
                minlength: 15
            },
            txt_cmt: {
                number: true,
                maxlength : 9,
                minlength: 9
            },
            txt_email: {
                required:true,
                email:true
            },
            txt_sdt :{
                required:true,
                number: true,
                maxlength : 11,
                minlength:10
            },
            txt_password: {
                required:true,
                minlength:6
            },
            txt_confirmPassword: {
                equalTo: "#txt_password",
                minlength: 6
            },
        },
        messages:{
            txt_name: {
                required: Message.MS_01,
            },
            rd_sex: {
                required: Message.MS_07,
            },
            txt_address: {
                required: Message.MS_01,
            },
            txt_birthday: {
                required: Message.MS_01,
            },
            txt_bhyt: {
                number:  Message.MS_02,
                minlength: Message.MS_03,
                maxlength:Message.MS_03,
            },
            txt_cmt: {
                number:  Message.MS_02,
                minlength: Message.MS_03,
                maxlength: Message.MS_03,
            },
            txt_email: {
                required: Message.MS_01,
                email:Message.MS_04,
            },
            txt_sdt :{
                required: Message.MS_01,
                number: Message.MS_02,
                minlength: Message.MS_03,
                maxlength: Message.MS_03,
            },
            txt_password: {
                required: Message.MS_01,
                minlength: Message.MS_05,
            },
            txt_confirmPassword: {
                equalTo: Message.MS_06,
            }
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
    $('#update-infor').validate({
        rules: {
            txt_name: {
                required: true
            },
            rd_sex: {
                required:true
            },
            txt_address: {
                required:true
            },
            txt_birthday: {
                required:true
            },
            txt_bhyt: {
                number: true,
                maxlength : 15,
                minlength: 15
            },
            txt_cmt: {
                number: true,
                maxlength : 9,
                minlength: 9
            },
            txt_email: {
                required:true,
                email:true
            },
            txt_sdt :{
                required:true,
                number: true,
                maxlength : 11,
                minlength:10
            },
            txt_pass: {
                required:true,
                minlength:6
            }
        },
        messages:{
            txt_name: {
                required: Message.MS_01,
            },
            rd_sex: {
                required: "Vui lòng chọn !"
            },
            txt_address: {
                required: Message.MS_01,
            },
            txt_birthday: {
                required: Message.MS_01,
            },
            txt_bhyt: {
                number:  Message.MS_02,
                minlength: Message.MS_03,
                maxlength: Message.MS_03,
            },
            txt_cmt: {
                number:  Message.MS_02,
                minlength: Message.MS_03,
                maxlength: Message.MS_03,
            },
            txt_email: {
                required: Message.MS_01,
                email:Message.MS_03,
            },
            txt_sdt :{
                required: Message.MS_01,
                number:Message.MS_02,
                minlength: Message.MS_03,
                maxlength: Message.MS_03,
            },
            txt_pass: {
                required: Message.MS_01,
                minlength: Message.MS_03,
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
    $('.btn-dangki').on('click',function(){
        if( $('#form-dangki').valid() == false){
            return;
        }
        $('#form-dangki').submit();
    });
    $('#btn-update-infor').on('click',function(){
        if( $('#update-infor').valid() == false){
            return;
        }
        $('#update-infor').submit();
    });
    function resetUI_lichkham(element){
        $('#message-lichkham').html("");
        $('#sel_time').empty();
        $('#sel_time').append('<option value="0">-chọn-</option>');
        if(element.id =='sel_khoa'){
            $('#txt_ngaykham').val('');
            $('select#sel_bacsi').empty();
            $('select#sel_bacsi').append('<option value="0">------ Khoa tự sắp xếp ------</option> ');
        }else if( element.id =='sel_bacsi' ){
            $('#txt_ngaykham').val('');
            $('#sel_time').empty();
            $('#sel_time').append('<option value="0">-chọn-</option>');
        }
    }
    $('#sel_khoa').on('change',function(){
        resetUI_lichkham(this);
        $('#txt_ngay_check').val('');
        var id = $(this).val();
        $.ajax({
            url:'/get-bacsi-by-idKhoa',
            type:'POST',
            dataType:'json',
            data:{nameRequest:100,idkhoa:id},
            success:function(result) {
                if(result.success){
                    $.each( result.data , function(index,element){
                        var html = "<option value='"+element.id+"'>"+element.ten+"</option>";
                        $('select#sel_bacsi').append(html);
                    });
                }
            }
        });
    });
    $('#sel_bacsi').on('change',function(){
        resetUI_lichkham(this);
        $('#txt_ngay_check').val('');
    });
    $('#txt_ngaykham').on('change',function(){
        resetUI_lichkham(this);
        if($('#sel_khoa').val() == 0){
            alert(Message.MS_08);
            $('#txt_ngaykham').val("");
            return;
        }
        $ngay =  $(this).val();
        var res = $ngay.split('/');
        $newngay = res[1]+"/"+res[0]+"/"+res[2];
        $now = new Date();
        $date_now = ($now.getMonth()+1)+"/"+$now.getDate()+"/"+$now.getFullYear() +" "+$now.getHours()+":"+$now.getMinutes();
        $.each(JSON.parse(array_time),function(index,element){
            $date_comp = $newngay+" "+element;
            if(Date.parse(new Date($date_comp)) > Date.parse(new Date($date_now))){
                let html = '<option value="'+index+'">'+element+'</option>';
                $('#sel_time').append(html);
            }
        });
    });
    $('#sel_time').on('change',function(){
        $('#message-lichkham').html("");
        var indextime = $(this).val();
        var time = $('#sel_time option:selected').text();
        var idbacsi = $('#sel_bacsi').val();
        var ngay = $('#txt_ngaykham').val();
        var idkhoa = $('#sel_khoa').val();
        var namekhoa = $('#sel_khoa option:selected').text();
        $.ajax({
            url:"/check-lichkham",
            type:"POST",
            dataType:'json',
            data:{nameRequest:210,idkhoa:idkhoa,namekhoa:namekhoa,indextime:indextime,time:time,idbacsi:idbacsi,ngay:ngay},
            success:function(result){
                let html ="";
                if(!result.status){
                    html = "<div class='alert alert-danger'>"+result.massage+"</div>";
                }
                $('#message-lichkham').html(html);
            }
        });
    });
    $('#form-appointment-schedule').validate({
        rules: {
            txt_ngaykham:{
                required:true
            },
            txt_reason:{
                required:true,
                maxlength : 300,
                minlength:3
            },
            txt_sdt :{
                number: true,
                maxlength : 11,
                minlength:10
            },
        },
        messages:{
            txt_ngaykham:{
                required: Message.MS_09,
            },
            txt_reason:{
                required: Message.MS_10,
                maxlength : Message.MS_11,
                minlength : Message.MS_12,
            },
            txt_sdt :{
                number: Message.MS_02,
                minlength: Message.MS_13,
                maxlength: Message.MS_14,
            },
        },
        errorClass: "label-danger",
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
    });
    $('.bnt-appointment-schedule').on('click',function(){
        if( $('#sel_khoa').val() == 0 ){
            // $('#error-sel-khoa').css("display","inline-block");
            alert(Message.MS_08);
            return;
        }
        if( $('#sel_time').val()==0 ){
            // $('#error-sel-time').css("display","inline-block");
            alert("Vui lòng chọn thời gian !");
            return;
        }
        if($('#form-appointment-schedule').valid() == false )
            return;
        if( $('#message-lichkham').html()==''){
            $('#form-appointment-schedule').submit();
        }else{
            alert(Message.MS_15);
            return;
        }
        
    });
    var option = {
        "language": {
            "info": "Hiển thị _START_ đến _END_ của _TOTAL_ kết quả",
            "lengthMenu":"Hiển thị _MENU_ kết quả",
            "infoEmpty":"Hiển thị 0 kết quả",
            "search":    "Tìm kiếm:",
            "paginate": {
                "first":        "Đầu",
                "previous":     "Trước",
                "next":         "Tiếp",
                "last":         "Cuối"
            }
        }
    }
    $('#table-benh-an-bacsi').dataTable(option);
    var option0 = Object.assign({}, option);
    option0.language["emptyTable"] = "<h4><i> "+ Message.MS_16 + "</i></h4>";
    $('#table-ds-benh-nhan').dataTable(option0);	

    var option1 = Object.assign({}, option);
    option1.language["emptyTable"] = "<h4><i> "+ Message.MS_17 + " </i></h4>";
    $('#table-ds-lich-kham-1').dataTable(option1);
    var option3 = Object.assign({}, option);
    option3.language["emptyTable"] = "<h4><i> "+ Message.MS_18 + " </i></h4>";
    $('#table-ds-lich-hen-1').dataTable(option3);

    var option2 = Object.assign({}, option);
    option2.language["emptyTable"] = "<h4><i>"+ Message.MS_19 + "</i></h4>";
    $('#table-ds-lich-kham-2').dataTable(option2);
    var option4 = Object.assign({}, option);
    option4.language["emptyTable"] = "<h4><i>"+ Message.MS_20 + "</i></h4>";
    $('#table-ds-lich-hen-2').dataTable(option4);
    var option5 = Object.assign({}, option);
    option5.language["emptyTable"] = "<h4><i>"+ Message.MS_21 + "</i></h4>";
    $('#table-ds-benh-an').dataTable(option4);
    $('#txt_gio').timepicker(option_time);
    // $('#txt_gio').on('change',function(){
    //     console.log($(this).val());
    // });
    $('.btn-confirm-done').on('click',function(){
        if( $(this).hasClass('btn-warning') ){
            var id = $(this).data('id');
            $this = $(this);
            $.ajax({
                url:'/comfirm-done',
                type:'POST',
                dataType:'JSON',
                data:{nameRequest:250,id:id},
                success:function(result){
                    if(result.status){
                        $this.removeClass('btn-warning').addClass('btn-success').prop('disabled',true);
                    }
                }
            });
        }
        window.location.reload();
    });
    $('#sel_khoa_tracuu').on('change',function(){
        $('#sel_bacsi_tracuu').empty();
        $('#sel_bacsi_tracuu').append('<option value="0">---------------Chọn bác sĩ-----------</option>');
        $('#txt_ngay_check').val('');
        var id = $(this).val();
        $.ajax({
            url:'/get-bacsi-by-idKhoa',
            type:'POST',
            dataType:'json',
            data:{nameRequest:100,idkhoa:id},
            success:function(result) {
                if(result.success){
                    $.each( result.data , function(index,element){
                        var html = "<option value='"+element.id+"'>"+element.ten+"</option>";
                        $('select#sel_bacsi_tracuu').append(html);
                    });
                }
            }
        });
    });
    $('#sel_bacsi_tracuu').on('change',function(){
        $('#txt_ngay_check').val('');
    })
    $('#txt_ngay_check').on('change',function(){
        var idbacsi = $('#sel_bacsi_tracuu').val();
        var ngay = $('#txt_ngay_check').val();
        if(idbacsi==0){
            alert(Message.MS_22);
            return;
        }
        $.ajax({
            url:'/tra-cuu',
            data:{nameRequest:310,idbacsi:idbacsi,ngay:ngay},
            type:'POST',
            success:function(result){
                $('#table-tracuu-phongkham tbody').html('');
                if(result){
                    $('#table-tracuu-phongkham tbody').html(result);
                }else{
                    $('#table-tracuu-phongkham tbody').html("<tr><td colspan='4'><center><h5><i>"+ Message.MS_23 + "</i></h5></center></td></tr>");
                }
            }
        });
        $('html,body').animate({
            scrollTop: $("#table-tracuu-phongkham").offset().top},
        'fast');
        // window.scroll({
        //     top: 1500,
        //     behavior: "smooth"
        //   });
    });
    // $('#btn_My_sott').on('click',function(){
    //     var idbacsi = $('#sel_bacsi_tracuu').val();
    //     var ngay = $('#txt_ngay_check').val();
    //     $.ajax({
    //         url:'/tra-cuu',
    //         data:{nameRequest:310,idbacsi:idbacsi,ngay:ngay},
    //         type:'POST',
    //         success:function(result){
    //             $('#table-tracuu-phongkham tbody').html('');
    //             if(result){
    //                 $('#table-tracuu-phongkham tbody').html(result);
    //             }else{
    //                 $('#table-tracuu-phongkham tbody').html("<tr><td colspan='3'><center><h5><i>Không có hàng chờ !</i></h5></center></td></tr>");
    //             }
    //         }
    //     });
    // });
    $('#sel_XN_tracuu').on('change',function(){
        var date = new Date();
        var currdate_ymd =  date.getFullYear()+"-"+ (date.getMonth()+1) +"-" + date.getDate();
        var idXN = $('#sel_XN_tracuu').val();

        $('#sel_time_XN').empty();
        $('#sel_time_XN').append('<option value="0">--Chọn--</option>');
        $now = new Date();
        $newngay = ($now.getMonth()+1)+"/"+$now.getDate()+"/"+$now.getFullYear();
        $date_now = ($now.getMonth()+1)+"/"+$now.getDate()+"/"+$now.getFullYear() +" "+$now.getHours()+":"+$now.getMinutes();
        $.each(JSON.parse(array_time),function(index,element){
            $date_comp = $newngay+" "+element;
            if(Date.parse(new Date($date_comp)) > Date.parse(new Date($date_now))){
                let html = '<option value="'+index+'">'+element+'</option>';
                $('#sel_time_XN').append(html);
            }
        });
       

        $.ajax({
            url:'/tra-cuu',
            data:{nameRequest:340,idXN:idXN,ngay:currdate_ymd},
            type:'POST',
            success:function(result){
                $('#table-tracuu-phongXN tbody').html('');
                if(result){
                    $('#table-tracuu-phongXN tbody').html(result);
                }else{
                    $('#table-tracuu-phongXN tbody').html("<tr><td colspan='4'><center><h5><i>"+ Message.MS_23 + "</i></h5></center></td></tr>");
                }
            }
        });
    });

    $('#btn_dat_lich_XN').on('click',function(){
		var id_XN = $('#sel_XN_tracuu').val();
		var id_time_XN = $('#sel_time_XN').val();
        var time = $('#sel_time_XN option:selected').text();
        var date = new Date();
        var currdate_ymd =  date.getFullYear()+"-"+ (date.getMonth()+1) +"-" + date.getDate();
		if( id_XN == 0){
			alert("Vui lòng chọn phòng xét nghiệm !");
			return;
		}
		if( id_time_XN == 0){
			alert("Vui lòng chọn giờ xét nghiệm !");
			return;
		}
		$.ajax({
			url:'/dat-lich-xet-nghiem',
			data:{ nameRequest: 390 ,id_XN  : id_XN , id_time_XN:id_time_XN ,ngay :currdate_ymd , time:time } ,
			type : 'POST',
			dataType:'JSON',
			success : function(result){
				var status = '';
				var html = '';
				if(result.status){
					status = 'success';
					html =  `<div class='alert alert-${status}'>${result.message}</div>`;
                    $('#message').html(html);
                    window.scrollTo(0,0);
					setTimeout(function(){ 
						$('#message').html('');
                        }, 1500);
                        $('#sel_XN_tracuu').change();
                    $('#sel_XN_tracuu').trigger("change");
				}else{
					status = 'danger';
					html =  `<div class='alert alert-${status}'>${result.message}</div>`;
                    $('#message').html(html);
                    window.scrollTo(0,0);
					setTimeout(function(){ 
						$('#message').html('');
                        }, 1500);
				}
			}
		});
	});


});
function delete_row_XN(obj){
    var row_index  =  $(obj).parent().parent().index();
    $('#table_xet_nghiem tbody tr').eq(row_index).remove();
}
function delete_row_thuoc(obj){
    var row_index  =  $(obj).parent().parent().index();
    $('#table_thuoc tbody tr').eq(row_index).remove();
}
$(function(){
    /** Thêm Bệnh Án */
    $('#sel_xet_nghiem').on('change',function(){
        var id_XN = $('#sel_xet_nghiem').val();
        var id_BN = $('input[name=id_benh_nhan]').val();
        if(id_XN > 0 ){
            $.ajax({
                url:'/tra-cuu',
                type:'POST',
                data : {nameRequest:350,id_XN:id_XN,id_BN:id_BN},
                success :function(result){
                    if(result){
                       $('#txt_lan_thu').val(result);
                    }
                }
            });
        }else{
            $('#txt_lan_thu').val('');
        }
       
    });
    $('#btn_them_xet_nghiem').on('click',function(e){
        var id_XN = $('#sel_xet_nghiem').val();
        var tenXN = $('#sel_xet_nghiem option:selected').html();
        var gioXN = $('#txt_gio').val();
        var lan_thu = $('#txt_lan_thu').val();
        var ketqua = $('#txt_ket_qua').val();
        if(id_XN == 0){
            alert(Message.MS_24);
            return;
        }
        var check = false;
        $('#table_xet_nghiem tbody tr').each(function(index,element){
            var id = $(this).attr("data-id_XN");
            if( id_XN == id){
                check = true;
                alert(Message.MS_25);
            }
        });
        if(check==true){
            e.preventDefault();
            return;
        }
        var html_tr = `<tr data-id_XN="${id_XN}">
                    <td>${tenXN}</td>
                    <td>${gioXN}</td>
                    <td>${lan_thu}</td>
                    <td>${ketqua}</td>
                    <td><input type="button" class="btn btn-warning btn-delete-XN" Onclick="delete_row_XN(this)" value="Xóa"></td>
                </tr>`;
        $('#table_xet_nghiem tbody').append(html_tr);
        $('#sel_xet_nghiem').val('0');
        $('#txt_gio').timepicker('setTime', new Date());
        $('#txt_lan_thu').val('');
        $('#txt_ket_qua').val('');
    });
    $('#btn_them_thuoc').on('click',function(e){
        var id_Thuoc = $('#sel_thuoc').val();
        var tenThuoc = $('#sel_thuoc option:selected').html();
        var donvi = $('#txt_donvi').val();
        var soluong = $('#txt_soluong').val();
        if(id_Thuoc == 0){
            alert(Message.MS_26);
            return;
        }
        if(soluong == 0){
            alert(Message.MS_27);
            return;
        }
        var check = false;
        $('#table_thuoc tbody tr').each(function(index,element){
            var id = $(this).attr("data-id_thuoc");
            if( id_Thuoc == id){
                check = true;
                alert(Message.MS_28);
            }
        });
        if(check==true){
            e.preventDefault();
            return;
        }
        
        var html_tr = `<tr data-id_thuoc="${id_Thuoc}">
                    <td>${tenThuoc}</td>
                    <td>${donvi}</td>
                    <td>${soluong}</td>
                    <td><input type="button" class="btn btn-warning btn-delete-thuoc" Onclick="delete_row_thuoc(this)" value="Xóa"></td>
                </tr>`;
        $('#table_thuoc tbody').append(html_tr);
        $('#sel_thuoc').val(0);
        $('#sel_thuoc').trigger("chosen:updated");
        $('#txt_donvi').val('');
        $('#txt_soluong').val('');
    });
    $('#sel_thuoc').on('change',function(){
        var donvi = "";
        $('#txt_donvi').val("");
        donvi = $('#sel_thuoc option:selected').data('donvi');
        $('#txt_donvi').val(donvi);
    });
    $('#btn_add_benh_an').on('click',function(){
        if($('#form-benh-an').valid() == true){
            data = {};
            data['nameRequest'] = 400;
            var id_LK = $('input[name=id_LK]').val();
            var id_BN = $('input[name=id_benh_nhan]').val();
            var soTT = $('input[name=txt_soTT]').val();
            var chieu_cao = $('input[name=text_chieu_cao]').val();
            var can_nang = $('input[name=txt_can_nang]').val();
            var huyet_ap = $('input[name=txt_huyet_ap]').val();
            var chuan_doan = $('textarea[name=text_chuan_doan]').val();
            var ghi_chu = $('textarea[name=text_ghi_chu]').val();
            
            var basic = {};
            basic['id_LK'] = id_LK;
            basic['id_BN'] = id_BN;
            basic['soTT'] = soTT;
            basic['chieu_cao'] = chieu_cao;
            basic['can_nang'] = can_nang;
            basic['huyet_ap'] = huyet_ap;
            basic['chuan_doan'] = chuan_doan;
            basic['ghi_chu'] = ghi_chu;
            data['basic'] = basic;

            var xetnghiem = {};
            $('#table_xet_nghiem tbody tr').each(function(e){
                var row_index  =  $(this).index();
                var xet_nghiem_tam = {};
                xet_nghiem_tam['id_XN'] = $(this).attr('data-id_XN');
                xet_nghiem_tam['tenXN'] = $(this).find('td:eq(0)').html();
                xet_nghiem_tam['gioXN'] = $(this).find('td:eq(1)').html();
                xet_nghiem_tam['lan_thu'] = $(this).find('td:eq(2)').html();
                xet_nghiem_tam['ketqua'] = $(this).find('td:eq(3)').html();
                xetnghiem[row_index] = xet_nghiem_tam;
            });
            data['xetnghiem'] = xetnghiem;

            var thuoc = {};
            $('#table_thuoc tbody tr').each(function(e){
                var row_index  =  $(this).index();
                var thuoc_tam = {};
                thuoc_tam['id_Thuoc'] = $(this).attr('data-id_thuoc');
                thuoc_tam['tenThuoc'] = $(this).find('td:eq(0)').html();
                thuoc_tam['donvi'] = $(this).find('td:eq(1)').html();
                thuoc_tam['soluong'] = $(this).find('td:eq(2)').html();
                thuoc[row_index] = thuoc_tam;
            });
            data['thuoc'] = thuoc;
        
            $.ajax({
                url:'/p-benh-an',
                dataType:'JSON',
                type:'POST',
                data : data,
                success :function(result){
                    if(result.status){
                        $('#message-tao_benh_An').html(`<div class='alert alert-success alert-massage'>${result.message}</div>`);
                        window.scrollTo(0,0);
                        setTimeout(function(){ 
                            window.location.href=href_benh_an;
                        }, 2000);
                    }
                }
            });
        }
        return;

    });
      /** Sủa Bệnh Án */
    $('#btn_edit_benh_an').on('click',function(){
        var validator = $('#form-benh-an').valid();
        if( validator == true){
            data = {};
            data['nameRequest'] = 410;
            var id_BN = $('input[name=id_benh_nhan]').val();
            var id_BA = $('input[name=id_benh_an]').val();
            var soTT = $('input[name=txt_soTT]').val();
            var chieu_cao = $('input[name=text_chieu_cao]').val();
            var can_nang = $('input[name=txt_can_nang]').val();
            var huyet_ap = $('input[name=txt_huyet_ap]').val();
            var chuan_doan = $('textarea[name=text_chuan_doan]').val();
            var ghi_chu = $('textarea[name=text_ghi_chu]').val();
            
            var basic = {};
            basic['id_BA'] = id_BA;
            basic['soTT'] = soTT;
            basic['chieu_cao'] = chieu_cao;
            basic['can_nang'] = can_nang;
            basic['huyet_ap'] = huyet_ap;
            basic['chuan_doan'] = chuan_doan;
            basic['ghi_chu'] = ghi_chu;
            data['basic'] = basic;

            var xetnghiem = {};
            $('#table_xet_nghiem tbody tr').each(function(e){
                var row_index  =  $(this).index();
                var xet_nghiem_tam = {};
                xet_nghiem_tam['id_XN'] = $(this).attr('data-id_XN');
                xet_nghiem_tam['tenXN'] = $(this).find('td:eq(0)').html();
                xet_nghiem_tam['gioXN'] = $(this).find('td:eq(1)').html();
                xet_nghiem_tam['lan_thu'] = $(this).find('td:eq(2)').html();
                xet_nghiem_tam['ketqua'] = $(this).find('td:eq(3)').html();
                xetnghiem[row_index] = xet_nghiem_tam;
            });
            data['xetnghiem'] = xetnghiem;

            var thuoc = {};
            $('#table_thuoc tbody tr').each(function(e){
                var row_index  =  $(this).index();
                var thuoc_tam = {};
                thuoc_tam['id_Thuoc'] = $(this).attr('data-id_thuoc');
                thuoc_tam['tenThuoc'] = $(this).find('td:eq(0)').html();
                thuoc_tam['donvi'] = $(this).find('td:eq(1)').html();
                thuoc_tam['soluong'] = $(this).find('td:eq(2)').html();
                thuoc[row_index] = thuoc_tam;
            });
            data['thuoc'] = thuoc;
            
            $.ajax({
                url:'/p-benh-an',
                dataType:'JSON',
                type:'POST',
                data : data,
                success :function(result){
                    if(result.status){
                        $('#message-tao_benh_An').html(`<div class='alert alert-success alert-massage'>${result.message}</div>`);
                        window.scrollTo(0,0);
                        setTimeout(function(){ 
                            window.location.href=href_benh_an;
                        }, 1500);
                    }else{
                        $('#message-tao_benh_An').html(`<div class='alert alert-danger alert-massage'>${result.message}</div>`);
                        window.scrollTo(0,0);
                    }
                }
            });
        }
        return;

    });
 
})