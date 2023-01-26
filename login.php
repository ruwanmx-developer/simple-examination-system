<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<?php 
$_email = $_password = $e_email = $e_password = "";
if (array_key_exists('user_login', $_POST)){
    $_email = $_POST["email"];
    $_password = $_POST["password"];
    $enc_password = md5($_password);
    $sql = "SELECT * FROM users WHERE email='$_email'";
    $result = $__conn->query($sql);
    if ($result->num_rows == 0) {
        $e_email = "This Email Address is not registerd";
    } else{
        $sql = "SELECT * FROM users WHERE email='$_email' AND password='$enc_password'";
        $result = $__conn->query($sql);
        if ($result->num_rows == 0) {
            $e_password = "Password is incorrect";
        } else {
            $row = $result->fetch_assoc();
            $_SESSION["_auth_"] = "true";
            $_SESSION["_userType_"] = $row['role_id'];
            $_SESSION["_email_"] = $_email;
            $_SESSION["_username_"] = $row['name'];
            $_SESSION["_userid_"] = $row['id'];
            $_SESSION["_depid_"] = $row['department_id'];
            $_email = $_password = $e_email = $e_password = "";
            header('location:index.php');
        }
    }  
} 
?>

<body>

    <!-- database connection -->
    <?php include_once('database/config.php');?>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- check auth users -->
    <?php 
        if(array_key_exists('_auth_', $_SESSION)){
            if($_SESSION['_auth_'] == 'true'){
                if($_SESSION['_userType_'] == 1){
                    header('location:admin.php');
                } else if($_SESSION['_userType_'] == 2){
                    header('location:index.php');
                } else if($_SESSION['_userType_'] == 3){
                    header('location:index.php');
                }  
            } 
        }
    ?>

    <!-- page content -->
    <div class="auth-wrap">
        <div class="login-wrap">
            <div class="container">
                <div class="text-center my-3">
                    <img src="./img/logo-mini.png" alt="logo" class="brand-img">
                    <h2><a href="index.php">Winexam</a></h2>
                    <h5>Sharp your knowledge</h5>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                    onsubmit="return va_email()" autocomplete="off">
                    <hr>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Address"
                            value="<?php echo $_email; ?>" onblur="va_email()">
                        <div class="feedback <?php if($e_email != ""){echo 'display';}?>" id="e_email">
                            <?php echo $e_email;?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            autocomplete="new-password" value="<?php echo $_password; ?>">
                        <div class="feedback <?php if($e_password != ""){echo 'display';}?>" id="e_password">
                            <?php echo $e_password;?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> Remember Me
                        </div>
                        <div class="col-6 psw-fog">
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-login" name="user_login">Log In</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <p>Don't have an account ? <a href="signup.php">Sign Up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>