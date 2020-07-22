<?php
ob_start();
session_start();

require_once 'db_conn6.php';

// if session is not set this will redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
// select logged-in users details
$res = mysqli_query($connect, "SELECT * FROM user WHERE userId=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res, MYSQLI_ASSOC);
?>

<?php

if (isset($_GET['update'])) {
    $id = $_GET['update'];

    $sql = "SELECT * FROM user WHERE userId = $id";
    $result = $connect->query($sql);
    $row = $result->fetch_assoc();
}
$connect->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hey Welcome - <?= $userRow['userName']; ?></title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Register APP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
            </ul>

            <span class="navbar-text">
                <i class="fa fa-user"></i>
                <?= $userRow['userName']; ?>
            </span>

        </div>
    </nav>

    <br>
    <br>
<h3>Update Employee</h3>
    <div class="container">

        <div class="row justify-content-center">
            <form action="t_update.php" method="post">

                <input type="hidden" name="id" value="<?= $row['userId'] ?>">
                <label>User Name</label>
                <input type="text" name="userName" value="<?= $row['userName'] ?>">
                <label>Position</label>
                <input type="text" name="position" value="<?= $row['position'] ?>">
                <input type="submit" name="submit" class="btn btn-info">
            </form>
        </div>
    </div>

</body>

</html>