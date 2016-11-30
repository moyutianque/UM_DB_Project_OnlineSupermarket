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
    <link rel="stylesheet" href="../css/bootstrap.min.css"  type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">


    <!-- Custom Fonts -->
    <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"  type="text/css">
    <link rel="stylesheet" href="../fonts/font-slider.css" type="text/css">

    <!-- jQuery and Modernizr-->
    <script src="../js/jquery-2.1.1.js"></script>

    <!-- Core JavaScript Files -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="../js/html5shiv.js"></script>
    <script src="../js/respond.min.js"></script>
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
    </div>
</header>

<hr>

<table>
    <tr>
        <div style="width: 20%;float: left;"><td></td></div>
        <div style="width: 60%;float: right;">
        <td">
            <div style="margin-top: 2em;"><a class="btn btn-1" href="addGoods.php" style="width: 10em;">ADD/DELTE GOODS</a></div>
            <div style="margin-top: 2em;"><a class="btn btn-1" href="Inventory.php" style="width: 10em;">INVENTORY</a></div>
            <div style="margin-top: 2em;"><a class="btn btn-1" href="addEmployee.php" style="width: 10em;">MANEGE EMPOLYEE</a></div>
            <div style="margin-top: 2em;"><a class="btn btn-1" href="addDepartment.php" style="width: 10em;">DEPARTMENT</a></div>
        </td>
        </div>
        <div  style="width: 20%;float: right;"><td></td></div>
    </tr>
</table>


</body>
</html>