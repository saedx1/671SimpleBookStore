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
        <center>	
            <form method="POST">                
                <h3>Address</h3>
                <textarea name="address" rows="5" style="width:35%;resize:none" pattern="[A-Za-z0-9]{1,80}" title="Address should contain each part on a single line." required></textarea>
                <h3>Credit Card</h3>
                <input type="text" name="ccno" style="width:35%" pattern="[0-9]{16-20}" title="Should be 16-20 digits." required>
                <br>
                <br>
                <input type="submit" value="Checkout" name="Checkout">
            </form>
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



                $con=mysqli_connect("dbproject.saadmtsa.club","root","password","dbproject");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                if (isset($_POST['Checkout']))
                {
		    $OrderID = $_GET['OrderID'];
                    $username =  $_COOKIE['username'];
                    $address =  $_POST['address']; 
	  	    $ccno =  $_POST['ccno'];  
		    //constant for checkout state
		    $checkout = 2;                 

                    $myquery = "INSERT INTO shipping (OrderID,Delivery,Address,Credit_Card)  VALUES('$OrderID',null,'$address','$ccno');";
                    if ($con->query($myquery) === TRUE) {
                        echo "Credit Card Approved!  ";
                    } else {
                        echo "Error: " . $myquery . "<br>" . $con->error;
                    }
		
		     $myquery = "UPDATE  orders SET State = '$checkout' where OrderID = '$OrderID' AND UserName = '$username';";
		     if ($con->query($myquery) === TRUE) {
                        echo "Order is being processed!";
                    } else {
                        echo "Error: " . $myquery . "<br>" . $con->error;
                    }

                    $con->close();
                    
                }
            ?>
		</center>	
    </body>
</html>
