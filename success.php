<?php
session_start();
require 'connection.php';

// Redirect if user is not logged in
if (!isset($_SESSION['email'])) {
    header('location:index.php');
    exit();
}

// Fetch the logged-in user's ID from the database using their email
$email = $_SESSION['email'];
$user_query = "SELECT id FROM users WHERE email='" . mysqli_real_escape_string($con, $email) . "' LIMIT 1";
$user_result = mysqli_query($con, $user_query) or die(mysqli_error($con));

if (mysqli_num_rows($user_result) > 0) {
    $row = mysqli_fetch_assoc($user_result);
    $user_id = intval($row['id']);

    // Update the order status for this user
    $confirm_query = "UPDATE users_items SET status='Confirmed' WHERE user_id=$user_id";
    $confirm_query_result = mysqli_query($con, $confirm_query) or die(mysqli_error($con));
} else {
    die("User not found.");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Art Gallery</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <div>
            <?php
                require 'header.php';
            ?>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-xs-6">
                       <center> 
                           <div class="panel panel-primary">
                                <div class="panel-heading"></div>
                                <div class="panel-body">
                                    <p>Your order is confirmed. Thank you for shopping with us. 
                                    <a href="products.php">Click here</a> to purchase any other item.</p>
                                </div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
            <center>
                <th><a href="payment.php?id=<?php echo $user_id ?>" class="btn btn-primary">Pay Now</a></th>
            </center>
            <footer class="footer">
               <div class="container">
                <center>
                   <p>Contact us via our email id: art@artgallery.com <br>
                   You can also use our phone number: 9988665512</p>
               </center>
               </div>
           </footer>
        </div>
    </body>
</html>
