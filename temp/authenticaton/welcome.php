<?php 

session_start();

// if (!isset($_SESSION['username'])) {
//     header("Location: index.php");
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <?php echo "<h1>Welcome " . $_SESSION['username'] . "</h1>"; ?>
    <a href="logout.php">Logout</a>

    <br>

    <a href="display.php">click here to view all the registered users</a>
</body>
</html>





<!-- 
home page->
navbar-
    top right -> profile
    
show joined classes
create class icon 
myworkplace



clicked class->  -->




