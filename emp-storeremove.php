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
        <div id="top">
            <div id="dashleft">
                <h4>Sales Statistics</h4>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $conn = new mysqli($servername, $username, $password);

                $storedelete = $_POST['itemremove'] ;



                $sqlempremove="DELETE from mystore.store WHERE sID = $storedelete";
                $conn->query($sqlempremove);
                $sqlempremove="DELETE from mystore.salesperson WHERE Storeassignedempid = $storedelete";
                $conn->query($sqlempremove);

                $sqlp="select sum(price) AS saleSum from mystore.transaction";
                $sales = $conn->query($sqlp);


                //echo 'Current Profits:<br/>';

                echo 'Current Sales: $'.$sales->fetch_object()->saleSum.'<br/><br/>';

                echo '<h4>Top Selling Products:</h4>';
                $sqltop="select name, count(name) from mystore.transaction t, mystore.product p where t.productid = p.id group by name order by count(name) desc limit 5";
                $topprod = $conn->query($sqltop);

                while($row = $topprod->fetch_assoc()){
                    echo '<li>'.$row["name"].', Number Sold:'.$row["count(name)"];
                }
                echo '<h4>Store Statistics</h4>';
                $sqlstore="select * from mystore.store where 1";
                $storequery = $conn->query($sqlstore);
                if ($storequery->num_rows>=0)
                {
                    echo "<table border=1px>";
                    echo "<tr>";
                    echo "<th>Store ID</th>";
                    echo "<th>Address</th>";
                    echo "<th>Salesperson</th>";
                    echo "<th>Region</th>";
                    echo "<th>Remove Store</th>";
                    echo "</tr>";
                    while($row = $storequery->fetch_assoc())
                    {
                        echo "<tr>";
                        foreach($row as $key=>$value)
                        {
                            echo "<td>$value</td>";

                        }
                        ?>
                        <td><form action="emp-storeremove.php" method="POST">
                                <input type="hidden" name="itemremove" value="<?php echo $row['sID']; ?>">

                                <button  name="removefromcart" onclick="return confirm('Are you sure?')" type="submit">Remove</button>
                            </form></td>
                        <?php
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                else{
                    echo "<p>No store</p>";
                }

                ?>
            </div>
            <!-- <div id="dashright" >

             //echo '<h4>Regional Statistics</h4>';
            //echo'<ul><li>Region 1: </li> ';
            // echo' <li>Region 2: </li> ';
            // echo' <li>Region 3: </li> ';


             </div>-->
        </div>

        <div id="employees">
            <h4>Employee List</h4>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $conn = new mysqli($servername, $username, $password);

            $sqle="select name, Jobtitle, Storeassignedempid,Salary from mystore.salesperson where 1";

            $result = $conn->query($sqle);
            if ($result->num_rows>=0)
            {
                echo "<table border=1px>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Job Title</th>";
                echo "<th>Store</th>";
                echo "<th>Salary</th>";
                echo "<th>Fired or Resigned</th>";
                echo "</tr>";
                while($row = $result->fetch_assoc())
                {
                    echo "<tr>";
                    foreach($row as $key=>$value)
                    {
                        echo "<td>$value</td>";

                    } ?>
                    <td><form action="emp-boardempremove.php" method="POST">
                            <input type="hidden" name="itemremove" value="<?php echo $row['name']; ?>">

                            <button  name="removefromcart" onclick="return confirm('Are you sure?')" type="submit">Remove</button>
                        </form></td>
                    <?php
                    echo "</tr>";
                }
                echo "</table>";
            }
            else{
                echo "<p>No match</p>";
            }


            $result->free();
            ?>
        </div>

        <div id="newitem">
            <h4>Add/Update a product</h4>

            <form class="form-inline" name="queryInput" action="emp-boardadd.php" method="POST">

                <input type="number" name="prodid" class="form-control" min="0" maxlength="10" placeholder="product number" required>

                <input type="other" name="itemname" class="form-control" maxlength="25" placeholder="name" required>


                <input type="number" name="amount" class="form-control" min="0" maxlength="5" placeholder="amount" required>


                <input type="other" name="details" class="form-control" maxlength="100" placeholder="details" required>


                <input type="other" name="origin" class="form-control" maxlength="20" placeholder="origin" required>


                <input type= "other" name="cat1" class="form-control" maxlength="20" placeholder="category1" required>


                <input type="other" name="cat2" class="form-control" maxlength="20" placeholder="category2" required>


                <input type="number" name="energy" class="form-control" maxlength="6" min="0" placeholder="energy (calories)" required>


                <input type="number" name="fats" class="form-control" maxlength="5" min="0" placeholder="fat in grams" required>


                <input type="number" name="carbs" class="form-control" maxlength="5" min="0" placeholder="carbs in grams" required>


                <input type="number" name="sugars" class="form-control" maxlength="5" min="0" placeholder="sugars in grams" required>


                <input type="number" name="protein" class="form-control" maxlength="5" min="0" placeholder="protein in grams" required>


                <input type="number" name="nutscore" class="form-control" maxlength="3" min="0" placeholder="nutrition score" required>

                <input type="number" name="instock" class="form-control" maxlength="5" min="0" placeholder="number in stock" required>

                <input type="number" name="price" class="form-control" maxlength="6" min="0" placeholder="price" required>

                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary"type="submit">Add</button>

            </form>
            <br/>

        </div>
        <div id="newitem">
            <h4>Add/Update a store</h4>

            <form class="form-inline" name="queryInput" action="emp-storeadd.php" method="POST">

                <input type="number" name="sID" class="form-control" min="0" maxlength="100" placeholder="store ID" required>

                <input type="other" name="address" class="form-control" maxlength="25" placeholder="address" required>


                <input type="number" name="salesperson" class="form-control" min="0" maxlength="100" placeholder="salesperson amount" required>


                <input type="number" name="region" class="form-control"  placeholder="region" required>
                <button class="btn btn-primary"type="submit">Add</button>

            </form>
            <br/>

        </div>

        <div id="prodsearch">
            <h4>Search Product Sales and Status</h4>
            <form action="emp-boardsearch.php" method="POST">
                <label for="search" >Search</label>
                <input type="text" name="itemsearch" class="form-control" maxlength = "50" placeholder="enter item name">
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary"type="submit">Go!</button>
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
</body>
</html>
