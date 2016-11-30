<?php
	session_start();
	require_once('../mysqli_connect.php');

	$product = $_GET['product'];
	$query = "SELECT * FROM Goods WHERE Gname = '".$product."' LIMIT 1 lock in share mode;";

	$response = mysqli_query($db,$query);

	if($response){
		$row = mysqli_fetch_array($response);
		$GID = $row['GID'];
		$Gname = $row['Gname'];
		$Price = $row['Price'];
		$category = $row['category'];
		$onSale = $row['onSale'];
		$location = $row['location'];
	}

	if (isset($_POST['login_btn'])){
		if(isset($_SESSION['num'])){
			$qty = $_POST['qty'];
			$_SESSION['num'] += $qty;
			if(isset($_SESSION['shoppingList'])){
				if(isset($_SESSION['shoppingList'][$Gname]))
					$_SESSION['shoppingList'][$Gname] += $qty;
				else
					$_SESSION['shoppingList'][$Gname] = $qty;
			}else{
				$_SESSION['shoppingList'] = array();
				$_SESSION['shoppingList'][$Gname] = $qty;

			}
		}else{
			$_SESSION['num']=0;
		}
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
    
    <script src="js/photo-gallery.js"></script>
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
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
	<!--///////////////////Product Page///////////////////-->
	<!--//////////////////////////////////////////////////-->
	<div id="page-content" class="single-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<ul class="breadcrumb">
						<li><a href="index.php">Home</a></li>
						<li><a href=""><?php echo $category; ?></a></li>
						<li><a href=""><?php echo $Gname; ?></a></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div id="main-content" class="col-md-8">
					<div class="product">
						<div class="col-md-6">
							<div class="image">
								<img class="cus" src="images/product.jpg" />
								<div class="image-more">
									 <ul class="row">
										 <li class="col-lg-3 col-sm-3 col-xs-4">
											<a href=""><img class="img-responsive" src="images/product.jpg"></a>
										</li>
										 <li class="col-lg-3 col-sm-3 col-xs-4">
											<a href=""><img class="img-responsive" src="images/product.jpg"></a>
										</li>
										 <li class="col-lg-3 col-sm-3 col-xs-4">
											<a href=""><img class="img-responsive" src="images/product.jpg"></a>
										</li>
										 <li class="col-lg-3 col-sm-3 col-xs-4">
											<a href=""><img class="img-responsive" src="images/product.jpg"></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="caption">
								<div class="name"><h3><?php echo "Name: ". $product; ?></h3></div>
								<div class="info">
									<ul>
										<li><font size="4"><?php echo "Category : ".$category;?></font></li>
										<li><font size="4"><?php echo "ID       : ".$GID; ?></font></li>
									</ul>
								</div>
								<div class="price"><?php
									echo $Price;
									if ($onSale!='not'){
										echo '<font color='."'red'"."> ON SALE</font>";
									}
									?></div>
								<div class="options">
									AVAILABLE OPTIONS
									<select>
										<option value="" selected>----Please Select----</option>
										<option value="red">Fresh</option>
										<option value="black">Poilage</option>
									</select>
								</div>
								<div class="rating"><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span></div>
								<div class="well"><form method="post" ><label>Qty: </label> <input class="form-inline quantity" type="text" value="1" name="qty"><input class="btn btn-2 " type="submit" name="login_btn" value="ADD"></form></div>
								<div class="share well">
									<strong style="margin-right: 13px;">Share :</strong>
									<a href="#" class="share-btn" target="_blank">
										<i class="fa fa-twitter"></i>
									</a>
									<a href="#" class="share-btn" target="_blank">
										<i class="fa fa-facebook"></i>
									</a>
									<a href="#" class="share-btn" target="_blank">
										<i class="fa fa-linkedin"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>	
					<div class="product-desc">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#description">Description</a></li>
							<li><a href="#review">Review</a></li>
						</ul>
						<div class="tab-content">
							<div id="description" class="tab-pane fade in active">
								<h4>Sample Text</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at ante. Mauris eleifend, quam a vulputate dictum, massa quam dapibus leo, eget vulputate orci purus ut lorem. In fringilla mi in ligula. Pellentesque aliquam quam vel dolor. Nunc adipiscing. Sed quam odio, tempus ac, aliquam molestie, varius ac, tellus. Vestibulum ut nulla aliquam risus rutrum interdum. Pellentesque lorem. Curabitur sit amet erat quis risus feugiat viverra. Pellentesque augue justo, sagittis et, lacinia at, venenatis non, arcu. Nunc nec libero. In cursus dictum risus. Etiam tristique nisl a</p>
								<h4>Sample Text</h4>
								<p>Sed eget turpis a pede tempor malesuada. Vivamus quis mi at leo pulvinar hendrerit. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque aliquet lacus vitae pede. Nullam mollis dolor ac nisi. Phasellus sit amet urna. Praesent pellentesque sapien sed lacus. Donec lacinia odio in odio. In sit amet elit. Maecenas gravida interdum urna. Integer pretium, arcu vitae imperdiet facilisis, elit tellus tempor nisi, vel feugiat ante velit sit amet mauris. Vivamus arcu. Integer pharetra magna ac lacus. Aliquam vitae sapien in nibh vehicula auctor. Suspendisse leo mauris, pulvinar sed, tempor et, consequat ac, lacus. Proin velit. Nulla semper lobortis mauris. Duis urna erat, ornare et, imperdiet eu, suscipit sit amet, massa. Nulla nulla nisi, pellentesque at, egestas quis, fringilla eu, diam.</p>
							</div>
							<div id="review" class="tab-pane fade">
							  <div class="review-text">
								<p>Your feedbacks are always welcomed! </p>
							  </div>
							  <div class="review-form">
								<h4>Write a review</h4>
								<form name="form1" id="ff" method="post" action="review.php">
									<label>
									<span>Enter your name:</span>
									<input type="text"  name="name" id="name" required>
									</label>
									<label>
									<span>Your message here:</span>
									<textarea name="message" id="message"></textarea>
									</label>
									<div class="text-right">
										<input class="btn btn-default" type="reset" name="reset" value="Reset">
										<input class="btn btn-default" type="submit" name="Submit" value="Submit">
									</div>
								</form>
							  </div>
							</div>
						</div>
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
	
	<!-- IMG-thumb -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">         
          <div class="modal-body">                
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
	<script>
	$(document).ready(function(){
		$(".nav-tabs a").click(function(){
			$(this).tab('show');
		});
		$('.nav-tabs a').on('shown.bs.tab', function(event){
			var x = $(event.target).text();         // active tab
			var y = $(event.relatedTarget).text();  // previous tab
			$(".act span").text(x);
			$(".prev span").text(y);
		});
	});
	</script>
</body>
</html>
