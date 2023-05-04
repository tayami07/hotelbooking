<?php

    require('../inc/essentials.php');
    require('../inc/db_config.php');
    
    adminLogin();

    if(isset($_POST['get_bookings']))
    {

        $frm_data = filteration($_POST);

        $limit = 2;
        $page = $frm_data['page'];
        $start = ($page-1)*$limit;

        //page 1: 0,10, page 2: 2-1*10

        $query = "SELECT bo.*, bd.* 
        FROM `booking_order` bo
        INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
        WHERE ((bo.booking_status ='booked' AND bo.arrival = 1)
        OR (bo.booking_status = 'cancelled' AND bo.refund = 1))
        AND (bo.booking_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
        ORDER BY bo.booking_id DESC";
        // print_r($query);

        // $res = mysqli_query($con,$query);
        // var_dump($res);
        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

        //pagination data
        $limit_query = $query ." LIMIT $start,$limit";
        $limit_res = select($limit_query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

        $total_rows=mysqli_num_rows($res);

        if($total_rows==0){
            $output = json_encode(['table_data'=>"<b>No data found!</b>","pagination"=>'']);
            echo $output;
            exit;
        }

        $i=$start+1;
        $table_data = "";

        while($data = mysqli_fetch_assoc($limit_res))
        {
            $date = date("d-m-Y", strtotime($data['datentime']));
            $checkin = date("d-m-Y",strtotime($data['check_in']));
            $checkout = date("d-m-Y",strtotime($data['check_out']));

            if($data['booking_status']=='booked'){
                $status_bg = 'bg-success';
            }
            else{
                $status_bg = 'bg-danger';
            }

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
                        Price: $$data[price]
                    </td>
                    <td>
                        Amount: $$data[total_pay]
                        <br>
                        Date: $date
                    </td>
                    <td>
                        <span class='badge $status_bg'>$data[booking_status]</span>
                    </td>
                    <td>
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='btn mt-2 btn-md fw-bold btn-outline-danger shadow-none'>
                        <i class='bi bi-trash'></i>
                    </button>
                    </td>
                </tr>
            ";
            // print_r($table_data);

            $i++;
        }

        $pagination ="";

        if($total_rows>$limit)
        {
            $total_pages=ceil($total_rows/$limit);

            $disabled = ($page==1) ? "disabled" : "";
            $prev = $page-1;
            $pagination .="<li class='page-item $disabled'>
                <button onclick='change_page($prev)' class='page-link shadow-none'>Previous</button>
                </li>";

            $disabled = ($page==$total_pages) ? "disabled" : "";
            $next = $page+1;
            $pagination .="<li class='page-item $disabled'>
            <button onclick='change_page($next)' class='page-link shadow-none'>Next</button>
            </li>";

        }

        $output = json_encode(["table_data"=>$table_data,"pagination"=>$pagination]);
        echo $output;
    }

    if(isset($_POST['assign_room']))
    {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
        ON bo.booking_id = bd.booking_id
        SET bo.arrival =?, bd.room_no=?
        WHERE bo.booking_id = ?
        ";

        $values = [1,$frm_data['room_no'],$frm_data['booking_id']];

        $res = update($query,$values,'isi'); //it will update 2 rows hence it will return 2
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