<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Add User</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<?php 
$_username = $_email = $_password = $_conPassword = $e_email ="";
if (array_key_exists('user_registration', $_POST)){
    $_username = $_POST["username"];
    $_email = $_POST["email"];
    $_password = $_POST["password"];
    $_role = $_POST["role"];
    $enc_password = md5($_password);
    $_department = $_POST["department"];
    $sql = "SELECT * FROM users WHERE email='$_email'";
    $result = $__conn->query($sql);
    if ($result->num_rows > 0) {
        $e_email = "This Email Address already registerd";
    } else{
        $e_email = "";
        $sql = "INSERT INTO users VALUES ('null','$_username', '$_email', '$enc_password','$_department','$_role')";
        if ($__conn->query($sql) === TRUE) {
            $_username = $_email = $_password = $_conPassword = $e_email ="";
            header('location:users_view.php');
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
                if($_SESSION['_userType_'] != 1){
                    $_redtitle = 'Unauthoriesed User'; 
                    $_redmsg = 'You have no permission to view that page. Stop snooping here and there.'; 
                    header("location:redirect.php?title=$_redtitle&msg=$_redmsg");
                }
            } else {
                header('location:login.php');
            }
        } else {
            header('location:login.php');
        }
    ?>

    <!-- page content -->
    <div class="content-wrap">
    <div class="container dynamic-content-small">
        <h3 class="mb-3">Add New User</h3>
        <a href="users_view.php" type="button" class="btn card-btn mb-3"><i class="bi bi-caret-left-fill"></i> Go
            Back</a>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            onsubmit="return va_registration()" autocomplete="off">
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="John Wick"
                            value="<?php echo $_username; ?>" onblur="va_username()">
                        <div class="feedback" id="e_username">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="example@gmail.com"
                            value="<?php echo $_email; ?>" onblur="va_email()">
                        <div class="feedback <?php if($e_email != ""){echo 'display';}?>" id="e_email">
                            <?php echo $e_email;?>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="************" autocomplete="new-password" value="<?php echo $_password; ?>"
                            onblur="va_password()">
                        <div class="feedback" id="e_password">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="************"
                            value="<?php echo $_conPassword; ?>" onblur="va_confirmPassword()">
                        <div class="feedback" id="e_confirmPassword">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
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
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" aria-label="Default select example" name="role">
                            <option value="2">Teacher</option>
                            <option value="3">Employee</option>
                        </select>
                    </div>
                </div>
                <div class="col-12" style="display:flex;justify-content:right;">
                    <button type="submit" class="btn card-btn" name="user_registration">
                        <i class="bi bi-person-plus-fill"></i> Add
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>

    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>