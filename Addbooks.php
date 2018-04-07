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
                <table width="800">
                    <tr>
                        <th><section class='const'>ISBN</section></th>
                        <th><input type="text" name="ISBN" pattern="[0-9]{10,13}" title="Must be 10 to 13 digits"></th>
                    </tr>
                    <tr>
                        <th><section class='const'>Title</section></th>
                        <th><input type="text" name="Title" ></th>
                    </tr>
                    <tr>
                        <th><section class='const'>Author 1</section></th>
                        <th><input type="text" name="author1"></th>

                    </tr>
                    <tr>
                        <th><section class='const'>Author 2</section></th>
                        <th><input type="text" name="author2"></th>

                    </tr>
                    <tr>
                        <th><section class='const'>Author 3</section></th>
                        <th><input type="text" name="author3"></th>

                    </tr>

                    <tr>
                        <th><section class='const'>Price</section></th>
                        <th><input type="text" name="Price" pattern="[0-9]{0,99}.[0-9]{0,99}" title="Must be in the form (23.54)"></th>
                    </tr>
                    <tr>
                        <th><section class='const'>Stock</section></th>
                        <th><input type="text" name="Stock" pattern="[0-9]{0,999}" title="must be under 1000"></th>
                    </tr>

                    <tr>
                        <th><section class='const'>TypeID</section></th>
                        <th><input type="int" name="TID" pattern="[0-9]{1,100}" title="must be under 100"></th>
                    </tr>
                    <tr>
                        <th><section class='const'>Year</section></th>
                        <th><input type="text" name="Year" pattern="[0-9]{4}" title="must be four digits"></th>
                    </tr>   
                </table>
            </div>
            <br>
            <br>
            <center>
                <input type="submit" value="ADD" name="ADD">
            </center>s
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