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
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]
    <script src="js/ie-emulation-modes-warning.js"></script>-->

    
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
        <h3>Update Profile</h3>
         
	
    <?php
    
    $name=$_POST["name"];
	$email=$_POST["email"];
	$addline=$_POST["street"];
	$city=$_POST["city"];
	$state=$_POST["state"];
	$statel=strlen($state);
	$zip=$_POST["zip"];
	$zipl = strlen((string)$zip);
	$income=$_POST["income"];
	$pass=$_POST["password"];
	$category=$_POST["category"];
    $category=$category[0];

   $servername = "localhost";
   $username = "root";
   $password = "";
   $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
	
	
	//if ($statel!=2) {
	//	echo "State Code number be two letters  <a href='createacc.php'>Back</a>"; 
	//}
	//else if ($zipl!=5) {
	//	echo "Zip Code must be 5 numbers  <a href='createacc.php'>Back</a> <br/>"; 
	//}
	//else {

    if (trim($name)!= "" )
    {
        $sqlname = "update mystore.customer_business set name = '$name' where username = '$_SESSION[username]'";
		if($conn->query($sqlname)===TRUE){
			echo ' Name Updated <br/>';
		}
		else{ echo'name not updated'. $conn->error;}
	}
	if ($pass!= "" )
    {
        $sqlpass = "update mystore.login set password = '$pass' where username = '$_SESSION[username]'";
		if($conn->query($sqlpass)===TRUE){
			echo ' Password Updated <br/>';
		}
		else{ echo'Password not updated: '. $conn->error;}
	}
	 if (trim($email)!= "" )
    {
        $sqlemail = "update mystore.customer_business set email = '$email' where username = '$_SESSION[username]'";
		if($conn->query($sqlemail)===TRUE){
			echo ' Email Updated <br/>';
		}
		else{ echo'email not updated: '. $conn->error;}
	}
	 if (trim($addline)!= "" )
    {
        $sqladdline = "update mystore.customer_business set addline = '$addline' where username = '$_SESSION[username]'";
		if($conn->query($sqladdline)===TRUE){
			echo 'Street Updated <br/>';
		}
		else{ echo'Street not updated'. $conn->error;}
	}
	if (trim($zip)!= "" )
    {
        $sqlzip = "update mystore.customer_business set zip = '$zip' where username = '$_SESSION[username]'";
		if($conn->query($sqlzip)===TRUE){
			echo ' Zip Updated <br/>';
		}
			else{ echo'zip not updated'. $conn->error;}
	}
	 if (trim($city)!= "" )
    {
        $sqlcity = "update mystore.zip set city = '$city' where zipcode = '$zip'";
		if($conn->query($sqlcity)===TRUE){
			echo ' City Updated <br/>';
		}
		else{ echo'city not updated'. $conn->error;}
	}
	 if (trim($state)!= "" )
    {
        $sqlstate = "update mystore.zip set state = '$state' where zipcode = '$zip'";
		if($conn->query($sqlstate)===TRUE){
			echo ' State Updated <br/>';
		}
		else{ echo'state not updated'. $conn->error;}
	}
	 if ($category != "blank" )
    {
        $sqlcat = "update mystore.customer_business set category = '$category' where username = '$_SESSION[username]'";
		if($conn->query($sqlcat)===TRUE){
			echo ' Category Updated <br/>';
		}
		else{ echo'Category not updated'. $conn->error;}
	}
	 if (trim($income)!= "" )
    {
        $sqlincome = "update mystore.customer_business set income = '$income' where username = '$_SESSION[username]'";
		if($conn->query($sqlincome)===TRUE){
			echo 'Income Updated <br/>';
		}
		else{ echo'income not updated'. $conn->error;}
	}
	
	
	else{
		echo 'No updates entered. Go <a href="profile.php">back.</a>';
	}
	


	?>   

      
	  </div>
	 
    </div> 
	</div><!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    IE10 viewport hack for Surface/desktop Windows 8 bug 
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>


