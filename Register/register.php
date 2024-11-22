<?php
require 'function.php';
if(isset($_POST["register"])){ 
    if(registrasi($_POST)>0){
        echo"<script>
        alert('user baru berhasil ditambahkan')
        </script>";
    }
    else{
        echo mysqli_error($conn);
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resgistration Page</title>
</head>
<body>
    <h1>Registration Page</h1>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">username :</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">password :</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <label for="password2">confirm password :</label>
                <input type="password" name="password2" id="password2">
            </li>
            <li>
                <label for="email">email :</label>
                <input type="email" name="email" id="email">
            </li>
            <li>
                <button type="submit" name="register">Submit</button>
                <button type="reset" name="cancel">Cancel</button>
            </li>
        </ul>
    </form>
</body>
</html>