<?php
session_start();
//connect to database
//$db = mysqli_connect("localhost","root","tsehao123","supermarket");
require_once('mysqli_connect.php');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (isset($_POST['login_btn'])){

    $username = $_POST['username'];//mysqli_real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $password = md5($password);
    $sql = "SELECT * FROM Customer WHERE CID = '$username' AND password='$password'";
    $result = mysqli_query($db, $sql);

    if($username!="" && mysqli_num_rows($result)==1){
        $_SESSION['username'] = $username;
        header("location: ../welcome/customer");
    }else{
        $message = "Please check your username/password";
        $_SESSION['message']=$message;
        //echo "<script type='text/javascript'>alert('$message');</script>";
    }

}
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login page</title>

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
            echo "<div id='error_msg' style='float: inherit;'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']);
        }
        ?>

        <form method="post" action="login.php" class="login">
            <table>
                <tr>
                    <td>Username:</td>
                    <td  colspan="2"><input type="text" name="username" class="testInput"></td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td colspan="2"><input type="password" name="password" class="testInput" ></td>

                </tr>


                <tr>
                    <td></td>
                    <td><a href="../index.php" class="button big">Cancel</a></td>
                    <td><input class="button big" type="submit" name="login_btn" value="Login"></td>
                </tr>
            </table>
        </form>




    </section>



</body>
</html>