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
        $uName = $_SESSION['user'];
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];
        $status = $_POST['stat'];
        $desc = $_POST['desc'];
        
        $sql = "INSERT INTO holidayrequests (uName,startDate,endDate,stat,reason) VALUES ( '$uName','$sDate', '$eDate', '$status','$desc')";
        if ($conn->query($sql) === TRUE)
        {
            echo'
            <html lang="en">
                <head>
                    <meta charset="utf-8">
                    <title>Employee Access Portal</title>
                    <link rel="reset" href="reset.css">
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                </head>
                <body>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="#">Employee Access Portal</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="main.php">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="Details.php">My Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="HolidayForm.php">Request Holiday</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">Report Absence</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" >Forum</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-2">
                                
                            </div>
                            <div class="col-7">
                                <p> Time off requested successfully</p>
                                <a href="main.php"> Return Home </a>
                            </div>
                            
                        </div>
                    </div>
                </body>
            </html> 
            ';
        } 
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>