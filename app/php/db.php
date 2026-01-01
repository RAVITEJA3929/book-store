<?php
function Createdb(){
    $servername = "mysql"; // Fixed for Docker networking
    $username = "bookuser";
    $password = "bookpass123";
    $dbname = "bookstore";

    $con = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$con){
        // Fallback to localhost for local testing
        $con = mysqli_connect("localhost", "root", "", $dbname);
    }

    if (!$con){
        die("Connection Failed: " . mysqli_connect_error());
    }

    $sql = "CREATE TABLE IF NOT EXISTS books(
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        book_name VARCHAR(100) NOT NULL,
        book_publisher VARCHAR(100),
        book_price DECIMAL(10,2),
        book_year VARCHAR(10)
    )";

    if(!mysqli_query($con, $sql)){
        echo "Table creation failed: " . mysqli_error($con);
    }

    return $con;
}
