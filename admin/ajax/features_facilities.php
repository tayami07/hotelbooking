<?php

    require('../inc/essentials.php');
    require('../inc/db_config.php');
    adminLogin();


    if(isset($_POST['add_feature']))
    {
        $frm_data = filteration($_POST);

        $q = "INSERT INTO `features`(`name`) VALUES (?)";
        $values = [$frm_data['name']];
        $res = insert($q,$values,'s');
        echo $res;
    }

    // if(isset($_POST['get_features']))
    // {
    //     $res = selectAll('features');

    //     while($row = mysqli_fetch_assoc($res))
    //     {
    //        echo<<<data
    //         <tr>
    //             <td>$i</td>
    //         </tr>
    //        data;
    //     }
    // }
?>