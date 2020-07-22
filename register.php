<?php


ob_start();
session_start(); // start a new session or continues the previous
if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home.php
}

include_once 'db_conn6.php';

$error = false;
if (isset($_POST['btn-signup'])) {

    // sanitize user input to prevent sql injection
    $name = trim($_POST['name']);

    //trim - strips whitespace (or other characters) from the beginning and end of a string
    $name = strip_tags($name);

    // strip_tags — strips HTML and PHP tags from a string
    $name = htmlspecialchars($name);

    // htmlspecialchars converts special characters to HTML entities
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    // basic name validation
    if (empty($name)) {
        $error = true;
        $nameError = "Please enter your full name.";
    } else if (strlen($name) < 3) {
        $error = true;
        $nameError = "Name must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $error = true;
        $nameError = "Name must contain alphabets and space.";
    }

    //basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $sql = "SELECT userEmail FROM user WHERE userEmail='$email'";
        $result = $connect->query($sql);
        $res = $result->fetch_assoc(); //noted*
        if ($res->num_rows != 0) {   //change
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }
    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have atleast 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $pass);

    // if there's no error, continue to signup
    if (!$error) {

        $sql = "INSERT INTO user (userName, userEmail, userPass) VALUES('$name','$email','$password')";
        #$res = mysqli_query($conn, $query);

        if ($connect->query($sql) === TRUE) { //change
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            unset($name);
            unset($email);
            unset($pass);
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
        }
    }
}
// Close connection
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Regs System</title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="home.php">Register App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="register.php">Register</a>
            <span class="navbar-text"> </span>
        </div>
    </div>
</nav>

<body>
    <div class="container">

        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <h2>Register</h2>
            <hr />
            <?php
            if (isset($errMSG)) {

            ?>
                <div class="alert alert-<?= $errTyp ?>">
                    <?= $errMSG; ?>
                </div>
            <?php
            }  //* some php wrapping stuff ?
            ?>

            <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
            <span class="text-danger"> <?php echo $nameError; ?> </span>

            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
            <span class="text-danger"> <?php echo $emailError; ?> </span>

            <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
            <span class="text-danger"> <?php echo $passError; ?> </span>
            <hr />

            <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Register</button>
            <hr />

            <a href="home.php"> <button type="submit" class="btn btn-success">Go Log in</button></a>

        </form>

    </div>

</body>

</html>
<?php ob_end_flush(); ?>