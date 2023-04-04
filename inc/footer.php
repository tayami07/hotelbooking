<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    // require_once('admin/inc/db_config.php');

    $contactQ = "SELECT * FROM `contact_details` WHERE `sr_no` = ?";
    $values = [1];
    $contact_r = mysqli_fetch_assoc(select($contactQ, $values, 'i'));
    ?>
    <!-- Footer -->
    <div class="container-fluid bg-white mt-5 d-flex">
        <div class="col-lg-4">
            <h3 class="h-font fw-bold fs-3 mb-2">Thyzen</h3>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                Dolor repudiandae voluptatibus facilis sunt quo vel alias saepe?
                Id debitis nulla ipsum alias magnam, exercitationem est voluptatum, accusamus dignissimos quos quod!</p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Links</h5>
            <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Home</a><br>
            <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Help</a><br>
            <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">Services</a><br>
            <a href="#" class="d-inline-block mb-2 text-dark text-decoration-none">About Us</a><br>

        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">Follow us</h5>
            <?php
            if ($contact_r['tw'] != '') {
                echo <<<data
                <a href="$contact_r[tw]" class="d-inline-block mb-3">
                    <span class="badge bg-light text-dark fs-6 p-2">
                    <i class="bi bi-twitter me-1"></i> Twitter</span>
                </a>
                <br>
                data;
            }
            ?>
            <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block mb-3">
                <span class="badge bg-light text-dark fs-6 p-2">
                    <i class="bi bi-facebook me-1">Facebook</i>
                </span>
            </a>
            <br>
            <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block mb-3">
                <span class="badge bg-light text-dark fs-6 p-2">
                    <i class="bi bi-facebook me-1">Instagram</i>
                </span>
            </a>
            <br>
        </div>

    </div>
</body>

<script>
    //setActive
    function setActive() {
        let navbar = document.getElementById('nav-bar');
        let a_tags = navbar.getElementsByTagName('a');

        for (i = 0; i < a_tags.length; i++) {
            let file = a_tags[i].href.split('/').pop();     //file location
            let file_name = file.split('.')[0];

            if (document.location.href.indexOf(file_name) >= 0) {
                a_tags[i].classList.add('active');
            }
        }

    }

    function alert(type, msg, position = 'body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
            <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">${msg}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        if (position == 'body') {
            document.body.append(element);
            element.classList.add('custom-alert');
        } else {
            document.getElementById(position).appendChild(element);
        }
        setTimeout(remAlert, 3000);
    }

    function remAlert() {
        document.getElementsByClassName('alert')[0].remove();
    }







    //ajax registration form
    let register_form = document.getElementById('register-form');
    register_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData(); //FormData used for image upload
        data.append('fname', register_form.elements['fname'].value);
        data.append('lname', register_form.elements['lname'].value);
        data.append('gender', register_form.elements['gender'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('profile', register_form.elements['profile'].files[0]);
        data.append('phonenum', register_form.elements['phonenum'].value);
        data.append('city', register_form.elements['city'].value);
        data.append('country', register_form.elements['country'].value);
        data.append('pincode', register_form.elements['pincode'].value);
        data.append('dob', register_form.elements['dob'].value);
        data.append('password', register_form.elements['password'].value);
        data.append('cpassword', register_form.elements['cpassword'].value);
        data.append('register', '');


        // modal hide
        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function() {
            if (this.responseText == 'pass_mismatch') {
                alert('error', "Password Mismatched");
            } 
            else if (this.responseText == 'email_already') {
                alert('error', "Email is already registered");
            }
            else if (this.responseText == 'phone_already') {
                alert('error', "Phone number is already registered");
            }
            else if (this.responseText == 'inv_img') {
                alert('error', "Only JPG, PNG, and WEBP images are allowed.");
            }
            else if (this.responseText == 'upd_failed') {
                alert('error', "Failed to upload image.");
            }
            else if (this.responseText == 'mail_failed') {
                alert('error', "Cannot send confirmation email. Server down");
            }
            else if (this.responseText == 'ins_failed') {
                alert('error', "Registration failed");
            }
            else {
                alert('success', "Registration successful. Confirmation link sent to mail.");
                register_form.reset();
            }
        }

        xhr.send(data);

    });






    // login form

    let login_form = document.getElementById('login-form');
    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData(); //FormData used for image upload

        data.append('email_mob', login_form.elements['email_mob'].value);
        data.append('password', login_form.elements['password'].value);
        data.append('login', '');

        // modal hide
        var myModal = document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function() {
            if (this.responseText == 'inv_email_mob') {
                alert('error', "Invalid Email or Mobile Number");
            } else if (this.responseText == 'not_verified') {
                alert('error', 'Email not verified.');
            } else if (this.responseText == 'inactive') {
                alert('error', "Account Suspended");
            } else if (this.responseText == 'invalid_pass') {
                alert('error', "Incorrect Password.");
            } else {
                window.location = window.location.pathname;
        }

        }
        xhr.send(data);

    });


    // forgot password
    let forgot_form = document.getElementById('forgot-form');
    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData(); //FormData used for image upload

        data.append('email', forgot_form.elements['email'].value);
        data.append('forgot_pass', '');

        // modal hide
        var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function() {
            if (this.responseText == 'inv_email') {
                alert('error', "Invalid Email or Mobile Number");
            } else if (this.responseText == 'not_verified') {
                alert('error', 'Email not verified. Contact admin.');
            } else if (this.responseText == 'inactive') {
                alert('error', "Account Suspended");
            } else if (this.responseText == 'mail_failed') {
                alert('error', "Cannot send email.");
            } else if (this.responseText == 'upd_failed') {
                alert('error', "Password reset failed.");
            } else {
                alert('success', "Confirmation link sent to mail.");
                business_form.reset();
            }
        }
        xhr.send(data);

    });


    setActive();
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</html>