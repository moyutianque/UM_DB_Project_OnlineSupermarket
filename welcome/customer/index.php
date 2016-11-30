<?php
	session_start();
	require_once('../mysqli_connect.php');

	$query = "SELECT * FROM Goods WHERE onSale='on' ORDER BY Price LIMIT 9 lock in share mode;";

// Store the content of each result for reusing in the page design
$response = mysqli_query($db,$query);
if($response){
	$a =array();

	while($row = mysqli_fetch_array($response)){
		array_push($a,$row);
	}
	$_SESSION['content'] = $a;
}



//About adding the items to shopping list
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
	
    <title>Supermarket</title>
	
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
	<!--///////////////////HomePage///////////////////////-->
	<!--//////////////////////////////////////////////////-->
	<div id="page-content" class="home-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<!-- Carousel -->
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators hidden-xs">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
						</ol>
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
								<img src="images/potato.jpg" alt="First slide" style="">
								<!-- Static Header -->
								<div class="header-text hidden-xs">
									<div class="col-md-12 text-center">
									</div>
								</div><!-- /header-text -->
							</div>
							<div class="item">
								<img src="images/main-banner2-1903x600.jpg" alt="Second slide">
								<!-- Static Header -->
								<div class="header-text hidden-xs">
									<div class="col-md-12 text-center">
									</div>
								</div><!-- /header-text -->
							</div>
							<div class="item">
								<img src="images/beer.jpg" alt="Third slide">
								<!-- Static Header -->
								<div class="header-text hidden-xs">
									<div class="col-md-12 text-center">
									</div>
								</div><!-- /header-text -->
							</div>
						</div>
						<!-- Controls -->
						<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
						</a>
					</div><!-- /carousel -->
				</div>
			</div>
			<div class="row">
				<div class="banner">
					<div class="col-sm-4">
						<img src="images/sub1.png" />
					</div>
					<div class="col-sm-4">
						<img src="images/sub2.png" />
					</div>
					<div class="col-sm-4">
						<img src="images/subbeer.jpg" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="heading"><h2>Products On Sale</h2></div>
					<div class="products">
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product">
								<div class="image"><a href="<?php
									echo "product.php?product=" . $_SESSION["content"][1]["Gname"] ;
									?>"><img src="images/product.jpg" /></a></div>
								<div class="buttons">
									<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][1]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
									<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
									<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
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
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product">
								<div class="image"><a href="<?php
									echo "product.php?product=" . $_SESSION["content"][2]["Gname"] ;
									?>"><img src="images/product.jpg" /></a></div>
								<div class="buttons">
									<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][2]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
									<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
									<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
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
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product">
								<div class="image"><a href="<?php
									echo "product.php?product=" . $_SESSION["content"][3]["Gname"] ;
									?>"><img src="images/product.jpg" /></a></div>
								<div class="buttons">
									<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][3]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
									<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
									<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
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
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="banner">
					<div class="col-sm-6">
						<img src="images/sub-banner4.jpg" />
					</div>
					<div class="col-sm-6">
						<img src="images/sub-banner5.png" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="heading"><h2>Products On Sale</h2></div>
					<div class="products">
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product">
								<div class="image"><a href="<?php
									echo "product.php?product=" . $_SESSION["content"][4]["Gname"] ;
									?>"><img src="images/product.jpg" /></a></div>
								<div class="buttons">
									<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][4]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
									<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
									<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
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
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product">
								<div class="image"><a href="<?php
									echo "product.php?product=" . $_SESSION["content"][5]["Gname"] ;
									?>"><img src="images/product.jpg" /></a></div>
								<div class="buttons">
									<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][5]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
									<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
									<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
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
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product">
								<div class="image"><a href="<?php
									echo "product.php?product=" . $_SESSION["content"][6]["Gname"] ;
									?>"><img src="images/product.jpg" /></a></div>
								<div class="buttons">
									<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][6]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
									<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
									<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
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
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
							<div class="product">
								<div class="image"><a href="<?php
									echo "product.php?product=" . $_SESSION["content"][7]["Gname"] ;
									?>"><img src="images/product.jpg" /></a></div>
								<div class="buttons">
									<a class="btn cart" onclick="<?php echo "MyReason('". $_SESSION['content'][7]['Gname']."')"; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></a>
									<a class="btn wishlist"><span class="glyphicon glyphicon-heart"></span></a>
									<a class="btn compare"><span class="glyphicon glyphicon-transfer"></span></a>
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
								</div>
							</div>
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
