<?php
    include_once 'configuration.php';

    $sql = "SELECT * FROM user;";

    $result = mysqli_query($link, $sql);
             
    $resultCheck = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style type="text/css">
            table{
                text-align: center;
                border: 1px;
                width:900px;
                line-height: 60px;
            }
            tr{
                text-align: center;
            }
            .topnav {
            background-color: #333;
            overflow: hidden;
            margin: auto;
            }

            /* Style the links inside the navigation bar */
            .topnav a {
                float: left;
                color: #f2f2f2;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                font-size: 17px;
            }
            
            /* Change the color of links on hover */
            .topnav a:hover {
                background-color: #ddd;
                color: black;
            }
            
            /* Add a color to the active/current link */
            .topnav a.active {
                background-color: grey;
                color: white;
            }
        </style>

    </head> 

    <body>
        <div class="topnav">
            <a href="index.html">Home</a>
            <a href="logout.php">Logout</a>
            <a class="active" href="stuRecord.php">Stuent Record</a>
        </div>
        
        <table align=center border=1px>
            <tr>
                <td colspan = "5"><h2>Application</h2></td>
            </tr>

            <tr>
                <td><h3>FullName</h3></td>
                <td><h3>Phonenumnber</h3></td>
                <td><h3>Username</h3></td>
                <td><h3>Address</h3></td>
                <td><h3>Email</h3></td>
            </tr>

            <?php
                if ($resultCheck > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>          
            <tr>
                <td><?php  echo $row['fullname']?></td>
                <td><?php  echo $row['phonenumber']?></td>
                <td><?php  echo $row['username']?></td>
                <td><?php  echo $row['address']?></td>
                <td><?php  echo $row['email']?></td>
            </tr>
            <?php
                    }
                 }
            ?>
                 
        </table>
    </body>
</html>  