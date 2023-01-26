<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<?php 
$_username = $_email = $_password = $_conPassword = $e_email ="";
if (array_key_exists('user_registration', $_POST)){
    $_username = $_POST["username"];
    $_email = $_POST["email"];
    $_password = $_POST["password"];
    $enc_password = md5($_password);
    $_department = $_POST["department"];
    $sql = "SELECT * FROM users WHERE email='$_email'";
    $result = $__conn->query($sql);
    if ($result->num_rows > 0) {
        $e_email = "This Email Address already registerd";
    } else{
        $e_email = "";
        $sql = "INSERT INTO users VALUES ('null','$_username', '$_email', '$enc_password','$_department','3')";
        if ($__conn->query($sql) === TRUE) {
            $row = $result->fetch_assoc();
            $_SESSION["_auth_"] = "true";
            $_SESSION["_userType_"] = $row['role_id'];
            $_SESSION["_email_"] = $_email;
            $_SESSION["_username_"] = $row['name'];
            $_SESSION["_userid_"] = $row['id'];
            $_SESSION["_depid_"] = $row['department_id'];
            $_username = $_email = $_password = $_conPassword = $e_email ="";
            header('location:index.php');
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Error: ' . $sql . "<br>" . $__conn->error . '</div>';
        } 
    }  
} 
?>

<body>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- check authentication -->
    <?php 
        if(array_key_exists('_auth_', $_SESSION)){
            if($_SESSION['_auth_'] == 'true'){
                header('location:index.php');
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
                    <h5>Make your path clear</h5>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                    onsubmit="return va_registration()" autocomplete="off">
                    <hr>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                            value="<?php echo $_username; ?>" onblur="va_username()">
                        <div class="feedback" id="e_username">
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Address"
                            value="<?php echo $_email; ?>" onblur="va_email()">
                        <div class="feedback <?php if($e_email != ""){echo 'display';}?>" id="e_email">
                            <?php echo $e_email;?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            autocomplete="new-password" value="<?php echo $_password; ?>" onblur="va_password()">
                        <div class="feedback" id="e_password">
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confrm Password"
                            value="<?php echo $_conPassword; ?>" onblur="va_confirmPassword()">
                        <div class="feedback" id="e_confirmPassword">
                        </div>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" name="department">
                            <?php 
                                $sql = "SELECT * FROM departments";
                                $result = $__conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $count = 1;
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-login" name="user_registration">Sign Up</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <p>Already have an account ? <a href="login.php">Log In</a></p>
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