<?php
    $email = $password = '';
    $errors = array();
    //include("config/db_connect.php");
    //......
    // mysqli_free_result($result);
    // mysqli_close($connection);
    if(isset($_POST["submit"]))
    {
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        if(empty($email))
        {
            $errors["email"] = "An email is required";
            
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $errors["email"] = "Invalid email format";
        }
        if(empty($password))
        {
            $errors["password"] = "A password is required";
            
        }elseif(strlen($password)<8){
            $errors["password"] = "Password must contains 8 or more characters";
        }

        if($password !== $_POST["confirmPassword"])
        {
            $errors["confirmPassword"] = "The password doesn't match";
        }

        if(empty($errors)){
            $options = [
                'cost' => 7,
            ];
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
            $conn = mysqli_connect("127.0.0.1", 'root', '', 'users');
            $sql = "INSERT INTO usersdata(email, password, role) VALUES('$email', '$hashedPassword', 'zed')";
            if(mysqli_query($conn, $sql)){
                session_start();
                $_SESSION['message'] = "User created";
                header('Location:index.php');
            }else{
                echo "error";
            }

        }
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication System</title>
    <link href="https://cdn.jsdelivr.xyz/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body class="d-flex justify-content-center " style="background-image: url(forest.jpg); background-repeat: no-repeat; background-size: 1600px; height: 715px;">
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" class="align-self-center align-middle mb-5 px-5 py-5 rounded-4 bg-black bg-opacity-75" style=" width: 450px;">
        <p class="text-success pt-2 fs-2 fw-bold text-center rounded-4" >Sign Up</p>
        <div class="mb-3">
            <label for="text" class="form-label">Email address</label>
            <input name="email" type="text" placeholder="example@mail.com" class="form-control" value="<?php echo $email ?>" id="email1" >
            <div class="text-danger"> <?php echo isset($errors['email']) ? $errors["email"] : '' ?></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" placeholder="Enter your password" class="form-control" id="password">
            <div class="text-danger"> <?php echo isset($errors['password']) ? $errors["password"] : '' ?></div>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input name="confirmPassword" type="password" placeholder="Confirm your password" class="form-control" id="confirmPassword">
            <div class="text-danger"> <?php echo isset($errors['confirmPassword']) ? $errors["confirmPassword"] : ''  ?></div>
        </div>
        <p class="text-secondary pt-2">Already have an account?</p>
        <div class="d-flex justify-content-between">
            <a class="text-success" href="index.php">Login</a>
            <input name="submit" type="submit" class="btn btn-success">
        </div>
    </form>
<script src="https://cdn.jsdelivr.xyz/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>