<html>
    <head>
        <meta charset="iso-8859-1">
        <link href="style.css" rel="stylesheet">
        <title>671BookStore</title>
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
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
        <center>
            <?php
                $con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                $perPage = 10;
                $limitA = 0;
                $limitB = $perPage;
                $mypage = 1;
                if(isset($_GET["page"]))
                {
                    $mypage = $_GET["page"];
                    $limitA = ($mypage - 1) * $perPage;
                }
                $query = "SELECT IF(CHAR_LENGTH(Title)>70,CONCAT(SUBSTR(Title,1,68),'...'),Title),TypeName,Year,ISBN,Format(Price,2) FROM BooksAuthors GROUP BY ISBN LIMIT $limitA,$perPage;";
                $count = "SELECT COUNT(*) FROM `books`;";
                if(isset($_POST['Search']))
                {
                    $book = $_POST['Book'];
                    $auth = $_POST['Author'];
                    $from = $_POST['YFrom'];
                    if($from == '')
                        $from = 0;
                    $to = $_POST['YTo'];
                    if($to == '')
                        $to = 3000;
                        
                    $query = "SELECT IF(CHAR_LENGTH(Title)>50,CONCAT(SUBSTR(Title,1,68),'...'),Title),TypeName,Year,ISBN,Format(Price,2) FROM BooksAuthors WHERE title like '%$book%' and year >= $from and year <= $to GROUP BY ISBN LIMIT $limitA,$perPage;";
                    $count = "SELECT COUNT(*) FROM `books` WHERE title like '%$book%' and year >= $from and year <= $to;";
                }
                $i = 0;
//                echo $query;
                $result = mysqli_query($con,$query);            
                $table = mysqli_fetch_all($result);
                //$myUser = $_COOKIE['username']; old version, delete when stable   
                foreach($table as $row)
                {
                    $result = mysqli_query($con, "SELECT A.AuthorName From authors_books B JOIN Authors A ON B.AuthorID = A.AuthorID WHERE B.ISBN = '$row[3]';");
                    $authorsCol = mysqli_fetch_all($result);
                    $authors = '';
                    foreach($authorsCol as $author)
                    {
                        $authors = "$authors, $author[0]";
                    }
                    $authors = substr($authors, 2);
			
		    $cart='display:none';  //cart is not enabled/visible
		    
		    //check if user is logged in, if so, make cart visible
		    if(isset($_COOKIE['username'])){
 		      $cart = ''; 
		    }
			



                    echo "  <a class='booka' href='book_page.php?isbn=$row[3]'>
                                <div class=\"book\">
                                    <table>
                                        <tr>
                                            <td>
                                                <h1>$row[0]</h1>
                                            </td>
                                            <td>
                                                <h2>$authors</h2>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2'>
                                                <h3>$row[1]</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2'>
                                                <h3>Publish Year: $row[2]</h3>
                                            </td>                            
                                        </tr>
                                        <tr>
                                            <td colspan='2'>
                                                <h3>ISBN: $row[3]</h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2'>
                                                <h4>$row[4]$</h4>
                                            </td>
                                        </tr>
                                    </table>
                                    <form method='POST'>
                                        <a href='orders.php?ISBN=$row[3]' style='$cart'>Add to Cart</a>
                                    </form>
                                </div>
                                </a>
                            ";
                }
                $result = mysqli_query($con,$count);
                $row = mysqli_fetch_row($result);
                $pages = ceil($row[0] / $perPage);
                if($mypage > $pages)
                    echo "Error 404; Not Found!";
                else
                {
                    $num = $perPage;
                    if($limitA + $perPage > $row[0])
                        $num = $row[0] % 30;
                    $finalIdx = $limitA + $num;
                    $limitA = $limitA + 1;
                    echo "Showing $num Books ($limitA-$finalIdx) out of $row[0]<br>";
                    echo "<form action=\"books.php\">
                              Page:&nbsp<select name=\"page\" style='width=100%;'>";

                    for($x = 1; $x <= $pages; $x++)
                    {   
                        $selectIt = "";
                        if($mypage == $x)
                        {
                            $selectIt = "SELECTED";
                        }
                        echo "<option value=\"$x\" $selectIt>$x</option>";
                    }
                    echo "</select>
                          <input type='submit' value='Go'>
                          </form>";
                }
            ?>            
        </center>
    </body>
</html>
