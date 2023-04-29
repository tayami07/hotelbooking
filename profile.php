<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $settings_r['site_title']?> - Profile</title>
    <link rel="stylesheet" href="css/buttons.css" />

    <!-- Links -->
    <?php require('inc/links.php');
    ?>

</head>

<body>
    <?php
        require('inc/header.php');

        if(!(isset($_SESSION['login'])&& $_SESSION['login']==true)){
            redirect('index.php');
        }

        $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'s');

        if(mysqli_num_rows($u_exist)==0){
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
                    <a href="index.php" class="text-secondary text-decoration-none">Profile</a>
                </div>
            </div>

            <div class="col-12 mb-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3 fw-bold">Basic Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" value="<?php echo $u_fetch['fname']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" value="<?php echo $u_fetch['lname']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phonenum" value="<?php echo $u_fetch['phonenum']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">City</label>
                                <input name="city" type="text" value="<?php echo $u_fetch['city']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Country</label>
                                <input name="country" type="text" value="<?php echo $u_fetch['country']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" type="number" value="<?php echo $u_fetch['pincode']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Date of Birth(DOB)</label>
                                <input name="dob" type="date" value="<?php echo $u_fetch['dob']?>" class="form-control shadow-none" required>
                            </div>
                            
                            <button type="submit" class="btn custom-btn text-white shadow-none">Save Changes</button>

                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4 mb-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3 fw-bold">Picture</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="fname" value="<?php echo $u_fetch['fname']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="lname" value="<?php echo $u_fetch['lname']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phonenum" value="<?php echo $u_fetch['phonenum']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">City</label>
                                <input name="city" type="text" value="<?php echo $u_fetch['city']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Country</label>
                                <input name="country" type="text" value="<?php echo $u_fetch['country']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" type="number" value="<?php echo $u_fetch['pincode']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Date of Birth(DOB)</label>
                                <input name="dob" type="date" value="<?php echo $u_fetch['dob']?>" class="form-control shadow-none" required>
                            </div>
                            
                            <button type="submit" class="btn custom-btn text-white shadow-none">Save Changes</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/footer.php');?>
    <script>
        let info_form = document.getElementById('info-form');

        info_form.addEventListener('submit', function(e){
            e.preventDefault();

            let data = new FormData();
            data.append('info_form','');
            data.append('fname', info_form.elements['fname'].value);
            data.append('lname', info_form.elements['lname'].value);
            data.append('phonenum', info_form.elements['phonenum'].value);
            data.append('city', info_form.elements['city'].value);
            data.append('country', info_form.elements['country'].value);
            data.append('pincode', info_form.elements['pincode'].value);
            data.append('dob', info_form.elements['dob'].value);


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php",true);

            xhr.onload = function(){
                if(this.responseText== 'phone_already'){
                    alert('error', "Phone number is already registered!");
                }
                else if(this.responseText == 0){
                    alert('error', "No changes made!");
                }
                else{
                    alert('success', "Changes saved!");
                }
            }
            xhr.send(data);
        })
    </script>
</body>

</html>