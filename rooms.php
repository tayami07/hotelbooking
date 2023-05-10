<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/buttons.css" />
    <title>Thyzen - Hotels</title>

    <!-- Links -->
    <?php require('inc/links.php');

    ?>



</head>

<body>

    <!-- Header -->
    <?php 
    require('inc/header.php');

    $checkin_default = "";
    $checkout_default = "";
    $adult_default = "";
    $children_default = "";


    if(isset($_GET['check_availability']))
    {
        $frm_data = filteration($_GET);
        $checkin_default = $frm_data['checkin'];
        $checkout_default = $frm_data['checkout'];
        $adult_default = $frm_data['adult'];
        $children_default = $frm_data['children'];
    }
    ?>

    <!-- Main Heading -->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Our Rooms</h2>

        <div class="h-line bg-dark"></div>
    </div>

    <!-- Filter -->
    <div class="container-fluid custom-bg">

        <div class="row">

            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 ps-4 mt-3">

                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    
                    <div class="container-fluid dlex-lg-column align-items-stretch">

                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#filterDropdown" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse flex-column align-items-stretch mt-2" id="filterDropdown">
                            <h4 class="bg-white  text-center p-1">Filters</h4>

                            <!-- Check availability filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>Check Availability</span>
                                    <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                

                                <label class="form-label">Check-in</label>
                                <input type="date" class="form-control shadow-none mb-3" value="<?php echo $checkin_default?>" id="checkin" name="checkin" onchange="chk_avail_filter()">

                                <label class="form-label">Check-out</label>
                                <input type="date" class="form-control shadow-none" value="<?php echo $checkout_default?>" id="checkout" name="checkout" onchange="chk_avail_filter()">
                            </div>
                            <!-- Services checkbox -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>Amenities</span>
                                    <button id="facilities_btn" onclick="facilities_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>
                                <?php 
                                    $facilites_q = selectAll('facilities');
                                    while($row = mysqli_fetch_assoc($facilites_q))
                                    {
                                        echo<<<facilities
                                        <div class="mb-2">
                                            <input type="checkbox" name="facilities" value="$row[id]" onclick="fetch_rooms()" id="$row[id]" class="form-check-iput shadow-none me-1">
                                            <label for="$row[id]" class="form-check-label">$row[name]</label>
                                        </div>
                                        facilities;
                                    }
                                ?>
                            </div>
                            <!-- Number of people Filter -->
                            <div class="border bg-light p-3 rounded mb-3">
                                <h5 class="d-flex align-items-center justify-content-between mb-3" style="font-size: 18px;">
                                    <span>Guests</span>
                                    <button id="guests_btn" onclick="guests_clear()" class="btn shadow-none btn-sm text-secondary d-none">Reset</button>
                                </h5>                                
                                <div class="d-flex">
                                    <div class="me-3 me-md-4">
                                        <label class="form-label">Adults</label>
                                        <input type="number" min="1" value="<?php echo $adult_default?>" id="adults" oninput="guests_filter()" class="form-control shadow-none">
                                    </div>
                                    <div>
                                        <label class="form-label">Children</label>
                                        <input type="number" min="0" value="<?php echo $children_default?>" id="children" oninput="guests_filter()" class="form-control shadow-none">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- room cards -->
            <div class="col-lg-9 col-md-12 px-4 mt-3" id="rooms-data">
                
            </div>

        </div>
    </div>

    <script>
        
        let rooms_data = document.getElementById('rooms-data');

        let checkin = document.getElementById('checkin');
        let checkout = document.getElementById('checkout');
        let chk_avail_btn = document.getElementById('chk_avail_btn');
        
        let adults = document.getElementById('adults');
        let children = document.getElementById('children');
        let guests_btn = document.getElementById('guests_btn');
        
        let facilities_btn = document.getElementById('facilities_btn');

        // xhr.open("GET", "ajax/rooms.php?fetch_rooms")

        function fetch_rooms() {
            let chk_avail = JSON.stringify({
                checkin: checkin.value,
                checkout: checkout.value
            });
            let guests = JSON.stringify({
                adults: adults.value,
                children: children.value
            })

            let facility_list = {"facilities":[]};
            let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
            if(get_facilities.length>0)
            {
                get_facilities.forEach((facility)=>{
                    facility_list.facilities.push(facility.value);
                });
                facilities_btn.classList.remove('d-none');
            }
            else{
                facilities_btn.classList.add('d-none');
            }
            facility_list = JSON.stringify(facility_list);


            console.log(chk_avail);
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "ajax/rooms.php?fetch_rooms&chk_avail="+chk_avail+"&guests="+guests+"&facility_list="+facility_list,true);

            xhr.onprogress = function() {
                rooms_data.innerHTML=`<div class="spinner-border text-info mb-3 mt-4 d-block mx-auto" id="loader" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>`;
                
            }

            xhr.onload = function() {
                rooms_data.innerHTML = this.responseText;
            }
            xhr.send();
        }
        fetch_rooms();

        function chk_avail_filter(){
            if(checkin.value!='' && checkout.value!=''){
                fetch_rooms();
                chk_avail_btn.classList.remove('d-none'); //show the reset button once both checkin and checkout are filled
            }
        }

        // reset button
        function chk_avail_clear(){
            checkin.value='';
            checkout.value='';
            chk_avail_btn.classList.add('d-none');
            fetch_rooms();
        }

        // function guests_filter(){
        //     console.log(guests_btn);
        //     if(adults.value>0 || children.value==0){
        //         fetch_rooms();
        //         guests_btn.classList.remove('d-none');
        //     }
        // }
        function guests_filter(){
            console.log(guests_btn);
            if (adults.value >= 1) {
                // If there is at least 1 adult, enable the children input field and fetch the rooms
                children.disabled = false;
                fetch_rooms();
                guests_btn.classList.remove('d-none');
            }
            else {
                // If there are 0 adults, disable the children input field and fetch the rooms
                children.disabled = true;
                children.value = 0;
                fetch_rooms();
                guests_btn.classList.remove('d-none');
            }
        }
        // function guests_clear()
        // {
        //     adults.value='';
        //     children.value='';
        //     guests_btn.classList.add('d-none');
        //     fetch_rooms();
        // }

        function guests_clear() {
            adults.value = '';
            children.value = '';
            guests_btn.classList.add('d-none');
            fetch_rooms();
            children.disabled = false;
        }

        function facilities_clear(){
            let get_facilities = document.querySelectorAll('[name="facilities"]:checked');
            get_facilities.forEach((facility)=>{
                    facility.checked=false;
                });
            facilities_btn.classList.add('d-none');
            fetch_rooms();
        }

        // fetch_rooms()
    </script>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>

</body>

</html>