<?php

use Stripe\Terminal\Location;

session_start();

    require('config.php');
    require_once('./admin/inc/db_config.php');
    require_once('./admin/inc/essentials.php');
    // require_once('./inc/links.php');
    //filter and get room and user data

    if(isset($_POST['stripeToken'])){

    
    \Stripe\Stripe::setVerifySslCerts(false);

    $token = $_POST['stripeToken'];

    $charge= \Stripe\Charge::create(array(
        "amount"=> "500",
        "currency"=>"usd",
        "source"=> $token,
    ));



//     $token = $_POST['stripeToken'];
// $room_id = $_POST['room_id'];
// $user_id = $_POST['user_id'];
// $booking_date = date('Y-m-d H:i:s');
// $booking_amount = $_POST['booking_amount'];

// $charge = \Stripe\Charge::create(array(
//     "amount" => $booking_amount,
//     "currency" => "usd",
//     "source" => $token,
// ));

// // Insert booking details into the database

// $frm_data = filteration($_POST);

// $insert_booking_query = "INSERT INTO booking_det (room_id, user_id, booking_date, booking_amount) VALUES (?, ?, ?, ?)";
// $insert_booking_stmt = $mysqli->prepare($insert_booking_query);
// $insert_booking_stmt->bind_param('iisi', $room_id, $user_id, $booking_date, $booking_amount);
// $insert_booking_stmt->execute();

// // Redirect to the success page
// redirect('happy.php');



    // $frm_data = filteration($_POST);
    // $query1 = "INSERT INTO `booking_order`(`room_id`, `check_in`, `check_out`, `order_id`) VALUES (?,?,?,?,?)";
    // insert($query1,[$CUST_ID,$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],$ORDER_ID],'issss');

    // $booking_id = mysqli_insert_id($con);

    // $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`,`user_name`, `phonenum`, `city`) VALUES (?,?,?,?,?,?,?)";

    // insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$TXN_AMOUNT],$frm_data['fname'],$frm_data['phonenum'],$frm_data['city'],'issssss');

    // echo"<pre>";
    // print_r($charge);
    $fname = $_POST['fname'];
    $phonenum = $_POST['phonenum'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $price = $_GET['price'];
    $amount = $_SESSION['room']['payment'];
    // var_dump($amount);
    $roomname = $_GET['room'];
    $city = $_POST['city'];
    $roomno = 01;
    $uid = $_SESSION['uId'];
    $roomid = $_SESSION['room']['id'];

    $query0 = "INSERT INTO `booking_order`(`user_id`, `room_id`,`check_in`,`check_out`) VALUES (?,?,?,?)";
    insert($query0,[$uid,$roomid,$check_in,$check_out],'isss');
    $update0 = "UPDATE `booking_order` SET `booking_status`='booked' WHERE `user_id`=$uid AND `room_id`=$roomid";
 

    // insert($query0,$_SESSION['uId'],$_SESSION['room']['id'],'ss');
   
    // $query0 = "insert into booking_order (user_id,room_id) values($uid, $roomid)";
    $booking_id = mysqli_insert_id($con);


    $query = "insert into booking_details (booking_id, room_name, check_in, check_out, price, total_pay, room_no, user_name, phonenum, city) values($booking_id,'$roomname', '$check_in', '$check_out', $price, $amount, $roomno, '$fname', '$phonenum', '$city')";

    $update = "UPDATE `rooms` SET `status`=0 WHERE `name`='$roomname'";

    echo $query;

    // $result = mysqli_query($con, $query0);
    $result = mysqli_query($con, $update0);

    $result = mysqli_query($con, $query);
    $result = mysqli_query($con, $update);

    if($result){
        print('Inserted');
    }

    echo "<script> alert('Booking Successfull')</script>";
    redirect("index.php");

}

    // echo '<pre>';
    // print_r($_POST);
?>