<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

// if (isset($_GET['seen'])) {
//     $frm_data = filteration($_GET);

//     if ($frm_data['seen'] == 'all') {
//         $q = "UPDATE `user_queries` SET `seen`=?";
//         $values = [1];
//         if (update($q, $values, 'i')) {
//             alert('success', 'Marked all as read');
//         } else {
//             alert('error', 'Operation failed');
//         }
//     } else {
//         $q = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
//         $values = [1, $frm_data['seen']];
//         if (update($q, $values, 'ii')) {
//             alert('success', 'Marked as read');
//         } else {
//             alert('error', 'Operation failed');
//         }
//     }
// }

// if (isset($_GET['del'])) {
//     $frm_data = filteration($_GET);

//     if ($frm_data['del'] == 'all') {
//         $q = "DELETE FROM `user_queries`";
//         if (mysqli_query($con, $q)) {
//             alert('success', 'Data deleted');
//         } else {
//             alert('error', 'Operation failed');
//         }
//     } else {
//         $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
//         $values = [$frm_data['del']];
//         if (delete($q, $values, 'i')) {
//             alert('success', 'Data deleted');
//         } else {
//             alert('error', 'Operation failed');
//         }
//     }
// }

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Features and Facilities</title>

    <?php require('inc/links.php'); ?>
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
                <div class="col-lg-10  p-4overflow-hidden">
                    <div class="container-fluid" id="main-content">
                        <div class="row">
                            <div class="col-lg-10 ms-auto -4 overflow-hidden">
                                <h3 class="mb-4">FEATURES AND FACILITIES</h3>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h5 class="card-title m-0">Features</h5>
                                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s">
                                                <i class="bi bi-pencil-square"></i>Edit
                                            </button>
                                        </div>

                                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                                            <table class="table table-hover border">
                                                <thead>
                                                    <tr class="bg-dark text-light">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="features-data">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- facilities -->
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h5 class="card-title m-0">Facilities</h5>
                                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                        </div>

                                        <div class="table-responsive-md" style="height: 350px; overflow-y: scroll;">
                                            <table class="table table-hover border">
                                                <thead>
                                                    <tr class="bg-dark text-light">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Icon</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col" width="40%">Description</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="facilities-data">

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




    <!-- features modal-->

    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="feature_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Feature</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="feature_name" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- facilities modal-->

    <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="facility_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Facility</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="facility_name" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon</label>
                            <input type="file" name="facility_icon" accept=".svg" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <?php require('inc/scripts.php'); ?>

    <script>
        let feature_s_form = document.getElementById('feature_s_form');
        let facility_s_form = document.getElementById('facility_s_form');


        feature_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_feature();
        });

        function add_feature() {
            let data = new FormData();
            data.append('name', feature_s_form.elements['feature_name'].value);
            data.append('add_feature', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('feature-s');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 1) {
                    alert('success', 'New feature added!');
                    feature_s_form.elements['feature_name'].value = '';
                    get_features();
                } else {
                    alert('error', 'Server down!');
                }

            }
            xhr.send(data);
        }

        function get_features() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('features-data').innerHTML = this.responseText;
            }
            xhr.send('get_features');
        }
        // window.onload = function(){
        // }

        function rem_feature(val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.responseText == 1) {
                    alert('success', 'Feature removed!');
                    get_features();
                } else if (this.responseText == 'room_added') {
                    alert('error', 'Feature is added in room!');
                } else {
                    alert('Server down');
                }
            }
            xhr.send('rem_feature=' + val);
        }



        // Facilites CRUD

        facility_s_form.addEventListener('submit', function(e) {
            e.preventDefault();
            add_facility();
        });

        function add_facility() {
            let data = new FormData();
            data.append('name', facility_s_form.elements['facility_name'].value);
            data.append('icon', facility_s_form.elements['facility_icon'].files[0]);
            data.append('desc', facility_s_form.elements['facility_desc'].value);
            data.append('add_facility', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);

            xhr.onload = function() {
                var myModal = document.getElementById('facility-s');
                var modal = bootstrap.Modal.getInstance(myModal);
                modal.hide();

                if (this.responseText == 'inv_img') {
                    alert('error', 'Only SVG images are allowed!');
                } else if (this.responseText == 'inv_size') {
                    alert('error', 'Image should be less than 1MB!');
                } else if (this.responseText == 'upd_failed') {
                    alert('error', 'Image upload failed. Server Down!');
                } else {
                    alert('success', 'New facility added!');
                    facility_s_form.reset();
                    get_facilities();
                }
            }

            xhr.send(data);
        }

        function get_facilities() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                document.getElementById('facilities-data').innerHTML = this.responseText;
            }
            xhr.send('get_facilities');
        }

        function rem_facility(val) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/features_facilities.php", true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (this.responseText == 1) {
                    alert('success', 'Facility removed!');
                    get_facilities();
                } else if (this.responseText == 'room_added') {
                    alert('error', 'Facility is added in room!');
                } else {
                    alert('Server down');
                }
            }
            xhr.send('rem_facility=' + val);
        }

        window.onload = function() {
            get_features();
            get_facilities();
        }
    </script>


</body>

</html>