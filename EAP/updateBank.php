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
        
        $noc = $_POST['NoC'];
        $accNo = $_POST['accNo'];
        $sCode = $_POST['SortC'];
        
        $sql = "UPDATE `bankdetails` SET `nameOnCard` = '$noc',
         `accountNo` = '$accNo', `sortCode` = '$sCode' WHERE `bankdetails`.`uName` = '$uName'";
        if ($conn->query($sql) === TRUE)
        {
            $_SESSION['msg'] = 'Details updated successfully';
            header("Location: BankDetails.php");
        } 
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>