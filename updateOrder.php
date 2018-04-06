<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
<script type='text/javascript' src="scripts.js"></script>
</head>
<body>

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
//end error reporting

//start
$username = $_COOKIE['username'];
$ISBN = $_GET['ISBN'];
$OrderID = $_GET['OrderID'];
$Method = $_GET['Method'];
debug_to_console($username);
debug_to_console($ISBN);
debug_to_console($OrderID);
debug_to_console($Method);
//constant for checkout state
$checkout = 2;

echo "<script>console.log( 'In updateOrders' );</script>";
$con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }


/*mysqli_select_db($con,"ajax_demo");*/

if(isset($_GET['Quantity'])){
	$Quantity = $_GET['Quantity'];

	//if Quantity <= 0, delete item
	if($Quantity === '0' || $Quantity <=0)
	{
	    $Method = "deleteItem";
	}
}

//delete item
if($Method == "deleteItem"){

$sql="delete FROM orderitems WHERE OrderID='$OrderID' AND ISBN='$ISBN';";
	if ($con->query($sql) === TRUE) {
		echo "Item deleted successfully";
		} else { 					
		 echo "Error: " . $sql . "<br>" . $con->error;
	}
} else if($Method == "updateQuantity"){

	//check if item in exist
	if(false/*mysqli_num_rows($result) == 0*/)
	{
	echo "ISBN does not exist";
	} else{
		/*check if item is in stock*/

		$sql = "SELECT  Stock from books where ISBN = '$ISBN';";
		$result = mysqli_query($con, $sql);
		$stock=-1;
		while($row = mysqli_fetch_array($result)) { //find stock
			$stock=$row['Stock'];
		}

		//check if new quanity is less than old quantity
		$sql = "SELECT  Quantity from orderitems where ISBN = '$ISBN' and OrderID = '$OrderID';";
		$result = mysqli_query($con, $sql);
		$oldQuantity=-1;
		while($row = mysqli_fetch_array($result)) { //find stock
			$oldQuantity=$row['Quantity'];
		}
		//make Quantity negative if we are removing items from cart
		//if($oldQuantity>$Quantity){
		$subQuantity = $Quantity-$oldQuantity;
		//} else{
		//$subQuantity = $oldQuantity-$Quantity;
		//}

		
		//check if amount requested is avalible 
		$updateQuantity= intval($stock-$subQuantity);
		//debug_to_console( $updateQuantity );
		//echo "updateQuantity=" . $updateQuantity;
		if($updateQuantity>=0){
		
		//update book stock
		$sql = "UPDATE books SET Stock = '$updateQuantity' where ISBN = '$ISBN';";
			if ($con->query($sql) === TRUE) {
				
				//make sure Quantity is positive
				//$Quantity = abs($Quantity);
				 
				//update order
				$sql2 = "UPDATE orderitems SET Quantity = '$Quantity' where OrderID = '$OrderID' AND ISBN = '$ISBN';";
				if ($con->query($sql2) === TRUE) {
					echo "Book Stock updated successfully";
				} else { 					
					echo "Error: " . $sql2 . "<br>" . $con->error;
				}
				echo "Quantity for order updated successfully";
			} else { 					
				echo "Error: " . $sql . "<br>" . $con->error;
			}

		
		} else{
			echo "Item does not have enough stock for amount requested";
		}
	}

} else if($Method == "checkout"){
  $sql = "UPDATE  orders SET State = '$checkout' where OrderID = '$OrderID' AND UserName = '$username';";
  if ($con->query($sql) === TRUE) {
			echo "Order is being processed";
			
			//alert customer that order is being processed
			
			//check if new quanity is less than old quantity
			$sql = "SELECT  Address, CreditCard from users where Username = '$username';";
			$result = mysqli_query($con, $sql);
			$address=-1;
			$credit=-1;
			while($row = mysqli_fetch_array($result)) { //find stock
				$address=$row['Address'];
				$credit=$row['CreditCard'];
			}

			//echo '<script type="text/javascript">';
//			echo "<script type='text/javascript'>alert('hello');</script>";
			echo "<script type='text/javascript'>alert('hi');</script>";
			//echo '<h3>Order will be shipped to "'. $address . '" using credit card "' . $credit . '" as payment)</h3>';
			//echo '</script>';
			} else { 					
			 echo "Error: " . $sql . "<br>" . $con->error;
		}
}

//debug
//echo "<h2>".$ISBN." ".$OrderID." ". $Method . "</h2>";

mysqli_close($con);
?>
</body>
</html>
