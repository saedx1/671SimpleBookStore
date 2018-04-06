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
        <h1>Book Info</h1>
        <?php
            $con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            if(isset($_GET['isbn']))
            {
		
		$cart='display:none';  //cart is not enabled/visible
		    
		    //check if user is logged in, if so, make cart visible
		    if(isset($_COOKIE['username'])){
 		      $cart = ''; 
		    }
					
		
                $isbn = $_GET['isbn'];
                $user = $_COOKIE['username'];
                if($user == 'admin'){
                    $query = "SELECT Title, TypeName, Year, Stock, Price,AuthorName FROM `BooksAuthors` WHERE ISBN = '$isbn';";
                }
                else{
                $query = "SELECT Title, TypeName, Year, IF(Stock > 0, 'Available','Out of Stock'), Price,AuthorName FROM `BooksAuthors` WHERE ISBN = '$isbn';";
                }
                $result = mysqli_query($con, $query);
                $table = mysqli_fetch_all($result);
                $authors = '';
                
                foreach($table as $row)
                {
                        $authors = "$authors, $row[5]";
                }
                $authors = substr($authors, 2);
                $row = $table[0];
                echo "<center>
                            <div class='bookInfo'>
                                <h4><center>$row[0]</center></h4>
                                <h4>Authors: $authors</h4>
                                <h4>Genre: $row[1]</h4>
                                <h4>Year: $row[2]</h4>
                                <h4>Stock: $row[3]</h4>
                                <h4>Price: $row[4]$</h4>
                            </div>
                            <form method='POST'>
                               <h2><a href='orders.php?ISBN=$isbn' style='$cart'>Add to Cart</a></h2>
                            </form>
                        </center>";
            }
        ?>
    </body>

</html>
