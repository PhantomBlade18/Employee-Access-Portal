<?php
 session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eap";
    $uName = $_SESSION['user'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        $pass = $_POST['pass'];
        
        $sql = "UPDATE `corporatedetails` SET `pWord` = '$pass' WHERE `corporatedetails`.`uName` = '$uName'";
        if ($conn->query($sql) === TRUE)
        {
            $_SESSION['msg'] = 'Details updated successfully';
            header("Location: Details.php");
        } 
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>