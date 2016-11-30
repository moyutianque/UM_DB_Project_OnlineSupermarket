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
<div style="float: left;width: 35%;margin-left: 2em;">
<form action="addEmployee.php" method="post" align="left" >
    <font size="5"><b>Add a new Goods to supermarket</b></font>
    <hr>
    <font size="4">
    <table>

        <tr><td>Employee SSN:</td>
        <td><input type="text" name="EID" size="30" value=""/></td>
        </tr>

        <tr><td>Password:</td>
        <td><input type="password" name="Password" size="30" value=""/></td>
        </tr>

        <tr><td>Name:</td>
            <td><input type="text" name="EName" size="30" value=""/></td>
        </tr>

        <tr><td>Salary:</td>
        <td><input type="number" name="salary" size="30" value=""/></td>
        </tr>

        <tr><td>Gender(M/F):</td>
            <td><input type="text" name="gender" size="30" value=""/></td>
        </tr>

        <tr><td>Department ID:</td>
            <td><input type="text" name="DID" size="30" value=""/></td>
        </tr>

    <tr>
        <td><input align="right" type="submit" name="delete" value="DELETE"/></td>
        <td><input align="right" type="submit" name="add" value="ADD"/></td>
    </tr>
    </table>
    </font>
</form>
</div>

<div style="float: left;width: 60%;">
<?php


    require_once('../mysqli_connect.php');
    if(isset($_POST['add'])){
        $query = "INSERT INTO Employee SET EID='" .$_POST['EID']."',password='".$_POST['Password'].
            "',EName='".$_POST['EName']."',salary=".$_POST['salary']
            .",gender='".$_POST['gender']."';";
        mysqli_query($db,$query);
        if (!mysqli_commit($db)) {//commit when finished the transaction
            //echo "<p>No thing happend in second insert</p>";
            mysqli_rollback($db);
            exit("Transaction commit failed\n");
        }

        $query = "INSERT INTO Work_in SET DID='".$_POST['DID']."',EID='" .$_POST['EID']."';";
        mysqli_query($db,$query);
        if (!mysqli_commit($db)) {//commit when finished the transaction
            //echo "<p>No thing happend in second insert</p>";
            mysqli_rollback($db);
            exit("Transaction commit failed\n");
        }
    }elseif (isset($_POST['delete'])){
        // After
    }




    //Display all the previous transaction information of this user
    $query = 'SELECT Employee.EID as EID,EName,salary,gender,Dname,Hiredate FROM Employee,Work_in,Department 
                WHERE Employee.EID=Work_in.EID and Work_in.DID=Department.DID LIMIT 9;';
    $response = mysqli_query($db,$query);
    if($response){
        echo '<font size="5em"><table align="right" cellspacing="5" cellpadding="8" width="100%" >
                 <caption><h2>Query Result</h2></caption> 
               <tr><td align="left"><b>EID</b></td>
               <td align="left"><b>Name</b></td>
               <td align="left"><b>Salary</b></td>
               <td align="left"><b>Gender</b></td>
                 <td align="left"><b>Department</b></td>
                 <td align="left"><b>HireDate</b></td>
                </tr>';

        while($row = mysqli_fetch_array($response)){
            echo '<tr><td align="left">'
                  .$row['EID'].'</td><td align="left">'
                  .$row['EName'].'</td><td align="left">'
                  .$row['salary'].'</td><td align="left">'
                  .$row['gender'].'</td><td align="left">'
                  .$row['Dname'].'</td><td align="left">'
                  .$row['Hiredate'].'</td></tr>';
        }
        echo '</table></font>';
    }else{
        echo "Could not issue database query";
        echo mysqli_errno($db);
    }

mysqli_close($db);
?>
</div>
<hr>
<div align="right" style="float: right;width: 100%;"><a class="btn btn-1" href="index.php">Back To Main Menu</a></div>

</body>
</html>