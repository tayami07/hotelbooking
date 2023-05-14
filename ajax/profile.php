<?php

require('../admin/inc/essentials.php');
require('../admin/inc/db_config.php');
// require('./ajax/jwt.php');s

// require('../inc/sendgrid/sendgrid-php.php');
date_default_timezone_set("Asia/Kathmandu");

const KEY = 'thisissecretkey';

if (isset($_POST['info_form'])) {

    $frm_data = filteration($_POST);

    session_start();

    $u_exist = select(
        "SELECT * FROM `user_cred` WHERE `phonenum`=? AND `id`!=? LIMIT 1",
        [$data['phonenum'], $_SESSION['uId']],
        "ss"
    );

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo 'phone_already';
        exit;
    }

    $query = "UPDATE `user_cred` SET `fname`=?,`lname`=?,`phonenum`=?,`city`=?,`country`=?,`pincode`=?,`dob`=? WHERE `id`=? LIMIT 1";
    $values = [$frm_data['fname'], $frm_data['lname'], $frm_data['phonenum'], $frm_data['city'], $frm_data['country'], $frm_data['pincode'], $frm_data['dob'], $_SESSION['uId']];

    if (update($query, $values, 'ssssssss')) {
        $_SESSION['ufName'] = $frm_data['fname'];
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['profile_form'])) {
    session_start();
    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($img == 'upd_failed') {
        echo ('upd_failed');
        exit;
    }



    //fetching old image and deleting it

    $u_exist = select("SELECT `profile` FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "s");
    $u_fetch = mysqli_fetch_assoc($u_exist);

    deleteImage($u_fetch['profile'], USERS_FOLDER);

    $query = "UPDATE `user_cred` SET `profile`=? WHERE `id`=?";
    $values = [$img, $_SESSION['uId']];

    if (update($query, $values, 'ss')) {
        $_SESSION['uPic'] = $img;
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['identity_form'])) {
    session_start();
    $img2 = uploadUserIdentification($_FILES['pincodeimg']);

    if ($img2 == 'inv_img') {
        echo 'inv_img';
        exit;
    } else if ($img2 == 'upd_failed') {
        echo ('upd_failed');
        exit;
    }

    //fetching old image and deleting it
    $u_exist = select("SELECT `pincodeimg` FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "s");
    $u_fetch = mysqli_fetch_assoc($u_exist);

    deleteImage($u_fetch['pincodeimg'], USERS_FOLDER);

    $query = "UPDATE `user_cred` SET `pincodeimg`=? WHERE `id`=?";
    $values = [$img2, $_SESSION['uId']];

    if (update($query, $values, 'ss')) {
        $_SESSION['uIdentity'] = $img2;
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['pass_form'])) {

    $frm_data = filteration($_POST);
    session_start();

    if ($frm_data['new_pass'] != $frm_data['confirm_pass']) {
        echo 'mismatch';
        exit;
    }
    $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);        //password encryption

    $query = "UPDATE `user_cred` SET `password`=? WHERE `id`=? LIMIT 1";

    $values = [$enc_pass, $_SESSION['uId']];

    if (update($query, $values, 'ss')) {
        echo 1;
    } else {
        echo 0;
    }
    session_destroy();
    redirect('índex.php');
}
