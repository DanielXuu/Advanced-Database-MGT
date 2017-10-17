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
    <script type="text/javascript" src="http://static.fusioncharts.com/code/latest/fusioncharts.js"></script>
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

<div class="jumbotron" >
    <h3>Neo4j Dashboard</h3>
<?php
include("fusioncharts.php");
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;
$client = ClientBuilder::create()
    ->addConnection('default', 'bolt://neo4j:123@localhost:7687') // Example for HTTP connection configuration (port is optional)
    ->build();


/*EXAMPLE
$result = $client->run('MATCH (n:region) RETURN n');
$aaaa;
foreach ($result->getRecords() as $record) {
    //var_dump($record);
    $Node = $record->get('n');
    $aaaa=$Node->value('rID');
}
*/

//QUERY1

$result = $client->run('MATCH (n:customer) where exists(n.gender) RETURN count(n)');
$record = $result->getRecord();
$numHome = $record->get('count(n)');
$result = $client->run('MATCH (n:customer) RETURN count(n)');
$record = $result->getRecord();
$numBus = $record->get('count(n)')-$numHome;


         $arrData =array(
            "chart" =>array(
                "caption"=> "Ratio of Customers",
                "subCaption"=> "by April 2017",
                "paletteColors"=> "#43A3E2,#f2c500",
                "numberPrefix"=> "",
                "showPercentInTooltip"=> "0",
                "decimals"=> "1",
                "useDataPlotColorForLabels"=> "1",
                "baseFontSize" => "20",
                "labelFontSize" => "16",
                "labelFontBold" => "true",
                "theme"=> "fint")
                     );

	 $actualData = array(
                "HOME" => $numHome,
                "BUSINESS" => $numBus
            );
            $arrData['data'] = array();
            // Iterate through the data in `$actualData` and insert in to the `$arrData` array.
            foreach ($actualData as $key => $value) {
                array_push($arrData['data'],
                    array(
                        'label' => $key,
                        'value' => $value
                    )
                );
            }

        $jsonEncodedData = json_encode($arrData);
        // chart object
        $msChart = new FusionCharts("pie2D", "ratio", "100%", "400", "chart-container1", "json", $jsonEncodedData);
        $msChart->render("chart-container1");

?>
<div id="dashleft">
    <div id="chart-container1">
    Fusion Charts will render here
    </div>
</div>
    <?php
    //QUERY2
    $result = $client->run('MATCH (n:fact) RETURN n.sID,n.Year,sum(n.Price) order by n.sID,n.Year asc');
    $count=0;
    $categoryArray=array();
    $dataseries1=array();
    $dataseries2=array();
    $dataseries3=array();
    $dataseries4=array();
    $dataseries5=array();

    foreach ($result->getRecords() as $record) {
    if($count<7) array_push($categoryArray, array("label" => $record->get('n.Year')));
        if($count<7)  array_push($dataseries1, array("value" => $record->get('sum(n.Price)')));
        else if($count<14)  array_push($dataseries2, array("value" => $record->get('sum(n.Price)')));
        else if($count<21)  array_push($dataseries3, array("value" => $record->get('sum(n.Price)')));
        else if($count<28)  array_push($dataseries4, array("value" => $record->get('sum(n.Price)')));
        else array_push($dataseries5, array("value" => $record->get('sum(n.Price)')));
    $count++;
    }

    $arrData2 = array(
        "chart" => array(
            "caption"=> "Comparison of Stores",
            "captionFontSize"=> "20",
            "xAxisname"=> "Year",
            "yAxisName"=> "Total Number of Sales",
            "numbersuffix"=> "%",
            "showvalues"=>"0",
            "anchorRadius"=> "6",
            "anchorBorderThickness"=> "2",
            "bgcolor"=>"#89C3C4",
            "canvasbgcolor"=>"#A0CBC2",
            "showPlotBorder"=>"1",
            "baseFont"=> "Open Sans",
            "theme" => "fint"
        )
    );

    $arrData2["categories"]=array(array("category"=>$categoryArray));
    // creating dataset object
    $arrData2["dataset"] = array(
        array("seriesName"=> "Store1", "data"=>$dataseries1),
        array("seriesName"=> "Store2", "data"=>$dataseries2),
        array("seriesName"=> "Store3", "data"=>$dataseries3),
        array("seriesName"=> "Store4", "data"=>$dataseries4),
        array("seriesName"=> "Store5", "renderAs"=>"line", "data"=>$dataseries5));

    $jsonEncodedData2 = json_encode($arrData2);
    // chart object
    $msChart2 = new FusionCharts("msline","stores_chart" , "100%", "400", "chart-container2", "json", $jsonEncodedData2);
    $msChart2->render("chart-container2");
