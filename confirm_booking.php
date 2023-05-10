<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/common.css" />
    <!-- Links -->
    <?php require('inc/links.php'); ?>
    <?php require('config.php'); ?>

    <title><?php echo $settings_r['site_title'] ?> - Confirm</title>





</head>

<body>

    <!-- Header -->
    <?php require('inc/header.php'); ?>

    <?php

    const KEY = 'thisissecretkey';

    //check id from url is present or not
    //check if shutdown mode is active or not
    //user is logged in or not

    if (!isset($_GET['id']) || $settings_r['shutdown'] == true) {
        redirect('rooms.php');
    } else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('rooms.php');
    }


    // Generate token
    $token = JWT::Sign(['id' => 'demoid'], KEY);


    // Vefity token
    $payload = JWT::Sign($token, KEY);

    $query = "UPDATE user_cred set token='.$payload.' WHERE id=". $_SESSION['uId'];
    
    $_SESSION['jwt'] = $payload;

    if(insertToken($query)){

        $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 's');

        if (mysqli_num_rows($u_exist) == 0) {
            redirect('index.php');
        }
        $u_fetch = mysqli_fetch_assoc($u_exist);
    }



    //filter and get room and user data

    $data = filteration($_GET);
    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }
    $room_data = mysqli_fetch_assoc($room_res);

    $_SESSION['room'] = [
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => false
    ];

    //user data fetch

    $user_res = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "i");
    $user_data = mysqli_fetch_assoc($user_res);

    ?>



    <!-- Filter -->
    <div class="container">
        <div class="row">
            <!-- Main Heading -->
            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">CONFIRM BOOKING</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRM</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4">
                <?php
                $room_thumb = ROOMS_IMG_PATH . "thumbnail.jpg";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                         WHERE `room_id`='$room_data[id]' 
                         AND `thumb`='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }

                echo <<<data
                        <div class="card p-3 shadow-sm rounded">
                            <img src="$room_thumb" class="img-fluid rounded-start mb-3">
                            <h5>$room_data[name]</h5>
                            <h5>$$room_data[price] per night</h5>


                        </div>
                    data;
                ?>
            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form id="booking_form" action="success.php?price=<?php echo $room_data['price'] ?>&room=<?php echo $room_data['name'] ?>" method="POST">
                            <h6 class="mb-3">Booking Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name</label>
                                    <input name="fname" id="fname" type="text" value="<?php echo $user_data['fname'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input name="lname" id="lname" type="text" value="<?php echo $user_data['lname'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input name="phonenum" id="phonenum" type="text" value="<?php echo $user_data['phonenum'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input name="city" id="city" type="text" value="<?php echo $user_data['city'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <input name="country" id="country" type="text" value="<?php echo $user_data['country'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Check-in</label>
                                    <input name="checkin" id="checkin" type="date" onchange="check_availability()" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Check-out</label>
                                    <input name="checkout" id="checkout" type="date" onchange="check_availability()" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <h6 class="mb-3 text-danger" id="pay_info">Please fill in the check-in and check-out date</h6>
                                    <!-- <button name="pay_now" id="payment-button" class="btn w-100 text-white custom-btn shadow-none mb-1">Pay Now</button> -->

                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" name="pay_now" id="pay_now" data-key="<?php echo $publishableKey ?>" data-amount="<?php echo $payment ?>" data-name="<?php echo $room_data['name'] ?>" data-id="<?php echo $room_data['id'] ?>" data-description="<?php echo $room_data['name'] ?>" data-currency="usd" data-locale="auto">
                                    </script>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <?php require('inc/footer.php'); ?>



    <script>
        // var config = {
        // // replace the publicKey with yours
        // publicKey: "test_public_key_6ed6739a38784535b64c748a6637783e",
        // productIdentity: "1234567890",
        // productName: "Dragon",
        // productUrl: "http://gameofthrones.wikia.com/wiki/Dragons",
        // paymentPreference: [
        // "KHALTI",
        // "EBANKING",
        // "MOBILE_BANKING",
        // "CONNECT_IPS",
        // "SCT",
        // ],
        // eventHandler: {
        // onSuccess(payload) {
        // console.log(payload);
        // GetPayLoad(payload);
        // },
        // onError(error) {
        // console.log(error);
        // },
        // onClose() {
        // console.log("widget is closing");
        // },
        // },
        // };

        // var checkout = new KhaltiCheckout(config);
        // var btn = document.getElementById("payment-button");
        // btn.onclick = function(e) {
        // e.preventDefault();
        // // minimum transaction amount must be 10, i.e 1000 in paisa.
        // checkout.show({
        // amount: 10000
        // });
        // };

        // function GetPayLoad(payload) {
        // console.log(payload);
        // console.log("Payment successful");
        // // alert('Payment Success')
        // var amt = "";
        // var tkn = "";
        // khaltidata = payload;
        // amt = khaltidata.amount;
        // tkn = khaltidata.token;
        // if(payload.status == 200){
        // console.log("hi");
        // // window.location.href = `confirmBooking.php?amount=${amt}&token=${tkn}`;
        // $.ajax({
        // type: "POST",
        // url: "confirmBooking.php", //call storeemdata.php to store form data
        // data: formdata,
        // cache: false,
        // success: function(html) {
        // alert(html);
        // }
        // });
        // }

        // // if ($success) {
        // // $response = array('success' => true, 'redirect' => 'success.php');
        // // } else {
        // // $response = array('success' => false, 'error' => 'Something went wrong!');
        // // }



        // }






        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        function check_availability() {
            let checkin_val = booking_form.elements['checkin'].value;

            let checkout_val = booking_form.elements['checkout'].value;
            // console.log(checkout_val)
            // booking_form.elements['pay_now'].setAttribute('disabled', true);

            // booking_form.elements['pay_now'].setAttribute('disabled', true);
            document.getElementById("pay_now").setAttribute("disabled", true);

            // booking_form.elements['pay_now'].removeAttribute('disabled');
            // booking_form.elements['pay_now'].setAttribute('disabled', true);
            // document.getElementById('stripe-button').disabled = true;

            // let stripeButton = document.getElementById('stripe-button');
            // stripeButton.disabled = true;

            // document.getElementsByClassName("stripe-button-el")[0].disabled=true;




            if (checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');

                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.php", true);

                xhr.onload = function() {

                    let data = JSON.parse(this.responseText);
                    if (data.status == 'check_in_out_equal') {
                        pay_info.innerText = "You cannot check-out on the same day!";
                    } else if (data.status == 'check_out_earlier') {
                        pay_info.innerText = "The Check-out date is earlier than the check-in date!";
                    } else if (data.status == 'check_in_earlier') {
                        pay_info.innerText = "The Check-in date is earlier than today's date!";
                    } else if (data.status == 'unavailable') {
                        pay_info.innerText = "Room not available for this check-in date!";
                    } else {
                        pay_info.innerHTML = "No. of days: " + data.days + "<br>Total amount to pay: $" + data.payment;
                        pay_info.classList.replace('text-danger', 'text-dark');
                        // booking_form.elements['pay_now'].removeAttribute('disabled');
                        document.getElementById("pay_now").removeAttribute("disabled", true);

                    }

                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }
                xhr.send(data);
            }
        }
    </script>











    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <!-- <script src="https://www.paypal.com/sdk/js?client-id=AQxS9T0dpJQRJ3Qvg79zXEbbapM3rQXfgV-sy5cWZ_t3tkDtsA8f_iMsZZKfU8Oed8whOJuTHr9418_b&currency=USD"></script>




    <script>
        // var fname = $('#fname').val();
        // var lname = $('#lname').val();
        // var phonenum = $('#phonenum').val();
        // var city = $('#city').val();
        // var country = $('#country').val();
        // var checkin = $('#checkin').val();
        // var checkout = $('#checkout').val();


        <
        script >
            paypal.Buttons({
                    // Order is created on the server and the order id is returned
                    createOrder() {
                        return fetch("/my-server/create-paypal-order", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                // use the "body" param to optionally pass additional order information
                                // like product skus and quantities
                                body: JSON.stringify({
                                    cart: [{
                                        sku: "YOUR_PRODUCT_STOCK_KEEPING_UNIT",
                                        quantity: "YOUR_PRODUCT_QUANTITY",
                                    }, ],
                                }),
                            })
                            .then((response) => response.json())
                            .then((order) => order.id);
                    },
                    // Finalize the transaction on the server after payer approval
                    onApprove(data) {
                        return fetch("/my-server/capture-paypal-order", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                },
                                body: JSON.stringify({
                                    orderID: data.orderID,
                                    purchase_units: [{
                                        amount: {
                                            value: <?php echo $room_data['price']; ?>
                                        }
                                    }]
                                })
                            })
                            .then((response) => response.json())
                            .then((orderData) => {
                                    // Successful capture! For dev/demo purposes:
                                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                    const transaction = orderData.purchase_units[0].payments.captures[0];
                                    alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                                    // When ready to go live,
    </script> -->




</body>

</html>