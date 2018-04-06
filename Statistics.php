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
        <form  method="POST">
            <div class="filter">
                <h1>Activity report:</h1>
                <table width="800" padding="25px">
                    <tr>
                        <th><section class='const'>From Date</section></th>
                        <th><input type="text" name="FDate" pattern="[0-9]{4}-[0-9]{1,12}-[0-9]{1,31}" title="year, month, day: XXXX-XX-XX"></th>
                    </tr>
                    <tr>
                        <th><section class='const'>To Date</section></th>
                        <th><input type="text" name="TDate"pattern="[0-9]{4}-[0-9]{1,12}-[0-9]{1,31}" title="year, month, day: XXXX-XX-XX"></th>
                    </tr>
                </table>
            </div>
            <br>
            <br>
            <center>
                <input type="submit" value="Check" name="Check">
            </center>
        </form>
        <?php
        $con = mysqli_connect("dbproject.saadmtsa.club", "root", "password", "dbproject");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }


        if (isset($_POST['Check'])) {
            $HolderA = $_POST['FDate'];
            $HolderB = $_POST['TDate'];
            $b = $a . "World!";
            $FDate = $HolderA . " 00:00:00";
            $TDate = $HolderB . " 23:59:59";

            echo "$FDate              $TDate";




            $query = "Select orderitems.ISBN, books.Title, sum(orderitems.quantity)
                  From Orders join Orderitems on Orders.OrderID=Orderitems.OrderID join books on books.ISBN=orderitems.ISBN
                  WHERE DateTime BETWEEN '$FDate' AND '$TDate' AND orders.State!=1 Group by Orderitems.ISBN ";

            $result = mysqli_query($con, $query);
            $table = mysqli_fetch_all($result);

            foreach ($table as $row) {

                echo "<center>
                            <div class='bookInfo'>
                                
                                <h4>ISBN: $row[0]</h4>
                                <h4>Title: $row[1]</h4>
                                <h4>Books Sold: $row[2]</h4>
                                
                                   
                                
                            </div>
                          <br padding=20px></br>
                        </center> ";
            }
        }
             ?>

    </body>

</html>





