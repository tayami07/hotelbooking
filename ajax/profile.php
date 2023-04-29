<?php

    require('../admin/inc/essentials.php');
    require('../admin/inc/db_config.php');
    // require('../inc/sendgrid/sendgrid-php.php');
    date_default_timezone_set("Asia/Kathmandu");

    if(isset($_POST['info_form']))
    {
        $frm_data = filteration($_POST);

        session_start();

        $u_exist = select(
            "SELECT * FROM `user_cred` WHERE `phonenum`=? AND `id`!=? LIMIT 1",
            [$data['phonenum'],$_SESSION['uId']],
            "ss"
        );
    
        if (mysqli_num_rows($u_exist)!=0) {
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo 'phone_already';
            exit;
        }

        $query = "UPDATE `user_cred` SET `fname`=?,`lname`=?,`phonenum`=?,`city`=?,`country`=?,`pincode`=?,`dob`=? WHERE `id`=?";
        $values = [$frm_data['fname'],$frm_data['lname'],$frm_data['phonenum'],$frm_data['city'],$frm_data['country'],$frm_data['pincode'],$frm_data['dob'],$_SESSION['uId']];

        if(update($query,$values,'ssssssss')){
            $_SESSION['ufName']=$frm_data['fname'];
            echo 1;
        }
        else{
            echo 0;
        }
    }
?>