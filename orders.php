<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="style.css" rel="stylesheet">
        <title>671BookStore</title>
<script type='text/javascript' src="scripts.js"></script>
<script>
function showUser(str) {
	var user = getCookie('username');
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        showHideYears('1');
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        var from = document.getElementById('yearfrom').value;
        var to = document.getElementById('yearto').value;
        if(from === '')
            from = '0';
        if(to === '')
            to = '3000';
        xmlhttp.open("GET","getOrders.php?state="+str+"&from="+from+"&to="+to,true);
        xmlhttp.send();
        showHideYears(str);    
    }
}
function ordersOnLoad()
{
    showMenu();
    showUser('1');
}
function showHideYears(str)
{
    if(str === '4')
    {
        document.getElementById('yfromrow').style.display = '';
        document.getElementById('ytorow').style.display = '';
    }
    else
    {
        document.getElementById('yfromrow').style.display = 'none';
        document.getElementById('ytorow').style.display = 'none';   
    }
}
</script>

<script>
//update cart

function updateOrder(ISBN,OrderID,Method){
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



console.log("ISBN:"+ISBN + " OrderID:"+OrderID+" Method:"+Method);
     
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
	if(Method=="updateQuantity"){
	var Quantity= document.getElementById("cartQuantity"+ISBN).innerHTML;
	
	//remove HTML tags from input	
	var Quantity = Quantity.replace(/<[^>]*(>|$)/,"");
console.log(Quantity+" in scripts if");

	xmlhttp.open("GET","updateOrder.php?ISBN="+ISBN+"&OrderID="+OrderID+"&Method="+Method+"&Quantity="+Quantity,true);
	} else{
console.log(Method+"in scripts else");
	xmlhttp.open("GET","updateOrder.php?ISBN="+ISBN+"&OrderID="+OrderID+"&Method="+Method,true);
	}
        
       xmlhttp.send();
    

}
</script>


</head>
<body onload="ordersOnLoad()">
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

<body>
<h1>
            Your Cart
</h1>

<form>
<div class = 'filter'>
    <table style="width:50%">
        <tr>
            <center>
                <select id = "order_status" name="users" onchange="showUser(this.value)">
                <option value="1">Cart</option>
                <option value="2">Processing</option>
                <option value="3">Shipped</option>
                <option value="4">Past</option>
                </select>
            </center>
        </tr>
        <tr id= 'yfromrow' style='display:none'>
            <th><section class='const'>Year From</section></th>
            <th><input id='yearfrom' type="text" name="YFrom" pattern="[0-9]{4}" title="Year should be 4 digits."></th>
        </tr>
        <tr  id= 'ytorow' style='display:none'>
            <th><section class='const'>Year To</section></th>
            <th><input id='yearto' type="text" name="YTo" pattern="[0-9]{4}" title="Year should be 4 digits."></th>
        </tr>
    </table>
</div>
</form>
<br>
<div id="txtHint"><b>Order info will be listed here...</b></div>
<div id="debug"><b>Important info will be listed here...</b></div>


<?php 

// ----------------------------------------------------------------------------------------------------
// - Display Errors
// ----------------------------------------------------------------------------------------------------
ini_set('display_errors', 'On');
ini_set('html_errors', 0);

// ----------------------------------------------------------------------------------------------------
// - Error Reporting
// ----------------------------------------------------------------------------------------------------
error_reporting(-1);

// ----------------------------------------------------------------------------------------------------
// - Shutdown Handler
// ----------------------------------------------------------------------------------------------------
function ShutdownHandler()
{
    if(@is_array($error = @error_get_last()))
    {
        return(@call_user_func_array('ErrorHandler', $error));
    };

    return(TRUE);
};

register_shutdown_function('ShutdownHandler');

// ----------------------------------------------------------------------------------------------------
// - Error Handler
// ----------------------------------------------------------------------------------------------------
function ErrorHandler($type, $message, $file, $line)
{
    $_ERRORS = Array(
        0x0001 => 'E_ERROR',
        0x0002 => 'E_WARNING',
        0x0004 => 'E_PARSE',
        0x0008 => 'E_NOTICE',
        0x0010 => 'E_CORE_ERROR',
        0x0020 => 'E_CORE_WARNING',
        0x0040 => 'E_COMPILE_ERROR',
        0x0080 => 'E_COMPILE_WARNING',
        0x0100 => 'E_USER_ERROR',
        0x0200 => 'E_USER_WARNING',
        0x0400 => 'E_USER_NOTICE',
        0x0800 => 'E_STRICT',
        0x1000 => 'E_RECOVERABLE_ERROR',
        0x2000 => 'E_DEPRECATED',
        0x4000 => 'E_USER_DEPRECATED'
    );

    if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
    {
        $name = 'E_UNKNOWN';
    };

    return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};

$old_error_handler = set_error_handler("ErrorHandler");

$con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}


$user = $_COOKIE['username'];

$orderID=null;

//add book to cart if ISBN != null/empty
if(isset($_GET['ISBN'])){


$ISBN = $_GET['ISBN'];
$sql="SELECT * FROM orders WHERE UserName = '$user' AND State='1';";
$result = mysqli_query($con,$sql);
/*debug_to_console( mysqli_error($result) );*/

/*check if there is a current cart, if not, add one*/
if (mysqli_num_rows($result)==0) { 
	$date = date("Y-m-d H:i:s");
	$sql2 = "INSERT INTO orders (UserName, State, DateTime) VALUES ('$user', '1','$date' )";
if ($con->query($sql2) === TRUE) {
    	echo "New cart created successfully";
	} else {
   	 echo "Error: " . $sql . "<br>" . $con->error;
	}	
} 
debug_to_console( $orderID );

/*get orderID*/
if($orderID==null){
	$sql2 = "SELECT OrderID FROM orders WHERE State='1' AND UserName = '$user';";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)) {
		$orderID = $row['OrderID'];
	}
}
debug_to_console( $orderID ."line 151");
/*add book to cart*/
if($orderID!=null){
	$sql2 = "INSERT INTO orderitems (OrderID, ISBN, Quantity) VALUES ('$orderID', '$ISBN','1' )";
	if ($con->query($sql2) === TRUE) {
	    	echo "New item added successfully";
		} else { //Book already in cart: increment Quantity
			$sql3 = "UPDATE  orderitems SET Quantity = Quantity + 1 where OrderID = '$orderID' AND ISBN = '$ISBN';";
			if ($con->query($sql3) === TRUE) {
	    			echo "New item updated successfully";
				} else { 					
	   			 echo "Error: " . $sql . "<br>" . $con->error;
			}
	   	 
		}
}
debug_to_console( $orderID ."line 156");

mysqli_close($con);

}//close bracket for if($ISBN!="") 
?>
</body>
</html>