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
                <div class="col-7">
                    <h1 class="title-card"> Time Off Request </h1>
                    <form action="RequestHoliday.php" method="Post">
                            <h2> Holiday Form </h2>

                            <div class="fBlock">
                                <label for="sDate">Start Date:</label>
                                <input type="date" id="sDate" name="sDate" required><br>
                            </div>

                            <div class="fBlock">
                                <label for="eDate">End Date:</label>
                                <input type="date" id="eDate" name="eDate" required ><br>
                            </div>

                            <div class="fBlock">
                                <label for="stat">Status:</label>
                                <input type="text" id="stat" name="stat" value="Not Reviewed" readonly  required><br>
                            </div>

                            <div class="fBlock">
                                <label for="desc">Description:</label><br>
                                <textArea id="desc" name="desc" rows="4" cols="50" required> </textarea>
                            </div>

                            <button type="submit" id="submitButton" onClick=""> Save </button>

                    </form>
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
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "eap";
                            $uName= $_SESSION['user'];
                        
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            if ($conn->connect_error)
                            {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            else{
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
                            }
                            $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="checkDate.js"></script>
    </body>
</html> 