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
                <input type="text" name="username" style="width:35%" pattern="[A-Za-z0-9]{5,20}" title="Only 5-20 Alphanumeric characters." required>
                <h3>Password</h3>
                <input type="password" name="password" maxlength="20" style="width:35%" required>
                <h3>EMail</h3>
                <input type="email" name="email" maxlength="50" style="width:35%" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                <br>
                <br>
                <input type="submit" value="Register" name="Register">
            </form>
            <?php
                $con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                if (isset($_POST['Register']))
                {
                    $username =  $_POST['username'];
                    $password =  $_POST['password'];
                    $email =  $_POST['email'];
                    $address =  $_POST['address'];
                    $ccno =  $_POST['ccno'];
                    $myquery = "INSERT INTO users VALUES('$username',MD5('$password'),'$email',1,NOW());";
                    if ($con->query($myquery) === TRUE) {
                        echo "Account has been created successfully";
                    } else {
                        echo "EMail or Username is already in use";
                    }

                    $con->close();
                    
                }
            ?>
		</center>	
    </body>
</html>