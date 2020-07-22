<?php 

require_once 'db_conn6.php';


if(isset($_POST['submit'])){
    $id = $_POST['id'];

    $uname = $_POST['userName'];
    $post = $_POST['position'];

    $sql = "UPDATE user SET userName='$uname', position='$post' WHERE userId= $id ";

    if($connect->query($sql) === TRUE)
    {
        echo "<center><h3>succesfuly updated </h3></center>";
        header("refresh:1 url=home.php");
    } else {
        echo "error dhu check your code again";
    }
}

$connect->close();

?>