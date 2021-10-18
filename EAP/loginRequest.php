<?php
session_start();

if( isset($_POST['usernameField']) && isset($_POST['passwordField']) )
{
    if( empty($_POST['usernameField']) || empty($_POST['passwordField']) )
    {
        $_SESSION['msg'] = 'Please enter your username AND password';
        header("Location: login.php");
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "eap";
    $conn = new mysqli($servername,$username,$password,$dbname);
    $fUserName = $_POST['usernameField'];
    $fPassword = $_POST['passwordField'];

    if($conn->connect_error)
    {
        die("Connection Failed:".$conn->connect_error);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $sqlQuery = "SELECT * FROM corporatedetails WHERE uName='$fUserName' AND pWord='$fPassword'";
        $query = $conn->query($sqlQuery);
        if($query->num_rows == 1)
        {
            $row = mysqli_fetch_array($query);
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $row[0];
            $_SESSION['job'] =$row[3];
            header("Location: main.php");
        }
        else
        {
            $_SESSION['msg'] = 'Username or Password incorrect';
            header("Location: login.php");
        }
    }

}
else
{

}

?>
