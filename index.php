<?php
include('config/config.php');

session_start();

$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) {
        $error['email'] = "Enter email";
    } else {
        if (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email is invalid";
        } else {
            $email = check_input($_POST['email']);
        }
    }

    if (empty($_POST["password"])) {
        $error['password'] = "Enter password";
    } else {
        $password = md5(check_input($_POST['password']));
    }

    if (0 === count($error)) {
        $emailQuery = "SELECT userId, dispName, proImg, status, password FROM users WHERE email = '$email';";
        $emailResult = mysqli_query($conn, $emailQuery);

        if ($emailResult && mysqli_num_rows($emailResult) == 1) {
            $row = mysqli_fetch_assoc($emailResult);
            if ($row['status'] === '1') {
                if ($row['password'] === $password) {
                    $_SESSION['userId'] = $row['userId'];
                    $_SESSION['dispName'] = $row['dispName'];
                    $_SESSION['proImg'] = $row['proImg'];

                    header('Location: package/main/dashboard.php');
                    exit();
                } else {
                    $error['access'] = "Access denied";
                }
            } else {
                $error['access'] = "User blocked by Admin";
            }
        } else {
            $error['access'] = "Access denied";
        }

        mysqli_close($conn);
    }
}

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | SolarSmart</title>
    <link rel="stylesheet" href="<?php echo WEB_URL; ?>css/bootstrap.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Sign In</h3></div>
                <div class="card-body">
                    <form method="POST" action="index.php">
                        <?php if (isset($error['access'])) : echo '<h6 class="text-center text-danger">'.$error['access'].'</h6>'; endif; ?>
                        <div class="form-group">
                            <label class="small mb-1">Email</label>
                            <input class="form-control py-4" type="email" name="email" placeholder="Enter email" />
                            <?php if (isset($error['email'])) : echo "<label style='color: red;'>".$error['email']."</label>"; endif; ?>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1">Password</label>
                            <input class="form-control py-4" type="password" name="password" placeholder="Enter password" />
                            <?php if (isset($error['password'])) : echo "<label style='color: red;'>".$error['password']."</label>"; endif; ?>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small" href="<?php echo WEB_URL; ?>package/user/forgot-password.php">Forgot Password?</a>
                            <div>
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Sign In" >
                                <input type="button" value="hello">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
