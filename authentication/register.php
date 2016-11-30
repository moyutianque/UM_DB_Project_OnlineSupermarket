<?php
    session_start();
    //connect to database
    require_once('mysqli_connect.php');
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    if (isset($_POST['register_btn'])){
        //session_start();
        $username = $_POST['username'];//mysqli_real_escape_string($_POST['username']);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if($password!="" && $password2!="" && $password==$password2 && $username!=''){
            //create user
            $password = md5($password); //hash the password
            $sql = "INSERT INTO Customer(CID,password,Email,CName) VALUES('$username','$password','$email','$username');";
            //$sql = "INSERT INTO Admin(ID,password) VALUES('$username','$password');";
            mysqli_query($db,$sql);

            //Grant
            $combine = "'".$username."'".'@\'%\'';
            $combine2 = "'".$password."'";

            echo "<p>".$combine."</p><br>";echo "<p>".$password."</p>";
            $sql = "GRANT select on * to $combine identified by $combine2;";
            mysqli_query($db,$sql);

            $_SESSION['username'] = $username;// similar to global variable
            $_SESSION['password'] = $password;
            //header("location: ../welcome/admin");
            header("location: ../welcome/customer"); //redirect to home page

            if (!mysqli_commit($db)) {//commit when finished the transaction
                mysqli_rollback($db);
                exit("Transaction commit failed\n");
            }

        }else{
            //failed
            $message = "The two passwords do not match";
            $_SESSION['message'] = $message;
            //echo "<script type='text/javascript'>alert('$message');</script>";
        }

    }
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register page</title>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/skel.min.js"></script>
    <script src="../js/skel-layers.min.js"></script>
    <script src="../js/init.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link href="../css/style-xlarge.css" rel="stylesheet" type="text/css"/>

</head>
<body class="landing">
    <section id="banner">
        <p>WE ARE HERE WAITING FOR YOU</p>
        <h2>FAMER'S SUPERMARKET</h2>

        <?php
            if(isset($_SESSION['message'])){
                echo "<div id='error_msg'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
            }
        ?>

        <form method="post" action="register.php">
            <table style="width: 70%;margin: 0 0 0 15%;">
                <tr>
                    <td colspan="2">
                        <td>Username:</td>
                        <td><input type="text" name="username" class="testInput"></td>

                    </td>
                    <td colspan="2">
                        <td>Password:</td>
                        <td><input type="password" name="password" class="testInput"></td>
                    </td>

                </tr>


                <tr>
                    <td colspan="2">
                        <td>Email:</td>
                        <td><input type="email" name="email" class="testInput"></td>
                    </td>
                    <td colspan="2">
                        <td>Password Again:</td>
                        <td><input type="password" name="password2" class="testInput"></td>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <td></td>
                        <td><a href="../index.php" class="button big">Cancel</a></td>
                    </td>
                    <td colspan="2">
                        <td></td>
                        <td><input type="submit" name="register_btn" value="Register" class="button big"></td>
                    </td>
                </tr>
            </table>
        </form>
        <section/>
</body>
</html>