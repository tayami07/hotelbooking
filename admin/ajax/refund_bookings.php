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
        AND (bo.booking_status = ? AND bo.refund = ?) 
        ORDER BY bo.booking_id DESC";
        // print_r($query);

        // $res = mysqli_query($con,$query);
        // var_dump($res);
        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","cancelled",0],'sssss');
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
                        Check-in: $checkin
                        <br>
                        Check-out: $checkout
                        <br>
                        Paid: $$data[total_pay]
                        <br>
                        Date: $date
                    </td>
                    <td>
                        <b>Refund Amount: $$data[total_pay]</b>
                    </td>
                    <td>
                    <button type='button' onclick='refund_booking($data[booking_id])' class='btn btn-sm fw-bold btn-success shadow-none'>
                        <i class='bi bi-cash-stack'></i> Refund
                    </button>
                    </td>
                </tr>
            ";
            // print_r($table_data);

            $i++;
        }

        echo $table_data;
    }

    if(isset($_POST['refund_booking']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` SET `refund`=? WHERE `booking_id`=?";
        $values = [1,$frm_data['booking_id']]; 
        $res = update($query,$values,'ii'); 

        echo $res;
    }
    

    







?>