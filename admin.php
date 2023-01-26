<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<?php 
$_username = $_email = $_password = "";
if (array_key_exists('admin_update', $_POST)){
    $_username = $_POST["username"];
    $_email = $_POST["email"];
    $_password = $_POST["password"];
    $_id = $_SESSION['_userid_'];
    if($_username != ""){
        $sql = "UPDATE users SET name='$_username' WHERE id=" . $_id;
        $result = $__conn->query($sql); 
    }
    if($_email != ""){
        $sql = "UPDATE users SET email='$_email' WHERE id=" . $_id;
        $result = $__conn->query($sql); 
    }
    if($_password != ""){
        $_enc = md5($_password);
        $sql = "UPDATE users SET password='$_enc' WHERE id=" . $_id;
        $result = $__conn->query($sql); 
    }
    $sql = "SELECT * FROM users WHERE id=" . $_id;
    $result = $__conn->query($sql);
    $row = $result->fetch_assoc();
    $_SESSION["_auth_"] = "true";
    $_SESSION["_userType_"] = $row['role_id'];
    $_SESSION["_email_"] = $row['email'];
    $_SESSION["_username_"] = $row['name'];
    $_SESSION["_userid_"] = $row['id'];
}      

$query = "SELECT (SELECT COUNT(id) FROM users) AS all_users, (SELECT COUNT(id) FROM users WHERE role_id=3) AS emp_count, (SELECT COUNT(id) FROM users WHERE role_id=2) AS tec_count, (SELECT COUNT(id) FROM exams) AS all_exams, (SELECT COUNT(id) FROM exams WHERE starting_time < curdate()) AS held_exams, (SELECT COUNT(id) FROM exams WHERE starting_time > curdate()) AS upcoming_exams, (SELECT COUNT(id) FROM exams WHERE starting_time = curdate()) AS ongoing_exams, (SELECT COUNT(id) FROM departments) AS all_departments";
$meta = $__conn->query($query);
$metadata = $meta->fetch_assoc();
?>

<body>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- page content -->
    <div class="content-wrap">
        <div>
            <div class="container dynamic-content-small">
                <h3 class="mb-3">Change Administrator Credentials</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off">
                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="John Wick" value="" onblur="va_admin_u()">
                                <div class="feedback" id="e_username">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="example@gmail.com" value="" onblur="va_admin_e()">
                                <div class="feedback" id="e_email">
                                    <?php echo $e_email;?>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="************" autocomplete="new-password" value=""
                                    onblur="va_admin_p()">
                                <div class="feedback" id="e_password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="display:flex;justify-content:right;">
                        <button type="submit" class="btn card-btn" name="admin_update"><i class="bi bi-pencil"></i>
                            Update</button>
                    </div>
                </form>
            </div>
            <div class="x3"></div>
            <div class="container dynamic-content-small">
                <h3 class="mb-3">View Site Data</h3>
                <h6>User Details</h6>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">All User Count</p>
                            <p class="form-control"><?php echo $metadata['all_users'];?></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">Emplyee Count</p>
                            <p class="form-control"><?php echo $metadata['emp_count'];?></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">Teachers Count</p>
                            <p class="form-control"><?php echo $metadata['tec_count'];?></p>
                        </div>
                    </div>
                </div>

                <h6>Exam Details</h6>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">All Exams</p>
                            <p class="form-control"><?php echo $metadata['all_exams'];?></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">Held Exams</p>
                            <p class="form-control"><?php echo $metadata['held_exams'];?></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">Upcoming Exams</p>
                            <p class="form-control"><?php echo $metadata['upcoming_exams'];?></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">Ongoing Exams</p>
                            <p class="form-control"><?php echo $metadata['ongoing_exams'];?></p>
                        </div>
                    </div>
                </div>
                <h6>Department Details</h6>
                <div class="row mb-3">
                    <div class="col-6">
                        <div class="input-group mb-1">
                            <p class="input-group-text" id="basic-addon1">All Departments</p>
                            <p class="form-control"><?php echo $metadata['all_departments'];?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>