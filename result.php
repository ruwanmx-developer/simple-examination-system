<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<body>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>
    
    <!-- check authentication -->
    <?php 
        if(array_key_exists('_auth_', $_SESSION)){
            if($_SESSION['_auth_'] == 'true'){
                if($_SESSION['_userType_'] != 3){
                    header("location:view_held_exam.php");
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
        <h3 class="mb-3">Examination Results</h3>

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Exam Name</th>
                            <th scope="col">Exam Number</th>
                            <th scope="col">Marks</th>
                            <th scope="col">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT b.name, b.number, a.marks, CASE WHEN a.marks > 75 THEN 'A' WHEN a.marks > 65 THEN 'B' WHEN a.marks > 55 THEN 'C' WHEN a.marks > 35 THEN 'S' ELSE 'F' END AS grade FROM answers a INNER JOIN exams b ON a.exam_id = b.id WHERE a.user_id=".$_SESSION['_userid_'];
                            $result = $__conn->query($sql);
                            if ($result->num_rows > 0) {
                                $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr> <th scope="row">'.$count.'</th>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row["number"].'</td>';

                                    if($row["marks"] == -1){
                                        echo '<td>Reviewing</td>
                                        <td>Reviewing</td>';
                                    } else {
                                        echo '<td>'.$row["marks"].'</td>
                                        <td>'.$row["grade"].'</td>
                                        </tr>';
                                    }
                                    $count++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>    </div>

    <!-- footer file -->
    <?php include('views/footer.php');?>