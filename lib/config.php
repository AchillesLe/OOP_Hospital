<?php 
    define("APP_NAME", "BENH VIEN QUAN DAN Y MIEN DONG");
    define("SITE_NAME","http://".$_SERVER['SERVER_NAME']);

    define("LOG_PATH","log");
/**
 * config database
 */
    define("DB_HOST", "localhost");
    define("DB_USER_NAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "benhvien");
/**
 * config mail
 */
    define("MAIL_HOST", "smtp.gmail.com");
    define("MAIL_SEND", "ngttdiem28@gmail.com");//
    define("MAIL_PASSWORD", "diem1234");//diem1234
    define("MAIL_SMTP_SECURE", "tls");
/**
 * config constant
 */
    define("REQUEST_GET_BACSI_BY_KHOA", 100);
    define("REQUEST_DANGKILICHKHAM", 200);
    define("REQUEST_CHECKTIMELICHKHAM", 210);
    define("REQUEST_CONFIRM_DONE", 250);
    define("REQUEST_CHECKTIMELICHHEN", 290);
    define("REQUEST_DANGKILICHHEN", 300);
    define("REQUEST_TRACUUSOTT_KHAM", 310);
    define("REQUEST_TRACUUSOTT_XN", 340);
    define("REQUEST_TRACUUSOTT_CUA_XN", 350);
    define("REQUEST_DANGKIXETNGHIEM", 390);
    define("REQUEST_THEMBENHAN", 400);
    define("REQUEST_SUABENHAN", 410);
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $array_time = array(   
        1=>"8:00",2=>"8:15",3=>"8:30",4=>"8:45",5=>"9:00",6=>"9:15",7=>"9:30",8=>"9:45",9=>"10:00",10=>"10:15",11=>"10:30",12=>"10:45",
        13=>"11:00",14=>"11:15",15=>"11:30",16=>"11:45",17=>"12:00",18=>"12:15",19=>"12:30",20=>"12:45",21=>"13:00",22=>"13:15",23=>"13:30",24=>"13:45",
        25=>"14:00",26=>"14:15",27=>"14:30",28=>"14:45",29=>"15:00",30=>"15:15",31=>"15:30",32=>"15:45",33=>"16:00",34=>"16:15",35=>"16:30",36=>"16:45"
    );
?>
