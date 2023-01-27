<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam In Action</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<?php 
$_examid = $_userid = $_ans = $e_email="";
if (array_key_exists('attend_exam', $_POST)){
        $_examid = $_POST["examid"];
        $_userid = $_POST["userid"];
        $_ans = $_POST["answer"];
        $sql = "SELECT * FROM answers WHERE exam_id='$_examid' AND user_id=". $_userid;
        $result = $__conn->query($sql);
        if ($result->num_rows == 0) {
            $e_email = "This Email Address already registerd";
        } else{
            $sql = "UPDATE answers SET answer='$_ans',status=0 WHERE exam_id='$_examid' AND user_id=". $_userid;
            if ($__conn->query($sql) === TRUE) {
                $_examid = $_userid = $_ans = $e_email="";
                header('location:exam_schedule.php');
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
                if(!($_SESSION['_userType_'] == 3)){
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
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-10">
                        <?php 
                            $row = $rows = "";
                            if(array_key_exists('userid',$_GET) && array_key_exists('examid',$_GET)){
                                $sql = "SELECT * FROM exams WHERE id=" . $_GET['examid'];
                                $sqls = "SELECT * FROM users WHERE id=" . $_GET['userid'];
                                $result = $__conn->query($sql);
                                $results = $__conn->query($sqls);
                                if ($results->num_rows == 1) {
                                    $row = $result->fetch_assoc();
                                    $rows = $results->fetch_assoc();
                                    if($row['department_id'] == $rows['department_id']){
                                        echo '<h4>'. $row['name'].'</h4>    
                                        </div>';
                                        $a = "SELECT * FROM answers WHERE exam_id=".$_GET['examid']. " AND user_id=".$_GET['userid'];
                                        $aa = $__conn->query($a);
                                        if ($aa->num_rows == 0) {
                                            $d = "INSERT INTO answers VALUES ('null','".$_GET['examid']."', '".$_GET['userid']."', 'null', cast(curtime() as time) ,'-1','1')";
                                            $__conn->query($d);    
                                        }?>

                        <div class="col-2 d-block">
                            <div class="timer">
                                <span id="hour"></span> :
                                <span id="minute"></span> :
                                <span id="second"></span>
                            </div>
                        </div>
                    </div>

                    <?php
                                echo '<p>'. $row['quiz'].'</p>';
                            } else {
                                header('location:login.php');
                            }
                        } else{
                            header('location:login.php');
                        }
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                        id="examination_form">
                        <textarea disabled name="answer" id="answer" rows="13" class="boxsizingBorder "></textarea>
                        <div class="col-12 mt-3" style="display:flex;justify-content:right;">
                            <?php if(array_key_exists('userid',$_GET) && array_key_exists('examid',$_GET)){ ?>
                            <input type="hidden" name="examid" value="<?php echo $_GET['examid'];?>">
                            <input type="hidden" name="userid" value="<?php echo $_GET['userid'];?>">
                            <input type="hidden" name="attend_exam" value="">
                            <?php } else { ?>
                            <input type="hidden" name="examid" value="<?php echo $_POST['examid'];?>">
                            <input type="hidden" name="userid" value="<?php echo $_POST['userid'];?>">
                            <input type="hidden" name="attend_exam" value="">
                            <?php }?>
                            <button type="submit" class="btn card-btn"><i class="bi bi-pencil"></i>
                                Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
            <?php 
                $sqli = "SELECT started_at, CURDATE() AS date FROM answers WHERE exam_id=" . $_GET['examid'] . " AND user_id=".$_GET['userid'];
                $resulti = $__conn->query($sqli);
                $rowi = $resulti->fetch_assoc();
                ?>
            // Set the date we're counting down to
            var countDownDate = new Date(new Date("<?php echo $rowi['date'] . " ".$rowi['started_at'] ;  ?>")
                .getTime() + <?php echo $row['duration'] ?> * 60000);
            // Update the count down every 1 second
            var x = setInterval(function() {
                if (document.getElementById("hour") == null) {
                    return;
                }
                var h = document.getElementById("hour");
                var m = document.getElementById("minute");
                var s = document.getElementById("second");
                var f = true;
                // Get today's date and time
                var now = new Date().getTime();
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                // Time calculations for days, hours, minutes and seconds
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                // Output the result in an element with id="demo"
                h.innerHTML = hours;
                m.innerHTML = minutes;
                s.innerHTML = seconds;
                // If the count down is over, write some text
                if (distance < 1) {
                    document.forms["examination_form"].submit();
                    clearInterval(x);
                } else {
                    if (f) {
                        document.getElementById("answer").removeAttribute("disabled");
                        f = false;
                    }
                }
            }, 1000);
            </script>
        </div>
    </div>
    </div>
    
    <!-- footer file -->
    <?php include('views/footer.php');?>