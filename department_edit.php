<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Edit Department</title>

    <!-- header file -->
    <?php include_once('./views/header.php');?>
</head>

<?php 
$_departmentName = $_description = "";
if (array_key_exists('department_update', $_POST)){
    $_departmentName = $_POST["departmentName"];
    $_description = $_POST["description"];
    $_id = $_POST["id"];
    $sql = "SELECT * FROM departments WHERE name='$_departmentName' AND NOT id=".$_POST["id"];
    $result = $__conn->query($sql);
    if ($result->num_rows > 0) {
        $e_departmentName = "This Department already registerd";
    } else{
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imagefile"]["name"]);
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
                $uploadOk = 3;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $tem = "";
        if($uploadOk == 3){
            $tem = ", path='" . $target_file . "' " ;
        } else {
            $tem = "";
        }
        $sql = "UPDATE departments SET name='$_departmentName', description='$_description' $tem WHERE id=" . $_id;
        if ($__conn->query($sql) === TRUE) {
            $_departmentName = $_description = "";
            header("location:department_view.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Error: ' . $sql . "<br>" . $__conn->error . '</div>';
        } 
    }  
} else {
    $sql = "SELECT * FROM departments WHERE id=".$_GET["id"];
    $result = $__conn->query($sql); 
    $row = $result->fetch_assoc();
    $_departmentName = $row["name"];
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
            <h3 class="mb-3">Edit Department</h3>
            <a href="department_view.php" type="button" class="btn card-btn mb-3"><i
                    class="bi bi-caret-left-fill"></i>Go
                Back</a>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                onsubmit="return va_registration()" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <?php if(array_key_exists('id',$_GET)){ ?>
                    <input type="hidden" name="id" value="<?php echo $_GET["id"];?>">
                    <?php } else {?>
                    <input type="hidden" name="id" value="<?php echo $_POST["id"];?>">
                    <?php }?>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="departmentName" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="departmentName" name="departmentName"
                                placeholder="Department Name" value="<?php  ?>" onblur="va_departmentName()">
                            <div class="feedback" id="e_departmentName">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description" value="<?php  ?>" onblur="va_departmentName()">
                            <div class="feedback" id="e_departmentName">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="imagefile" class="form-label">Department Logo (Ratio : 6x9)</label>
                            <input class="form-control" type="file" id="imagefile" name="imagefile" accept="image/*">
                        </div>
                    </div>
                    <div class="col-12" style="display:flex;justify-content:right;">
                        <button type="submit" class="btn card-btn" name="department_update"><i class="bi bi-pencil"></i>
                            Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>