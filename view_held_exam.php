<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorized: Past Exams</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<body >

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- check authentication -->
    <?php 
        if(array_key_exists('_auth_', $_SESSION)){
            if($_SESSION['_auth_'] == 'true'){
                if($_SESSION['_userType_'] != 2){
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
        <h3 class="mb-3">Pending Answer Checks</h3>
        <!-- <a href="users_add.php" class="btn card-btn mb-2"><i class="bi bi-person-plus-fill"></i> Add New User</a> -->

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- table headings -->
                            <th scope="col">No</th>
                            <th scope="col">Exam Number</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Participants</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT a.id, a.number, a.name, b.name AS dep_name, (SELECT COUNT(id) FROM answers WHERE exam_id=a.id) AS participants, (SELECT COUNT(id) FROM answers WHERE exam_id=a.id AND status = 0) AS unMarked FROM exams a INNER JOIN departments b ON a.department_id=b.id WHERE a.starting_time < curdate()";
                            $result = $__conn->query($sql);
                            if ($result->num_rows > 0) {
                                $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    if($row['unMarked'] > 0){
                                    echo '<tr> <th scope="row">'.$count.'</th>
                                    <td>'.$row['number'].'</td>
                                    <td>'.$row["name"].'</td>
                                    <td>'.$row["dep_name"].'</td>
                                    <td>'.$row["participants"].'</td>
                                    <td>';
                                        echo '<a class="action-btn" href="mark_exam.php?examid='.$row['id'].'"><i class="bi bi-pencil"></i></a> ';
                                    echo'
                                    </td>
                                    </tr>';
                                    $count++;
                                }
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
        <h3 class="mb-3">Finished Answer Checks</h3>
        <!-- <a href="users_add.php" class="btn card-btn mb-2"><i class="bi bi-person-plus-fill"></i> Add New User</a> -->

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- table headings -->
                            <th scope="col">No</th>
                            <th scope="col">Exam Number</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Participants</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT a.id, a.number, a.name, b.name AS dep_name, (SELECT COUNT(id) FROM answers WHERE exam_id=a.id) AS participants, (SELECT COUNT(id) FROM answers WHERE exam_id=a.id AND status = 0) AS unMarked FROM exams a INNER JOIN departments b ON a.department_id=b.id WHERE a.starting_time < curdate()";
                            $result = $__conn->query($sql);
                            if ($result->num_rows > 0) {
                                $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    if($row['unMarked'] <= 0){
                                    echo '<tr> <th scope="row">'.$count.'</th>
                                    <td>'.$row['number'].'</td>
                                    <td>'.$row["name"].'</td>
                                    <td>'.$row["dep_name"].'</td>
                                    <td>'.$row["participants"].'</td>
                                    <td>';
                                        echo '<a class="action-btn" href="view_result_by_exam.php?examid='.$row['id'].'"><i class="bi bi-eye"></i></a>'; 
                                    echo'
                                    </td>
                                    </tr>';
                                    $count++;
                                }
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
    <!-- footer file -->
    <?php include('views/footer.php');?>