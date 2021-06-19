<?php
include('../../config/config.php');
include('../../content/function.php');

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

    if (0 === count($error)) {
        $emailQuery = "SELECT userId FROM users WHERE email = '$email';";
        $emailResult = mysqli_query($conn, $emailQuery);

        if ($emailResult && mysqli_num_rows($emailResult) == 1) {
            $row = mysqli_fetch_assoc($emailResult);
            if ($row['status'] === '1') {
                $resetPass = random_number();
                if (sendMail($email,"forgot password",$resetPass)) {
                    if (resetPassword($email, $resetPass)) {
                        $returnMeg = 'E-mail sent Successfully!';
                    } else {
                        $returnMeg = 'Reset false';
                    }
                }
            } else {
                $error['access'] = "User blocked by Admin";
            }
        } else {
            $error['access'] = "Is this your mail?";
        }

        mysqli_close($conn);
    }
}

function resetPassword($email, $resetPass) {
    global $conn;
    $dbQueryUser = "UPDATE users SET password='" . md5($resetPass) . "' WHERE email = '" . $email . "';";
    if (mysqli_query($conn, $dbQueryUser)) {
        return true;
    } else {
        return false;
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | SolarSmart</title>
    <link rel="stylesheet" href="../../css/bootstrap.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Forgot Password</h3></div>
                <div class="card-body">
                    <form method="POST" action="forgot-password.php">
                        <?php if (isset($error['access'])) : echo '<h6 class="text-center text-danger">'.$error['access'].'</h6>'; endif; ?>
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                            <input class="form-control py-4" type="email" name="email" placeholder="Enter email" />
                            <?php if (isset($error['email'])) : echo "<label style='color: red;'>".$error['email']."</label>"; endif; ?>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            <div>
                                <input class="btn btn-primary btn-block" type="submit" name="submit" value="Submit" >
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