<?php

require('../admin/inc/essentials.php');
require('../admin/inc/db_config.php');
require('../inc/sendgrid/sendgrid-php.php');
date_default_timezone_set("Asia/Kathmandu");


function send_mail($uemail, $token, $type)
{
    if ($type == "email_confirmation") {
        $page = 'email_confirm.php';
        $subject = 'Account Verification Link';
        $content = "Confirm your email";
    } else {
        $page = 'index.php';
        $subject = 'Account Reset Link';
        $content = "Reset your account";
    }

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom(SENDGRID_EMAIL, SENDGRID_NAME);      //SET in essentials.php
    $email->setSubject($subject);

    $email->addTo($uemail);

    $email->addContent(
        "text/html",
        "
            Click the link to $content: <br>
            <a href='" . SITE_URL . "$page?$type&email=$uemail&token=$token" . "'>
                Click here
            </a>
            "
    );
    $sendgrid = new \SendGrid(SENDGRID_API_KEY);
    try {
        $sendgrid->send($email);
        echo ("hello");
        return 1;
    } catch (Exception $e) {
        echo ("bye");

        return 0;
    }
}


//register user
if (isset($_POST['register'])) {
    $data = filteration($_POST);

    //match password and confirm password field

    if ($data['password'] != $data['cpassword']) {
        echo 'pass_mismatch';
        exit;
    }


    //check user exist or not
    $u_exist = select(
        "SELECT * FROM `user_cred` WHERE `email` = ? AND `phonenum` = ? LIMIT 1",
        [$data['email'], $data['phonenum']],
        "ss"
    );

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    //upload user image to server
    $img = uploadUserImage($_FILES['profile']);

    if($img == 'inv_img'){
        echo 'inv_img';
        exit;
    }
    else if($img == 'upd_failed'){
        echo('upd_failed');
        exit;
    }

    //send email confirmation link to user's email

    $token = bin2hex(random_bytes(16));                      //generating token

    if (!send_mail($data['email'], $token, "email_confirmation")) {
        echo 'mail_failed';
        exit;
    }
    $enc_pass = password_hash($data['password'], PASSWORD_BCRYPT);        //password encryption

    $query = "INSERT INTO `user_cred` (`fname`, `lname`, `gender`, `email`, `profile`, `phonenum`, 
    `city`, `country`, `pincode`, `dob`, `password`, `token`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";


    $values = [$data['fname'], $data['lname'], $data['gender'], $data['email'], $img, $data['phonenum'], 
        $data['city'],$data['country'],$data['pincode'], $data['dob'],$enc_pass, $token];

    if (insert($query, $values, 'ssssssssssss')) {
        echo 1;
    } else {
        echo 'ins_failed';
    }
}



//login user
if (isset($_POST['login'])) {
    $data = filteration($_POST);                        
    $u_exist = select(
        "SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1",
        [$data['email_mob'], $data['email_mob']],
        "ss"
    );
    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email_mob';
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo 'not_verified';
        } else if ($u_fetch['status'] == 0) {
            echo 'inactive';
        } else {
            if (!password_verify($data['password'], $u_fetch['password'])) {
                echo 'invalid_pass';
            }
            else {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['ufName'] = $u_fetch['fname'];
                $_SESSION['uPic'] = $u_fetch['profile'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];
                echo 1;
            }
        }
    }

    echo($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
    exit;
}


// forgot pass
if (isset($_POST['forgot_pass'])) {
    $data = filteration($_POST);

    $u_exist = select("SELECT * FROM `user_cred` WHERE `email`=? LIMIT 1", [$data['email']], "s");

    if (mysqli_num_rows($u_exist) == 0) {
        echo 'inv_email';
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo 'not_verified';
        } else if ($u_fetch['status'] == 0) {
            echo 'inactive';
        } else {
            //send reset link to email
            $token = bin2hex(random_bytes(16));
            if (send_mail($data['email'], $token, 'account_recovery')) {
                echo 'mail_failed';
            } else {
                $date = date("Y-m-d");
                $query = mysqli_query($con, "UPDATE `user_cred` SET `token`='$token',`t_expire`='$date'
                     WHERE `id` = '$u_fetch[id]'");

                if ($query) {
                    echo 1;
                } else {
                    echo 'upd_failed';
                }
            }
        }
    }
    // echo($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
    // exit;
}
