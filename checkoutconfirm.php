<?php
// include database configuration file

?>
<!DOCTYPE html>
<!-- php: php.searchlist
	variables: dropdownCountry, dropdownCategories, dropdownCalories, dropdownFat, dropdownProtein, dropdownSugar, radioOrder, search -->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>DB Online Store</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">DB Online Store</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              
              
              			  
			  <?php
			  session_start();
		  if(isset($_SESSION['username'])){
			  if (($_SESSION['username']=='admin') === TRUE){ 
					echo' <li ><a href="emp-board.php"> Manager Dasboard</a></li>
					<li ><a href="orders.php"> Orders</a></li>
					<li ><a href="logout.php"> Log Out</a></li>
					<li class="uname"><a><font color=#1A5276><i>Hello <b>'.$_SESSION['username'].'</font></a></b></i></li>';}
		      else{
			  echo ' 
			  <li><a href="index.php">Home</a></li>
			  <li><a href="shoppingcart.php">Cart</a></li>
			  <li ><a href="profile.php"> Profile</a></li>
			  <li ><a href="logout.php"> Log Out</a></li>
			  <li class="uname"><a><font color=#1A5276><i>Hello <b>'.$_SESSION['username'].'</font></a></b></i></li>.';}
		  }
		  else{
		  	echo '
			<li><a href="index.php">Home</a></li>
			  <li><a href="shoppingcart.php">Cart</a></li>
			<li><a href="login.php">Login</a></li>
			<li class="active"><a href="createacct.php">Create an Account</a></li> 
			<li class="uname"><a style="text-decoration: none"><font color=#1A5276><i>Hello, guest.</i></font></a></li>';
		  }
			 ?>
			 </ul>
			 </div>
        <!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h3>Checkout </h3>
          
	<br/>
    <?php
    $type=$_POST["cardtype"];
    $type=$type[0];
    $cardnum=$_POST["cardnum"];
	$cardl = strlen((string)$cardnum);
	$exp=$_POST["exp"];
	$seccode=$_POST["seccode"];
	$secl = strlen((string)$seccode);
	$uname = $_SESSION['username'];
	$orderid = rand();

	$servername = "localhost";
	$username = "root";
	$password = "";
	$conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlr="select id from mystore.transaction where id = $orderid";
    $randid = $conn->query($sqlr);
	if ($cardl!=16) {
	echo "Please enter a valid 16-digit card number  <a href='checkout.php'>Back</a>"; 
		}
	else if ($secl!=3) {
	echo "Card Security code must be 3 digits <a href='checkout.php'>Back</a> <br/>"; 
	}
	else{
		if ($randid->num_rows>0)
			{
			$orderid = rand();}
		else if($randid->num_rows==0){  
	
			$sqlc="select productID, quantity,price from mystore.cart, mystore.product where productID=id";
			$addcart = $conn->query($sqlc);
		
			while($row = $addcart->fetch_assoc()){
			
			$prodid = $row['productID'];
			$itemquant = $row['quantity'];
			$date= new DateTime();
			$dresult = $date->format('Y-m-d H:i:s');
            $price=$row['price'];
			
			$sqlc="INSERT into mystore.transaction values('$orderid','$dresult','$prodid', '$itemquant','$uname',NULL,$price)";
			if($conn->query($sqlc)===FALSE){
			echo 'error: '. $conn->error;}
			else{
				
			}
        

	  
        } $emptycart="delete from mystore.cart";
				if($conn->query($emptycart)===FALSE){
					echo 'error: '. $conn->error;}
				else {echo 'Success! Your order number is '.$orderid;}}
		else{
         echo '<p>Error with order. Please contact admin.</p>';
	} }?>

      </div>
	 
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>


