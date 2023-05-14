<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title><?php echo $settings_r['site_title'] ?> - Confirm Booking</title> -->

    <link rel="stylesheet" href="css/buttons.css" />

    <!-- Links -->
    <?php require('inc/links.php');
    // require('./admin/inc/db_config.php');
    ?>
    <title><?php echo $settings_r['site_title'] ?> - Profile</title>


</head>

<body>
    <?php
    require('inc/header.php');

    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {

        redirect('index.php');
    }

    $token = $_COOKIE['JWT_TOKEN'];

    // Vefity token
    $payload = JWT::Verify($token, KEY);

    if ($payload == false) {

        unset($_COOKIE['JWT_TOKEN']);  //coocies clear
        session_destroy();
        session_start();
        $_SESSION['invalid_token'] = "The Token Is Invalid. Please Login Again";
        redirect('index.php');
    }

    $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');

    if (mysqli_num_rows($u_exist) == 0) {
        redirect('index.php');
    }
    $u_fetch = mysqli_fetch_assoc($u_exist);


    ?>

    <div class="container">
        <div class="row">
            <div class="col-12 my-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">Home</a>
                    <span class="text-secondary"> > </span>
                    <a href="profile.php" class="text-secondary text-decoration-none">Profile</a>
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <h3 class="mb-3">Profile Information</h3>
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" value="<?php echo $u_fetch['fname'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" value="<?php echo $u_fetch['lname'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phonenum" value="<?php echo $u_fetch['phonenum'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">City</label>
                                <input name="city" type="text" value="<?php echo $u_fetch['city'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Country</label>
                                <input name="country" type="text" value="<?php echo $u_fetch['country'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" type="number" value="<?php echo $u_fetch['pincode'] ?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Date of Birth(DOB)</label>
                                <input name="dob" type="date" value="<?php echo $u_fetch['dob'] ?>" class="form-control shadow-none" required>
                            </div>

                            <button type="submit" class="btn custom-btn text-white shadow-none">Save Changes</button>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="profile-form">
                        <h5 class="mb-3 fw-bold">Profile photo</h5>
                        <img src="<?php echo USERS_IMG_PATH . $u_fetch['profile'] ?>" class="rounded-circle img-fluid mb-3">

                        <label class="form-label"> Upload new profile photo</label>
                        <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none mb-4" required>

                        <button type="submit" class="btn custom-btn text-white shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="identity-form">
                        <h5 class="mb-3 fw-bold">Identification Photo</h5>
                        <img src="<?php echo USERS_IMG_PATH . $u_fetch['pincodeimg'] ?>" class="rounded-circle img-fluid mb-3">

                        <label class="form-label">Change your identification photo</label>
                        <input name="pincodeimg" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none mb-4" required>

                        <button type="submit" class="btn custom-btn text-white shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb-3 fw-bold">Change Password</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_pass" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_pass" class="form-control shadow-none" required>
                            </div>
                        </div>

                        <button type="submit" id="change-password" class="btn custom-btn text-white shadow-none">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="jwt" value="<?php echo $u_fetch['fname'] ?>">

    <?php require('inc/footer.php'); ?>
    <script>
        let info_form = document.getElementById('info-form');

        info_form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // var changed = false;
                    // document.getElementById('form [name]').change(function() {
                    //     changed = true;
                    // });

                    // document.getElementById('form').submit(function(){
                    //         if (!changed) {
                    //             return false
                    //         }
                    //     });
                        

                        let data = new FormData(); data.append('info_form', ''); data.append('fname', info_form.elements['fname'].value); data.append('lname', info_form.elements['lname'].value); data.append('phonenum', info_form.elements['phonenum'].value); data.append('city', info_form.elements['city'].value); data.append('country', info_form.elements['country'].value); data.append('pincode', info_form.elements['pincode'].value); data.append('dob', info_form.elements['dob'].value);
                        // data.append('jwt', info_form.elements['jwttoken'].value);

                        let xhr = new XMLHttpRequest(); xhr.open("POST", "ajax/profile.php", true);

                        xhr.onload = function() {
                            if (this.responseText == 'phone_already') {
                                alert('error', "Phone number is already registered!");
                            } else if (this.responseText == 0) {
                                alert('error', "No changes made!");
                            } else {
                                alert('success', "Changes saved!");
                            }
                        }
                        xhr.send(data); 
                        location.reload();

                    });

                let profile_form = document.getElementById('profile-form'); profile_form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let data = new FormData();
                    data.append('profile_form', '');
                    data.append('profile', profile_form.elements['profile'].files[0]);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/profile.php", true);

                    xhr.onload = function() {
                        if (this.responseText == 'inv_img') {
                            alert('error', "Only JPG, PNG, and WEBP images are allowed.");
                        } else if (this.responseText == 'upd_failed') {
                            alert('error', "Failed to upload image!");
                        } else if (this.responseText == 0) {
                            alert('error', "Failed to update the image!");
                        } else {
                            window.location.href = window.location.pathname;
                        }
                    }
                    xhr.send(data);
                    console.log('uploaded');
                })

                let identity_form = document.getElementById('identity-form'); identity_form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let data = new FormData();
                    data.append('identity_form', '');
                    data.append('pincodeimg', identity_form.elements['pincodeimg'].files[0]);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/profile.php", true);

                    xhr.onload = function() {
                        if (this.responseText == 'inv_img') {
                            alert('error', "Only JPG, PNG, and WEBP images are allowed.");
                        } else if (this.responseText == 'upd_failed') {
                            alert('error', "Failed to upload image!");
                        } else if (this.responseText == 0) {
                            alert('error', "Failed to update the image!");
                        } else {
                            window.location.href = window.location.pathname;
                        }
                    }
                    xhr.send(data);
                    console.log('uploaded2');
                })


                let pass_form = document.getElementById('pass-form'); pass_form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    let new_pass = pass_form.elements['new_pass'].value;
                    let confirm_pass = pass_form.elements['confirm_pass'].value;

                    if (new_pass != confirm_pass) {
                        alert('error', 'The passwords do not match!');
                        return false;
                    }

                    let data = new FormData();
                    data.append('pass_form', '');
                    data.append('new_pass', new_pass);
                    data.append('confirm_pass', confirm_pass);

                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "ajax/profile.php", true);

                    xhr.onload = function() {
                        if (this.responseText == 'mismatch') {
                            alert('error', "The passwords do not match!");
                        } else if (this.responseText == 0) {
                            alert('error', "Failed to update the password!");
                        } else {
                            alert('success', "Changes saved!");
                            pass_form.reset();
                        }
                    }
                    xhr.send(data);

                    console.log('pass_updated');
                })
    </script>
</body>

</html>