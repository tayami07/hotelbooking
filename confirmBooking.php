<!-- <?php
    require('config.php');

    echo '<pre>';
    print_r($_POST);
?>

 -->


<!-- 
<?php

require('admin/inc/db_config.php');
require('admin/inc/essentials.php');



$args = http_build_query(array(
  'token' => 'QUao9cqFzxPgvWJNi9aKac',
  'amount'  => 1000
));

$url = "https://khalti.com/api/v2/payment/verify/";

# Make the call using API.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$headers = ['Authorization: Key test_secret_key_f59e8b7d18b4499ca40f68195a846e9b'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Response
$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);



$frm_data = filteration($_POST);
var_dump($_POST);
$query1 = "INSERT INTO `booking_order`(`room_id`, `check_in`, `check_out`, `order_id`) VALUES (?,?,?,?,?)";

insert($query1,[$CUST_ID,$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],$ORDER_ID],'issss');

$booking_id = mysqli_insert_id($con);

$query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`,`user_name`, `phonenum`, `city`) VALUES (?,?,?,?,?,?,?)";

insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$TXN_AMOUNT],$frm_data['fname'],$frm_data['phonenum'],$frm_data['city'],'issssss');

?> -->


 <!-- <?php

// Get the amount and token from the POST data
$amount = $_POST['amount'];
$token = $_POST['token'];

// Connect to the MySQL database
require('inc/db_config.php'); 
require('inc/essentials.php');

//$conn = new mysqli($servername, $username, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert the booking details into the database
$sql = "INSERT INTO bookings (amount, token) VALUES ('$amount', '$token')";

if ($conn->query($sql) === TRUE) {
    // Display a confirmation message
    echo "Your booking has been confirmed!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?> -->
