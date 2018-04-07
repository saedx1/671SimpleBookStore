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
        <?php
        $con = mysqli_connect("dbproject.saadmtsa.club", "root", "password", "dbproject");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }


        $query = "Select ISBN, Title
                  From Books WHERE Stock = 0";

            $result = mysqli_query($con, $query);
            $table = mysqli_fetch_all($result);
            $t = 0;
            foreach ($table as $row) {
                if($t == 0)
                {
                    echo "<table class='responstable'>
                                <tr>
                                <th>ISBN</th>
                                <th>Title</th>
                                </tr>";
                    $t = 1;
                }
                
                echo "<tr>
                        <td>$row[0]</td>
                        <td>$row[1]</td>
                      </tr>";
            }
            if($t == 1)
                echo "</table>";
            else
                echo "<center><h1>No books are out of stock</h1></center>";
        
             ?>

    </body>

</html>





