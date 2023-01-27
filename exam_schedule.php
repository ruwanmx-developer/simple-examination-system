<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Schedule</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<body id="exam-schedule">

    <!-- database connection -->
    <?php include_once('database/config.php');?>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- check authentication -->
    <?php 
        if(array_key_exists('_auth_', $_SESSION)){
            if($_SESSION['_auth_'] != 'true'){
                header('location:login.php');
            }
        } else {
            header('location:login.php');
        }
    ?>

    <!-- page content -->
    <div class="content-wrap">
    <div class="container dynamic-content-small">
        <h3 class="mb-3 ">Examination Schedule</h3>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Exam Number</th>
                            <th scope="col">Duaration</th>
                            <th scope="col">Available On</th>
                            <th scope="col">Department</th>
                            <th scope="col">Info</th>
                            <?php if($_SESSION['_userType_'] == 3){ echo '<th scope="col">Attend</th>'; } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($_SESSION['_userType_'] == 3){
                            $sql = "SELECT a.id, a.name AS ename, a.number, a.instruction, a.duration, a.starting_time, b.id AS dep, b.name FROM exams a INNER JOIN departments b ON a.department_id = b.id WHERE a.department_id=".$_SESSION['_depid_'] ." ORDER BY a.starting_time DESC";
                        } else {
                            $sql = "SELECT a.id, a.name AS ename, a.number, a.instruction, a.duration, a.starting_time, b.id AS dep, b.name FROM exams a INNER JOIN departments b ON a.department_id = b.id ORDER BY a.starting_time DESC";
                        }
                        $result = $__conn->query($sql);
                        if ($result->num_rows > 0) {
                            $count = 1;
                            while($row = $result->fetch_assoc()) {
                                echo '<tr> <th scope="row">'.$count.'</th>
                                <td>'.$row['ename'].'</td>
                                <td>'.$row["number"].'</td>
                                <td>'.$row["duration"].'</td>
                                <td>'.$row["starting_time"].'</td>
                                <td>'.$row["name"].'</td>
                                <td><span data-bs-toggle="modal" data-bs-target="#model'.$row["number"].'" class="action-btn"><i class="bi bi-info-square"></i></span></td>';
                                if($_SESSION['_userType_'] == 3){
                                    $sqls = "SELECT id FROM exams WHERE department_id=".$row["dep"];
                                    $results = $__conn->query($sqls);
                                    if ($results->num_rows == 0) {
                                        echo '<td><span a class="attend-btn disable">Unavilable</span></td>';
                                    } else {
                                        $sqls = "SELECT * FROM answers WHERE exam_id=".$row["id"] . " AND user_id=".$_SESSION['_userid_'] . " AND status=0 OR status=3";
                                        $results = $__conn->query($sqls);
                                        if ($results->num_rows == 0) {
                                            $sqlss = "SELECT * FROM exams WHERE id=".$row["id"] . " AND starting_time=CURDATE()";
                                            $resultss = $__conn->query($sqlss);
                                            if ($resultss->num_rows == 0) {
                                                echo '<td><p class="attend-btn disable"><a>Not Available</a></p></td>';
                                            } else{
                                                echo '<td><p class="attend-btn attend"><a href="attend_exam.php?userid='.$_SESSION['_userid_'].'&examid='.$row['id'].'">Attend</a></p></td>';
                                            }
                                        } else{
                                            echo '<td><p class="attend-btn disable"><a>Completed</a></p></td>';
                                        }
                                    }
                                }
                                echo '</tr>';
                                echo '<div class="modal fade" id="model'.$row["number"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">'.$row['name'].'</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">'.$row["instruction"].'</div>
                                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button></div>
                                            </div>
                                        </div>
                                    </div>';
                                $count++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- footer file -->
    <?php include('views/footer.php');?>