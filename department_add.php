<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Add Department</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<?php 
$_departmentName = $_description = "";
if (array_key_exists('department_registration', $_POST)){
    $_departmentName = $_POST["departmentName"];
    $_description = $_POST["description"];
    $sql = "SELECT * FROM departments WHERE name='$_departmentName'";
    $result = $__conn->query($sql);
    if ($result->num_rows > 0) {
        $e_email = "This Department is already registerd";
    } else{
        $e_email = "";
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagefile"]['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["imagefile"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $sql = "INSERT INTO departments VALUES ('null','$_departmentName','$_description','$target_file')";
        if ($__conn->query($sql) === TRUE) {
            $_departmentName = $_description = "";
            header('location:department_view.php');
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
            <h3 class="mb-3">Add New Department</h3>
            <a href="department_view.php" type="button" class="btn card-btn mb-3">
                <i class="bi bi-caret-left-fill"></i> Go Back
            </a>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                onsubmit="return va_registration()" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="departmentName" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="departmentName" name="departmentName"
                                placeholder="Department Name" value="<?php echo $_departmentName; ?>"
                                onblur="va_departmentName()">
                            <div class="feedback" id="e_departmentName">
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description" value="<?php echo $_departmentName; ?>"
                                onblur="va_departmentName()">
                            <div class="feedback" id="e_departmentName">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Department Logo (Ratio : 6x9)</label>
                            <input class="form-control" type="file" id="imagefile" name="imagefile" accept="image/*">
                        </div>
                    </div>
                    <div class="col-12" style="display:flex;justify-content:right;">
                        <button type="submit" class="btn card-btn" name="department_registration"><i
                                class="bi bi-clipboard2-plus-fill"></i> Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>