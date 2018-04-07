<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>671BookStore</title>
        <link href="style.css" rel="stylesheet">
        <script type='text/javascript' src="scripts.js"></script>
        
        <script>
//update cart

function updateState(OrderID){
/*
var http = new XMLHttpRequest();
var url = "updateOrder.php";
var Quantity = "NA"
if(Method=="updateQuantity"){
	Quantity= document.getElementById("cartQuantity"+ISBN).innerHTML;
	
	//remove HTML tags from input	
	Quantity = Quantity.replace(/<[^>]*(>|$)/,"");
}
console.log("ISBN:"+ISBN + " OrderID:"+OrderID+" Method:"+Method);
var params = "ISBN="+ISBN+"&OrderID="+OrderID+"&Method="+Method+"&Quantity="+Quantity;
http.open("POST", url, true);

//Send the proper header information along with the request
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
        alert(http.responseText);
    }
}
http.send(params);
*/



console.log(" OrderID:"+OrderID);
     
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("debug").innerHTML = this.responseText;
            }
        };
	
console.log(Method+"in scripts else");
	xmlhttp.open("GET","updateState.php?OrderID="+OrderID,true);
	
        
       xmlhttp.send();
    

}
</script>
        
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
        <h1>Unprocessed Purchases</h1>
        <?php
        $con = mysqli_connect("dbproject.saadmtsa.club", "root", "password", "dbproject");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        if(isset($_POST["orderid"]))
        {
            $orderid = $_POST["orderid"];
            $query = "UPDATE ORDERS SET STATE = 3 WHERE OrderID = '$orderid';";
            $con->query($query);
            $query = "UPDATE SHIPPING SET DELIVERY = NOW() + Interval 2 DAY WHERE OrderID = '$orderid';";
                    $con->query($query);

        }
        $query = "(Select * 
                      from orders
                      Where State = 2)";
        $result = mysqli_query($con, $query);
        $table = mysqli_fetch_all($result);

        foreach ($table as $row) {

            echo "<center>
                            <div class='bookInfo'>
                            <form action=\"Processpurchase.php\" method='POST'>
                              
                                <h4>OrderID: $row[0]</h4>
                                <h4>UserName: $row[1]</h4>
                                <h4>State: Unprocessed</h4>
                                <h4>DateTime: $row[3]</h4>
                                <button name='orderid' value='$row[0]' type='submit'>Process</button>
                             </form>
                            </div>
                          <br padding=20px></br>
                        </center> ";
        }
         $con->close();
        ?>
         </form>
    </body>

</html>