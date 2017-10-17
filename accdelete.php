<!DOCTYPE html>
<!--PHP file name: createacc.php
User variables: username, password, firstname, lastname, street, city, state, zip --> 
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
	<script src="js/jquery-3.1.1.min.js"></script>
	

   
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
           </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
		<?php
		$servername = "localhost";
		$databaseusername = "root";
		$databasepassword = "";	
		$conn = new mysqli($servername, $databaseusername, $databasepassword);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$acctdelete = $_SESSION['acctdelete']; 
		
		$findhome = "Select* from mystore.customer_home where username = '$acctdelete'";
		$homeuser = $conn->query($findhome);
			
		$findbiz = "Select * from mystore.customer_business where username = '$acctdelete'";
		$bizuser = $conn->query($findbiz);
				
		if($homeuser->num_rows>0){
		
			$sqlacctremove="DELETE from mystore.customer_home WHERE username = '$acctdelete'";
            $sqlloginrmv="DELETE from mystore.login WHERE username = '$acctdelete'";
			if($conn->query($sqlacctremove)===TRUE){
				echo 'Account for '.$acctdelete.'has been deleted.';}
			else { echo 'error in deleting account.'.$conn->error;}
		
			}
		
		else if ($bizuser->num_rows>0){
			$sqlbizremove="DELETE from mystore.customer_business WHERE username = '$acctdelete'";
            $sqlloginrmv="DELETE from mystore.login WHERE username = '$acctdelete'";
			if($conn->query($sqlbizremove)===TRUE){
				echo 'Account for '.$acctdelete.' has been deleted.';}
			else { echo 'error in deleting account.'.$conn->error;;}
		}
      
		else {echo"error in finding account";}
	
		 ?>
       
	 
	 
	 
        
	 </div>
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
	 
	<script> $("#zip").validate({
  rules: {
    field: {
      required: true,
      minlength: 5
    }
  }
	}</script>
  </body>
</html>