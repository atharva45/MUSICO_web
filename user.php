<?php

    session_start();

    $conn = new mysqli('localhost', 'root', '', 'msc');
    mysqli_select_db( $conn, 'signup');
    
    $email = $_POST['email'];
    $password = $_POST['passw'];

    $s = "SELECT uname FROM signup WHERE email = '$email' && passw = '$password'";

    $result = mysqli_query($conn, $s);

    $num = mysqli_num_rows($result);

    if($num == 1){
        if(isset($_POST['remember'])){
            setcookie('email', $email,time()+60*60*7);
            setcookie('password', $password,time()+60*60*7);
        }
        $_SESSION['email'] = $email;
        header("Location: index.php");
    }else{
        echo'<script>alert("Wrong Email or password. Please try again.")</script>';
    }
?>
