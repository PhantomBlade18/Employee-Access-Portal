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
    
        $fName = $_POST['fname'];
        $sName = $_POST['lname'];
        $DOB = date_format(date_create($_POST['DOB']),"Y-m-d");
        $gender = $_POST['gender'];
        $pMail =$_POST['email'];
        $ad1 = $_POST['add1'];
        $ad2 = $_POST['add2'];
        $postcode = $_POST['postcode'];
        $city =$_POST['city'];
        $country = $_POST['country'];
        
        $sql = "UPDATE `personaldetails` SET `fName` = '$fName', `sName` = '$sName',`DOB` = '$DOB',`gender` = '$gender',`personalMail` = '$pMail',
        `Address1` = '$ad1', `Address2` = '$ad2', `Postcode` = '$postcode', `City` = '$city', `Country` = '$country'  WHERE `personaldetails`.`uName` = '$uName'";
        if ($conn->query($sql) === TRUE)
        {
            $_SESSION['msg'] = 'Details updated successfully';
            header("Location: PersonalDetails.php");
        } 
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>