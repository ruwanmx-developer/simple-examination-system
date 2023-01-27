<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>

    <!-- header file -->
    <?php include_once('views/header.php');?>
</head>

<body>

    <!-- navigation bar -->
    <?php include('views/navigation.php');?>

    <!-- page content -->
    <div class="content-wrap">

    
    <div class="container">
        <div class="row">
            <?php 
        $sql = "SELECT * FROM departments";
        $result = $__conn->query($sql);
        if ($result->num_rows > 0) {
            $count = 1;
            while($row = $result->fetch_assoc()) { ?>
            <div class="col-4 my-3">
                <div class="dynamic-content-small-card">
                    <img src="<?php echo $row['path']?>" alt="" class="dep-image">
                    <h4><?php echo $row['name'];?></h4>
                    <p><?php echo $row['description'];?></p>
                </div>
            </div>
            <?php } } ?>
        </div>
    </div>
    </div>
    <!-- footer file -->
    <?php include('views/footer.php');?>