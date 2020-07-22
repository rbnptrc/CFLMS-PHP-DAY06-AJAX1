<?php
ob_start();
session_start();
require_once 'db_conn6.php';

// it will never let you open index(login) page if session is set
if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
    exit;
}

$error = false;

if (isset($_POST['btn-login'])) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if (empty($email)) {
        $error = true;
        $emailError = "Please enter your email address.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    }

    if (empty($pass)) {
        $error = true;
        $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

        $password = hash('sha256', $pass); // password hashing - sha256
        //this needs checking again *
        $res = $connect->query("SELECT userId, userName, userPass FROM user WHERE userEmail='$email'");
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $count = mysqli_num_rows($res); // if uname/pass is correct it returns must be 1 row

        if ($count == 1 && $row['userPass'] == $password) {
            $_SESSION['user'] = $row['userId'];
            header("Location: home.php");
        } else {
            $errMSG = "Incorrect Credentials, Try again...";
        }
    }
    // Close connection
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEW CRUD APP</title>
    <!--Bootstrap-->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="home.php">Employee APP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="register.php">Register</a>
        </div>
    </div>
</nav>

<body>

    <div class="row justify-content-center">
        <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

            <h2>Log in</h2>
            <hr/>

            <?php
            if (isset($errMSG)) {
                echo $errMSG;
            ?>
            <?php
            }    //* some php wrapping stuff ?
            ?>
           
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Your Email" maxlength="40" />
                <span class="text-danger"><?php echo $emailError; ?></span>
           
                <label>Password</label>
                <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                <span class="text-danger"><?php echo $passError; ?></span>
           
                <hr/>
                <button type="submit" name="btn-login" class="btn btn-primary">Log In</button>
                <hr/>
        
            <a href="register.php"><button type="submit" class="btn btn-info">Register Here</button></a>

        </form>

    </div>

</body>
</html>
<?php ob_end_flush(); ?>