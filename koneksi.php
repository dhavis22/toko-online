<?php 
    $con = mysqli_connect("localhost","root","","online_shop");
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
}
?>