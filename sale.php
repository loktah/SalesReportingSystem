<!-- Student information
Name: Xuan Loi Pham
Student number: 4964241
-->
<HTML>
<head>
<title>Sales Input System</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
<script type="text/javascript" src="script.js"></script>
</head>
<body>
<h1>Sales Input System</h1>
<p><a href="index.php">Home</a> | <a href="report.php">Get Report</a></p></br></br>

<?php
	//open connection
	$connect = @mysqli_connect('localhost', 'root', 'root', 'salesreportingsystem') or die("<p>Unable to connect to database server</p>");
	
	//retrieve data from database
	$query = "select * from product where stock > '0'";
	$result = @mysqli_query($connect, $query) or die("ERR1: Please try again!</p>");
	
	//set up html string
	$string = "<table border=\"1\">
						<tr>
							<th>Product ID</th>
							<th>Product Name</th> 
							<th>Buying Price</th>
							<th>Selling Price</th>
							<th>Stock</th>
						</tr>";
	//fill up data
	if ($result->num_rows > 0)
	{
		//fetch all data rows
		while ($row = $result->fetch_assoc())
		{
			
			$string = $string . "<tr>
									<td>". $row["ProdID"]. "</td>
									<td>". $row["ProdName"]. "</td>
									<td>". $row["BuyingPrice"]. "</td>
									<td>". $row["SellingPrice"]. "</td>
									<td>". $row["Stock"]. "</td>
									</tr>";
		}
	}
	else
	{
		echo "no results";
	}
	
	echo $string;
	
	//close connection
	mysqli_close($connect);
?>

<form>
<label>Customer ID (optional) <input type="text" name="custid" /></label></br>
<label>Product ID <input type="text" name="prodid" required /></label>
<label>Quantity <input type="number" name="quantity" required /></label>
<input type="submit" value="Add" /><br/><br/>
</form>
<h1>Available Products</h1>

<?php
if(isset($_GET['custid']) && isset($_GET['prodid']) && isset($_GET['quantity']))
{
	//assign input data
	$custid = $_GET['custid'];
	$prodid = $_GET['prodid'];
	$quantity = $_GET['quantity'];
	
	//open connection
	$connect = @mysqli_connect('localhost', 'root', 'root', 'salesreportingsystem') or die("<p>Unable to connect to database server</p>");
	
	//check product ID
	$query = "select prodid from product where prodid = '$prodid'";
	$result = @mysqli_query($connect, $query) or die("<p>Query error</p>");
	if(mysqli_num_rows($result) == 0)
	{
		$message = "Product ID is invalid/Product does not exist";
		echo "<script type='text/javascript'>alert('$message');</script>";
	}
	else
	{
		//check available stock
		$query = "select stock from product where prodid = '$prodid'";
		$result = @mysqli_query($connect, $query) or die("<p>Query error</p>");
		while($row = $result->fetch_assoc())
		{
			if($quantity > 0)
			{
				if($row["stock"] >= $quantity)
				{
					//add new sale
					$query = "insert into sale (custid, prodid, quantity, time) values ('$custid', '$prodid', '$quantity', now())";
					$result = @mysqli_query($connect, $query) or die("Please try again!");
		
					//update product table
					$query = "update product set stock = (stock -'$quantity') where prodid = '$prodid' ";
					$result = @mysqli_query($connect, $query) or die("Please try again!</p>");
	
					//retrieve sale id
					$query = "select max(saleid) from sale";
					$result = @mysqli_query($connect, $query) or die("Query error");
					$data = mysqli_fetch_assoc($result);
					$saleid = $data["max(saleid)"];
	
					//refresh the page
					header('Location: sale.php');
					//exit;
				}
				else
				{
					$message = "Not enough stock";
					echo "<script type='text/javascript'>alert('$message');</script>";
				}
			}
			else
			{
				$message = "Invalid stock input";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
	}
	
	//show newly added sales
	
	
	//fill up data
	

	//close connection
	mysqli_close($connect);
}
?>

</body>
</HTML>