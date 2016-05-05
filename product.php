<!-- Student information
Name: Xuan Loi Pham
Student number: 4964241
-->
<HTML>
<head>
<title>Product Management System</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<h1>Product Management</h1>
<p><a href="index.php">Home</a></p>
<article class="contentbox">
<form>
<label>Name: <input type="text" name="name" required /></label><br/>
<label>Buying Price: <input type="number" name="buyprice" required /></label><br/>
<label>Selling Price: <input type="number" name="sellprice" /></label><br/>
<label>Stock: <input type="number" name="stock" /></label><br/><br/>
<input type="submit" value="Submit" /><br/>
</form>
<?php
if(isset($_GET['name']) && isset($_GET['buyprice']) && isset($_GET['sellprice']) && isset($_GET['stock']))
{
	//assign input data
	$name = $_GET['name'];
	$buyprice = $_GET['buyprice'];
	$sellprice = $_GET['sellprice'];
	$stock = $_GET['stock'];
	
	//open connection
	$connect = @mysqli_connect('localhost', 'root', 'root', 'salesreportingsystem') or die("<p>Unable to connect to database server</p>");
	//add new product
	$query = "insert into product (prodname, buyingprice, sellingprice, stock) values ('$name', '$buyprice', '$sellprice', '$stock')";
	$result = @mysqli_query($connect, $query) or die("Please try again!</p>");
	//retrieve product number
	$query = "select max(prodid) from product";
	$result = @mysqli_query($connect, $query) or die("Query error");
	$data = mysqli_fetch_assoc($result);
	$prodid = $data["max(prodid)"];
	//confirmation message
	echo "Product <b>$name</b> has been successfully added into the system. Product ID is <b>$prodid</b>.";
	//close connection
	mysqli_close($connect);
}
?>
</article>
</body>
</HTML>