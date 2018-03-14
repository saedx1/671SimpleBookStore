<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>671BookStore</title>
        <link href="style.css" rel="stylesheet">
    </head>
    
    <body>
        <h1>
            671 BookStore
        </h1>
        <div class="menu" style="margin-bottom: 2em;">
        <center>
            <a href=".">Home</a>
            <a href="books.php">Books</a>
            <a href="search.html">Search</a>
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
                $isbn = $_GET['isbn'];
                $query = "SELECT Title, TypeName, Year, Stock, Price,AuthorName FROM `BooksAuthors` WHERE ISBN = '$isbn';";
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
                            <input type=\"submit\" value=\"Add To Cart\" class='bookinput'>
                        </center>";
            }
        ?>
    </body>
</html>