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
        $title = $_POST['pTitle'];
        $manager = $_POST['manager'];
        $status = "Active";
        
        $sql = "INSERT INTO project (title,manager,pStatus) VALUES ('$title', '$manager','$status')";
        if ($conn->query($sql) === TRUE)
        {

            $mysqlq = "INSERT INTO projectgroups(uName, projectID) VALUES ('$manager', (SELECT P.ProjectID FROM project P WHERE P.manager = '$manager' AND P.title = '$title'))";
            if ($conn->query($mysqlq) === TRUE)
            {
                header("Location: main.php");
            }
            
        } 
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>