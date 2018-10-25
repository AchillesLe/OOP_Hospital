<?php 
class MessageNoti
{

    public static $msgLoginFailed = "Email hoặc mật khẩu không đúng ";

    public static $msgRegisterFailed = "Có lỗi xuất hiện trong quá trình đăng kí  !";
    public static $msgRegisterSuccessfully = "Đăng kí thành công , xin mời đăng nhập !";
    public static $msgEmailExist = "Địa chỉ Email này đã được đăng kí trong hệ thống , vui lòng kiểm tra lại !";
    public static $msgEmailNotExist = "Địa chỉ mail chưa không có trong hệ thống , vui lòng kiểm tra lại !";
    public static $msgCMNDExist = "Số CMND  đã được đăng kí trong hệ thống , vui lòng kiểm tra lại !";
    public static $msgBHYTExist = "Số BHYT  đã được đăng kí trong hệ thống , vui lòng kiểm tra lại !";
    public static $msgBHYTOrCMNDExist = " Số CMND hoặc BHYT đã được đăng kí trong hệ thống , vui lòng kiểm tra lại !";
    public static $msgUpdateFailed = "Có lỗi xuất hiện trong quá trình cập nhật thông tin , thử lại lần nữa !";
    public static $msgUpdateSuccessfully = "Cập nhật thông tin thành công  !";
    public static $msgSendMailSuccessfully = "Mail đã được gửi thành công , vui lòng kiểm tra mail !";
    public static $msgSendMailFailed = "Xuất hiện lỗi trong quá trình gửi mail , vui lòng thử lại !";
    public static $msgRegisterAppointmentScheduleSuccessfully = "Đặt lịch hẹn thành công , vui lòng kiểm tra mail !";
    public static $msgRegisterAppointmentScheduleFailed = "Đặt lịch hẹn thất bại , Vui lòng thử lại !";

    public static function RegisterApponitmentScheduleSuccessfullyInMail($ten, $giokham, $ngaykham, $tenkhoa, $sott)
    {
        return "Bạn đã đặt lịch hẹn khám bệnh với bác sĩ <b>{$ten}</b> lúc <b>{$giokham}</b> ngày <b>{$ngaykham}
        </b> tại khoa <b>{$tenkhoa}</b> , số thứ thự của bạn là <b>{$sott}</b>.
        <p>Mong bạn tới đúng giờ , xin cảm ơn !</p>";
    }
    public static function RegisterApponitmentScheduleSuccessfully($sott)
    {
        return "Đăng kí thành công ! Số thứ thự của bạn là <b>{$sott}</b>. Mong bạn tới đúng giờ xin cảm ơn !";
    }
    public static function ApponitmentScheduleExist($namekhoa, $ngay)
    {
        return "Bạn đã có sẵn 1 lịch hẹn với khoa {$namekhoa}  trong ngày {$ngay}. Vui lòng chọn khoa khác !";
    }
    public static function ApponitmentScheduleExistGioNgay($time, $ngay)
    {
        return "Bạn đã có sẵn 1 lịch hẹn lúc {$time}  trong ngày {$ngay}. Vui lòng chọn thời gian khác !";

    }
    public static function SomeBodyApponitmentScheduleExistGioNgay($time, $ngay)
    {
        return "Đã có người đặt lúc  {$time}  trong ngày {$ngay}. Vui lòng chọn thời gian khác !";
    }
    public static function PatientApponitmentScheduleExistGioNgay($giokham, $ngayhen)
    {
        return "Bệnh nhân đã có  sẵn 1 lịch hẹn lúc {$giokham}  trong ngày {$ngayhen}. Vui lòng chọn ngày/giờ khác !";
    }
    public static function MS_100($giokham, $ngayhen)
    {
        return "Bạn đã có sẵn 1 lịch khám / hẹn lúc {$giokham}  trong ngày {$ngayhen}. Vui lòng chọn ngày/giờ khác !";
    }
    public static function MS_200($ngayhen)
    {
        return "Bệnh nhân đã có  sẵn 1 lịch hẹn ở khoa của bạn  trong ngày {$ngayhen}. Vui lòng chọn ngày khác !";
    }
    public static function MS_300($name_bacsi, $giohen, $ngayhen)
    {
        return "Bác sĩ <b> {$name_bacsi} </b> đã hẹn bạn tới khám tại Bệnh Viện Quân Dân Y Miền Đông lúc {$giohen} ngày {$ngayhen}. <p>Mong bạn thu xếp thời gian tới khám , vì sức khỏe của bạn . Trân trọng !</p>";
    }
    public static function MS_400($pass, $url_login)
    {
        return "Mật khẩu của bạn là <b>{$pass} !</b><h3>Đi tới <a href='{$url_login}' target='_blank'>trang đăng nhập</a>!</h2>";
    }
    public static function MS_500($gio, $new_ngay)
    {
        return "Đã có người đặt  lịch hẹn với  lúc <b>{$gio}</b> ngày  <b>{$new_ngay}</b> với phòng xét nghiệm . Vui lòng kiểm tra lại !";
    }
    public static $RegisAnalysisSuccesfully = "Tạo lịch hẹn xét nghiệm thành công !";
    public static $RegisAnalysisFailed = "Tạo lịch hẹn xét nghiệm thất bại , Vui lòng thử lại !";

}
?>