?>
    <div id="dashright">
        <div id="chart-container2"></div>
    </div>

    <?php
    //QUERY3
    $categoryArray=array();
    $dataseries1=array();
    $dataseries2=array();
    $dataseries3=array();
    $dataseries4=array();
    $dataseries5=array();
    $dataseries6=array();
    $dataseries7=array();
    $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\'2008\' return n.Name,sum(toInteger(m.Price)) as total order by total desc limit 5');
    foreach ($result->getRecords() as $record) array_push($dataseries1, array("value" => $record->get('total'),"displayValue"=>$record->get('n.Name')));
    $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\'2009\' return n.Name,sum(toInteger(m.Price)) as total order by total desc limit 5');
    foreach ($result->getRecords() as $record) array_push($dataseries2, array("value" => $record->get('total'),"displayValue"=>$record->get('n.Name')));
    $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\'2010\' return n.Name,sum(toInteger(m.Price)) as total order by total desc limit 5');
    foreach ($result->getRecords() as $record) array_push($dataseries3, array("value" => $record->get('total'),"displayValue"=>$record->get('n.Name')));
    $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\'2011\' return n.Name,sum(toInteger(m.Price)) as total order by total desc limit 5');
    foreach ($result->getRecords() as $record) array_push($dataseries4, array("value" => $record->get('total'),"displayValue"=>$record->get('n.Name')));
    $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\'2012\' return n.Name,sum(toInteger(m.Price)) as total order by total desc limit 5');
    foreach ($result->getRecords() as $record) array_push($dataseries5, array("value" => $record->get('total'),"displayValue"=>$record->get('n.Name')));
    $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\'2013\' return n.Name,sum(toInteger(m.Price)) as total order by total desc limit 5');
    foreach ($result->getRecords() as $record) array_push($dataseries6, array("value" => $record->get('total'),"displayValue"=>$record->get('n.Name')));
    $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\'2014\' return n.Name,sum(toInteger(m.Price)) as total order by total desc limit 5');
    foreach ($result->getRecords() as $record) array_push($dataseries7, array("value" => $record->get('total'),"displayValue"=>$record->get('n.Name')));

    array_push($categoryArray, array("label" => 'Top1'));
    array_push($categoryArray, array("label" => 'Top2'));
    array_push($categoryArray, array("label" => 'Top3'));
    array_push($categoryArray, array("label" => 'Top4'));
    array_push($categoryArray, array("label" => 'Top5'));

    $arrData3 = array(
        "chart" => array(
        "caption"=> "Top5 products of each year",
        "xAxisName"=> "Rank",
        "yAxisName"=> "Sales (In USD)",
        "numberPrefix"=> "$",
        "paletteColors"=> "#F54EA2,#1aaf5d,#f2c500,#0075c2,#8C54A1,#388186,#F56262",
        "bgColor"=> "#ffffff",
        "showBorder"=> "0",
        "showCanvasBorder"=> "0",
        "usePlotGradientColor"=> "0",
        "plotBorderAlpha"=> "10",
        "legendBorderAlpha"=> "0",
        "legendBgAlpha"=> "0",
        "legendShadow"=> "0",
        "showHoverEffect"=> "1",
        "valueFontColor"=> "#ffffff",
        "rotateValues"=> "1",
        "placeValuesInside"=> "1",
        "divlineColor"=> "#999999",
        "divLineDashed"=> "1",
        "divLineDashLen"=> "1",
        "canvasBgColor"=> "#ffffff",
        "captionFontSize"=> "20",
        "labelFontColor"=> "#085B74",
            "valuefontcolor"=> "#045FB4",
        //"subcaptionFontSize"=> "14",
        //"subcaptionFontBold"=> "0"
        )
    );
    $arrData3["categories"]=array(array("category"=>$categoryArray));

    $arrData3["dataset"] = array(
        array("seriesName"=> "2008", "data"=>$dataseries1),
        array("seriesName"=> "2009", "data"=>$dataseries2),
        array("seriesName"=> "2010", "data"=>$dataseries3),
        array("seriesName"=> "2011", "data"=>$dataseries4),
        array("seriesName"=> "2012", "data"=>$dataseries5),
        array("seriesName"=> "2013", "data"=>$dataseries6),
        array("seriesName"=> "2014", "data"=>$dataseries7));
    $jsonEncodedData3 = json_encode($arrData3);
    // chart object
    $msChart3 = new FusionCharts("mscolumn3d","product_chart" , "100%", "520", "chart-container3", "json", $jsonEncodedData3);
    $msChart3->render("chart-container3");

    ?>
    <div id="chart-container3"></div>

