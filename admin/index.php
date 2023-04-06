<?php 
    require('inc/db_config.php'); 
    require('inc/essentials.php');
    // require('inc/adminheader.php');
    require('inc/links.php');

    session_start();
    if((isset($_SESSION['adminLogin'])&& $_SESSION['adminLogin']==true)){
        redirect('dashboard.php');
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <style>
        div.login-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
        }
    </style>

</head>

<body>
    <div class="login-form">
        <h1>Admin panel</h1>
        <form method="POST">
            <div class="mb-4">
                <label class="form-label">User name</label>
                <input required name="admin_name" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input required name="admin_pass" type="password" class="form-control" required>
                <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
            </div>
            <button name="login" type="submit">Login</button>
        </form>
    </div>


    <?php
    if (isset($_POST['login'])) {
        $frm_data = filteration($_POST);
        $query = "SELECT * FROM `admin_cred` WHERE `admin_name` =? AND `admin_pass`=?";
        $values = [$frm_data['admin_name'], $frm_data['admin_pass']];
        
        $res = select($query, $values, "ss");
        //print_r($res);
        if ($res->num_rows == 1) {
            // echo "Got user";
            $row = mysqli_fetch_assoc($res);      //fectching data
            //session_start();
            $_SESSION['adminLogin']=true;
            $_SESSION['adminId']=$row['admin_id'];
            //redirect
            redirect('dashboard.php');

        } else {
            alert('error', 'Login failed - Invalid credntials!');
        }
    }
    ?>


    <!-- <?php require('scripts.php'); ?> -->

</body>

</html>