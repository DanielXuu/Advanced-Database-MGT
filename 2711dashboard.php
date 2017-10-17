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
    <style>
        #tb{width: 30%;margin-left:35%; margin-right:35%;}
        td {text-align: center;vertical-align: middle;}
    </style>
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
                            echo' <li ><a href="emp-board.php"> Manager Dasboard</a></li>
                    <li ><a href="2711dashboard_neo.php"> Neo4j Dasboard</a></li>
                    <li ><a href="2711dashboard.php"> Mysql Dasboard</a></li>
					<li ><a href="orders.php"> Orders</a></li>
					<li ><a href="logout.php"> Log Out</a></li>';
                    ?>
                </ul>
            </div><!--/.container-fluid -->
        </div>
    </nav>

</div>

    <div class="jumbotron" style="height: 1000px">
    <h3>Mysql Dashboard</h3><br>
    <label>Question Option</label>
    <form action="2711dashboard.php" method="post">
        <select class="form-control form-control-sm" name="question" style="width: 600px;position: absolute;margin-left: 350px">
                 <option value="0">Select</option>
                 <option value="1">What is the ratio of business to home customers?</option>
                 <option value="2">What stores are increasing in sales?</option>
                 <option value="3">Maintain every year the aggregate sales and profit of the top 5 and the bottom 5 products.</option>
                 <option value="4">Maintain every year the top 2 customer categories (highest sales) and the top product categories.</option>
                 <option value="5">How do the various regions compare by sales volume?</option>
                 <option value="6">Which businesses are buying given products the most?</option>
                 <option value="7">What is the demand curve for each product category?</option>
                 <option value="8">Customers that buy the product more than 2 times per month</option>
        </select>
        <br><br><br>
        <input type="submit" name="submit" value="submit" />
    </form>

<?php
   
   
  
   $servername = "localhost";
   $username = "root";
   $password = "";
   $conn = new mysqli($servername, $username, $password);
   if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
   }

    if(isset($_POST['submit'])){
        $selected_val = $_POST['question'];   
        
        switch ($selected_val) {
        case '1':
            $sql="select (SELECT count(*) from mystore.customer_business)/(SELECT count(*) from mystore.customer_home) as rate";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<br> The ratio of business to home customers: ". $row["rate"]. "<br>";
                }
            } else {
                echo "0 results";
            }
            break;
            
        case '2':
            $sql = "select salesperson.Storeassignedempid as ss,SUM(sum1),y1 from mystore.salesperson, (SELECT SalesPersonId,YEAR(date) as y1, SUM(numbers) as sum1 FROM mystore.transaction group by SalesPersonId,YEAR(date)) as tb1 where salesperson.empid = tb1.SalesPersonId group by Storeassignedempid,y1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table id='tb'><tr><th>StoreID</th><th>SaleVolume</th><th>Year</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["ss"]. "</td><td>" . $row["SUM(sum1)"]. "</td><td> " . $row["y1"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            break;
            
        case '3':
            $sql = "Select product.Name as pn, tb1.sum1 as sum,y1 from mystore.product, (Select ProductId,year(date) as y1, SUM(Price) as sum1 from mystore.transaction group by ProductId,year(date)) as tb1 WHERE tb1.ProductId = product.ID group by product.Name,y1,sum1 ORDER BY sum1 DESC LIMIT 5";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table id='tb'><tr><th>ProductName</th><th>Profit</th><th>Year</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["pn"]. "</td><td>" . $row["sum"]. "</td><td> " . $row["y1"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            $sql2 = "Select product.Name as pn, tb1.sum1 as sum,y1 from mystore.product,
                    (Select ProductId,year(date) as y1, SUM(Price) as sum1
                    from mystore.transaction group by ProductId,year(date)) as tb1
                    WHERE tb1.ProductId = product.ID group by product.Name,y1,sum1
                    ORDER BY sum1 asc LIMIT 5";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                echo "<table id='tb'><tr><th>ProductName</th><th>Profit</th><th>Year</th></tr>";
                // output data of each row
                while($row = $result2->fetch_assoc()) {
                    echo "<tr><td>" . $row["pn"]. "</td><td>" . $row["sum"]. "</td><td> " . $row["y1"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        break;
        
        case '4':
            $sql = "select year, sum,gender,marriage from ( SELECT year,sum,gender,marriage, @row:=case when @prev=year then @row else 0 end +1 rn, @prev:=year FROM mystore.category t CROSS JOIN (select @row:=0, @prev:=null) c order by year, sum desc ) src where rn <= 2 order by year, sum";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "Top 2 Customer Categories";
                echo "<table id='tb'><tr><th>Year</th><th>TotalPrice</th><th>Gender</th><th>Marriage</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["year"]. "</td><td>" . $row["sum"]. "</td><td> " . $row["gender"]. "</td><td>" . $row["marriage"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            
            $sql2 = "select y1, sum,Category2 from ( SELECT y1,sum,Category2, @row:=case when @prev=y1 then @row else 0 end +1 rn, @prev:=y1 FROM mystore.category2 t CROSS JOIN (select @row:=0, @prev:=null) c order by y1, sum desc ) src where rn <= 2 order by y1, sum";
            $result2 = $conn->query($sql2);
            if ($result->num_rows > 0) {
                echo "Top 2 Product Categories";
                echo "<table id='tb'><tr><th>Year</th><th>SaleNumber</th><th>Category</th></tr>";
                // output data of each row
                while($row = $result2->fetch_assoc()) {
                    echo "<tr><td>" . $row["y1"]. "</td><td>" . $row["sum"]. "</td><td> " . $row["Category2"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        break;
        
        case '5':
            $sql = "select RegionId, SUM(sum) from mystore.store, (select s.Storeassignedempid as sid, SUM(t.numbers) as sum from mystore.transaction t,mystore.salesperson s where s.empid=t.SalesPersonId group by s.Storeassignedempid) as tb1 where store.sID = tb1.sid group by RegionID";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "The businesses are buying given products the most";
                echo "<table id='tb'><tr><th>RegionID</th><th>SaleNumber</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["RegionId"]. "</td><td>" . $row["SUM(sum)"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        break;

            case '6':
                $sql = "select customer_business.name as cn,sum from mystore.customer_business,(select CustomerId, sum(numbers) as sum from mystore.transaction group by CustomerId)as tb1 where tb1.CustomerId = customer_business.username ORDER BY sum DESC limit 1;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo "The businesses are buying given products the most";
                    echo "<table id='tb'><tr><th>Business Name</th><th>SaleNumber</th></tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["cn"]. "</td><td>" . $row["sum"]. "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }
                break;


            case'7':
            $column = array();
            $sql = "select SUM(numbers),Price/numbers as sp from mystore.transaction where ProductId=527 group by sp;";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "Product Tableta de chocolate negro 85% cacao";
                echo "<table id='tb'><tr><th>SaleNumber</th><th>Price</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["SUM(numbers)"]. "</td><td>" . $row["sp"]. "</td></tr>";
                } 
                echo "</table>";                
            } else {
                echo "0 results";
            }
        break;
        
        case '8':
            $sql = "select CustomerId,count(*) from (select YEAR(date),MONTH(date),CustomerId,count(*) count from mystore.transaction group by YEAR(date),MONTH(date), CustomerId Having count(*) >= 3) as tb1 group by CustomerId having count(*) >= 75";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "Customers buy the product more than 2 times per month";
                echo "<table id='tb'><tr><th>CustomerID</th><th>Month Number</th></tr>";
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["CustomerId"]. "</td><td>" . $row["count(*)"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        break;
    
        default:
            break;
        }
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