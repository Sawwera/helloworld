<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
            body{ font: 14px sans-serif; 
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
        <a class="active" href="welcome.php">Portal</a>
    </div>

    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        <a href="stuRecord.php" class="btn btn-primary">Student Record</a>
    </p>
</body>
</html>