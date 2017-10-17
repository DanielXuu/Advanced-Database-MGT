<?php
// initializ shopping cart class
include 'Cart.php';
$cart = new Cart;
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Cart - PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    .container{padding: 50px;}
    input[type="number"]{width: 20%;}
    </style>
    <script>
    function updateCartItem(obj,id){
        $.get("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('Cart update failed, please try again.');
            }
        });
    }
    </script>
</head>
</head>
<body>
<div class="container">
    <h1>Shopping Cart</h1>
    <table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
			<th>&nbsp;</th>
			<
            <th>Subtotal</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
         <?php
		 $servername = "localhost";
		 $username = "root";
		 $password = "";
		 $conn = new mysqli($servername, $username, $password);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		
		$sqlgetcart = "SELECT id, name, price, quantity, instocknum from mystore.product p, mystore.cart c where productID = ID";
		$getcart =$conn->query($sqlgetcart);
		
        if($getcart->num_rows> 0){
			while($row = $getcart->fetch_assoc()){
            //get cart items from session
            //$cartItems = $getcart->contents();
            //foreach($cartItems as $item){
        ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo '$'.$row["price"].' USD'; ?></td>
            <td><form action="shoppingcartincrease.php" method="POST">
			<input type="number" class="form-control text-center" name="quant" value="<?php echo $row["quantity"]; ?>"></td>
			<input type="hidden" name="itemupdate" value="<?php echo $row['id']; ?>">
			<td><button class="btn btn-control" name="update" type="submit">Update Amt</button>
            </form></td>
			<td><?php echo '$'.$row["price"]*$row["quantity"].' USD'; ?></td>
            <td>
				<form action="shoppingcartremove.php" method="POST">
				<input type="hidden" name="itemremove" value="<?php echo $row['id']; ?>">
                            
                            <button class="btn btn-danger" name="removefromcart" onclick="return confirm('Are you sure?')" type="submit">Remove</button>
							</form>
                
            </td>
        </tr>
        <?php } }else{ ?>
        <tr><td colspan="5"><p>Your cart is empty.....</p></td>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td><a href="index.php" class="btn btn-warning"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a></td>
            <td colspan="2"></td>
            <?php 
			$sqltotal="Select sum(price*quantity) as total From mystore.product, mystore.cart Where ID = productID";
			$total = $conn->query($sqltotal);
						
			if($getcart->num_rows> 0){ ?>
            <td class="text-center"><strong>Total <?php echo '$'.$total->fetch_object()->total.' USD'; ?></strong></td>
            <td><a href="checkout.php" class="btn btn-success btn-block">Checkout <i class="glyphicon glyphicon-menu-right"></i></a></td>
            <?php } ?>
        </tr>
    </tfoot>
    </table>
</div>
</body>
</html>