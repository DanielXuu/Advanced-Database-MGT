<?php
// include database configuration file
include 'dbConfig.php';
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
            <a class="navbar-brand" href="#">
			
			DB Online Store</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="login.php">Login</a></li>
              <li><a href="createacc.php">Create an Account</a></li>
           
			  <?php
			  session_start();
		  if(isset($_SESSION['username']))
		    echo ' <li ><a href="logout.php"> Log Out</a></li><li class="uname"><a><font color=#1A5276><i>Hello <b>'.$_SESSION['username'].'</font></a></b></i></li>.';
		  else
		  	echo '<li class="uname"><a style="text-decoration: none"><font color=#1A5276><i>Hello, guest.</i></font></a></li>'
             ?>
			 </ul>
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h3>Welcome to our online food store!</h3>
          <?php
          
          if(isset($_SESSION['username']))
              echo 'You are welcome to browse the online store.';
          else
              echo 'You can sign in or browse as a guest.'
          ?>
		  
		   <br/><br/><br/>
         <form class="form-inline" name="queryInput" action="searchlist.php" method="POST">
		 
             <label for='dropdownCountry[]'>Country of Origin</label>
             <select class="form-control form-control-sm" name="dropdownCountry[]">
                 <?php
                 $h_country=array("Select","Australia","Belgium","France","Germany","Luxembourg","New Zealand","Portugal","Spain","Switzerland","United Kingdom","United States");
                 $chosen_country=$_POST['dropdownCountry'];
                 for($i=0;$i<count($h_country);$i++)
                 {
                     $selected_country=(in_array($h_country[$i],$chosen_country)?'selected="selected"':'');
                     echo "<option {value=$h_country[i]} $selected_country".'>'.$h_country[$i].'</option>';
                 }
                 ?>
			 </select>
			 
             <label for='dropdownCategories[]'>Categories</label>
             <select class="form-control form-control-sm" name="dropdownCategories[]">
                 <option value="Select">Select</option>
                 <option value="appetizers">Appetizers</option>
                 <option value="beverages">Beverages</option>
                 <option value="bread">Bread</option>
                 <option value="cereals and potatoes">Cereals and Potatoes</option>
                 <option value="composite foods">Composite Foods</option>
                 <option value="fat and sauces">Fat and Sauces</option>
                 <option value="fish meat eggs">Fish, Meat, Eggs</option>
                 <option value="fruits and vegetables">Fruits and Vegetables</option>
                 <option value="fruits and vegetables">Fruits and Vegetables</option>
                 <option value="milk and dairy products">Milk and Dairy Products</option>
                 <option value="salty snacks">Salty Snacks</option>
                 <option value="sugary snacks">Sugary Snacks</option>
                 <option value="vegetables">Vegetables</option>
			 </select>
		 	 
             <label for='dropdownCalories[]'>Calorie Range</label>
             <select class="form-control form-control-sm" name="dropdownCalories[]">
                 <option value="Select">Select</option>
                 <option value=" and energy<=150">0-150</option>
                 <option value=" and energy>150 and energy<=300">150-300</option>
                 <option value=" and energy>300 and energy<=450">300-450</option>
                 <option value=" and energy>450">more than 450</option>
			 </select>
			 <br/><br/>
             <label for='dropdownFat[]'>Fat Count</label>
             <select class="form-control form-control-sm" name="dropdownFat[]">
                 <option value="Select">Select</option>
                 <option value="and fat=0">Fat Free</option>
                 <option value=" and fat>0 and fat<=5">Low Fat</option>
                 <option value=" and fat>5 and fat<=15">Normal Fat</option>
                 <option value=" and fat>15">High Fat</option>
			 </select>
			 
			 <label for='dropdownProtein[]'>Protein Count</label>
             <select class="form-control form-control-sm" name="dropdownProtein[]">
                 <option value="Select">Select</option>
                 <option value=" and proteins<=6">Low Protein</option>
                 <option value=" and proteins>6 and proteins<=10">Normal Protein</option>
                 <option value=" and proteins>10">High Protein</option>
             </select>
			 
			 <label for='dropdownSugar[]'>Sugar Count</label>
             <select class="form-control form-control-sm" name="dropdownSugar[]">
                 <option value="Select">Select</option>
                 <option value=" and sugars<=2.5">Low Sugar</option>
                 <option value=" and sugars>2.5 and sugars<=10">Normal Sugar</option>
                 <option value=" and sugars>10">High Sugar</option>
              </select>
			<br/><br/>
			<b>Order By:</b>
			<input type="radio" class="form-check-input" name="radioOrder" value="nutritionscore">Nutrition Score
			<input type="radio" class="form-check-input" name="radioOrder" value="price">Price
			<input type="radio" class="form-check-input" name="radioOrder" value="energy">Calories
		<br/><br/>
	  <label for="search" >Search</label>
        <input type="text" name="search" class="form-control" placeholder="enter keyword">
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-primary"type="submit">Go!</button>     
		   
	</form>
	<br/>
   

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

