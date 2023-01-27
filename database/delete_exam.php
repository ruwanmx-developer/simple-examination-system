<?php
include_once('config.php');

if (array_key_exists('id', $_GET)){
    $_id = $_GET["id"];
    $sql = "SELECT * FROM exams WHERE id=" . $_id;
    $result = $__conn->query($sql);
    if ($result->num_rows == 1 ) {
        $sql = "DELETE FROM exams WHERE id=" . $_id;
        if ($__conn->query($sql) === TRUE) {
            header("location:../exam_view.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Error: ' . $sql . "<br>" . $__conn->error . '</div>';
        }
    }  
}
?>