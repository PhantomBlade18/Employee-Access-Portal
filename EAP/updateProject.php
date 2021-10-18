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
        
        $stat = $_POST['stat'];
        $pNo = $_POST['pID'];
        
        $sql = "UPDATE `project` SET `pStatus` = '$stat' WHERE `project`.`projectID` = '$pNo'";
        if ($conn->query($sql) === TRUE)
        {
            $_SESSION['msg'] = 'Project Status updated successfully';
            header("Location: main.php");
        } 
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }