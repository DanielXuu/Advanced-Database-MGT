<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>DB Online Store</title>


    <link href="css/bootstrap.min.css" rel="stylesheet">


    <link href="style.css" rel="stylesheet">


    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    
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
</div> <!-- /container -->
<div  class="jumbotron">
<?php
$username=$_POST['username'];
$password=$_POST['password'];
$bizname=$_POST['bizname'];
$email =$_POST['email'];
$street=$_POST['street'];
$city=$_POST['city'];
$state=$_POST['state'];
$statel=strlen($state);
$zip=$_POST['zip'];
$zip=intval($zip);
$zipl = strlen((string)$zip);
$category = $_POST['category'];
$yrprofits = $_POST['yrprofits'];


$servername = "localhost";
$databaseusername = "root";
$databasepassword = "";
$conn = new mysqli($servername, $databaseusername, $databasepassword);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql1="select * from mystore.customer_home where username='$username'";
$result =$conn->query($sql1);
if ($statel!=2) {
  echo "State Code number be two letters  <a href='createacct.php'>Back</a>";
}
else if ($zipl!=5) {
  echo "Zip Code must be 5 numbers  <a href='createacct.php'>Back</a>";
}
else if($result->num_rows>0)
{
    echo 'Failed:Account already exists <a href="createacct.php">Back</a>';
}
else
{
    $sql="insert into mystore.customer_business values ('$username','$bizname','$email','$street','$zip','$category','$yrprofits')";
    if($conn->query($sql)==false)
      echo "Error: " . $sql . "<br>" . $conn->error;
    $sql2="insert into mystore.login values('$username','$password');";
    $conn->query($sql2);
	$sql3="insert into mystore.zip values('$zip','$city', '$state');";
    $conn->query($sql3);
    echo 'Succeed! <a href="login.php">Sign in</a>';
}

?>

</div>
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