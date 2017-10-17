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
	  <div id="1">
	  <p> Please choose which account type you would like to create</p>
	  <button id="btnHome">Home User</button> <button id="btnBiz">Business User</button>
	  </div>
	  <div id="home" style="display:none">
        <form  class="form-signin" name="queryInput" action="createacc_handle.php" method="POST">
	<h2 class="form-signin-heading">Create an Account</h2>
	  <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" class="form-control" maxlength="15" placeholder="username" required>
			<br/>	
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" maxlength="15" placeholder="password" required>
				
		<label for="firstname" class="sr-only">First Name</label>
        <input type="other" name="firstname" class="form-control" maxlength="15" placeholder="first name" required>
		
		<label for="lastname" class="sr-only">Last Name</label>
        <input type="other" name="lastname" class="form-control" maxlength="15" placeholder="last name" required>
		
		<label for="email" class="sr-only">Email</label>
        <input type="email" name="email" class="form-control" maxlength="30" placeholder="email (must be valid address)" required>
				
		<label for="street" class="sr-only">Street Address</label>
        <input type="other" name="street" class="form-control" maxlength="30" placeholder="street address" required>
		
		<label for="city" class="sr-only">City</label>
        <input type="other" name="city" class="form-control" maxlength="30" placeholder="city" required>
		
		<label for="state" class="sr-only">State</label>
        <input type="other" name="state" class="form-control" maxlength="2" placeholder="state" required>
		
		<label for="zip" class="sr-only">Zip</label>
        <input type="number" name="zip" class="form-control" maxlength="5" placeholder="zip" required>
		
		    <select class="form-control form-control-sm" name="gender">
                 <option value="Select">gender</option>
                 <option value="male">Male</option>
                 <option value="female">Female</option>
				 <option value="private">Private</option>
             </select>
			 <br/>
             <select class="form-control form-control-sm" name="marriage">
                 <option value="Select">marriage status</option>
                 <option value="single">Single</option>
                 <option value="married">Married</option>
				 <option value="single">Divorced</option>
             </select>
			 <br/>
		<label for="age" class="sr-only">Age</label>
        <input type="number" name="age" class="form-control" maxlength="3" min="15" max="150" placeholder="age" required>
				 
		<label for="income" class="sr-only">Income</label>
        <input type="number" name="income" class="form-control"  maxlength="8" placeholder="income" required>
		
        <!--<div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>-->
		<div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		</div>
	 
	 </form>
	 </div>
	 
	 <div id="biz" style="display:none">
        <form  class="form-signin" name="queryInput" action="createaccbiz_handle.php" method="POST">
	<h2 class="form-signin-heading">Create a Business Account</h2>
	  <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" class="form-control" maxlength="15" placeholder="username" required>
			<br/>	
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" maxlength="15" placeholder="password" required>
				
		<label for="bizname" class="sr-only">Business Name</label>
        <input type="other" name="bizname" class="form-control" maxlength="20" placeholder="business name" required>
		
		<label for="email" class="sr-only">Email</label>
        <input type="email" name="email" class="form-control" maxlength="30" placeholder="(must be valid address)" required>
		
		<label for="street" class="sr-only">Street Address</label>
        <input type="other" name="street" class="form-control" maxlength="30" placeholder="street address" required>
		
		<label for="city" class="sr-only">City</label>
        <input type="other" name="city" class="form-control" maxlength="30" placeholder="city" required>
		
		<label for="state" class="sr-only">State</label>
        <input type="other" name="state" class="form-control" maxlength="2" placeholder="state" required>
		
		<label for="zip" class="sr-only">Zip</label>
        <input pattern=".{5,}" type="number" name="zip" id="zip"  class="form-control" maxlength="5" placeholder="zip" required>
		
		    <select class="form-control form-control-sm" name="category">
                 <option value="Select">category</option>
                 <option value="market">market</option>
                 <option value="restaurant">restaurant</option>
				 <option value="cafeteria">IT</option>
				 <option value="cafeteria">finance</option>
				 <option value="cafeteria">education</option>
				 <option value="cafeteria">non-profit</option>
				 <option value="other">other</option>
             </select>
			 					 
		<label for="income" class="sr-only">yrprofits</label>
        <input type="number" name="yrprofits" class="form-control" placeholder="yearly profits" required>
		
        <!--<div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>-->
		<div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		</div>
	 
	 </form>
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
	   <script>
	   
	
   
	   
  $('#btnHome').on('click',function(){
    if($('#1').css('display')!='none'){
    $('#1').html($('#home').html()).show().siblings('div').hide();
    }else if($('#1').css('display')!='none'){
        $('#1').show().siblings('div').hide();
    }
  })
	
	$('#btnBiz').on('click',function(){
    if($('#1').css('display')!='none'){
    $('#1').html($('#biz').html()).show().siblings('div').hide();
    }else if($('#1').css('display')!='none'){
        $('#1').show().siblings('div').hide();
    }
	})
	</script>
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