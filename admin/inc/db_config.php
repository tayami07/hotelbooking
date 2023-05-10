<?php 
    $hname = 'localhost';
    $uname = 'root';
    $pass = '';
    $db = 'hotelbooking';

    $con = mysqli_connect($hname,$uname,$pass,$db);
    
    if(!$con)
    {
        die("cannot connect" .mysqli_connect_error());
    }

    function filteration($data){
        foreach($data as $key => $value)
        {
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $data[$key] = $value;
        }
        return $data;
    }
    function selectAll($table)
    {
        $con = $GLOBALS['con'];
        $res = mysqli_query($con, "SELECT * FROM $table");
        return $res;
    }

    function select($sql,$values,$datatypes){
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("query cannot be executed -select");            
            }
        }
        else{
            die("query cannot be prepared - select");
        }
    }

    function delete($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Delete");
            }
        }
        else{
            die("Query cannot be prepared - Delete");
        }
    }

    function update ($sql,$values,$datatypes){
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("query cannot be executed- update");       
            }
        }
        else{
            die("query cannot be prepared - update");
        }
    }

    function insert ($sql,$values,$datatypes){
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("query cannot be executed- insert");   
            }
        }
        else{
            die("query cannot be prepared - insert");
        }
    }

    function insertToken($sql){
        $con = $GLOBALS['con'];
            
        if ($con->query($sql) === TRUE) {
           return true;
        } 
           return false;

    }
