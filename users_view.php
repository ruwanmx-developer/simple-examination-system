<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: View Users</title>

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
        <h3 class="mb-3">Manage Users</h3>
        <a href="users_add.php" class="btn card-btn mb-2"><i class="bi bi-person-plus-fill"></i> Add New User</a>

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- table headings -->
                            <th scope="col">No</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Department</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql = "SELECT a.id, a.name AS username, a.email, b.name as department, c.name AS role FROM users a INNER JOIN departments b ON a.department_id = b.id INNER JOIN user_roles c ON a.role_id = c.id WHERE NOT a.role_id=1";
                            $result = $__conn->query($sql);
                            if ($result->num_rows > 0) {
                                $count = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr> <th scope="row">'.$count.'</th>
                                    <td>'.$row['username'].'</td>
                                    <td>'.$row["email"].'</td>
                                    <td>'.$row["department"].'</td>
                                    <td>'.$row["role"].'</td>
                                    <td>
                                        <a class="action-btn" href="users_edit.php?id='.$row['id'].'">
                                            <i class="bi bi-pencil"></i>
                                        </a> &nbsp;&nbsp;&nbsp;
                                        <a class="action-btn" href="database/delete_user.php?id='.$row['id'].'"> 
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