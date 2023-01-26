<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="./img/logo-mini.png" alt="" width="40" height="auto" class="d-inline-block align-text-top">
            Winexam</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="exam_schedule.php">Exam Schedule</a>
                </li>
                <?php
                if(array_key_exists('_userType_', $_SESSION)){
                if($_SESSION['_userType_'] != 1){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="result.php">Results</a>
                </li>
                <?php } } ?>
                <li class="nav-item">
                    <a class="nav-link" href="departments.php">Departments</a>
                </li>
                <?php
                if(array_key_exists('_userType_', $_SESSION)){
                if($_SESSION['_userType_'] == 1){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Administrator Features
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="users_view.php">Manage Users</a></li>
                        <li><a class="dropdown-item" href="department_view.php">Manage Department</a></li>
                        <li><a class="dropdown-item" href="exam_view.php">Manage Examinations</a></li>
                    </ul>
                </li>
                <?php } 
                if($_SESSION['_userType_'] == 2){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Teacher Features
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="exam_view.php">Manage Exams</a></li>
                        <li><a class="dropdown-item" href="view_held_exam.php
                        ">Pending Markings</a></li>
                    </ul>
                </li>
                <?php } } ?>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About Us</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                if(array_key_exists('_auth_', $_SESSION)){
                    if($_SESSION['_auth_'] == "true"){  
                        if($_SESSION['_userType_'] == 1){
                            echo '<a class="btn cmb-btn" href="admin.php"><i class="bi bi-person-fill"></i> '.$_SESSION['_username_'].'</a>';
                            echo '<a class="btn cmb-btn" href="database/logout.php" type="button"><i class="bi bi-box-arrow-left"></i> Log Out</a>';
                        } else if($_SESSION['_userType_'] == 2){
                            echo '<a class="btn cmb-btn-n" ><i class="bi bi-person-fill"></i> '.$_SESSION['_username_'].'</a>';
                            echo '<a class="btn cmb-btn" href="database/logout.php" type="button"><i class="bi bi-box-arrow-left"></i> Log Out</a>';
                        } else if($_SESSION['_userType_'] == 3){
                            echo '<a class="btn cmb-btn-n"><i class="bi bi-person-fill"></i> '.$_SESSION['_username_'].'</a>';
                            echo '<a class="btn cmb-btn" href="database/logout.php" type="button"><i class="bi bi-box-arrow-left"></i> Log Out</a>';
                        }
                    } else{
                        echo 'ewrfwef';
                    }
                } else {
                    echo ' <a class="btn cmb-btn" href="login.php" type="submit"><i class="bi bi-box-arrow-in-right"></i> Log In</a>
                    <a class="btn cmb-btn" href="signup.php" type="submit"><i class="bi bi-person-fill"></i> Register</a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>