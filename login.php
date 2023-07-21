


<?php
$songno=1;
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit&display=swap" rel="stylesheet">
</head>
<body>
    <header></header>
    <rect></rect>
    <logo>MUSICO</logo>
    <img src="img2.svg">
    <t1>Login</t1>
    <t2>Get started and enjoy</t2>
    <form name="form1" action="user.php" method="post">
    <t3>Email</t3>
    <div class="input1">
        <input type="text" name="email" placeholder="Your Email" id="email">
    </div>
    <t4>Password</t4>
    <div class="input2">
        <input type="password" name="passw" placeholder="Your Password" id="passw">
        <br><input type="checkbox" name="remember" class="rem" style="position: absolute;
        bottom: -30px;
        left: -4px"/><div class="rem" style="font-family: Outfit;
    font-style: normal;
    font-weight: normal;
    font-size: 18px;
    line-height: 30px;
    position: absolute;
    left: 16px;
    bottom: -35px">Remember Me</div>
    </div>
    <input type="submit" class="button" onclick="ValidateEmail(document.form1.email),ValidatePassw(document.form1.passw)">Submit</input>
</form>
    
    <script>
function ValidateEmail(inputText)
   {
   var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
   if(inputText.value.match(mailformat))
   {
   document.form1.email.focus();
   return true;
   }
   else
   {
   alert("You have entered an invalid email address!");
   document.form1.email.focus();
   return false;
   }
   }
   
   function ValidatePassw(inputtxt)
   {
       var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
   if(inputtxt.value.match(passw)) 
   { 
   return true;
   }
   else
   { 
   alert('Please have a password with atleast 8 characters and one uppercase letter and one number')
   document.form1.passw.focus();
   return false;
   }
   }
   
    </script>



    <?php 
    if(isset($_COOKIE['email']) and isset($_COOKIE['password'])){
        $email = $_COOKIE['email'];
        $password = $_COOKIE['password'];
        ?>

    <script>
        document.getElementById('email').value = $email;
        document.getElementById('password').value = $password;
        alert('email')
    </script>

<?php
    }

?>

</body>
</html>
