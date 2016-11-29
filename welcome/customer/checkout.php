<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Supermarket</title>

    <!-- Bootstrap Core CSS-->
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
        function ItemRemove(itemname){
            alert("Remove item "+itemname+" successfully! ");
            document.getElementById("itemname").value = itemname;
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


<hr>
<div class="heading" ><h2 align="center">Previous Transaction</h2></div>

<?php


    require_once('../root.php');

    if(isset($_SESSION['shoppingList'])){
        $query = "INSERT INTO Deal(CID,totalAmount) VALUES ('" .$_SESSION['username']."',".$_SESSION['totalamount'].");";
        mysqli_query($db,$query);

        if (!mysqli_commit($db)) {//commit when finished the transaction
            mysqli_rollback($db);
            exit("Transaction commit failed\n");
        }

        $query = "Select max(TID) as Max_TID FROM DEAl";
        $response=mysqli_query($db,$query);
        if($response){
            while($row = mysqli_fetch_array($response)){

                $TID = $row['Max_TID'];
            }
        }

        foreach($_SESSION['shoppingList']as $key=>$value){
            $query = "SELECT GID FROM Goods WHERE Gname='".$key."';";
            $response=mysqli_query($db,$query);
            if($response){
                while($row = mysqli_fetch_array($response)){
                    $GID = $row['GID'];
                    echo "<p>".$GID." No thing happend in first insert</p>";
                }
            }

            $query = 'INSERT INTO transaction_goods SET TID=' .$TID.',GID='.$GID.',quantity='.$value.';';
            mysqli_query($db,$query);
            if (!mysqli_commit($db)) {//commit when finished the transaction
                //echo "<p>No thing happend in second insert</p>";
                mysqli_rollback($db);
                exit("Transaction commit failed\n");
            }

        }
    }

    //Display all the previous transaction information of this user
    $query = "SELECT Deal.TID as TID,TDate,totalAmount,Gname,quantity 
            FROM transaction_goods, Deal, Goods Where Deal.TID=transaction_goods.TID and Goods.GID=transaction_goods.GID; ";
    $response = mysqli_query($db,$query);
    if($response){
        echo '<font size="5em"><table align="center" cellspacing="5" cellpadding="8" width="70%" >
               <tr><td align="left"><b>TID</b></td>
               <td align="left"><b>Date</b></td>
               <td align="left"><b>Name</b></td>
               <td align="left"><b>Quantity</b></td>
               <td align="left"><b>Total Amount</b></td></tr>';
        while($row = mysqli_fetch_array($response)){
            echo '<tr><td align="left">'
                  .$row['TID'].'</td><td align="left">'
                  .$row['TDate'].'</td><td align="left">'
                  .$row['Gname'].'</td><td align="left">'
                  .$row['quantity'].'</td><td align="left">'
                  .$row['totalAmount'].'</td></tr>';
        }
        echo '</table></font>';
    }else{
        echo "Could not issue database query";
        echo mysqli_errno($db);
    }


unset($_SESSION['num']);
unset($_SESSION['shoppingList']);
mysqli_close($db);
?>
<hr>
<div align="right"><a class="btn btn-1" href="index.php">Back To Main Menu</a></div>

</body>
</html>