<?php
    require_once('admin/inc/db_config.php');
    require_once('admin/inc/essentials.php');
    require_once('links.php');


    $contact_q = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
    $values = [1];
    $contact_r = mysqli_fetch_assoc(select($contact_q, $values, 'i'));
    // print_r($contact_r);
    // session_start();
?>
<!-- CSS -->
<link rel="stylesheet" href="../css/common.css">
</link>

<!-- Navbar -->
<nav id="nav-bar" class="navbar navbar-expand-lg bg-body-tertiary bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php">Thyzen</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center w-75 ">
                <li class="nav-item ">
                    <a class="nav-link me-2" href="index.php">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link me-2" href="rooms.php">Rooms</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link me-2" href="facilities.php">Facilities</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link me-2" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="about.php">About</a>
                </li>


            </ul>
            <!-- <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-primary " type="submit">Search</button>
            </form> -->
            <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
    </div>

    <!-- Session array -->
    
    <?php
    if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
        $path = USERS_IMG_PATH;

        echo <<<data
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <img src="$path$_SESSION[uPic]" style="width 25px; height: 25px;" class="me-1">
                            $_SESSION[ufName]
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="bookings.php">Bookings</a></li>
                            <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                        </ul>
                    </div>
                data;
    }
    else {
        echo <<<data
                <div class="d-flex w-25 justify-content-end">
                    <button type="button" class="btn btn-primary shadow-none me-lg-2 me-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Log In
                    </button>
            
                    <button type="button" class="btn btn-primary custom-btn shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                        Register
                    </button>
                </div>
                data;

    }
    ?>
    


</nav>

<!-- User Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="login-form">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center" id="exampleModalLabel">
                        <i class="bi bi-person-lines-fill"></i>User Login
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email/Mobile</label>
                        <input name="email_mob" type="text" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary shadow-none">LOG IN</button>
                        <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
                    </div>

                </div>

            </form>


        </div>
    </div>
</div>


<!-- Client Register -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="register-form">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center" id="exampleModalLabel">
                        <i class="bi bi-person-lines-fill"></i>User Registration
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                        Note: Upon check-in, your information must match what is on your ID(Citzenship, Passport, Driving License, etc.).
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">First Name</label>
                                <input name="fname" type="text" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Last Name</label>
                                <input name="lname" type="text" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <select class="form-select" name="gender" for="gender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6 ps-0">
                                <label class="form-label">Email address</label>
                                <input name="email" type="email" class="form-control" required>
                            </div>
                            <!-- //contacts -->
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Picture</label>
                                <input name="profile" type="file" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Phone Number</label>
                                <input name="phonenum" type="number" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">City</label>
                                <input name="city" type="text" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Country</label>
                                <input name="country" type="text" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Pincode</label>
                                <input name="pincode" type="number" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Date of Birth(DOB)</label>
                                <input name="dob" type="date" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" class="form-control" required>
                            </div>
                            <div class="mb-4 col-md-6 ps-0">
                                <label class="form-label">Confirm Password</label>
                                <input name="cpassword" type="password" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary shadow-none">Register</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>

<!-- Forgot Login password -->
<div class="modal fade" id="forgotModal" aria-hidden="true" aria-labelledby="forgotModalLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form id="forgot-form">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 d-flex align-items-center" id="exampleModalLabel">
                        <i class="bi bi-person-lines-fill"></i>Forgot Password
                    </h1>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                        Note: A link will be sent to your email to reset your password.
                    </span>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control shadow-none" required>
                    </div>
                    <div class="mb-2 text-end">
                        <button type="button" class="btn text-secondary text-decoration-none shadow-none" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary shadow-none p-0 me-2">Send Link</button>

                    </div>

                </div>

            </form>


        </div>
    </div>
</div>