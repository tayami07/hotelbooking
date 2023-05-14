<?php
require('inc/essentials.php');
require('inc/db_config.php');

adminLogin();

if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as read');
        } else {
            alert('error', 'Operation failed');
        }
    } else {
        $q = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read');
        } else {
            alert('error', 'Operation failed');
        }
    }
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['del'] == 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $q)) {
            alert('success', 'Data deleted');
        } else {
            alert('error', 'Operation failed');
        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data deleted');
        } else {
            alert('error', 'Operation failed');
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - New Bookings</title>

    <?php require('inc/links.php'); ?>
    <!-- <link rel="stylesheet" type="text/css" href="css/common.css"> -->
</head>

<body class="bg-light">


    <div class="row">
        <div class="col-12">
            <!-- Heading -->
            <div class="w-100">
                <div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">

                    <h3 class="mb-0 h-font">THYZEN - ADMIN</h3>
                    <a href="logout.php" class="btn btn-light btn-sm">Log Out</a>
                </div>
            </div>

        </div>
        <div class="col-3">
            <?php require('inc/adminheader.php') ?>
        </div>
        <div class="container-fluid col-9 mt-3" id="main-content">
            <div class="row">
                <div class="p-4 overflow-hidden">

                    <div class="container-fluid" id="main-content">
                        <div class="row">
                            <div class="ms-auto -4 overflow-hidden">
                                <h3 class="mb-4">New Bookings</h3>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="text-end mb-4">
                                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search">
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover border">
                                                <thead>
                                                    <tr class="bg-dark text-light">
                                                        <th scope="col">#</th>
                                                        <th scope="col">User Details</th>
                                                        <th scope="col">Room Details</th>
                                                        <th scope="col">Booking Details</th>
                                                        <th scope="col">Action</th>

                                                    </tr>
                                                </thead>

                                                <tbody id="table-data">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- assign room number bookings modal-->

    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Room</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Room Number</label>
                            <input type="text" name="room_no" class="form-control shadow-none" required>
                        </div>
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                            Note: Assign room number only when user has arrived!
                        </span>
                        <input type="hidden" name="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary text-white shadow-none">Assign</button>
                    </div>
                </div>
            </form>

        </div>
    </div>



    <?php require('inc/scripts.php'); ?>

    <script src="scripts/new_bookings.js"></script>


</body>

</html>