<?php

    session_start();
    header("Location: login.php");

    $conn = new mysqli('localhost', 'root', '', 'msc');
    mysqli_select_db( $conn, 'signup');

    $name = $_POST['name'];
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['passw'];

    $s = "SELECT * FROM signup WHERE uname = '$uname'";

    $result = mysqli_query($conn, $s);

    $num = mysqli_num_rows($result);

    if($num == 1){
        echo"Username Already Taken";
    }else{
        $reg = "INSERT INTO signup(name, uname, email, passw) values ('$name', '$uname', '$email', '$password')";
    mysqli_query($conn, $reg);
    echo"Succesfully registered";
    }

?>

