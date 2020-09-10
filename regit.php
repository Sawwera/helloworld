
<?php
    include 'configuration.php';

    $fullname = $phonenumber = $address = $gName = $gNumber = $password = $email = $confirm_password = "";

    $fullname_err = $phonenumber_err = $address_err = $gName_err = $gNumber_err = $password_err = $email_err = $confirm_password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        // Validate the username
        if(empty(trim($_POST["fullname"]))){
            $username_err = "Please enter your name.";
        } else{
            // Prepare a select statement
            $sql = "SELECT fullname FROM user WHERE fullname = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_fullname);
                
                // Set parameters
                $param_fullname = trim($_POST["fullname"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $fullname_err = "This name is already taken.";
                    } else{
                        $fullname = trim($_POST["fullname"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
                 // Close statement
            mysqli_stmt_close($stmt);   
        }

        // Phone Number
        if(empty(trim($_POST["phonenumber"]))){
            $fullname_err = "Please enter your phone number.";
        } elseif (strlen(trim($_POST["phonenumber"])) < 10) {
            $phonenumber_err = "Phone number must have at least 10 digits";
        } else {
            $phonenumber = trim($_POST["phonenumber"]);
        }

        // Address
        if(empty(trim($_POST["address"]))){
            $address_err = "Please enter your address.";
        } else {
            $address= trim($_POST["address"]);
        }

        //Guardian Name
        if(empty(trim($_POST["gName"]))){
            $gName_err = "Please enter your guardian name.";
        } else {
            $gName = trim($_POST["gName"]);
        }

        //Guardian Number
        if(empty(trim($_POST["gNumber"]))){
            $gNumber_err = "Please enter your guardian number.";
        } else {
            $gNumber = trim($_POST["gNumber"]);
        }

        //Email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter your email.";
        } else {
            $email = trim($_POST["email"]);
        }
        
        // Validate Password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST["password"]);
        }

        // Validate Confrim Password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

        if(empty($fullname_err) && empty($phonenumber_err) && empty($address_err) && empty($gName_err) && empty($gNumber_err) && empty($email_err) && empty($password_err)) {

            $sql = "INSERT INTO user (fullname, phonenumber, address, gName, gNumber, email, password) VALUES (?, ?, ?, ?, ?, ?, ?);";

            if($stmt = mysqli_prepare($link, $sql)){

                mysqli_stmt_bind_param($stmt, "sississ", $param_fullname, $param_phonenumber, $param_address, $param_gName, $param_gNumber, $param_email, $param_password);

                $param_fullname = $fullname;
                $param_phonenumber = $phonenumber;
                $param_address = $address;
                $param_gName = $gName;
                $param_gNumber = $gNumber;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT);

                if(mysqli_stmt_execute($stmt)){
                    header("location: login.php");
                } else {
                    echo "Something went wrong. Please try again later.";
                }
            }

            mysqli_stmt_close($stmt);
        }


        mysqli_close($link);
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <style>
            body{ 
                font: 20px sans-serif;
                text-align: center;
                font-weight: 100;
            }
            
            P{
                font-size: 25px;
            }

            /* Add a black background color to the top navigation */
            .topnav {
                background-color: #333;
                overflow: hidden;
                margin: 10px 10px 10px;
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

            .myButton input[type="submit"]{
                background-color: #535b63;
            }

            .myButton input[type="reset"]
            {
                
                background-color: #535b63;
                color: white;
            }

        </style>
    </head>
    

    <body>

        <div class="topnav">
            <a href="index.html">Home</a>
            <a href="#news">About Us</a>
            <a href="#contact">Courses</a>
            <a href="login.php">Login</a>
            <a class="active" href="registration.php">Register</a>
          </div>

        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>

        <div class="container myContainer">
            <div class="row myRow">
                <div class="col-md-6 myCol">

                    <div id="ui">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">

                            <div class="row myRow">
                                <div class="col-md-6 myCol <?php echo (!empty($fullname_err)) ? 'has-error' : ''; ?>">
                                    <lable>Full Name</lable>
                                    <input type="text" name="fullname" class="form-control" value="<?php echo $fullname; ?>">
                                    <span class="help-block"><?php echo $fullname_err; ?></span>
                                </div>

                                <div class="col-md-6 myCol <?php echo (!empty($phonenumber_err)) ? 'has-error' : ''; ?>">
                                    <lable>Phone Number</lable>
                                    <input type="number" name="phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
                                    <span class="help-block"><?php echo $phonenumber_err; ?></span>
                                </div>
                            </div>

                            <br>

                                <div class="<?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                                    <lable >Address</lable>
                                    <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                                    <span class="help-block"><?php echo $address_err; ?></span> 
                                </div>

                            <br>

                            <div class="row myRow">
                                <div class="col-md-6 myCol" <?php echo (!empty($gName_err)) ? 'has-error' : ''; ?>>
                                    <lable>Guardian Name</lable>
                                    <input type="text" name="gName" class="form-control" value="<?php echo $gName; ?>">
                                    <span class="help-block"><?php echo $gName_err; ?></span>
                                </div>

                                <div class="col-md-6 myCol <?php echo (!empty($gNumber_err)) ? 'has-error' : ''; ?>">
                                    <lable>Guardian Phonenumber</lable>
                                    <input type="text" name="gNumber" class="form-control" value="<?php echo $gNumber; ?>">
                                    <span class="help-block"><?php echo $gNumber_err; ?></span>
                                </div>
                            </div>

                            <br>

                                <div class="<?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                    <lable>Email</lable>
                                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                                    <span class="help-block"><?php echo $email_err; ?></span>
                                </div>

                            <br>

                            <div class="row myRow">
                                <div class="col-md-6 myCol <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <lable>Password</lable>
                                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                    <span class="help-block"><?php echo $password_err; ?></span>
                                </div>

                                <div class="col-md-6 myCol <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                    <lable>Confirm Password</lable>
                                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                </div>
                            </div>
                            <br>

                            <div class="row myRow myButton">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <input type="reset" class="btn btn-default" value="Reset">
                            </div>
                            <br>

                            <div class="row myRow">
                                <p>Already have an account? <a href="login.php">Login here</a>.</p>
                            </div>
                        </form>
                    </div>
                </div>    
            </div>
            
        </div>

    </body>
</html>