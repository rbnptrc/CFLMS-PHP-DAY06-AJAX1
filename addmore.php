<?php 

#require_once 'db_conn6.php';

$connect = mysqli_connect("localhost", "root", "", "web_app");

$uname = $_POST["userName"];
$post = $_POST["position"];

$sql = "INSERT INTO user (userName, position) VALUES ('$uname', '$post')";

if($connect->query($sql) === TRUE)
{
    echo "<h3>succesfuly updated <h3><br> <a href='../home.php'>Back Home</a>";
    header("Refresh:1; url=home.php");
} else {
    echo "error dhu check your code again";
}

/*
if ($_POST){
    $uname = $_POST['userName'];
    $post = $_POST['position'];

    $sql = "INSERT INTO user (userName, position) VALUES ('$uname', '$post')";

    if($connect->query($sql) === TRUE)
    {
        echo "<h3>succesfuly updated <h3><br> <a href='../home.php'>Back Home</a>";
        header("refresh:1 url=home.php");
    } else {
        echo "error dhu check your code again";
    }

}*/

$connect->close();

?>