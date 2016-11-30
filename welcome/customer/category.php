<?php
	session_start();
	require_once('../mysqli_connect.php');
	$category = $_GET['category'];
	/*echo "<script type='text/javascript'>alert('$category');</script>";*/


	$query = "SELECT * FROM Goods WHERE category='".$category."' ORDER BY Price LIMIT 9 lock in share mode;";

	$response = mysqli_query($db,$query);
	if($response){
		$a =array();

		while($row = mysqli_fetch_array($response)){
			array_push($a,$row);
		}
		$_SESSION['content'] = $a;
	}

	if(isset($_SESSION['num'])){
		if(isset($_POST['num'])){
			$_SESSION['num']=$_SESSION['num']+$_POST['num'];
			$_SESSION['item'] = $_POST['name'];
			if(isset($_SESSION['shoppingList'])){
				if(isset($_SESSION['shoppingList'][$_POST['name']]))
					$_SESSION['shoppingList'][$_POST['name']] += $_POST['num'];
				else
					$_SESSION['shoppingList'][$_POST['name']] = $_POST['num'];
			}else{
				$_SESSION['shoppingList'] = array();
				$_SESSION['shoppingList'][$_POST['name']] = $_POST['num'];


			}
			//echo "<p>".$_SESSION['item']."</p>";
		}

	}else{
		$_SESSION['num']=0;
	}

//Search button
if (isset($_POST['search_btn'])){
	$search = $_POST['searchContent'];
	header("location: search.php?searchContect=".$search);
}
mysqli_close($db);
?>



<!DOCTYPE html>
<html lang="en">

<!--used for num of items-->
<form id="form" method="POST" action="">
	<input type="hidden" id="name" name="name"/>
	<input type="hidden" id="num" name="num"/>
</form>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="">
    <meta name="author" content="">
	
    <title>Mobile Shop</title>
	
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css"  type="text/css">
	
	<!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
	
	
	<!-- Custom Fonts -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css"  type="text/css">
    <link rel="stylesheet" href="fonts/font-slider.css" type="text/css">
	
	<!-- jQuery and Modernizr-->
	<script src="js/jquery-2.1.1.js"></script>
	
	<!-- Core JavaScript Files -->  	 
    <script src="js/bootstrap.min.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->

	<script type="text/javascript">
		function MyReason(name){
			var num = prompt("Number of items",0);
			document.getElementById("name").value = name;
			document.getElementById("num").value = num;
			document.getElementById("form").submit();
		}

	</script>
