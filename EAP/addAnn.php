<?php
session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eap";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
    {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        $date = date("Y-m-d");
        $time = date("H:i ");
        $imp = $_POST['imp'];
        $body = $_POST['body'];
        $project= $_SESSION['projectID'];
        
        $sql = "INSERT INTO announcements (projectID,aDate,aTime,body,importance) VALUES ( '$project','$date', '$time', '$body','$imp')";
        if ($conn->query($sql) === TRUE)
        {
            $_SESSION['msg'] = 'Announcement Posted';
            header("Location: main.php");
        } 
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>