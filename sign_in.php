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
        <center>	
            <form method="POST">
                 <h3>Username</h3>
                <input type="text" name="username" maxlength="20">
                <h3>Password</h3>
                <input type="password" name="password" maxlength="20">
                <br>
                <br>
                <input type="submit" value="Sign in" name="SignIn">
            </form>
            <?php
                $con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                if (isset($_POST['SignIn']))
                {
                    $username =  $_POST['username'];
                    $password =  $_POST['password'];
                    $myquery = "SELECT count(*),sum(type) FROM `users` WHERE `username` = '$username' AND `password` = MD5('$password');";
                    $result = mysqli_query($con,$myquery);
                    while($row = mysqli_fetch_row($result))
                    {
                        if($row[0] == '1')
                        {
                            echo "<script> signin('$username')</script>";
                            echo '<br>Successfully logged in!';
                        }
                        else
                        {
                            echo '<br>Wrong credentials!';
                            break;
                        }
                    }
                    
                }
            ?>
		</center>	
    </body>
</html>