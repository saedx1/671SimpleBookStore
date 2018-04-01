<!DOCTYPE html>
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



$username = $_COOKIE['username'];
$state = intval($_GET['state']);
    
$dateFrom = intval($_GET['from']) ;
$dateTo = intval($_GET['to']);
$orderID =null;
/*
state 1 = cart
state 2 = processing
state 3 = shipped
state 4 = past
*/

/*get orderID*/
if($orderID==null){
	$sql = "SELECT OrderID FROM orders WHERE State='1' AND UserName = '$username';";
	$result = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($result)) {
		$orderID = $row['OrderID'];
	}
}

$con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }


/*mysqli_select_db($con,"ajax_demo");*/
$sql="SELECT * FROM orders o, orderitems i, books b WHERE o.OrderID=i.OrderID AND i.ISBN=b.ISBN AND o.username = '$username' AND o.STATE = '$state' AND Year(o.DateTime) >= $dateFrom AND Year(o.DateTime) <= $dateTo;";
$result = mysqli_query($con,$sql);
echo "<script>console.log( 'In getOrders' );</script>";
//use different logic for cart, other states should be have the same output (for now)
if($state==1){
$total = 0;
$OrderID = null;
if(mysqli_num_rows($result) != 0)
{
    echo "<table>
    <tr>
    <th>OrderID</th>
    <th>Title</th>
    <th>ISBN</th>
    <th>Price</th>
    <th>Quantity</th>
    </tr>";
}
while($row = mysqli_fetch_array($result)) {
    $total = $total + doubleval($row['Price']) * intval($row['Quantity']);
    $OrderID = $row['OrderID'];
    echo "<tr>";
    echo "<td>" . $row['OrderID'] . "</td>";            
    echo "<td>" . $row['Title'] . "</td>";
    echo "<td>" . $row['ISBN'] . "</td>";
    echo "<td>" . $row['Price'] . "</td>"; 
    echo "<td bgcolor=\"white\"><div id=\"cartQuantity".$row['ISBN']."\" style=\"background-color:lightblue\" contenteditable>" . $row['Quantity'] . "</div><a href=\"orders.php\" onclick='updateOrder(\"".$row['ISBN'] . "\",".$row['OrderID'].",\"updateQuantity\")'>update</a></td>";
    echo "<td><a href=\"orders.php\" onclick='updateOrder(\"".$row['ISBN'] . "\",".$row['OrderID'].",\"deleteItem\")'>Delete<a></td>"; 
    echo "</tr>";
}
echo "</table>";
if($total != 0)
{
    echo "<h2>Order Total: $". $total ."</h2>";
    echo "<h2><a href=\"orders.php\" onclick='updateOrder(\"None\",".$OrderID.",\"checkout\")'>Checkout</a></h2>";
}
} else{

$total = 0;
echo "<table>
<tr>
<th>OrderID</th>
<th>UserName</th>
<th>Title</th>
<th>Price</th>
<th>Quantity</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    $total = $total + doubleval($row['Price']) * intval($row['Quantity']);
    echo "<tr>";
    echo "<td>" . $row['OrderID'] . "</td>";
    echo "<td>" . $row['UserName'] . "</td>";         
    echo "<td>" . $row['Title'] . "</td>";
    echo "<td>" . $row['Price'] . "</td>"; 
    echo "<td>" . $row['Quantity'] . "</td>";
    echo "</tr>";
}
echo "</table>";

}
mysqli_close($con);
?>
</body>
</html>
