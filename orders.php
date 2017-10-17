<!DOCTYPE html>
<!-- php: 
	1. Need function to obtain Sales, Profits, and top Selling items under "Sales Statistics." Top items will be in a numbered list.
	2. Need Sales numbers for each region under "Regional Statistics"
	3. List of employees should automatically populate under "Employee List." There is a button for "remove" with action fire.php
	4. Add new item: additem.php
	variables: itemname, amount, details, origin, cat1, cat2, energy, fats, carbs, sugars, protein, nutscore, instock 
	5. Manager must be able to search by item to see sales for that item. There is a search field that returns itemsearch and the action is itemsearch.php 
	**I'm sure this will need some reformatting once all of the php is working! I hope the bits of php I put in were helpful and not more trouble for you!-->
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

    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <style>
  .orders{
	   width: 300px;
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


      <div class="jumbotron">
        <h3>Manager Dashboard</h3>
        
		 <h4>Sales Statistics</h4>
		 <?php
		 $servername = "localhost";
		$username = "root";
		$password = "";
		$conn = new mysqli($servername, $username, $password);
		
		
				
		echo'<h4>INCOMPLETE ORDERS</h4>';
	

			$sqlord="select id from mystore.transaction where salespersonid is NULL GROUP BY id ";
			
			$incomp_ord= $conn->query($sqlord);
			if ($incomp_ord->num_rows>=0)
			{
				echo "<table class ='orders' border=1px align=center>";
				echo "<tr>";
				echo "<th class='orders'>Order ID</th>";
			
				echo "<th class='orders'>ASSIGN SALES PERSON</th>";
				
				echo "</tr>";
				while($row = $incomp_ord->fetch_assoc())
				{
					echo "<tr>";
					foreach($row as $key=>$value)
					{
						echo "<td>$value</td>";
				
					} ?>
					<td><form action="assignsalesperson.php" method="POST">
					<input type="number" name="assignsales" class="form-control" placeholder="number" maxlength="4"><br><br>
                            <button class="btn btn-lg btn-primary btn-block" value= <?php $_SESSION['orderassign'] = $row["id"];?> type="submit">Submit</button>
							</form></td>
					<?php
					echo "</tr>";
				}
				echo "</table>";
			}
			else{
				echo "<p>No match</p>";
			}  ?>
	
        </div>

        </div>
	
		 
		 </div>

       <!-- /container -->


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
