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
<p><a href="index.php">Home</a> | <a href="sale.php">Add New Sale</a></p>

<form>
<label>Choose Date: 
<select name="day">
	<option value="day" selected>Day</option>
	<option value="01">1</option>
	<option value="02">2</option>	
	<option value="03">3</option>
	<option value="04">4</option>
	<option value="05">5</option>
	<option value="06">6</option>
	<option value="07">7</option>
	<option value="08">8</option>
	<option value="09">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
</select>
<select name="month">
	<option value="month" selected>Month</option>
	<option value="01">January</option>
	<option value="02">February</option>
	<option value="03">March</option>
	<option value="04">April</option>
	<option value="05">May</option>
	<option value="06">June</option>
	<option value="07">July</option>
	<option value="08">August</option>
	<option value="09">September</option>
	<option value="10">October</option>
	<option value="11">November</option>
	<option value="12">December</option>
</select>
<select name="year">
	<option value="year" selected>Year</option>
	<option value="2016">2016</option>
	<option value="2017">2017</option>
	<option value="2018">2018</option>
	<option value="2019">2019</option>
</select></label><br/><br/>
<label>Report Types: 
<input type="radio" name="reportType" value="daily" checked>Daily
<input type="radio" name="reportType" value="weekly">Weekly
<input type="radio" name="reportType" value="monthly">Monthly
</label><br/><br/>
<input type="submit" value="Get Report" />
</form>

<?php
if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year']) && isset($_GET['reportType']))
{
	//assign input data
	$day = $_GET['day'];
	$month = $_GET['month'];
	$year = $_GET['year'];
	$reportType = $_GET['reportType'];
	
	//check if all inputs are given properly
	$allgiven = true;
	/*if($day == "day"){
		echo "<p>Please select a Day!</p>";
		$allgiven = false;
	}
	if($month == "month"){
		echo "<p>Please select a Month!</p>";
		$allgiven = false;
	}
	if($year == "year"){
		echo "<p>Please select a Year!</p>";
		$allgiven = false;
	}*/
	
	//when all inputs are given properly, process the session
	if($allgiven == true){
		//handle date input
		$string = "$day-$month-$year";
		$datestr = strtotime($string);
		$date = date("Y-m-d", $datestr);
		
		//open connection
		$connect = @mysqli_connect("localhost", "root", "root", "salesreportingsystem") or die("Connect failed");
		
		//CASE Daily
		if($reportType == "daily")
		{			

			$numberOfSales = 0;
			$totalProfit = 0;
			$totalBuyingPrice = 0;
			$totalSellingPrice = 0;

			//retrieve data from database
			//$query = "select * from sale where DATE(time) = '$date'";
			$query = "select * from sale inner join Product on sale.ProdID = Product.ProdID where DATE(time) = '$date'";
			$result = @mysqli_query($connect, $query) or die("Query error");
			
			//set up html string
			$string = "<table border=\"1\">
							<tr>
								<th>Sale ID</th>
								<th>Product ID</th> 
								<th>Customer ID</th>
								<th>BuyingPrice</th>
								<th>SellingPrice</th>
								<th>Quantity</th>
								<th>Profit</th>
								<th>Time</th>
							</tr>";
			//fill up data
			if ($result->num_rows > 0)
			{
				//fetch all data rows
				while ($row = $result->fetch_assoc())
				{
					$string = $string . "<tr>
											<td>". $row["SaleID"]. "</td>
											<td>". $row["ProdID"]. "</td>
											<td>". $row["CustID"]. "</td>
											<td>". $row["BuyingPrice"]. "</td>
											<td>". $row["SellingPrice"]. "</td>
											<td>". $row["Quantity"]. "</td>
											<td>". $row["Quantity"]*($row["SellingPrice"]-$row["BuyingPrice"]) . "</td>
											<td>". $row["Time"]. "</td>
										</tr>";
					$numberOfSales++;
					$totalBuyingPrice = $totalBuyingPrice + $row["BuyingPrice"];
					$totalSellingPrice = $totalSellingPrice + $row["SellingPrice"];
					$totalProfit = $totalProfit + ($row["Quantity"]*($row["SellingPrice"]-$row["BuyingPrice"]));

				}

			//calculate the number of sales

			$buyingprice =(int)($request_fetch['BuyingPrice']) * (int)($request_fetch['Stock']);

			//$buyingprice = (int)($row['Product.BuyingPrice']) * (int)($row ['Product.Stock']);
			//$sellingprice =(int)($row['Product.SellingPrice']) * (int)($row['sale.Quantity']);
			//$sellingprice =(int)($request_fetch['Product.BSellingPrice']) * (int)($request_fetch['sale.Quantity']);
			$profit = $buyingprice - $sellingprice;
			
			}
			else
			{
				echo "no results";
			}
			$string = $string . "<p>Total Sales: ". $numberOfSales ."</p>";
			//$string = $string . "<p>Total Buying Price: $". $totalBuyingPrice ."</p>";
			//$string = $string . "<p>Total Selling Price: $". $totalSellingPrice ."</p>";
			$string = $string . "<p>Total Profit: $". $totalProfit ."</p>";
			echo $string;
			
		}
		
		//CASE Weekly
		if($reportType == "weekly")
		{
			//retrieve data from database
			$query = "select * from sale where (DATE(time) = '$date') <= [(DATE(time) = '$date') - 7 ]";
			$result = @mysqli_query($connect, $query) or die("Query error");
	
			//set up html string
			$string = "<table border=\"1\">
							<tr>
								<th>Sale ID</th>
								<th>Product ID</th> 
								<th>Customer ID</th>
								<th>Quantity</th>
								<th>Time</th>
							</tr>";
			//fill up data
			if ($result->num_rows > 0)
			{
				//fetch all data rows
				while ($row = $result->fetch_assoc())
				{
					$string = $string . "<tr>
											<td>". $row["SaleID"]. "</td>
											<td>". $row["ProdID"]. "</td>
											<td>". $row["CustID"]. "</td>
											<td>". $row["Quantity"]. "</td>
											<td>". $row["Time"]. "</td>
										</tr>";
				}
			}
			else
			{
				echo "no results";
			}
			echo $string;
			
		}
		
		//CASE Monthly
		if($reportType == "monthly")
		{
			//need implementation
		}
		
		//close connection
		mysqli_close($connect);
	}
}
?>

</body>
</HTML>