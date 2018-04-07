<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="style.css" rel="stylesheet">
        <title>671BookStore</title>
    <script type='text/javascript' src="scripts.js"></script>
    </head>
    
    <body onload="showMenu()">
        <h1>
            671 BookStore
        </h1>
        <div class = "menu" style="margin-bottom: 2em;">
        <center>
            <a href=".">Home</a>
            <a href="books.php">Books</a>
            <a href="search.php">Search</a>
            <a id="signin" style='display:none' href="sign_in.php">Sign in</a>
            <a id="register" style='display:none' href="register.php">Register</a>
            <a id="myaccount" style='display:none' href="myaccount.php">My Account</a>
            <a id="admin" style='display:none' href="admin.php">Admin</a>
            <a id="signout" style='display:none' onclick="signout()" href="index.php">Sign Out</a>
        </center>
        </div>
    </body>
    <h2><a id="Addbooks" color="blue" href="Addbooks.php">Add Books</a></h2>
    <h2><a id="Statistics" href="Statistics.php">Statistics</a></h2>
    <h2><a id="Processpurchase" href="Processpurchase.php">Process Purchases</a></h2>
    <h2><a id="outofstock" href="Outofstock.php">Out of Stock</a></h2>
</html>