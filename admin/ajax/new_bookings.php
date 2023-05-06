<?php

    require('../inc/essentials.php');
    require('../inc/db_config.php');
    
    adminLogin();

    if(isset($_POST['get_bookings']))
    {

        $frm_data = filteration($_POST);

        $query = "SELECT bo.*, bd.* 
        FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
        WHERE (bo.booking_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
        AND (bo.booking_status = ? AND bo.arrival = ?) 
        ORDER BY bo.booking_id DESC";
        // print_r($query);

        // $res = mysqli_query($con,$query);
        // var_dump($res);
        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","booked",0],'sssss');
        $i=1;
        $table_data = "";

        if(mysqli_num_rows($res)==0){
            echo "<b>No data found!</b>";
            exit;
        }

        while($data = mysqli_fetch_assoc($res))
        {
            $date = date("d-m-Y", strtotime($data['datentime']));
            $checkin = date("d-m-Y",strtotime($data['check_in']));
            $checkout = date("d-m-Y",strtotime($data['check_out']));

            $table_data .="
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge bg-primary'>
                        Booking Id: $data[booking_id]
                        </span>
                        <br>
                        <b>Name:</b> $data[user_name]
                        <br>
                        Phone No: $data[phonenum]
                        <br>
                    </td>
                    <td>
                        Room: $data[room_name]
                        <br>
                        Price: $data[price]
                    </td>
                    <td>
                        Check-in: $checkin
                        <br>
                        Check-out: $checkout
                        <br>
                        Paid: $data[total_pay]
                        <br>
                        Date: $date
                    </td>
                    <td>
                    <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold btn-primary shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                        <i class='bi bi-check2-square'></i> Assign Room
                    </button>
                    <br>
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='btn mt-2 btn-sm fw-bold btn-outline-danger shadow-none'>
                        <i class='bi bi-trash'></i> Cancel Booking
                    </button>
                    </td>
                </tr>
            ";
            // print_r($table_data);

            $i++;
        }

        echo $table_data;
    }

    if(isset($_POST['assign_room']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
        ON bo.booking_id = bd.booking_id
        SET bo.arrival =?, bo.rate_review=?, bd.room_no=?
        WHERE bo.booking_id = ?
        ";

        $values = [1,0,$frm_data['room_no'],$frm_data['booking_id']];

        $res = update($query,$values,'iisi'); //it will update 2 rows hence it will return 2
        echo($res=2)?1:0;
    }

    if(isset($_POST['cancel_booking']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` SET `booking_status` =?, `refund`=?
        WHERE `booking_id`=?
        ";
        $values = ['cancelled',0,$frm_data['booking_id']]; 
        $res = update($query,$values,'sii'); 

        echo $res;
    }
    

    















    if(isset($_POST['remove_user']))
    {
        $frm_data = filteration($_POST);

        $res = delete("DELETE FROM `user_cred` WHERE `id`=? AND `is_verified`=?",[$frm_data['user_id'],0],'ii');

        if($res){
            echo 1;
        }
        else{
            echo 0;
        }
    }

    if(isset($_POST['search_user']))
    {
        $frm_data = filteration($_POST);
        // print_r($frm_data);

        $query = "SELECT * FROM `user_cred` WHERE `fname` LIKE ?";
        // echo $query;

        $res = select($query,["%$frm_data[fname]%"],'s');

        $i = 1;
        $path = USERS_IMG_PATH;

        $data = "";
        while($row = mysqli_fetch_assoc($res))
        {
            $del_btn = "
                <button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
                    <i class='bi bi-trash'></i>
                </button>";
            $verified = "<span class='badge text-bg-warning'><i class='bi bi-x-lg'></i></span>";

            if($row['is_verified']){
                $verified = "<span class='badge text-bg-success'><i class='bi bi-check-lg'></i></span>";
                $del_btn="";
            }

            $status="
            <button onclick='toggle_status($row[id],0)' class='btn btn-success btn-sm shadow-none'>
                active
            </button>";
            if(!$row['status']){
                $status="<button onclick='toggle_status($row[id],1)' class='btn btn-warning btn-sm shadow-none'>
                    inactive
                </button>";
            }

            $date = date("d-m-Y : H:m:s",strtotime($row['datentime']));
            $data.="
                <tr>
                    <td>$i</td>
                    <td>
                        <img src='$path$row[profile]' width='55px'>
                        $row[fname]
                    </td>
                    <td>$row[lname]</td>
                    <td>$row[gender]</td>

                    <td>$row[email]</td>
                    <td>$row[phonenum]</td>
                    <td>$row[city]</td>
                    <td>$row[country]</td>
                    <td>$row[pincode]</td>
                    <td>$row[dob]</td>

                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

?>