<?php 

require_once 'db_conn6.php';

if (isset($_GET["delete"])){
    $id = $_GET["delete"];

    $sql = "DELETE FROM user WHERE userId = $id" ;
    if($connect->query($sql) === TRUE)
    {
        echo "<center><h3>Succesfuly Delted </h3><center>";
        header("refresh:1 url=home.php");
    } else {
        echo "error dhu check your code again";
    }

}

$connect->close();

?>