<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bệnh viện quân dân y miền đông - Quên mật khẩu</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Quên mật khẩu</div>
        <?php 
        if( isset($_SESSION['status']) && $_SESSION['status']==true ){
            echo "<div class='alert alert-success'>{$_SESSION['message-forgotmail']}</div>";
            unset($_SESSION['message-forgotmail']);
            unset($_SESSION['status']);
        }else if(isset($_SESSION['status']) && $_SESSION['status']==false){
            echo "<div class='alert alert-danger'>{$_SESSION['message-forgotmail']}</div>";
            unset($_SESSION['message-forgotmail']);
            unset($_SESSION['status']);
        }
        ?>
        <div class="card-body">
			<div class="text-center mb-4">
				<h4>Bạn quên mật khẩu?</h4>
				<p>Nhập email của bạn , chúng tôi sẽ gửi lại mật khẩu cho bạn ở trong email .</p>
			</div>
			<form action="/p-forgotpassword" id="form-fogotmail" method="POST">
				<div class="form-group">
                    <input type="email" name="txt_email" class="form-control" placeholder="Nhập địa chỉ email" >
				</div>
				<a class="btn btn-primary btn-block" id="sendmail-forgot">Gửi email</a>
			</form>
			<div class="text-center">
                <a class="d-block small mt-3" href="/dangki">Đăng kí</a>
				<a class="d-block small mt-3" href="/">Trang đăng nhập</a>
			</div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/message.js"></script>
    <script>
        $(document).ready(function(){
            $('#form-dangki').validate({
                rules: {
                    txt_email: {
                        required:true,
                        email:true
                    },
                },
                messages:{
                    txt_email: {
                        required: Message.MS_01,
                        email:Message.MS_04
                        
                    },
                },
                errorClass: "label-danger",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                }

            });
            $('#sendmail-forgot').on('click',function(){
                if( $('#form-fogotmail').valid() == false ) return;
                $('#form-fogotmail').submit();
            });
        });
    </script>
  </body>

</html>

