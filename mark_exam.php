<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized: Mark Exam</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<?php
$title = $username = $quiz = $answer =  $examid = "";
if(array_key_exists('mark_update',$_POST)){
    $examid = $_POST['examid'];
    $userid = $_POST['userid'];
    $marks = $_POST['marks'];
    $sql2 = "UPDATE answers SET marks='$marks', status=3 WHERE exam_id='$examid' AND user_id='$userid'";
    if ($__conn->query($sql2) === TRUE) {
        //header("location:mark_exam.php?examid=$examid");
    } else {
        echo '<div class="alert alert-danger" role="alert">
        Error: ' . $sql . "<br>" . $__conn->error . '</div>';
    } 
}
$row = $row = '';
if(array_key_exists('examid', $_GET)){
    $examid = $_GET['examid'];
} else {
    $examid = $_POST['examid'];
}
$sql = "SELECT id, name, quiz FROM exams WHERE id=". $examid;
$result = $__conn->query($sql);
    if ($result->num_rows == 0) {} else {
        $row = $result->fetch_assoc();
        $sql1 = "SELECT a.id, a.exam_id, a.user_id, a.answer, a.status, b.name AS username FROM answers a INNER JOIN users b ON a.user_id=b.id WHERE exam_id=".$row['id']." AND status=0 LIMIT 1";
        $result1 = $__conn->query($sql1);
        if ($result1->num_rows == 0) {
            header("location:view_held_exam.php");
        } else {
            $row1 = $result1->fetch_assoc();
        }
    }
?>

<body>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- page content -->
    <div class="content-wrap">
        <div class="container dynamic-content-small">
            <h3 class="mb-3"><?php echo $row['name'];?></h3>
            <!-- <a href="users_add.php" class="btn card-btn mb-2"><i class="bi bi-person-plus-fill"></i> Add New User</a> -->
            <p style="margin-bottom:0;"><?php echo $row1['username'];?></p>
            <p><?php echo $row['quiz'];?></p>
            <textarea id="" disabled cols="30" rows="10"><?php echo $row1['answer'];?></textarea>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="row mt-2">
                    <div class="col-12" style="display:flex;justify-content:right;">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="marks" name="marks"
                                placeholder="Marks out of 100" value="" onblur="va_email()">
                        </div>
                    </div>
                    <?php if(array_key_exists('examid',$_GET)){?>
                    <input type="hidden" name="examid" value="<?php echo  $_GET['examid'];?>">
                    <?php } else { ?>
                    <input type="hidden" name="examid" value="<?php echo  $_POST['examid'];?>">
                    <?php } ?>
                    <input type="hidden" name="userid" value="<?php echo  $row1['user_id'];?>">
                    <div class="col-12" style="display:flex;justify-content:right;">
                        <button type="submit" class="btn card-btn" name="mark_update"><i class="bi bi-check2-all"></i>
                            Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- footer file -->
    <?php include('views/footer.php');?>