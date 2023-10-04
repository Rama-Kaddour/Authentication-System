<?php
    session_start();
    
    if(isset($_POST['submit'])){
        

        $email = $_POST["email"];
        $password = $_POST["password"];
        if(empty($email) || empty($password)){
            echo "<div class='alert alert-danger'>
            Please fill all data
            </div>";
        }
        else{
            $query = "SELECT id, email, password, role FROM usersdata WHERE email='{$email}'";
            $user = getDataFrom($query);
            if(!password_verify($password, $user['password'])){
                echo "<div class='alert alert-danger'>
                Wrong Password
                </div>";
            }
            else{
                setcookie(
                    'user_id',
                    $user['id'],
                    time()+60*60*24*30,
                    httponly:true,
                    secure: true
                );
                header('Location:index.php');
            }
        }
        
        
    }
    function getDataFrom(string $query): array|false|null
    {
        //$query = "SELECT id, email, password FROM usersdata WHERE email='{$email}'";
        $conn = mysqli_connect("127.0.0.1", "root", "", "users");
        $data = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($data);
        mysqli_close($conn);
        return $data;
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
<body class="d-flex flex-column justify-content-center " style="background-image: url(forest.jpg); background-repeat: no-repeat; background-size: 1600px; height: 715px;">

    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" class="align-self-center align-middle mb-5 px-5 py-5 rounded-4 bg-black bg-opacity-75" style=" width: 450px;">
        <p class="text-success pt-2 fs-2 fw-bold text-center rounded-4" >Login</p>
        <?php
        if(isset($_SESSION['message'])){
            $message = $_SESSION['message'];
            unset ($_SESSION["message"]);
            echo "<div class='alert alert-success'>
            {$message}
            </div>";
            
        }
        if(isset($_COOKIE['user_id'])){
            $id = $_COOKIE["user_id"];
            $user = getDataFrom("SELECT email FROM usersdata where id='$id'");
            echo "<div class='alert alert-success'>
            U are logged in as {$user['email']}
            </div>";
            
        }
    ?>
        <div class="mb-3">
        <label for="text" class="form-label">Email address</label>
        <input name="email" type="text" placeholder="example@mail.com" class="form-control" id="email1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input name="password" type="password" placeholder="Enter Your Password" class="form-control" id="password1">
        </div>
        <div class="mb-3">
            <input name="rememberMe" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>
        <p class="text-secondary pt-2">Don't have an account?</p>
        <div class="d-flex justify-content-between">
            <a class="text-success" href="signup.php">Sign Up</a>
            <button name="submit" type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.xyz/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>