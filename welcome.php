<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
if (!isset($username)) {
    $username = '';
}
if (!isset($email)) {
    $email = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/homestyle.css" />

    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>
    <section class="form-dark">
        <div class="container">

            <div class="card card-image">
                <div class="text-white rgba-stylish-strong py-5 px-5 z-depth-4">

                    <div class="img_container">
                        <img src="img/avatar.svg" />
                        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Your details are.</h1>
                    </div>
                    <div>
                        <div class="md-form pb-3">
                            <td>
                                <button class=" btn focus  ">First Name is :</button> <button class="btn focus"> <?php echo $_SESSION['first_name']; ?></button>
                            </td>
                        </div><br>

                        <div class="md-form pb-3">
                            <button class=" btn focus  ">Your Last Name is :</button> <button class=" btn focus  "> <?php echo $_SESSION['last_name']; ?></button>
                        </div><br>

                        <div class="md-form pb-3">
                            <button class=" btn focus  ">Your EmailId is :</button> <button class=" btn focus  "> <?php echo $_SESSION['email']; ?></button>
                        </div><br>

                        <div class="md-form pb-3">
                            <button class=" btn focus  ">Your Mobile is :</button> <button class=" btn focus  "> <?php echo $_SESSION['mobile']; ?> </button>
                        </div><br>

                        <div class="md-form pb-3">
                            <button class=" btn focus  ">Your Age is :</button> <button class=" btn focus  "> <?php echo $_SESSION['age']; ?> </button>
                        </div><br>

                        <div class="md-form pb-3">
                            <p>
                                <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
                                <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
</body>
<script type="text/javascript" src="js/main.js"></script>

</html>