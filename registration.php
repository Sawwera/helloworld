<?php
 include 'configuration.php';
// Define variables and initialize with empty values
$fullname = $phonenumber = $username = $address = $email = $password = $confirm_passwor = "";
$score = 0;

$fullname_err = $phonenumber_err = $username_err = $address_err = $email_err = $password_err = $confirm_password_err = $score_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Full Name
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter your full name.";
    } else {
        $fullname = trim($_POST["fullname"]);
    }

    //phonenumber
    if(empty(trim($_POST["phonenumber"]))){
        $phonenumber_err = "Please enter your phone number.";     
    } elseif(strlen(trim($_POST["phonenumber"])) < 8){
        $phonenumber_err = "Phone number must have atleast 8 digits.";
    } else{
        $phonenumber = trim($_POST["phonenumber"]);
    }

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT username FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
             // Close statement
        mysqli_stmt_close($stmt);   
    }

    //Address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter your address.";
    } else {
        $address = trim($_POST["address"]);
    }

    //Email
    if(empty(trim($_POST["email"]))){
        $email_err = "Plese enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty(trim($_POST["score"]))){
        $score_err = "Please enter your English score.";
    } else {
        $score = trim($_POST["score"]);
    }
    
    // Check input errors before inserting in database
    if(empty($fullname_err) && empty($phonenumber_err) && empty($username_err) && empty($address_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO user (isAdmin, fullname, phonenumber, username, address, email, password, score) VALUES (0,?, ?, ?, ?, ?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sissssi", $param_fullname, $param_phonenumber, $param_username, $param_address, $param_email, $param_password,$param_score);
            
            // Set parameters
            $param_fullname = $fullname;
            $param_phonenumber = $phonenumber;
            $param_username = $username;
            $param_address = $address;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_score = $score;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
			   header("location: login.php");
            } else{
                print_r($stmt);
                echo "Something went wrong. Please try again later.";
            }
            //if()

        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
    <link rel="stylesheet" href="">
    <style type="text/css">
        body{ 
            font: 20px sans-serif;
            text-align: center;
            font-weight: 100;
        }
        /* Add a black background color to the top navigation */
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

        .form-group{
            width: 450px;
            margin: 0 auto;
            font-family: sans-serif;
            text-align: center;
            font-weight: 100;
            font-size: 20px;
        }
        .form-group{
            margin: 0 auto;
            width: 300px;
        }
        .form-group input[type="text"] {
            width: 100%;
			padding: 15px;
			border: 1px solid #dddddd;
			margin-bottom: 15px;
			box-sizing:border-box;
        }
        .form-group input[type="password"]
        {
            width: 100%;
			padding: 15px;
			border: 1px solid #dddddd;
			margin-bottom: 15px;
			box-sizing:border-box;
        }
        .form-group input[type="submit"],
        .form-group input[type="reset"]
         {
			width: 25%;
			padding: 5px;
			background-color: #535b63;
			border: 0;
			box-sizing: border-box;
			cursor: pointer;
			font-weight: bold;
			color: #ffffff;
        }
        
    </style>
</head>
<body>
    <div class="wrapper">
        
         <div class="topnav">
            <a href="index.html">Home</a>
            <a href="#news">About Us</a>
            <a href="#contact">Courses</a>
            <a href="login.php">Login</a>
            <a class="active" href="registration.php">Register</a>
          </div>
        
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
       
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                <label>Fullname</label>
                <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
                <span class="help-block"><?php echo $fullname_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($number_err)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="number" name="phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
                <span class="help-block"><?php echo $phonenumber_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    

            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $addressname; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($score_err)) ? 'has-error' : ''; ?>">
                <label>English Scofe</label>
                <input type="number" name="score" class="form-control" value="<?php echo $score; ?>">
                <span class="help-block"><?php echo $score_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <br>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        
    </div>    
</body>
</html>