</head>
<body>
	<!--Top-->
	<nav id="top">
		<div class="container">
			<div class="row">
				<div class="col-xs-6">
					<select class="language">
						<option value="English" selected>English</option>
						<option value="Chinese">Chinese</option>
					</select>
					<select class="currency">
						<option value="MOP" selected>MOP</option>
						<option value="CNY">CNY</option>
					</select>
				</div>
				<div class="col-xs-6">
					<ul class="top-link">
						<li><?php echo "Welcome, " . $_SESSION['username']." !";?></li>
						<li><a href="http://127.0.0.1/authentication/logout.php"><span class="glyphicon glyphicon-user"></span> Log out</a></li>
						<li><a href="contact.php"><span class="glyphicon glyphicon-envelope"></span> Contact</a></li>
					</ul>
				</div>
			</div>
		</div>
	</nav>
	<!--Header-->
	<header class="container">
		<div class="row">
			<div class="col-md-4">
				<div id="logo">Famer's Supermarket</div>
			</div>
			<div class="col-md-4">
				<form class="form-search" method="post">
					<input placeholder="Orange" type="text" class="input-medium search-query" name="searchContent">
					<!--<input class="btn" type="submit" name="login_btn" value="ADD">-->
					<button type="submit" class="btn" name="search_btn"><span class="glyphicon glyphicon-search"></span></button>
				</form>
			</div>
			<div class="col-md-4">
				<div id="cart"><a class="btn btn-1" href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span>
						<?php if(isset($_SESSION['num']))
					echo "CART : ".$_SESSION['num'] ." ITEM";
						else echo "CART : 0 ITEM";?></a></div>
			</div>
		</div>
	</header>
	<!--Navigation-->
	<nav id="menu" class="navbar">
		<div class="container">
			<div class="navbar-header"><span id="heading" class="visible-xs">Categories</span>
				<button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Home</a></li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Fruits</a>
						<div class="dropdown-menu">
							<div class="dropdown-inner">
								<ul class="list-unstyled">
									<li><a href="<?php
										$var="orange";
										echo "http://127.0.0.1/welcome/customer/category.php?category=" . $var ;
										?>">Orange</a></li>
									<li><a href="category.php">Apple</a></li>
									<li><a href="category.php">Pineapple</a></li>
								</ul>
							</div>
						</div>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Drinks</a>
						<div class="dropdown-menu">
							<div class="dropdown-inner">
								<ul class="list-unstyled">
									<li><a href="category.php">Beer</a></li>
									<li><a href="category.php">Wine</a></li>
									<li><a href="category.php">Mineral water</a></li>
									<li><a href="<?php
										$var="soda";
										echo "http://127.0.0.1/welcome/customer/category.php?category=" . $var ;
										?>">Soda</a></li>
									<li><a href="category.php">Milk</a></li>
								</ul>
							</div>
						</div>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Snacks</a>
						<div class="dropdown-menu" style="margin-left: -203.625px;">
							<div class="dropdown-inner">
								<ul class="list-unstyled">
									<li><a href="<?php
										$var="chips";
										echo "http://127.0.0.1/welcome/customer/category.php?category=" . $var ;
										?>">Chips</a></li>
									<li><a href="<?php
										$var="biscuit";
										echo "http://127.0.0.1/welcome/customer/category.php?category=" . $var ;
										?>">Biscuit</a></li>
									<li><a href="category.php">Pudding</a></li>
									<li><a href="category.php">Popcorn</a></li>
									<li><a href="category.php">Nuts</a></li>
								</ul>
								<ul class="list-unstyled">
									<li><a href="category.php">Pretzels</a></li>
									<li><a href="category.php">Beef jerky</a></li>
									<li><a href="category.php">Bun</a></li>
									<li><a href="category.php">French fries</a></li>
									<li><a href="category.php">Ice cream</a></li>
								</ul>
							</div>
						</div>
					</li>
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Electronic Products</a>
						<div class="dropdown-menu">
							<div class="dropdown-inner">
								<ul class="list-unstyled">
									<li><a href="category.php">Mobile phone</a></li>
									<li><a href="category.php">Headset</a></li>
									<li><a href="category.php">Notebook</a></li>
									<li><a href="category.php">Television</a></li>
								</ul>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	
	<!--//////////////////////////////////////////////////-->
	<!--///////////////////Category Page//////////////////-->
	<!--//////////////////////////////////////////////////-->
	<div id="page-content" class="single-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<ul class="breadcrumb">
						<li>Home</li>
						<li>Category : <?php echo $category;?></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div id="main-content" class="col-md-8">

					<div class="row">
						<div class="col-md-12">
							<div class="products">
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][0]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][0]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][0]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][0]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][0]["Price"];
												if ($_SESSION["content"][0]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][1]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][1]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][1]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][1]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][1]["Price"];
												if ($_SESSION["content"][1]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][2]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][2]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][2]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][2]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][2]["Price"];
												if ($_SESSION["content"][2]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="products">
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][3]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][3]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][3]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][3]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][3]["Price"];
												if ($_SESSION["content"][3]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
											<div class="rating"><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][4]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][4]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][4]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][4]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][4]["Price"];
												if ($_SESSION["content"][4]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
											<div class="rating"><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][5]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][5]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][5]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][5]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][5]["Price"];
												if ($_SESSION["content"][5]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
											<div class="rating"><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="products">
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][6]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">

											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][6]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][6]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][6]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][6]["Price"];
												if ($_SESSION["content"][6]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
											<div class="rating"><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][7]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][7]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][7]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][7]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][7]["Price"];
												if ($_SESSION["content"][7]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
											<div class="rating"><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-xs-12">
									<div class="product">
										<div class="image"><a href="<?php
											echo "product.php?product=" . $_SESSION["content"][8]["Gname"] ;
											?>"><img src="images/product.jpg" /></a></div>
										<div class="buttons">
											<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][8]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
											<a class="btn wishlist" href="#"><span class="glyphicon glyphicon-heart"></span></a>
											<a class="btn compare" href="#"><span class="glyphicon glyphicon-transfer"></span></a>
										</div>
										<div class="caption">
											<div class="name"><h3><a href="<?php
													echo "product.php?product=" . $_SESSION["content"][8]["Gname"] ;
													?>"><?php
														echo $_SESSION["content"][8]["Gname"];
														?></a></h3></div>
											<div class="price"><?php
												echo $_SESSION["content"][8]["Price"];
												if ($_SESSION["content"][8]["onSale"]!='not'){
													echo '<font color='."'red'"."> ON SALE</font>";
												}
												?></div>
											<div class="rating"><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row text-center">
						<ul class="pagination">
						  <li class="active"><a href="#">1</a></li>
						  <li><a href="#">2</a></li>
						  <li><a href="#">3</a></li>
						  <li><a href="#">4</a></li>
						  <li><a href="#">5</a></li>
						</ul>
					</div>
				</div>
				<div id="sidebar" class="col-md-4">
					<div class="widget wid-discouts">
						<div class="heading"><h4>Shopping List</h4></div>
						<div class="content">
							<?php
							if(isset($_SESSION['shoppingList']))
							{
								echo "<table>";
								foreach($_SESSION['shoppingList']as $key=>$value){
									echo "<tr><td>".$key.'</td><td>&emsp;&emsp;&emsp;&emsp;</td><td>'.$value."</td>
									<td>&emsp;&emsp;&emsp;</td><td><input type='checkbox'></td></tr>";
									//echo  . "&emsp;&emsp;&emsp;&emsp;". $value.  '</br>';
								}
								echo "</table>";
							}
							?>
						</div>
					</div>
					<div class="widget wid-categories">
						<div class="heading"><h4>CATEGORIES</h4></div>
						<div class="content">
							<ul>
								<li><a href="">Fruits & Drinks</a></li>
								<li><a href="">Snacks</a></li>
								<li><a href="">Electronic Products</a></li>
							</ul>
						</div>
					</div>
					<div class="widget wid-type">
						<div class="heading"><h4>TYPE</h4></div>
						<div class="content">
							<select>
								<option value="EL" selected>Electronic Products</option>
								<option value="MT">Mice and Trackballs</option>
								<option value="WC">Web Cameras</option>
								<option value="TA">Tablates</option>
								<option value="AP">Audio Parts</option>
							</select>
						</div>
					</div>
					<div class="widget wid-discouts">
						<div class="heading"><h4>DISCOUNTS</h4></div>
						<div class="content">
							<label class="checkbox"><input type="checkbox" name="discount" checked="">Upto - 10% (20)</label>
							<label class="checkbox"><input type="checkbox" name="discount">40% - 50% (5)</label>
							<label class="checkbox"><input type="checkbox" name="discount">30% - 20% (7)</label>
							<label class="checkbox"><input type="checkbox" name="discount">10% - 5% (2)</label>
							<label class="checkbox"><input type="checkbox" name="discount">Other(50)</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer>
		<div class="container">
			<div class="wrap-footer">
				<div class="row">
					<div class="col-md-3 col-footer footer-1">
						<h3>Famer's Supermarket</h3>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					</div>
					<div class="col-md-3 col-footer footer-2">
						<div class="heading"><h4>Customer Service</h4></div>
						<ul>
							<li><a href="#">About Us</a></li>
							<li><a href="#">Delivery Information</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Terms & Conditions</a></li>
							<li><a href="#">Contact Us</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-footer footer-3">
						<div class="heading"><h4>My Account</h4></div>
						<ul>
							<li><a href="#">My Account</a></li>
							<li><a href="#">Brands</a></li>
							<li><a href="#">Gift Vouchers</a></li>
							<li><a href="#">Specials</a></li>
							<li><a href="#">Site Map</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-footer footer-4">
						<div class="heading"><h4>Contact Us</h4></div>
						<ul>
							<li><span class="glyphicon glyphicon-home"></span>Macau SAR, China</li>
							<li><span class="glyphicon glyphicon-earphone"></span>+853 62879264</li>
							<li><span class="glyphicon glyphicon-envelope"></span>moyutianque@outlook.com</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						Copyright &copy; 2015.Company name All rights reserved.
					</div>
					<div class="col-md-6">
						<div class="pull-right">
							<ul>
								<li><img src="images/visa-curved-32px.png" /></li>
								<li><img src="images/paypal-curved-32px.png" /></li>
								<li><img src="images/discover-curved-32px.png" /></li>
								<li><img src="images/maestro-curved-32px.png" /></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</body>
</html>
