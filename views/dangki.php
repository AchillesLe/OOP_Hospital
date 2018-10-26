
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bệnh Viện Quân Dân Y Miền Đông - Đăng kí</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Đăng kí tài khoản</div>
        <?php
        /**
        * (1) Hiển thị ban đầu
        *      1. Thực hiện khởi tạo màn hình ban đầu
        */ 
        if (isset($_SESSION['message-register'])) {
            echo "<div class='alert alert-danger'>{$_SESSION['message-register']}</div>";
            unset($_SESSION['message-register']);
        }
        ?>
        <div class="card-body">
            <form id="form-dangki" method="POST" action="/p-dangki">
                <div class="form-group">
                    <input type="text" id="txt_name" name="txt_name" class="form-control" placeholder="Họ và tên">
                </div>
                <div class="form-group">
                    <div class="form-row" >
                        <div class="col-md-3">
                            <label class="mr-5">Giới tính</label>
                        </div>
                        <div class="col-md-3">
                            <input type="radio" name="rd_sex" id="sex_1"  value="Nam">
                            <label for="rd_sex">Nam</label>
                        </div>
                        <div class="col-md-3">
                            <input type="radio"  name="rd_sex" id="sex_2" value="Nu">
                            <label for="rd_sex">Nữ</label>
                        </div>
                        <div class="col-md-3">
                            <input type="radio"  name="rd_sex" id="sex_3" value="Khac">
                            <label for="rd_sex">Khác</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="txt_address" name="txt_address" class="form-control" placeholder="Địa chỉ" >
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" id="txt_birthday" name="txt_birthday" class="form-control" placeholder="Ngày sinh ( dd/mm/yyyy )">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="txt_bhyt" name="txt_bhyt" class="form-control" placeholder="Bảo hiểm y tế">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="text" id="txt_cmt" name="txt_cmt" class="form-control" placeholder="Chứng minh thư" >
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="txt_dantoc" name="txt_dantoc" class="form-control" placeholder="Dân tộc" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" id="txt_nghe" name="txt_nghe" class="form-control" placeholder="Nghề nghiệp">
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="email" id="txt_email" name="txt_email" class="form-control" placeholder="Email" >
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="txt_sdt" name="txt_sdt" class="form-control" placeholder="Số điện thoại" >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <input type="password" id="txt_password" name="txt_password" class="form-control" placeholder="Password" >
                        </div>
                        <div class="col-md-6">
                            <input type="password" id="txt_confirmPassword"  name="txt_confirmPassword"  class="form-control" placeholder="Confirm password" >
                        </div>
                    </div>
                </div>
                <input type="text" name="submit-form-dangki" id="submit-form-dangki" hidden>
                <input type="button" class="btn btn-primary btn-block btn-dangki" value="Đăng kí">
            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="/">Trang đăng nhập</a>
                <a class="d-block small" href="/forgot-password">Quên mật khẩu !</a>
            </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/message.js"></script>
    <script src="js/custom.js"></script>
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
  </body>

</html>
