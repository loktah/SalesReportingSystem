
<HTML>
<head>
<title>Sales Input System</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<h1>Sales Input System</h1>
<p><a href="index.php">Home</a></p>
<article class="contentbox">
<form>
<label>Customer ID (optional): <input type="number" name="custid" ></label><br/> 
<label>Product ID: <input type="number" name="prodid" required/ ></label><br/>
<label>Quantity	: <input type="number" name="quantity" required/ ></label><br/>
<input type="submit" value="Submit" /><br/>
</form>
<?php
if(isset($_GET['custid']) && isset($_GET['prodid']) && isset($_GET['quantity']))
{
	//assign input data
	$custid = $_GET['custid'];
	$prodid = $_GET['prodid'];
	$quantity = $_GET['quantity'];
	
	//open connection
	$connect = @mysqli_connect('localhost', 'root', 'root', 'salesreportingsystem') or die("<p>Unable to connect to database server</p>");
	//add new sale
	$query = "insert into sale (custid, prodid, quantity, time) values ('$custid', '$prodid', '$quantity', now())";
	$result = @mysqli_query($connect, $query) or die("Please try again!</p>");
	//retrieve sale id
	$query = "select max(saleid) from sale";
	$result = @mysqli_query($connect, $query) or die("Query error");
	$data = mysqli_fetch_assoc($result);
	$saleid = $data["max(saleid)"];
	//confirmation message
	echo "Successfully added. Sale ID is <b>$saleid</b>.";
	//close connection
	mysqli_close($connect);
}
?>
</article>
</body>
</HTML>