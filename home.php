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
<!DOCTYPE html>
<html>

<head>
    <title>Hey Welcome - <?= $userRow['userName']; ?></title>
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>


<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Employee APP</a>
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
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
            </ul>

            <span class="navbar-text">
                <i class="fa fa-user"></i>
                <?= $userRow['userName']; ?>
            </span>

        </div>
    </nav>

    <h1>Hello! <?= $userRow['userName']; ?></h1>
    <h2>You may Edit the employee Info</h2>
    <br>
<hr>


    <!---Insert Area --->
    <div class="container">
        <h3>Add New Employee</h3>

        <div class="form-group row justify-content-center">
            
            <form id="submit"> <!-- action="addmore.php" method="post" --->

                <label>User Name</label>
                <input type="text" name="userName">

                <label>Position</label>
                <input type="text" name="position">

                <input type="submit" class="btn btn-success">
            </form>
        </div>
    </div>
<br>
<br>


    <?php
    // display employee data + info

    $sql = "SELECT * FROM user";
    $res = $connect->query($sql);

    //pre_r($res);

    ?>
    <div class="container">

        <div class="form-group row justify-content-center" id="read"> 

        </div>

    </div>


    <div class="border border-light p-3 mb-4">
        <div class="text-center">
            <a href="logout.php?logout"><button type="button" class="btn btn-danger">Sign Out</button></a>
        </div>
    </div>
    </div>

    <!--Ajax scripts--->
    <script>

 //** ** ** */ Get info from Read into Home section through Function
function readInfo(){
    var request;
    request = $.ajax({
       url: "read.php", // * refers now to to the action page method
       type: "post"  // * rferes to the usual method named post
        // *! holds key and value
   });

   // Callback handler that will be called on success
   request.done(function (response, textStatus, jqXHR){
       // Log a message to the console
       document.getElementById("read").innerHTML=response;
       //document.getElementById("result").innerHTML =response;
   });
}

// Variable to hold request
var request;
readInfo();
// Bind to the submit event of our form // *>identification id of form = trigger event
$("#submit").submit(function(event){

   // Prevent default posting of form - put here to work in case of errors
   event.preventDefault();

   // Abort any pending request
   if (request) {
       request.abort();
   }
   // setup some local variables
   var $form = $(this); // * refferes to the id used = submit

   // Let's select and cache all the fields
   var $inputs = $form.find("input, select, button, textarea"); // *all tags covered - adjustable

   // Serialize the data in the form
   var serializedData = $form.serialize(); // * selects elements refers to $_POST method

   // Let's disable the inputs for the duration of the Ajax request.
   // Note: we disable elements AFTER the form data has been serialized.
   // Disabled form elements will not be serialized.
   $inputs.prop("disabled", true);

   // Fire off the request to /form.php
   request = $.ajax({
       url: "addmore.php", // * refers to the usual action method
       type: "post",  // * rferes to the usual method named post
       data: serializedData // * holds key and value
   });

   // Callback handler that will be called on success
   request.done(function (response, textStatus, jqXHR){
       // Log a message to the console
       console.log("Hooray, it worked!");
       console.log(response); // double check that
       readInfo();
       //document.getElementById("result").innerHTML =response;
   });

   // Callback handler that will be called on failure
   request.fail(function (jqXHR, textStatus, errorThrown){
       // Log the error to the console
       console.error(
           "The following error occurred: "+
           textStatus, errorThrown
       );
   });

   // Callback handler that will be called regardless
   // if the request failed or succeeded
   request.always(function () {
       // Reenable the inputs
       $inputs.prop("disabled", false);
   });
});

</script>

</body>
</html>
<?php ob_end_flush(); ?>