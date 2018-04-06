<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>671BookStore</title>
        <link href="style.css" rel="stylesheet">
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
        <h1>processed Purchases</h1>
        <?php
        $con = mysqli_connect("dbproject.saadmtsa.club", "root", "password", "dbproject");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $query = "(Select * 
                      from orders
                      Where State = 3)";

        $result = mysqli_query($con, $query);
        $table = mysqli_fetch_all($result);



        foreach ($table as $row) {

            if ($row[2] <= 2) {
                $State1 = "Unprocessed";
            } else {
                $State1 = "Processed";
            }

            echo "<center>
                            <div class='bookInfo'>
                                <h4>OrderID: $row[0]</h4>
                                <h4>UserName: $row[1]</h4>
                                <h4>State: $State1</h4>
                                <h4>DateTime: $row[3]</h4>
                                
                            </div>
                          <br padding=20px></br>
                        </center> ";
        }
        if (isset($_POST['done'])) {
            header('Location: admin.php');
            exit();
        }
        $con->close();
        ?>

    </body>

</html>
