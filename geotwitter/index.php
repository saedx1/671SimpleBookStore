<html>
<head>
	<link href="style.css" rel="stylesheet">
</head>
<?php
                $con=mysqli_connect("geotwitter.uncg.edu","root","vJnVubg49U","geotwitter");
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
                $perPage = 30;
                $limitA = 0;
                $limitB = $perPage;
                $mypage = 1;
                if(isset($_GET["page"]))
                {
                    $mypage = $_GET["page"];
                    $limitA = ($mypage - 1) * $perPage;
                }
                $query = "SELECT tweet_id, created_at, text, image_url FROM polished_tweets WHERE image_url is not null LIMIT $limitA,$perPage;";
                $count = "SELECT COUNT(*) FROM polished_tweets WHERE image_url is not null;";
                $i = 0;
                $result = mysqli_query($con,$query);            
                $table = mysqli_fetch_all($result);
                foreach($table as $row)
                {
		                    echo "  <a class='booka'>
                                		<div class=\"book\">
		                                    <table>
		                                        <tr>
		                                            <td>
		                                                <h3>$row[0]</h1>
		                                            </td>
		                                        </tr>
		                                        <tr>
		                                            <td>
		                                                <h3>$row[1]</h3>
		                                            </td>
		                                        </tr>
		                                        <tr>
		                                            <td>
		                                                <h1>$row[2]</h3>
		                                            </td>                            
		                                        </tr>
		                                        <tr>
		                                            <td>
		                                                <IMG SRC='$row[3]' height='200px' width='200px'>
		                                            </td>
		                                        </tr>

		                                    </table>
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
                    echo "Showing $num Tweets ($limitA-$finalIdx) out of $row[0]<br>";
                    echo "<form action=\"index.php\">
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
</html>
