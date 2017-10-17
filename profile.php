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

<style>
 .row{
	  width:300px;
	  align:center;
  }
</style>

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
		
		$username = $_SESSION['username'];
		
			$findhuser = "Select * from mystore.customer_home where username = '$username'";
		$homeuser = $conn->query($findhuser);
			
		$findbuser = "Select * from mystore.customer_business where username = '$username'";
		$bizuser = $conn->query($findbuser);
		
		$ziphome = "Select city as c, state as s from mystore.zip, mystore.customer_home where username = '$username' and zip=zipcode";
		$ziph = $conn->query($ziphome);
		$ziphomes = "Select state as s from mystore.zip, mystore.customer_home where username = '$username' and zip=zipcode";
		$ziphs = $conn->query($ziphomes);
		
		$zipbizc = "Select city as c from mystore.zip, mystore.customer_business where username = '$username' and zip=zipcode";
		$zipbc = $conn->query($zipbizc);
		$zipbizs = "Select state as s from mystore.zip, mystore.customer_business where username = '$username' and zip=zipcode";
		$zipbs = $conn->query($zipbizs);
		
		if($homeuser->num_rows>0){
			while($row = $homeuser->fetch_assoc()){
				echo '<form  class="form-signin" name="queryInput" action="updatehome.php" method="POST">
					<h2 class="form-signin-heading">Your Account</h2>
					<label for="username" class="sr-only">Username</label>
					<input type="text" name="username" class="form-control" maxlength="15" placeholder="'.$row['username'].'" readonly>
				<br/>	
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" maxlength="15" placeholder="password (private)" >
				
		<label for="firstname" class="sr-only">First Name</label>
        <input type="other" name="fullname" class="form-control" maxlength="15" placeholder="'.$row["name"].'">
				
		<label for="email" class="sr-only">Email</label>
        <input type="email" name="email" class="form-control" maxlength="30" placeholder="'.$row['email'].'">
				
		<label for="street" class="sr-only">Street Address</label>
        <input type="other" name="street" class="form-control" maxlength="30" placeholder="'.$row['addline'].'">
		Note: City, State, and Zip - if one is updated, all must be updated.
		<label for="city" class="sr-only">City</label>
        <input type="other" name="city" class="form-control" maxlength="30" placeholder="'.$ziph->fetch_object()->c.'" >
		
		<label for="state" class="sr-only">State</label>
        <input type="other" name="state" class="form-control" maxlength="4" placeholder="'.$ziphs->fetch_object()->s.'" >
		
		<label for="zip" class="sr-only">Zip</label>
        <input type="number" name="zip" class="form-control" maxlength="5" placeholder="'.$row['zip'].'">
		
		    <select class="form-control form-control-sm" name="gender">
                 <option value="Select">Gender: only select to update</option>
                 <option value="male">Male</option>
                 <option value="female">Female</option>
				 <option value="private">Private</option>
             </select>
			 <br/>
             <select class="form-control form-control-sm" name="marriage">
                 <option value="Select">marriage: only select to update</option>
                 <option value="single">Single</option>
                 <option value="married">Married</option>
				 <option value="single">Divorced</option>
             </select>
			 <br/>
		<label for="age" class="sr-only">Age</label>
        <input type="number" name="age" class="form-control" maxlength="3" placeholder="'.$row['age'].'">	 
				 
		<label for="income" class="sr-only">Income</label>
        <input type="number" name="income" class="form-control" min="15" max="150" maxlength="8" placeholder="'.$row['income'].'">
		
        <div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Update</button>
		</div></form>';
		
		
			}
		}
		
		else if ($bizuser->num_rows>0){
			while($row = $bizuser->fetch_assoc()){
			echo '<form  class="form-signin" name="queryInput" action="updatebiz.php" method="POST">
	<h2 class="form-signin-heading">Update Business Account</h2>
	  <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" class="form-control" maxlength="15" placeholder="'.$row['username'].'" READONLY	>
			<br/>	
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" maxlength="15" placeholder="password (private)" >
				
		<label for="bizname" class="sr-only">Business Name</label>
        <input type="other" name="name" class="form-control" maxlength="20" placeholder="'.$row['name'].'" >
		
		<label for="email" class="sr-only">Email</label>
        <input type="email" name="email" class="form-control" maxlength="30" placeholder="'.$row['email'].'" >
		
		<label for="street" class="sr-only">Street Address</label>
        <input type="other" name="street" class="form-control" maxlength="30" placeholder="'.$row['addline'].'">
		
		<label for="city" class="sr-only">City</label>
        <input type="other" name="city" class="form-control" maxlength="30" placeholder="'.$zipbc->fetch_object()->c.'" >
		
		<label for="state" class="sr-only">State</label>
        <input type="other" name="state" class="form-control" maxlength="2" placeholder="'.$zipbs->fetch_object()->s.'" >
		
		<label for="zip" class="sr-only">Zip</label>
        <input pattern=".{5,}" type="number" name="zip" id="zip"  class="form-control" maxlength="5" placeholder="'.$row['zip'].'">
		
		    <select class="form-control form-control-sm" name="category">
                 <option value="blank">category</option>
                 <option value="market">market</option>
                 <option value="restaurant">restaurant</option>
				 <option value="IT">IT</option>
				 <option value="finance">finance</option>
				 <option value="education">education</option>
				 <option value="non-profit">non-profit</option>
				 <option value="other">other</option>
             </select>
			 					 
		<label for="income" class="sr-only">yrprofits</label>
        <input type="number" name="income" class="form-control" placeholder="'.$row['income'].'" >
		
        <div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		</div>
	 
	 </form>';
	 		
			
		}}
		else{ echo'Error in finding account.';}
		
		//$userorders="select t.id, productid, name, numbers, t.price from mystore.transaction as t, mystore.product as p where customerid = '$username' and productID = p.ID";
		$userorders="select t.id, productid, numbers, t.price from mystore.transaction as t where customerid = '$username'";
		
			$u_orders = $conn->query($userorders);
			if ($u_orders->num_rows>=0)
			{
				echo "ORDERS";
				echo "<table class='row' border=1px align='center'>";
				echo "<tr>";
				echo "<th class='row' >Order ID</th>";
				echo "<th class='row' >Product ID</th>";
				//echo "<th class='row' >Product</th>";
				echo "<th class='row' >numbers</th>";
				echo "<th class='row' >total</th>";
				
				echo "</tr>";
				while($orow = $u_orders->fetch_assoc())
				{
					echo "<tr>";
					foreach($orow as $key=>$value)
					{
						echo "<td>$value</td>";
				
					}
					
					echo "</tr>";
				}
				echo "</table><br/>";
			}
			else{
				echo "<p>No match</p>";
			}
			
			//$_SESSION['acctdelete'] = $username;		?>	
			
			<form action="accdelete.php" method="POST">
                            <button class="btn btn-danger" name="acctremove" onclick="return confirm('Are you sure you want to delete your account?')" value="<?php $_SESSION['acctdelete'] = $username; ?>">Delete account</button>
							</form>
			<?php
			
       
	 
	 
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
	 
	
  </body>
</html>