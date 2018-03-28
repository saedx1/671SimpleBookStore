<html lang="en">
    <head>
        <meta charset="utf-8">
        <link href="style.css" rel="stylesheet">
        <title>671BookStore</title>
<script>
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
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
        xmlhttp.open("GET","getOrders.php?username=saad&state="+str,true);
       xmlhttp.send();
    }
}
</script>


</head>
<body>
<h1>
            Your Cart
</h1>

<form>
<select name="users" onchange="showUser(this.value)">
  <option value="">Select an order option:</option>
  <option value="1">Cart</option>
  <option value="2">Processing</option>
  <option value="3">Shipped</option>
  <option value="4">Past</option>
  </select>
</form>
<br>
<div id="txtHint"><b>Order info will be listed here...</b></div>


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


$user = $_GET['username'];
$ISBN = $_GET['ISBN'];
$orderID=null;
$sql="SELECT * FROM orders WHERE UserName = '$user';";
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
	$sql2 = "SELECT OrderID FROM orders WHERE UserName = '$user';";
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
		} else {
	   	 echo "Error: " . $sql . "<br>" . $con->error;
		}
}
debug_to_console( $orderID ."line 156");

mysqli_close($con);
?>
</body>
</html>
