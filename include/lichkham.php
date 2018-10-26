<?php 
/**
 * (2) Xử lý đăng kí
 *      2. Check hạng mục
 *          a.check hạng mục
 */
if (isset($_SESSION['user'])) {
    ob_start();
    if (isset($_POST['nameRequest']) && $_POST['nameRequest'] == REQUEST_DANGKILICHKHAM) {
        $id_bacsi = $_POST['sel_bacsi'];
        $id_benhnhan = ($_SESSION['user'])['id'];
        $idkhoa = $_POST['sel_khoa'];
        $ngaykham = str_replace('/', '-', $_POST['txt_ngaykham']);
        $stt = $_POST['sel_time'];
        $giokham = $array_time[$_POST['sel_time']];
        $lido = $_POST['txt_reason'];
        $sdt = $_POST['txt_sdt'];
        $ngaykham = date("Y-m-d", strtotime($ngaykham));
        if ($_POST['sel_bacsi'] == 0) {
                // Những bác sĩ trong khoa mà ko có bất cứ lịch hẹn nào trong ngày
            $bacsiModel = new bacsiModel();
            $data = $bacsiModel->GetAllBacsiNoLichKhamInDay($idkhoa, $ngaykham);
            if ($data) {
                $id_bacsi = $data[0]['id'];
            } else {
                    // Những bác sĩ trong khoa có lịch khám bệnh trong ngày ít nhất
                $data = $bacsiModel->GetBacsiItLichKhamTrongNgayNhat($idkhoa, $ngaykham);
                if ($data) {
                    $id_bacsi = $data[0]['id'];
                }
            }

        }
            // Tạo lịch hẹn không bị trùng
        $lichkhamModel = new datlichkhamModel($id_benhnhan, $id_bacsi, $stt, $ngaykham, $giokham, $sdt, $lido, 0);
        $data = $lichkhamModel->insert();
        if ($data) {
                //lấy thông tin bác sĩ và khoa để gửi mail
            $data = $bacsiModel->GetinforKhoaAndbacSi($id_bacsi);
                // send mail
            $inforMail = array(
                'emailTo' => ($_SESSION['user'])['Email'],
                'subject' => "Mail đăng kí lịch hẹn",
                'body' => MessageNoti::RegisterApponitmentScheduleSuccessfullyInMail($data['ten'], $giokham, $_POST['txt_ngaykham'], $data['tenKhoa'], $stt),
            );
            $mail = new Mail();
            $result = $mail->send($inforMail);
            if ($result) {
                $_SESSION['message-dklichkham'] = MessageNoti::$msgSendMailSuccessfully;
                $_SESSION['status'] = true;
            } else {
                $_SESSION['message-dklichkham'] = MessageNoti::RegisterApponitmentScheduleSuccessfully($stt);
                $_SESSION['status'] = true;
            }
        }
        echo "<meta http-equiv='Refresh' content='0;URL=/dangki-lichkham' />";
        exit();

    } else if (isset($_POST['nameRequest']) && $_POST['nameRequest'] == REQUEST_CHECKTIMELICHKHAM) {
        $id_benhnhan = $id_benhnhan = ($_SESSION['user'])['id'];
        $id_bacsi = $_POST['idbacsi'];
        $idkhoa = $_POST['idkhoa'];
        $namekhoa = $_POST['namekhoa'];
        $indextime = $_POST['indextime'];
        $time = $_POST['time'];
        $ngay = str_replace('/', '-', $_POST['ngay']);
        $ngay = date("Y-m-d", strtotime($ngay));
        $result = ['status' => true, 'massage' => ""];

        $lichkhamModel = new datlichkhamModel();
            //Kiểm tra trùng khoa
        $data = $lichkhamModel->CheckDuplicateKhoa($id_benhnhan, $ngay, $idkhoa);

        if ($data != 0) {
            $result['status'] = false;
            $result['massage'] = MessageNoti::ApponitmentScheduleExistKhoaNgay($namekhoa, $_POST['ngay']);
            echo json_encode($result);
            exit();
        }
            //Kiểm tra lịch hẹn  có trùng ngày giờ 
        $data = $lichkhamModel->CheckDuplicateDatetime($id_benhnhan, $ngay, $indextime);

        if ($data != 0) {
            $result['status'] = false;
            $result['massage'] = MessageNoti::ApponitmentScheduleExistGioNgay($time, $_POST['ngay']);
            echo json_encode($result);
            exit();
        }
        if ($_POST['idbacsi'] != 0) {
            $data = $lichkhamModel->CheckBacsiDuplicateLich($id_benhnhan, $id_bacsi, $ngay, $indextime);
            if ($data->num_rows != 0) {
                $result['status'] = false;
                $result['massage'] = MessageNoti::SomeBodyApponitmentScheduleExistGioNgay($time, $_POST['ngay']);
                echo json_encode($result);
                exit();
            }
        }
    }
    /**(2) Xử lý đặt hẹn													
     *      1. Nhấn nút Tạo lịch hẹn thì thực hiện xử lý.														
     */
    else if (isset($_POST['nameRequest']) && $_POST['nameRequest'] == REQUEST_CONFIRM_DONE) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $lichkhamModel = new datlichkhamModel();
                //Kiểm tra trùng khoa
            $data = $lichkhamModel->UpdateConfirmDone($id);
            if ($data) {
                echo json_encode(['status' => true]);
                exit();
            } else {
                echo json_encode(['status' => false]);
                exit();
            }
        }

    }
    /**
     * (2) Xử lý đăng kí
     *      2. Check hạng mục
     *          a.check hạng mục
     */
    else if (isset($_POST['nameRequest']) && $_POST['nameRequest'] == REQUEST_CHECKTIMELICHHEN) {
        $id_bacsi = ($_SESSION['user'])['id'];
        $id_benhnhan = $_POST['idbn'];
        $ngayhen = str_replace('/', '-', $_POST['ngay']);
        $stt = $_POST['indextime'];
        $giokham = $array_time[$_POST['indextime']];
        $ngayhen = date("Y-m-d", strtotime($ngayhen));
        $lichkhamModel = new datlichkhamModel();

        $data = $lichkhamModel->CheckMultiBacsiDuplicateLich($id_benhnhan, $ngayhen, $stt);
        if ($data != 0) {
            $result['status'] = false;
            $result['massage'] = MessageNoti::PatientApponitmentScheduleExistGioNgay($giokham, $ngayhen);
            echo json_encode($result);
            exit();
        }
        /**  check bác sĩ đã có hẹn trong giờ / ngày đó hay chưa */
        $data = $lichkhamModel->CheckBacsiHasLichHen($id_bacsi, $ngayhen, $stt);
        if ($data != 0) {
            $result['status'] = false;
            $result['massage'] = MessageNoti::MS_100($giokham, $ngayhen);
            echo json_encode($result);
            exit();
        }
        /** check cac bác sĩ cùng khoa đặt lịch vs bệnh nhan hoặc bệnh nhan có lịch hẹn trong khoa trong cùng 1 ngày */
        $data = $lichkhamModel->Check_001($id_bacsi, $id_benhnhan, $ngayhen);
        if ($data != 0) {
            $result['status'] = false;
            $result['massage'] = MessageNoti::MS_200($ngayhen);
            echo json_encode($result);
            exit();
        }

    }
    /**
     * (2) Xử lý đăng kí
     *      2. Check hạng mục
     *          a.check hạng mục
     */
    else if (isset($_POST['nameRequest']) && $_POST['nameRequest'] == REQUEST_DANGKILICHHEN) {
        $id_bacsi = ($_SESSION['user'])['id'];
        $id_benhnhan = $_POST['id_bn'];
        $ngayhen = str_replace('/', '-', $_POST['txt_ngayhen']);
        $stt = $_POST['sel_time_hen'];
        $giohen = $array_time[$stt];
        $lyDo = $_POST['txt_reason'];
        $ngayhen = date("Y-m-d", strtotime($ngayhen));

        $lichkhamModel = new datlichkhamModel($id_benhnhan, $id_bacsi, $stt, $ngayhen, $giohen, null, $lyDo, 1);
        $result = $lichkhamModel->insertHasChuDong();
        if ($result) {
            $dangnhap = new dangnhapModel();
            $result_2 = $dangnhap->GetInforBenhNhan($id_benhnhan);
            if ($result_2) {
                $email = $result_2['Email'];
                $name_bacsi = ($_SESSION['user'])['ten'];
                $inforMail = array(
                    'emailTo' => $email,
                    'subject' => "BỆNH VIÊN QUÂN DÂN Y MIÊN ĐÔNG",
                    'body' => MessageNoti::MS_300($name_bacsi, $giohen, $ngayhen),
                );
                $mail = new Mail();
                $result = $mail->send($inforMail);
                //check Trường hợp bệnh nhân đã có lịch hẹn với bác sĩ cùng ngày																
                $_SESSION['message-dklichhen'] = MessageNoti::$msgRegisterAppointmentScheduleSuccessfully;
                $_SESSION['status'] = true;
                echo "<meta http-equiv='Refresh' content='0;URL=/danh-sach-benh-nhan' />";
            }

        } else {
            $_SESSION['message-dklichhen'] = MessageNoti::$msgRegisterAppointmentScheduleFailed;
            $_SESSION['status'] = false;
            echo "<meta http-equiv='Refresh' content='0;URL=/dat-hen' />";
        }


    }

    ob_end_flush();
}
?>