
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
        <h3>Checkout form</h3>
          <?php
          
          if(isset($_SESSION['username'])){
              echo 'Shopping cart for '.$_SESSION['username'];
          
          ?>
		  
		   <br/><br/><br/>
         <form class="form-inline" name="queryInput" action="checkoutconfirm.php" method="POST">
		 
			  <label for='cardtype[]'>Card Type</label><br>
             <select required class="form-control form-control-sm" name="cardtype[]" >
                 <option value="">Select</option>
                 <option value="visa">Visa</option>
                 <option value="master">Master Card</option>
                 <option value="discover">Discover</option>
              </select><br><br>
			
		Card number<br>
        <input type="number" name="cardnum" class="form-control" placeholder="enter card number" maxlength="16" required><br><br>
		Exp Date<br>
		<input type="month" name="exp" class="form-control" placeholder="enter expiration date" min="2016-12" required><br><br>
		Security Code<br>
		<input type="number" name="seccode" class="form-control" maxlength="3" placeholder="enter security code" required><br><br>
		
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-primary"type="submit">Complete Checkout</button>     
		   
	</form>
	<?php }else{
              echo 'You must sign in to check out.';}?>
	<br/>
    
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


