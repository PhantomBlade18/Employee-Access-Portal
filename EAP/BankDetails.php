<?php
session_start()

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Employee Access Portal</title>
        <link rel="reset" href="reset.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="genstyling.css">
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
                    <div>
                        <?php
                            if($_SESSION['job']== "Manager")
                            {
                                echo'
                                <ul id="actions">
                                    <li><a href="">Review Holiday Requests</a> </li>
                                    <li><a href="searchEmployee.php">Search for Employee</a> </li>
                                    <li><a href="addProject.php">Add A project</a> </li>
                                </ul>';
                            }
                        ?>
                    </div>
                </div>
                <div class="col-7">
                    <h1 class="title-card"> My Details </h1>
                    <?php

                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "eap";
                    $conn = new mysqli($servername,$username,$password,$dbname);
                    $uName = $_SESSION['user'];
                    
                    if($conn->connect_error)
                    {
                        die("Connection Failed:".$conn->connect_error);
                    }
                        $sqlQuery = "SELECT * FROM  bankdetails B WHERE B.uName='$uName'";
                        $query = $conn->query($sqlQuery);
                        $row = mysqli_fetch_array($query);
                        $noc = $row[1];
                        $accNo = $row[2];
                        $sortCode = $row[3];

                        if(isset($_SESSION['msg'])){
                            $msg =$_SESSION['msg'];
                            echo '<p>'.$msg.'</p>';
                            unset($_SESSION['msg']);
                        }

                        echo' 
                        <form action="updateBank.php" method="Post">
                            <h2> Bank Details </h2>

                            <div class="fBlock">
                                <label for="NoC">Name on Card:</label>
                                <input type="text" id="NoC" name="NoC" value="'.$noc.'" required><br>
                            </div>

                            <div class="fBlock">
                                <label for="accNo">Account Number (8 digits):</label>
                                <input type="text" id="accNo" pattern="[0-9]{8}" name="accNo" value="'.$accNo.'"required><br>
                            </div>

                            <div class="fBlock">
                                <label for="sortC">Sort Code (6 digits):</label>
                                <input type="text" id="sortC" name="SortC" pattern="[0-9]{6}" value="'.$sortCode.'"required><br>
                            </div>

                            <button type="submit" onClick=""> Save </button>

                        </form>';
                    ?>
                    
                </div>
                <div class="col-3">
                    <div class="logout">
                        <form  id="logoutF" method="POST" action="logout.php">
                            <fieldset>
                                <?php
                                 echo '<legend><p>Welcome '.$_SESSION['user'].'</p></legend>'
                                ?>
                                <button type="submit" onclick="">Log Out</button>
                            </fieldset>
                        </form>
                    </div>
                    <div id= "ann-title">
                        <h2  id="ann"> Announcements </h2>
                    </div>
                    <div class="Announcement-field">
                        
                        <?php
                            $uName= $_SESSION['user'];
                            $sqlQuery = "SELECT A.aDate,A.aTime,A.body,A.importance,P.title FROM announcements A, project P, projectgroups G WHERE A.ProjectID = (SELECT G.projectID WHERE G.uName ='$uName') AND P.ProjectID = (SELECT G.projectID WHERE G.uName ='$uName') ORDER BY aDate DESC, aTime DESC";
                            $result= $conn->query($sqlQuery);

                            while($row= mysqli_fetch_array($result))
                            {
                                $time = date_format(date_create($row[1]),"H:i ");
                                $date = date_format(date_create($row[0]),"jS F Y ");
                                $ann = $row[2];
                                $imp = $row[3];
                                $tit = $row[4];

                                echo '<hr>';
                                echo '<div id="announcement"><p id= "timestamp">'.$time.''.$date.'</p>
                                    <p><b> '.$tit.'</p></b>';
                                echo '<p id="annImportance">Importance: '.$imp.'</p></div>';
                                echo '<p id="annbody">'.$ann.'</p>';
                                
                            }
                            $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> 