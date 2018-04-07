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

        <form  method="POST">
            <div class="filter">
                <h1>Add Books</h1>
                <table width="800" class='responstable'>
                    <tr>
                        <td><section class='const'>ISBN</section></td>
                        <td><input type="text" name="ISBN" pattern="[0-9]{10,13}" title="Must be 10 to 13 digits" style='width:100%'></td>
                    </tr>
                    <tr>
                        <td><section class='const'>Title</section></td>
                        <td><input type="text" name="Title" style='width:100%'></td>
                    </tr>
                    <tr>
                        <td><section class='const'>Author 1</section></td>
                        <td><input type="text" name="author1" style='width:100%'></td>

                    </tr>
                    <tr>
                        <td><section class='const'>Author 2</section></td>
                        <td><input type="text" name="author2" style='width:100%'></td>

                    </tr>
                    <tr>
                        <td><section class='const'>Author 3</section></td>
                        <td><input type="text" name="author3" style='width:100%'></td>

                    </tr>

                    <tr>
                        <td><section class='const'>Price</section></td>
                        <td><input type="text" name="Price" pattern="[0-9]{0,99}.[0-9]{0,99}" title="Must be in the form (23.54)" style='width:100%'></td>
                    </tr>
                    <tr>
                        <td><section class='const'>Stock</section></td>
                        <td><input type="text" name="Stock" pattern="[0-9]{0,999}" title="must be under 1000" style='width:100%'></td>
                    </tr>

                    <tr>
                        <td><section class='const'>TypeID</section></td>
                        <td><input type="int" name="TID" pattern="[0-9]{1,100}" title="must be under 100" style='width:100%'></td>
                    </tr>
                    <tr>
                        <td><section class='const'>Year</section></td>
                        <td><input type="text" name="Year" pattern="[0-9]{4}" title="must be four digits" style='width:100%'></td>
                    </tr>   
                </table>
            </div>
            <br>
            <br>
            <center>
                <input type="submit" value="ADD" name="ADD">
            </center>
        </form>
        <?php
        $con = mysqli_connect("dbproject.saadmtsa.club", "root", "password", "dbproject");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        if (isset($_POST['ADD'])) {
            $isbn1 = $_POST['ISBN'];
            $title1 = $_POST['Title'];
            $typeID1 = $_POST['TID'];
            $year1 = $_POST['Year'];
            $stock1 = $_POST['Stock'];
            $price1 = $_POST['Price'];
            $author1 = $_POST['author1'];
            if('author2'!="")
                $author2 = $_POST['author2'];
            else
                $author2 = NULL;
            if('author3'!="")
                $author3 = $_POST['author3'];
            else 
                $author3 = NULL; 
           



            $myquery = "INSERT INTO books 
                     VALUES ('$isbn1','$title1','$typeID1','$year1','$stock1','$price1');";
          
            $myquery1 = "INSERT INTO authors 
                        VALUES (null,'$author1');
                        Set @last_ID1 = LAST_Insert_ID();
                        INSERT INTO authors_books (ISBN,AuthorID)
                        VALUES ('$isbn1',@last_ID1);";
            
            if($author2==NULL){
            $myquery1 = $myquery1."INSERT INTO authors 
                        VALUES (null,'$author2');
                        Set @last_ID2 = LAST_Insert_ID();
                        INSERT INTO authors_books (ISBN,AuthorID)
                        VALUES ('$isbn1',@last_ID2);";
            }
            if($author3==NULL){
            $myquery1 = $myquery1."INSERT INTO authors 
                        VALUES (null,'$author3');
                        Set @last_ID3 = LAST_Insert_ID();
                        INSERT INTO authors_books (ISBN,AuthorID)
                        VALUES ('$isbn1',@last_ID3);";
            }
           
            

            if ($con->query($myquery) === TRUE && $con->multi_query($myquery1) === True) {
                echo "Book successfully added";
            } else {
                echo "Book adding failed";
            }

            $con->close();
        }
        ?>




    </body>
</html>