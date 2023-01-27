<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: Department View</title>

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
            <h3 class="mb-3">Manage Departments</h3>
            <a href="department_add.php" class="btn card-btn mb-2"><i class="bi bi-building"></i> Add New Department</a>
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Department Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image Path</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $sql = "SELECT * FROM departments";
                            $result = $__conn->query($sql);
                            if ($result->num_rows > 0) {
                                $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr> <th scope="row">'.$count.'</th>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$row['description'].'</td>
                                    <td>'.$row['path'].'</td>
                                    <td>
                                        <a class="action-btn" href="department_edit.php?id='.$row['id'].'">
                                            <i class="bi bi-pencil"></i>
                                        </a> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="action-btn" href="database/delete_department.php?id='.$row['id'].'"> 
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
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

    <!-- validation javascript -->
    <script src="js/user_validation.js" type="text/javascript"></script>

    <!-- footer file -->
    <?php include('views/footer.php');?>