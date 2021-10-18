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
                    <h1 class="title-card"> My Projects </h1>
                        <?php
                        if(isset($_SESSION['msg'])){
                            $msg =$_SESSION['msg'];
                            echo '<p>'.$msg.'</p>';
                            unset($_SESSION['msg']);
                        }
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "eap";
                        $conn = new mysqli($servername,$username,$password,$dbname);
                        $uName= $_SESSION['user'];
                        
                        if($conn->connect_error)
                        {
                            die("Connection Failed:".$conn->connect_error);
                        }

                        $sqlQuery = "SELECT P.projectID,P.title, P.pStatus FROM project P, projectgroups G WHERE P.projectID = (SELECT G.projectID WHERE G.uName = '$uName') ";
                        $query = $conn->query($sqlQuery);
                        echo '<table class="table table-striped">';
                        echo '<thead><tr><th>Project:</th><th>Status:</th> <th> </th></tr> </thead>';
                        while($row= mysqli_fetch_array($query))
                        {
                            $pid = $row[0];
                            $title = $row[1];
                            $status = $row[2];
                            echo '<tr>';
                            echo '<th scope="row">'.$title. '</th>';
                            echo '<td>'.$status.'</td>';
                            echo '<td>
                                    <form action="project.php" method="Post">
                                        <input type="hidden" name="pID" value="'.$pid.'">
                                        <button type="" onClick=""> View Project </button>
                                    </form>
                                </td>';
                            echo '</tr>';
                            
                            
                        }
                        echo '</table>';
                        

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