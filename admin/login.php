<?php

require_once "dbconnect.php"; // Include the database connection file

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['btnLogin'])) //login request
{
    $email = $_POST['email']; // name attribute value of form value
    $password = $_POST['password'];

    $sql = 'SELECT * FROM admin WHERE email = ?';
    $stmt = $conn->prepare($sql); //prevent sql injection attack
    $stmt->execute([$email]); // Assuming you want to fetch the user by email
    $adminInfo = $stmt->fetch();
    
    //$hashcode = "$2y$10\$xbu1MoWyj7AWLlOj7dJNAO/1NUW4nVfN9bhMPbnKVa3edIncAfz/6";
    
    if($adminInfo) { //email exist
        $hashcode = $adminInfo['password']; // Fetch the hashed password from the database

        if (password_verify($password, $hashcode)) // two arguments required plain text, hashcode
        {
            $_SESSION['email'] = $email;

        } else {//correct email and incorrect password
            $errMsg = "Incorrect Password.";
        }
    }else //email does not exist
    {
        $errMsg = "Email does not exist. Please resgister first!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- cdn link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            require_once "navigation.php";
            ?>
        </div>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <form action="login.php" class="form mt-5" method="post">
                    <legend>Admin Login</legend>
                    <?php 
                        if(isset($errMsg)) {
                            echo "<p class='alert alert-danger'>$errMsg</p>";
                            unset($errMsg);
                        }
                    ?>
                    <fieldset>
                        <!--Email -->
                        <div class="mb-1">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>

                        <div class=" mb-1">
                            <label for="" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <!-- Button -->
                        <button type="submit" class="btn btn-primary mt-2" name="btnLogin">Login</button>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</body>

</html>