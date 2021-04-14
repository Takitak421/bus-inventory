<?php
// enter php logic here.

include("../includes/data.php");


$login_errors_edit = "";

/* the old style
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    loginForEdit($_POST['username'], $_POST['password']);
}
else if ($_SERVER['REQUEST_METHOD'] == "GET")
{
    if (isset($_GET['edit_login_error']))
    {
      $login_errors_edit = $_GET['edit_login_error'];
    }
} */

if(isset($_POST['loginsubmit']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (($username == "$my_username") && (password_verify($password, $my_password)))
    {
        session_start();
        $_SESSION['GWENITAKITAK'] = session_id;

        header("Location: insert.php");
    }

    else {
        $login_errors_edit = "Invalid Login";
    }
}

include(__DIR__."/../includes/header_template.php");
?>
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title><?php echo $thisTitle; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="container">
        <form class="login-form row form-control mt-5 mx-auto p-4" method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
            <div class="input-login">
                <div class="form-check col-12">
                    <h1>Login to edit</h1>
                </div>
                <div class="form-check col-12">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="form-control mx-auto" name="username" placeholder="username">
                </div>
                <div class="form-check col-12">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control mx-auto" name="password" placeholder="password">
                </div>
            </div>

            <button class="btn btn-lg btn-primary my-3" type="submit" name="loginsubmit">Log in</button>
            <?php if($login_errors_edit !="") {?>
            <div class="alert alert-danger mx-auto col-12" style="width: 12rem;">
              <?php echo $login_errors_edit; }?>
            </div>
        </form>
        
    </div>
</body>

</html>