<div>
<style type="text/css">
    table{
        opacity: .95;
        filter: alpha(opacity=50);
        background-color: white;
        align: center;
        height:100%;
        width:100%;
        padding:4px 3px;

    }

</style>

    <?php
    echo "<table>";
    echo "<tr>";
    echo "<th>Year</th>";
    echo "<th>Bottom1</th>";
    echo "<th>Bottom2</th>";
    echo "<th>Bottom3</th>";
    echo "<th>Bottom4</th>";
    echo "<th>Bottom5</th>";
    echo "<th>BottomTotal</th>";
    echo "<th>YearTotal</th>";
    echo "<th>Percentage</th>";
    echo "</tr>";
    $result1=$client->run('MATCH (n:fact) RETURN n.Year,sum(n.Price) as sum order by n.Year');
    for($Year=2008;$Year<2015;$Year++){
        $result = $client->run('match(n:product)-[:sell]->(m:transaction) where m.Year=\''.$Year.'\' return n.Name,sum(toInteger(m.Price)) as total order by total asc limit 5');
        $botsum=0;
        echo "<tr>";
        echo "<td>$Year</td>";
        foreach ($result->getRecords() as $record) {
            $botsum+=$record->get('total');
            $name=$record->get('n.Name');
            echo "<td>$name</td>";
        }
        echo "<td>$botsum</td>";
        $annsum=$result1->getRecords()[$Year-2008]->get('sum');
        echo "<td>$annsum</td>";
        $percentage=round(($botsum/$annsum)*100,3).'%';
        echo "<td>$percentage</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
        </div>


    <?php
     //QUERY4
    $categoryArray=array();
    $dataseries1=array();
    $dataseries2=array();
    $dataseries3=array();
    $dataseries4=array();

    $result = $client->run('match(n:customer)-[:buy]->(m:transaction) where exists(n.gender) return m.Year,n.gender,n.marriage,sum(toInteger(m.Price)) as total order by m.Year,n.gender,n.marriage');
    $count=0;
    foreach ($result->getRecords() as $record) {
        if($count%4==0) array_push($categoryArray, array("label" => $record->get('m.Year')));
        if($count%4==0)  array_push($dataseries1, array("value" => $record->get('total')));
        else if($count%4==1)  array_push($dataseries2, array("value" => $record->get('total')));
        else if($count%4==2)  array_push($dataseries3, array("value" => $record->get('total')));
        else  array_push($dataseries4, array("value" => $record->get('total')));
        $count++;
    }
    $arrData4 = array(
        "chart" => array(
            "caption"=> "Customer purchase each year",
            "xAxisName"=> "Year",
            "yAxisName"=> "Sales (In USD)",
            "numberPrefix"=> "$",
            "paletteColors"=> "#0075c2,#1aaf5d,#F56262,#f2c500",
            "bgColor"=> "#ffffff",
            "showBorder"=> "0",
            "showCanvasBorder"=> "0",
            "usePlotGradientColor"=> "0",
            "plotBorderAlpha"=> "10",
            "legendBorderAlpha"=> "0",
            "legendBgAlpha"=> "0",
            "legendShadow"=> "0",
            "showHoverEffect"=> "1",
            "valueFontColor"=> "#ffffff",
            "rotateValues"=> "1",
            "placeValuesInside"=> "1",
            "divlineColor"=> "#999999",
            "divLineDashed"=> "1",
            "divLineDashLen"=> "1",
            "canvasBgColor"=> "#ffffff",
            "captionFontSize"=> "20",
            //"subcaptionFontSize"=> "14",
            //"subcaptionFontBold"=> "0"
        )
    );
    $arrData4["categories"]=array(array("category"=>$categoryArray));

    $arrData4["dataset"] = array(
        array("seriesName"=> "Married Female", "data"=>$dataseries1),
        array("seriesName"=> "Single Female", "data"=>$dataseries2),
        array("seriesName"=> "Married Male", "data"=>$dataseries3),
        array("seriesName"=> "Single Male", "data"=>$dataseries4));
    $jsonEncodedData4 = json_encode($arrData4);
    // chart object
    $msChart4 = new FusionCharts("stackedcolumn3d","cushome_chart" , "100%", "520", "chart-container4", "json", $jsonEncodedData4);
    $msChart4->render("chart-container4");

    ?>

        <div id="dashleft">
        <div id="chart-container4"></div>
    </div>
    <?php
    $result = $client->run('MATCH(t:transaction)<-[:handle]-(s:salesperson)-[:belong]->(m:store)-[:locate]->(n:region) RETURN n.Name,sum(toInteger(t.numbers)) as total');
    $arrData =array(
        "chart" =>array(
            "caption"=> "Sale volume of each region",
            "captionFontSize"=> "20",
            "subCaption"=> "by April 2017",
            "numberPrefix"=> "",
            "showPercentInTooltip"=> "0",
            "decimals"=> "1",
            "useDataPlotColorForLabels"=> "1",
            "labelFontSize" => "16",
            "labelFontBold" => "true",
            "theme"=> "fint")
    );
    $arrData['data'] = array();
    foreach ($result->getRecords() as $record)
        array_push($arrData['data'], array("label" => $record->get('n.Name'),"value"=>$record->get('total')));

    $jsonEncodedData = json_encode($arrData);
    // chart object
    $msChart5 = new FusionCharts("pie3D", "regionchart", "100%", "520", "chart-container5", "json", $jsonEncodedData);
    $msChart5->render("chart-container5");
    ?>
    <div id="dashright">
        <div id="chart-container5"></div>
    </div>

    <?php
    $result = $client->run('MATCH (n:product)-[r:sell]->(m:transaction) where n.ID=\'505\' with m.Year as ye,n,sum(toInteger(m.Price)) as sum order by m.Year asc, n.Year desc,n.Month desc with ye,collect(n.Price)[..1] as pri,sum(sum) as yearsum unwind pri as price return ye,price,yearsum order by ye');

    $categoryArray=array();
    $dataseries1=array();
    $dataseries2=array();

    foreach ($result->getRecords() as $record) {
        array_push($categoryArray, array("label" => $record->get('ye')));
        array_push($dataseries1, array("value" => $record->get('yearsum')));
        array_push($dataseries2, array("value" => $record->get('price')));
    }
    $arrData6 = array(
        "chart" => array(
            "caption"=> "Customer purchase each year",
            "captionFontSize"=> "20",
            "xAxisName"=> "Year",
            "yAxisName"=> "Sales (In USD)",
            "numberPrefix"=> "$",
            "sYAxisName"=> "Unit Price",
            "sNumberSuffix"=> "$",
            "sYAxisMaxValue"=> "25",
            "paletteColors"=> "#0075c2,#1aaf5d,#f2c500",
            "bgColor"=> "#ffffff",
            "showBorder"=> "0",
            "showCanvasBorder"=> "0",
            "usePlotGradientColor"=> "0",
            "plotBorderAlpha"=> "10",
            "legendBorderAlpha"=> "0",
            "legendBgAlpha"=> "0",
            "legendShadow"=> "0",
            "showHoverEffect"=> "1",
            "valueFontColor"=> "#ffffff",
            "rotateValues"=> "1",
            "placeValuesInside"=> "1",
            "divlineColor"=> "#999999",
            "divLineDashed"=> "1",
            "divLineDashLen"=> "1",
            "canvasBgColor"=> "#ffffff",
            "captionFontSize"=> "20",
            //"subcaptionFontSize"=> "14",
            //"subcaptionFontBold"=> "0"
        )
    );
    $arrData6["categories"]=array(array("category"=>$categoryArray));

    $arrData6["dataset"] = array(
        array("seriesName"=> "Tortellini au jambon", "data"=>$dataseries1),
        array("seriesName"=> "Unit price", "renderAs"=>"line", "parentYAxis"=>"S", "showValues"=> "0","data"=>$dataseries2));
    $jsonEncodedData6 = json_encode($arrData6);
    // chart object
    $msChart6 = new FusionCharts("mscolumn3dlinedy","product_curve" , "100%", "400", "chart-container6", "json", $jsonEncodedData6);
    $msChart6->render("chart-container6");
    ?>

    <div id="chart-container6"></div>
<p style="font-size:320%; color:#F56262; font-family:fantasy " >Other intetresting Stastics:</p>
    <p style="font-size:270%; color:#0075c2 ;font-family:fantasy " >The top 1 category of each year:</p>
    <?php
    // list results
    //echo '<font size="80" color="#78BBE6" face="Arial">'.'Other intetresting analysis'.'</font>';

    //find top 1 category of each year
    $result = $client->run('MATCH (n:product)-[:sell]->(m:transaction) with n.Category2 as cat, m.Year as ye, sum(toInteger(m.Price)) as total order by ye ,total desc with ye,collect(cat)[..1] as col unwind col as category return ye, category order by ye');
    foreach ($result->getRecords() as $record) {
        echo "<p style=\"font-size:230%; font-family:fantasy \" >".$record->get('ye').':'.'&nbsp;'.'&nbsp;'.$record->get('category')."</p>";
    }
    //find top 1 business
    echo '</br>';
    $result = $client->run('MATCH (n:customer)-[:buy]->(m:transaction) where exists(n.category) return n.name, sum(toInteger(m.Price)) as total order by total desc limit 1');
    echo "<p style=\"font-size:270%; color:#0075c2 ;font-family:fantasy \" >The top 1 Business:</p>";
    echo "<p style=\"font-size:230%; font-family:fantasy \" >".$result->getRecord()->get('n.name')."</p>";
    echo'</br>';
    //frequent customers who comes 3 times almost every month(75/76)
    echo "<p style=\"font-size:270%; color:#0075c2 ;font-family:fantasy \" >The frequent customers who come 3 times almost every month:</p>";

    $result = $client->run('MATCH (n:customer)-[:buy]->(m:transaction) with m.Year as ye,m.Month as mo,n.name as na,count(*) as freq where freq>2 with na, count(*) as total where total>74 return na order by total desc');
    echo "<p style=\"font-size:230%; font-family:fantasy \" >";
    $ntime=0;
    foreach ($result->getRecords() as $record) {
        echo $record->get('na').'&nbsp;'.'&nbsp;'.'&nbsp;'.'&nbsp;';
        if($ntime%3==2) echo'</br>';
        $ntime++;
        ;}
    echo'</p>';
    ?>
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