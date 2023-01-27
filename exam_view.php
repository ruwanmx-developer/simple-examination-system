<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized: Exam View</title>
    
    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<body>

    <!-- database connection -->
    <?php include_once('database/config.php');?>

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

    <div>
    <div class="container dynamic-content-small">
        <h3 class="mb-3">Upcoming Exams</h3>
        <a href="exam_add.php" class="btn card-btn mb-2"><i class="bi bi-person-plus-fill"></i> Add New Exam</a>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Exam Number</th>
                            <th scope="col">Duraton</th>
                            <th scope="col">Start At</th>
                            <th scope="col">Department</th>
                            <th scope="col">Info</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT a.id, a.name AS ename, a.number, a.instruction, a.duration, a.starting_time, b.name FROM exams a INNER JOIN departments b ON a.department_id = b.id WHERE a.starting_time > curdate()";
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
                                <td><span data-bs-toggle="modal" data-bs-target="#model'.$row["number"].'" class="action-btn"><i class="bi bi-info-square"></i></span></td>
                                <td>
                                    <a class="action-btn" href="exam_edit.php?id='.$row['id'].'">
                                        <i class="bi bi-pencil"></i>
                                    </a> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="action-btn" href="database/delete_exam.php?id='.$row['id'].'"> 
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                                </tr>';
                                echo '<div class="modal fade" id="model'.$row["number"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">'.$row['name'].'</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">'.$row["instruction"].'</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
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
    <div class="x3"></div>
    <div class="container dynamic-content-small">
        <h3 class="mb-3">Ongoing Exams</h3>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Exam Number</th>
                            <th scope="col">Duraton</th>
                            <th scope="col">Start At</th>
                            <th scope="col">Department</th>
                            <th scope="col">Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT a.id, a.name AS ename, a.number, a.instruction, a.duration, a.starting_time, b.name FROM exams a INNER JOIN departments b ON a.department_id = b.id WHERE a.starting_time = curdate()";
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
                                <td><span data-bs-toggle="modal" data-bs-target="#model'.$row["number"].'" class="action-btn"><i class="bi bi-info-square"></i></span></td>
                                </tr>';
                                echo '<div class="modal fade" id="model'.$row["number"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">'.$row['name'].'</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">'.$row["instruction"].'</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
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
    <div class="x3"></div>
    <div class="container dynamic-content-small">
        <h3 class="mb-3">Finished Exams</h3>
        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Exam Number</th>
                            <th scope="col">Duraton</th>
                            <th scope="col">Start At</th>
                            <th scope="col">Department</th>
                            <th scope="col">Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT a.id, a.name AS ename, a.number, a.instruction, a.duration, a.starting_time, b.name FROM exams a INNER JOIN departments b ON a.department_id = b.id WHERE a.starting_time < curdate()";
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
                                <td><span data-bs-toggle="modal" data-bs-target="#model'.$row["number"].'" class="action-btn"><i class="bi bi-info-square"></i></span></td>
                                </tr>';
                                echo '<div class="modal fade" id="model'.$row["number"].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">'.$row['name'].'</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">'.$row["instruction"].'</div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
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
    </div>

    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>