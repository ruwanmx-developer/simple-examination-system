<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized: Edit Exam</title>

    <!-- header file -->
    <?php include_once('./views/header.php');?>
</head>

<?php 
$_ename = $_enumber = $_desc = $_eduration = $_estart = $_department = "";
if (array_key_exists('exam_update', $_POST)){
    $_ename = $_POST["ename"];
    $_enumber = $_POST["enumber"];
    $_desc = $_POST["desc"];
    $_eduration = $_POST["eduration"];
    $_estart = $_POST["estart"];
    $_department = $_POST["department"];
    $_quiz = $_POST["quiz"];
    $_id = $_POST["id"];
    $sql = "UPDATE exams SET name='$_ename', number='$_enumber', instruction='$_desc', duration='$_eduration', starting_time='$_estart', department_id='$_department', quiz='$_quiz' WHERE id=" . $_id;
    if ($__conn->query($sql) === TRUE) {
        header("location:exam_view.php");
    } else {
        echo '<div class="alert alert-danger" role="alert">
        Error: ' . $sql . "<br>" . $__conn->error . '</div>';
    } 
} else {
    $sql = "SELECT * FROM exams WHERE id=".$_GET["id"];
    $result = $__conn->query($sql); 
    $row = $result->fetch_assoc();
    $_ename = $row["name"];
    $_enumber = $row["number"];
    $_desc = $row["instruction"];
    $_eduration = $row["duration"];
    $_estart = $row["starting_time"];
    $_department = $row["department_id"];
    $_quiz = $row["quiz"];
}
?>

<body>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- check authentication -->
    <?php 
        if(array_key_exists('_auth_', $_SESSION)){
            if($_SESSION['_auth_'] == 'true'){
                if(!($_SESSION['_userType_'] == 1 || $_SESSION['_userType_'] == 2)){
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
        <h3 class="mb-3">Edit Exam</h3>
        <a href="exam_view.php" type="button" class="btn card-btn mb-3">
            <i class="bi bi-caret-left-fill"></i> Go Back
        </a>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return va_update()"
            autocomplete="off">
            <div class="row">
                <input type="hidden" name="id" value="<?php echo $_GET["id"];?>">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="ename" class="form-label">Exam Name</label>
                            <input type="text" class="form-control" id="ename" name="ename" placeholder="Module Name"
                                value="<?php echo $_ename; ?>" required>
                            <div class="feedback" id="e_ename">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="enumber" class="form-label">Exam Number</label>
                            <input type="number" class="form-control" id="enumber" name="enumber" placeholder="45"
                                value="<?php echo $_enumber; ?>" required>
                            <div class="feedback <?php if($e_enumber != ""){echo 'display';}?>" id="e_enumber">
                                <?php echo $e_enumber;?>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="desc" class="form-label">Instructions</label><br>
                            <textarea name="desc" id="desc" rows="7" cols="45"><?php echo $_desc; ?></textarea>
                            <div class="feedback" id="e_desc">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="quiz" class="form-label">Quiz</label><br>
                            <textarea name="quiz" id="quiz" rows="7" cols="45"
                                required><?php echo $_quiz;  ?></textarea>
                            <div class="feedback" id="e_quiz">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="eduration" class="form-label">Duration</label>
                            <input type="number" class="form-control" id="eduration" name="eduration"
                                placeholder="Enter Minutes" value="<?php echo $_eduration; ?>" required>
                            <div class="feedback" id="e_eduration">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="estart" class="form-label">Starting Time</label>
                            <input type="date" class="form-control" id="estart" name="estart" placeholder="10/27/2022"
                                value="<?php echo date('Y-m-d',strtotime($_estart)) ?>" required>
                            <div class="feedback" id="e_estart">
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
                    <div class="col-12" style="display:flex;justify-content:right;">
                        <button type="submit" class="btn card-btn" name="exam_update"><i class="bi bi-pencil"></i>
                            Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    
    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>