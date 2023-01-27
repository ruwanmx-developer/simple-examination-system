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


<?php 
$sql = "SELECT name FROM exams WHERE id=" . $_GET['examid']; 
$result = $__conn->query($sql);
$row = $result->fetch_assoc()
?>
    <!-- page content -->
    <div class="content-wrap">
    <div class="container dynamic-content-small">
        <h3 class="mb-3"><?php echo $row['name']?></h3>
        <a href="view_held_exam.php" class="btn card-btn mb-2"><i class="bi bi-caret-left-fill"></i> Back</a>

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- table headings -->
                            <th scope="col">No</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Marks</th>
                            <th scope="col">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $sql = "SELECT a.id, b.name, a.marks, CASE WHEN a.marks > 75 THEN 'A' WHEN a.marks > 65 THEN 'B' WHEN a.marks > 55 THEN 'C' WHEN a.marks > 35 THEN 'S' ELSE 'F' END AS grade FROM answers a INNER JOIN users b ON a.user_id = b.id WHERE a.exam_id=" . $_GET['examid']; 
                        $result = $__conn->query($sql);
                        if ($result->num_rows > 0) {
                            $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr> <th scope="row">'.$count.'</th>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row["marks"].'</td>
                                    <td>'.$row["grade"].'</td>
                                    </tr>';
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