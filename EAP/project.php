<?php
session_start();

date_default_timezone_set('UTC');
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
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "eap";
                    $conn = new mysqli($servername,$username,$password,$dbname);
                    $pNo = $_POST['pID'];
                    $_SESSION['projectID']= $_POST['pID'];
                    
                    if($conn->connect_error)
                    {
                        die("Connection Failed:".$conn->connect_error);
                    }
                        $sqlQuery = "SELECT * FROM  project P WHERE P.projectID='$pNo'";
                        $query = $conn->query($sqlQuery);
                        $row = mysqli_fetch_array($query);
                        $title = $row[1];
                        $manager = $row[2];
                        $status = $row[3];

                        echo' <h2 class="title-card">'.$title.'</h2>
                        <p>Manager: '.$manager.' </p>';
                        if($_SESSION['job']== "Manager")
                        {
                        echo'
                            <form action="updateProject.php" method="Post">
                            <div class="fBlock">
                                <label> Status: </label> 
                                <select id="stat" name="stat" value="'.$status.'">
                                    <option value="Active"> Active </option>
                                    <option value="Delayed"> Delayed </option>
                                    <option value="On-Hold"> On-hold </option>
                                    <option value="Completed"> Completed </option>
                                    <option value="Cancelled"> Cancelled </option>
                                </select> 
                                <input type="hidden" name="pID" value="'.$pNo.'">
                                <button type="submit" onClick=""> Save </button>
                            </div>
                            </form>';
   
                        }
                        else{
                            echo '<p> Status:   '.$status.'</p>';
                        }
                        
                    ?>
                    <h2>Project Announcements:</h2>
                    
                    <div id="Project-Announcements">
                        <div class="Announcements">
                            <?php
                                $sqlQuery = "SELECT * FROM announcements WHERE projectID ='$pNo' ORDER BY aDate DESC, aTime DESC";
                                $result= $conn->query($sqlQuery);

                                while($row= mysqli_fetch_array($result))
                                {
                                    $time = date_format(date_create($row[2]),"H:i e ");
                                    $date = date_format(date_create($row[1]),"jS F Y ");
                                    $ann = $row[3];
                                    $imp = $row[4];

                                    echo '<hr>';
                                    echo '<div id="announcement"><p id= "timestamp">'.$time.''.$date.'</p>';
                                    echo '<p id="annImportance">Importance: '.$imp.'</p></div>';
                                    echo '<p id="annbody">'.$ann.'</p>';
                                    
                                }
                                
                            ?>
                        </div>
                        <div class="ann-form">
                            <h3> Make announcement:</h3>
                            <form action="addAnn.php" method="POST">
                                <fieldset>
                                    <div class="fBlock">
                                        <label for="Importance">Importance:</label>
                                        <select id="Importance" name="imp" value="Low">
                                            <option value="Very High">Very High </option>
                                            <option value="High"> High </option>
                                            <option value="Medium"> Medium </option>
                                            <option value="Low"> Low </option>
                                            <option value="Very Low">Very Low </option>
                                        </select> <br>
                                    </div>

                                    <div class="fBlock">
                                        <label id="content" for="body">Content:</label><br>
                                        <textarea id="body" name="body" rows="4" cols="50" required></textarea>
                                    </div>
                                        
                                    <button type="submit" id="annSubmit" > Post Announcement </button>
                                </fieldset>
                            </form>
                        </div> 
                    </div>
                    <div class="team-members">
                        <h2> Project Members </h2>
                        <hr>
                        <?php
                            $sqlQuery = "SELECT DISTINCT E.uName, E.fName, E.sName FROM personaldetails E, projectgroups G WHERE E.uName = (SELECT G.uName WHERE G.projectID = '$pNo') ";
                            $query = $conn->query($sqlQuery);
                            echo '<table class="table table-striped">';
                            echo '<thead><tr><th>ID: </th><th>Name: </th> <th>Surname: </th><th></th></tr> </thead>';
                            while($row= mysqli_fetch_array($query))
                            {
                                $eID = $row[0];
                                $fName = $row[1];
                                $sName = $row[2];
                                echo '<tr>';
                                echo '<th scope="row">'.$eID. '</th>';
                                echo '<td>'.$fName.'</td>';
                                echo '<td>'.$sName.'</td>';

                                if($_SESSION['job']== "Manager")
                                {
                                    echo '<td>
                                            <form action="removeEmp.php" method="Post">
                                                <input type="hidden" name="pID" value="'.$pNo.'">
                                                <input type="hidden" name="rem" value="'.$eID.'">
                                                <button type="" onClick=""> Remove From Project </button>
                                            </form>
                                        </td>';
                                    echo '</tr>';
                                }
                                else{
                                    echo '<td> </td>';
                                }
                                
                                
                            }
                            echo '</table>';
                        ?>
                        <hr>
                        <div>
                            <?php

                                if($_SESSION['job']== "Manager")
                                {
                                    echo'
                                    <h2> Add Member to Project </h2>
                                    
                                        <form action="project.php" method="Post">
                                            <label for="fName">Search:  </label>
                                            <input type="text" id="search" name="search">
                                            <input type="hidden" name="pID" value="'.$pNo.'">
                                            <button type="submit" onClick=""> Search </button>

                                        </form>';
                                    echo'<b> Results:</b>';
                                    if(isset($_POST['search'])){
                                        $search = $_POST['search'];
                                        $sqlQuery = "SELECT DISTINCT P.uName, P.fName, P.sName FROM  personaldetails P, projectgroups G WHERE P.fName LIKE '%$search%' OR P.sName LIKE'%$search%' OR P.uName LIKE'%$search%'";
                                        $query = $conn->query($sqlQuery);
                                        if($query->num_rows >0)
                                        {
                                            echo '<table class="table table-striped">';
                                            echo '<thead>
                                                    <tr>
                                                    <th scope="col">Username:</th>
                                                    <th scope="col">First Name:</th>
                                                    <th scope="col">Last Name:</th>
                                                    <th> </th>
                                                    </tr>
                                                </thead>';
                                            while($row= mysqli_fetch_array($query))
                                            {
                                                $eID = $row[0];
                                                $fName = $row[1];
                                                $sName = $row[2];
                                                echo '<tr>';
                                                echo '<th scope="row">'.$eID. '</th>';
                                                echo '<td>'.$fName.'</td>';
                                                echo '<td>'.$sName.'</td>';
                                                echo '<td>
                                                        <form action="addEmp.php" method="Post">
                                                            <input type="hidden" name="pID" value="'.$pNo.'">
                                                            <input type="hidden" name="emp" value="'.$eID.'">
                                                            <button type="" onClick=""> Add to Project </button>
                                                        </form>
                                                    </td>';
                                                echo '</tr>';
                                            }
                                            echo '</table>';
                                        }
                                        else{
                                            echo'<p>There are no users with information matching this criteria. Please try again </p>';
                                        }
                                    
                                    }
                                    else{
    
                                        $sqlQuery = "SELECT DISTINCT E.uName, E.fName, E.sName FROM personaldetails E, projectgroups G WHERE NOT E.uName = (SELECT G.uName WHERE G.projectID ='$pNo')";
                                        $query = $conn->query($sqlQuery);
    
                                        echo '<table class="table table-striped">';
                                        echo '<thead><tr><th>ID: </th><th>Name: </th> <th>Surname: </th><th></th></tr> </thead>';
                                        while($row= mysqli_fetch_array($query))
                                        {
                                            $eID = $row[0];
                                            $fName = $row[1];
                                            $sName = $row[2];
                                            echo '<tr>';
                                            echo '<th scope="row">'.$eID. '</th>';
                                            echo '<td>'.$fName.'</td>';
                                            echo '<td>'.$sName.'</td>';
                                            echo '<td>
                                                    <form action="addEmp.php" method="Post">
                                                        <input type="hidden" name="pID" value="'.$pNo.'">
                                                        <input type="hidden" name="emp" value="'.$eID.'">
                                                        <button type="" onClick=""> Add to Project </button>
                                                    </form>
                                                </td>';
                                            echo '</tr>';
                                        }
                                        
                                        echo '</table>';
                                    }
                                }
                                
                            ?>
                        </div>
                    </div> 
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
        <script type="text/javascript" src="annLenCheck.js"></script>
    </body>
</html> 