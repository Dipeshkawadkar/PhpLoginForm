<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email  =  $first_name = $last_name = $gender = $age = $mobile =  "";
$username_err = $email_err = $password_err = $confirm_password_err =  $first_err = $last_err = $gerr = $age_err = $mobile_err = "";
$boolen = false;
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if(isset($_POST['submit'])){

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM userss WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    //Validates email
    if (empty($_POST["email"])) {
        $email_Err = "You Forgot to Enter Your Email!";
    } else {
        $email = trim($_POST["email"]);
        // check if e-mail address syntax is valid
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)) {
            $email_Err = "You Entered An Invalid Email Format";
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,12}$/', $_POST["password"])) {
        $password_err = "Password must have atleast 6 characters, alphanumeric,";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    //

    //Validates firstname
    if (empty($_POST["first_name"])) {
        $first_Err = "You Forgot to Enter Your First Name!";
    } else {
        $first_name = trim($_POST["first_name"]);
        //Checks if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $first_name)) {
            $first_Err = "Only letters and white space allowed";
        }
    }
    if (empty($_POST["last_name"])) {
        $last_Err = "You Forgot to Enter Your Last Name!";
    } else {
        $last_name = trim($_POST["last_name"]);
        //Checks if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $last_name)) {
            $last_Err = "Only letters and white space allowed";
        }
    }
    //Mobile Number
    $c = $_POST['mobile'];

    if (preg_match("/^[0-9]{10}+$/", $c)) {
        $mobile = $c;
        echo "mobile number is valid<br>";
    } else {
        $mobile_err = "enter valid mobile number<br>";
    }
    $age = $_POST['age'];

    //Gender
    //  if (empty($_POST["gender"])) {
    //         $gerr = "Gender Required...!";
    //         $boolen = true;
    //     } else {
    //         $gender = trim(($_POST["gender"]));
    //         $boolen = false;
    //     }

    if (isset($_POST["ck1"])) {
        $boolen = true;
    } else {
        $boolen = false;
    }


    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)   && empty($first_err) && empty($last_err) && empty($gerr) && empty($age_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO userss (username, password, confirm_password, email, first_name, last_name, age, mobile ) VALUES (?,?,?,?,?,?,?,?)";
        // $sql = "INSERT INTO userss (username, password ) VALUES (?,?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_username, $param_password, $param_confirm_password, $param_email, $param_first_name, $param_last_name, $param_age, $param_mobile);
            // mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_confirm_password = password_hash($confirm_password, PASSWORD_DEFAULT);
            $param_email = $email;
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_gender = $gender;
            $param_age = $age;
            $param_mobile = $mobile;


            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign_Up Form</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">


</head>

<body>
    <img class="wave" src="img/wave.png">
    <div class="container">
        <div class="img">
            <img src="img/bg.svg">
        </div>
        <div class="login-content">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation">
                <img src="img/avatar.svg">
                <h2 class="title">Sign up</h2>
                <p>Please fill this form to create an account.</p>

                <div class="input-div one  <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>Username</h5> -->
                        <input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>" required>
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                </div>

                <div class="input-div one   <?php echo (!empty($first_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>First Name</h5> -->
                        <input type="text" name="first_name" id="textfname" class="form-control" placeholder="First name" value="<?php echo $first_name; ?>" required>
                        <span class="help-block"><?php echo $first_err; ?></span>
                    </div>
                </div>

                <div class="input-div pass  <?php echo (!empty($last_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>Last Name</h5> -->
                        <input type="text" name="last_name" id="textlname" placeholder="Last Name" class="form-control" value="<?php echo $last_name; ?>" required>
                        <span class="help-block"><?php echo $last_err; ?></span>
                    </div>
                </div>

                <div class="input-div pass  <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>Email</h5> -->
                        <input type="text" placeholder="email" name="email" class="form-control" value="<?php echo $email; ?>" required>
                        <span class="help-block"><?php echo $email_err; ?></span>
                    </div>
                </div>

                <div class="input-div pass <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>Password</h5> -->
                        <input type="password" placeholder="Password" name="password" class="form-control" value="<?php echo $password; ?>" required>
                        <span class="help-block"><?php echo $password_err; ?></span>

                    </div>
                </div>

                <div class="input-div pass <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>Confirm Password</h5> -->
                        <input type="password" placeholder="Confirm Password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>" required>
                        <span class="help-block"><?php echo $confirm_password_err; ?></span>

                    </div>
                </div>

                <div class="input-div pass  <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>Age</h5> -->
                        <input type="text" name="age" id="age" placeholder="Age" class="form-control" value="<?php echo $age; ?>" required>
                        <span class="help-block"><?php echo $age_err; ?></span>
                    </div>
                </div>

                <div class="input-div pass  <?php echo (!empty($mobile_err)) ? 'has-error' : ''; ?>">
                    <div class="i">
                        <i class="fas fa fa-phone-alt"></i>
                    </div>
                    <div class="div">
                        <!-- <h5>Mobile</h5> -->
                        <input type="text" name="mobile" id="mobile" placeholder="mobile" class="form-control" value="<?php echo $username; ?>" required>
                        <span class="help-block"><?php echo $mobile_err; ?></span>
                    </div>
                </div>

                <div class="radios <?php echo (!empty($gerr)) ? 'has-error' : ''; ?>">
                    <h4>Gender :</h4>
                    <input type="radio" name="gender" value="<?php echo $gender; ?>" required>
                    <label for="">Male</label>

                    <input type="radio" name="gender" value="<?php echo $gender; ?>" required>
                    <label for="">Female</label>
                    <span class="help-block"><?php echo $gerr; ?></span>
                </div>

                <div class="form-group">
                    <div class="form-check p1-0">
                        <input class="form-check-input" type="checkbox" value="" name="ck1" id="ckbox" id="invalidCheck2" required>
                        <label class="form-check-label" for="invalidCheck2">
                            <span>Agree to terms and conditions</span>
                        </label>
                        <!-- <div class="invalid-feedback">
                            You must agree before submitting.
                        </div> -->
                    </div>
                </div>

                <div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-default" value="Reset">
                    <p>Already have an account? <a href="login.php">Login here</a>.</p>

                </div>

            </form>
        </div>
    </div>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>