<!-- Student information
Name: Xuan Loi Pham
Student number: 4964241
-->
<HTML>
<head>
<title>Customer Registration System</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<h1>Customer Registration</h1>
<p><a href="index.php">Home</a></p>
<article class="contentbox">
<form>
<label>Name: <input type="text" name="name" required /></label><br/>
<label>Email: <input type="text" name="email" required /></label><br/>
<label>Phone: <input type="tel" name="phone" pattern="\d{10}" maxlength="10" required /></label><br/><br/><br/>
<input type="submit" value="Submit" /><br/>
</form>
<?php
if(isset($_GET['name']) && isset($_GET['email']) && isset($_GET['phone']))
{
	//assign input data
	$name = $_GET['name'];
	$email = $_GET['email'];
	$phone = $_GET['phone'];
	
	//open connection
	$connect = @mysqli_connect('localhost', 'root', 'root', 'salesreportingsystem') or die("<p>Unable to connect to database server</p>");
	//add new customer
	$query = "insert into customer (custname, email, phone) values ('$name', '$email', '$phone')";
	$result = @mysqli_query($connect, $query) or die("Please try again!</p>");
	//retrieve customer id
	$query = "select max(CustID) from customer";
	$result = @mysqli_query($connect, $query) or die("Query error");
	$data = mysqli_fetch_assoc($result);
	$custid = $data["max(CustID)"];
	//confirmation message
	echo "Customer <b>$name</b> has been successfully registered. Customer ID is <b>$custid</b>.";
	//close connection
	mysqli_close($connect);
}
?>
</article>
</body>
</HTML>